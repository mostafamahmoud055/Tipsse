<?php

namespace App\Http\Controllers;


use App\Enums\PaymentStatusEnum;
use App\Models\Payment;
use App\Services\Payments\PaymentService;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class PaymentController extends Controller
{


    public function __construct(protected PaymentService $paymentService) {}
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'sort']);
        $payments = $this->paymentService->getPayments($filters, 15);

        return view('pages.tips', [
            'payments' => $payments,
        ]);
    }
    public function processPayment(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'amount' => 'required|numeric|min:0.01',
            // 'payment_method' => ['required', new Enum(PaymentGatewayEnum::class)],
        ]);

        $gateway = $request->input('payment_method') ?? 'stripe';
        $amount = $request->input('amount');
        $rating = $request->rating ?? 0;

        $paymentResult = $this->paymentService->processPayment($request->employee_id, $rating, $gateway, $amount);

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
        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            abort(400, 'No session ID');
        }

        Stripe::setApiKey(config('services.stripe.secret_key'));

        // Get full session from Stripe
        $session = Session::retrieve($sessionId);

        // Optional: get payment intent for more details
        $paymentIntent = \Stripe\PaymentIntent::retrieve($session->payment_intent);

        // Update payment record in DB
        Payment::where('transaction_id', $session->id)
            ->update([
                'status' => PaymentStatusEnum::SUCCESSFUL->value,
                'transaction_id' => $paymentIntent->id,
            ]);

        return view('pages.payment.success', [
            'title' => 'Payment Successful',
            'session' => $session,
            'paymentIntentId' => $paymentIntent->id,
        ]);
    }
    public function cancel(Request $request)
    {
        $sessionId = $request->query('session_id');

        if ($sessionId) {
            Payment::where('transaction_id', $sessionId)
                ->update([
                    'status' => PaymentStatusEnum::FAILED->value,
                ]);
        }

        return view('pages.payment.cancel', [
            'title' => 'Payment Cancelled'
        ]);
    }
}
