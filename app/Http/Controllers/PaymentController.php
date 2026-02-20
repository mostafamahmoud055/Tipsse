<?php

namespace App\Http\Controllers;


use App\Enums\PaymentGatewayEnum;
use App\Services\Payments\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class PaymentController extends Controller
{


    public function __construct(protected PaymentService $paymentService) {}

    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_method' => ['required', new Enum(PaymentGatewayEnum::class)],
        ]);

        $gateway = $request->input('payment_method');
        $amount = $request->input('amount');

        $payment = $this->paymentService->processPayment($request->employee_id, $gateway, $amount);
        if (isset($payment['error'])) {
            return redirect()
                ->back()->with('error', $payment['error']);
        }
        return redirect()
            ->back()->with('success', 'Payment processed successfully');
    }
}
