<?php

namespace App\Services\Payments;

use App\Enums\PaymentGatewayEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Employee;
use App\Models\Payment;

class PaymentService
{
    public function __construct(protected PaymentGatewayService $gatewayService) {}

    public function processPayment(int $id, string $method, string $amount)
    {
        $employee = Employee::findOrFail($id);

        $gateway = $this->resolveGateway($method);

        if (is_array($gateway) && isset($gateway['error'])) {
            return $gateway;
        }

        $result = $gateway->pay(['amount' => $amount, 'employee_id' => $employee->id]);

        $paymentStatus = $this->determinePaymentStatus($result['status']);

        $payment = $this->createPaymentRecord($employee, $method, $paymentStatus, $result ,$amount);

        if ($paymentStatus === PaymentStatusEnum::SUCCESSFUL) {
            return [
                'status' => $payment,
            ];
        }

        return ["error" => "Payment cannot be processed for employee ID: {$employee->id}", "status" => 400];
    }


    protected function determinePaymentStatus(string $status): PaymentStatusEnum
    {
        return strtolower($status) === 'success'
            ? PaymentStatusEnum::SUCCESSFUL
            : PaymentStatusEnum::FAILED;
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

    protected function createPaymentRecord(Employee $employee, string $gateway, PaymentStatusEnum $status, array $gatewayResult, $amount): Payment
    {
        return Payment::create([
            'employee_id' => $employee->id,
            'payment_method' => $gateway,
            'status' => $status->value,
            'amount' => $amount,
            'reference_id' => $gatewayResult['transaction_id'],
        ]);
    }
}
    