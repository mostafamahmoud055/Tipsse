<?php

namespace App\Services\Payments;

use App\Enums\PaymentGatewayEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Employee;
use App\Models\Payment;

class PaymentService
{
    public function __construct(protected PaymentGatewayService $gatewayService) {}

    public function processPayment(int $id, string $method, float $amount)
    {
        $employee = Employee::findOrFail($id);

        $gateway = $this->resolveGateway($method);

        if (is_array($gateway) && isset($gateway['error'])) {
            return $gateway;
        }

        $result = $gateway->pay($amount, $employee);
        // Determine status: success, failed, or pending

        $paymentStatus = $this->determinePaymentStatus($result['status']);

        // إذا فيه checkout_url، رجعه للمستخدم
        if (isset($result['checkout_url'])) {
            return [
                'status' => $paymentStatus->value,
                'checkout_url' => $result['checkout_url'],
                'transaction_id' => $result['transaction_id'] ?? null,
            ];
        }
        // لو الدفع ناجح
        if ($paymentStatus === PaymentStatusEnum::SUCCESSFUL) {
            return [
                'status' => $paymentStatus->value,
                'transaction_id' => $result['transaction_id'] ?? null,
            ];
        }
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

    protected function createPaymentRecord(
        Employee $employee,
        string $gateway,
        PaymentStatusEnum $status,
        array $gatewayResult,
        float $amount
    ): Payment {
        return Payment::create([
            'employee_id'    => $employee->id,
            'payment_method' => $gateway,
            'status'         => $status->value,
            'amount'         => $amount,
            'reference_id'   => $gatewayResult['transaction_id'] ?? null,
        ]);
    }
}
