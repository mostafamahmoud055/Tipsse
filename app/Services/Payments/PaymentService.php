<?php

namespace App\Services\Payments;

use App\Enums\PaymentGatewayEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Employee;
use App\Models\Payment;

class PaymentService
{
    public function __construct(protected PaymentGatewayService $gatewayService) {}

    public function getPayments(array $filters = [], int $perPage = 10)
    {
        $query = Payment::with(['employee.branch', 'employee.user']);

        $user = auth()->user();

        // Filter by merchant owner
        if ($user->role === 'merchant_owner') {
            $query->where('user_id', $user->id);
        }

        // Search filter - search in employee name, payment id, transaction id
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->whereHas('employee', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        if (!empty($filters['sort'])) {
            if ($filters['sort'] === 'newest') {
                $query->latest();
            } elseif ($filters['sort'] === 'oldest') {
                $query->oldest();
            }
        } else {
            $query->latest();
        }

        // Calculate statistics before pagination
        $stats = $this->calculatePaymentStats(clone $query);

        // Paginate and attach statistics
        $paginated = $query->paginate($perPage)->withQueryString();

        // Attach stats to the paginated result
        $paginated->stats = $stats;

        return $paginated;
    }

    /**
     * Calculate payment statistics
     */
    protected function calculatePaymentStats($query)
    {
        return [
            'total_tips' => $query->count(),
            'released_tips' => $query->where('status', PaymentStatusEnum::SUCCESSFUL->value)->count(),
            'pending_tips' => $query->where('status', PaymentStatusEnum::PENDING->value)->count(),
            'rejected_tips' => $query->where('status', PaymentStatusEnum::FAILED->value)->count(),
            // 'total_count' => $query->count(),
            // 'released_count' => $query->where('status', PaymentStatusEnum::SUCCESSFUL->value)->count(),
            // 'pending_count' => $query->where('status', PaymentStatusEnum::PENDING->value)->count(),
            // 'rejected_count' => $query->where('status', PaymentStatusEnum::FAILED->value)->count(),
            // 'average_rating' => $query->whereNotNull('rating')->avg('rating'),
        ];
    }

    /**
     * Legacy method name for backward compatibility
     */
    public function getPayemnts(array $filters = [], int $perPage = 10)
    {
        return $this->getPayments($filters, $perPage);
    }
    public function processPayment(int $id, int $rating = 0, string $method, float $amount)
    {
        $employee = Employee::findOrFail($id);

        $gateway = $this->resolveGateway($method);

        if (is_array($gateway) && isset($gateway['error'])) {
            return $gateway;
        }

        $result = $gateway->pay($amount, $employee);

        // إذا فيه checkout_url، رجعه للمستخدم
        if (isset($result['checkout_url'])) {
            // // Create payment record
            $payment = Payment::create([
                'employee_id'    => $employee->id,
                'payment_method' => $method,
                'status'         => PaymentStatusEnum::PENDING->value,
                'amount'         => $amount,
                'rating'         => $rating,
                'user_id'        => $employee->user_id,
                'transaction_id'   => $result['transaction_id'] ?? null,
            ]);

            return [
                'status' => PaymentStatusEnum::PENDING->value,
                'checkout_url' => $result['checkout_url'],
                'transaction_id' => $payment->transaction_id,
                'payment_id' => $payment->id,
            ];
        }
        // لو instant payment gateway
        $paymentStatus = $this->determinePaymentStatus($result['status']);

        Payment::create([
            'employee_id'    => $employee->id,
            'payment_method' => $method,
            'status'         => $paymentStatus->value,
            'amount'         => $amount,
            'rating'         => $rating,
            'user_id'        => $employee->user_id,
            'transaction_id'   => $result['transaction_id'] ?? null,
        ]);

        // لو الدفع فشل
        return [
            'error' => "Payment cannot be processed for employee: {$employee->name}",
            'status' => 400,
        ];
    }

    protected function determinePaymentStatus(string $status): PaymentStatusEnum
    {
        return match (strtolower($status)) {
            'success' => PaymentStatusEnum::SUCCESSFUL,
            'pending' => PaymentStatusEnum::PENDING,
            default   => PaymentStatusEnum::FAILED,
        };
    }

    protected function resolveGateway(string $method): mixed
    {
        $gatewayEnum = PaymentGatewayEnum::tryFrom($method);

        $gateway = $this->gatewayService->getGateway($gatewayEnum->value);

        if (is_array($gateway) && isset($gateway['error'])) {
            return $gateway;
        }

        return $gateway;
    }
}
