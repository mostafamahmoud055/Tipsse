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
        'employee_id' => 'required|exists:employees,id',
        'amount' => 'required|numeric|min:0.01',
        'payment_method' => ['required', new Enum(PaymentGatewayEnum::class)],
    ]);

    $gateway = $request->input('payment_method');
    $amount = $request->input('amount');

    $paymentResult = $this->paymentService->processPayment($request->employee_id, $gateway, $amount);

    // لو فيه خطأ
    if (isset($paymentResult['error'])) {
        return redirect()->back()->with('error', $paymentResult['error']);
    }

    // لو فيه checkout_url (Stripe)، عمل redirect للمستخدم
    if (isset($paymentResult['checkout_url'])) {
        return redirect($paymentResult['checkout_url']);
    }

    // لو الدفع ناجح مباشرة
    return redirect()->back()->with('success', 'Payment processed successfully');
}

    public function success(Request $request)
    {
        $paymentIntentId = $request->query('payment_intent');
        
        return view('pages.payment.success', [
            'paymentIntentId' => $paymentIntentId,
            'title' => 'Payment Successful'
        ]);
    }

    public function cancel(Request $request)
    {
        return view('pages.payment.cancel', [
            'title' => 'Payment Cancelled'
        ]);
    }
}
