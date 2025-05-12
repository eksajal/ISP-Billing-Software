<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Payment;  // Assuming you have a model to save payment data

class PaymentController extends Controller
{
    // Show the payment form
    public function showPaymentForm()
    {
        return view('payment.form');
    }

    // Process bKash payment
    public function processPayment(Request $request)
    {
        // Get bKash number from the form
        $bkashNumber = $request->bkash_number;

        // Simulate the payment process
        $paymentStatus = $this->simulateBkashPayment();

        if ($paymentStatus['status'] == 'success') {
            // Simulate payment info to be saved
            $payment = new Payment();
            $payment->user_name = 'John Doe';  // Example data, ideally from session or database
            $payment->phone = '017XXXXXXXX';
            $payment->amount = 800;  // Example bill amount
            $payment->transaction_id = $paymentStatus['transaction_id'];  // Simulated transaction ID
            $payment->bkash_number = $bkashNumber;
            $payment->status = 'successful';
            $payment->save();

            // Redirect to success page with success message
            Session::flash('payment_status', 'Payment successful!');
            return redirect()->route('payment.success');
        } else {
            // Redirect to failed page with failure message
            Session::flash('payment_status', 'Payment failed. Please try again.');
            return redirect()->route('payment.failed');
        }
    }

    // Simulate bKash payment response
    private function simulateBkashPayment()
    {
        // Simulated success response
        return [
            'status' => 'success',  // Simulate successful payment
            'transaction_id' => '1234567890',  // Simulated transaction ID
            'message' => 'Payment completed successfully',
        ];
    }

    // Show success page
    public function successPage()
    {
        return view('payment.success');
    }

    // Show failed page
    public function failedPage()
    {
        return view('payment.failed');
    }








    public function checkBillForm(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:customers,user_id',
        ]);
    
        $customer = Customer::with('package')->where('user_id', $request->user_id)->first();
    
        if (!$customer) {
            return redirect('/')->with('error', 'Customer not found.');
        }
    
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
    
        $currentMonth = now()->format('F');
    
        // ✅ New: Just check if any bill exists for this customer that is paid
        $isPaid = \App\Models\Bill::where('customer_id', $customer->id)
                    ->where('is_paid', 1)
                    ->exists();
    
        return view('home.check_bill_page', compact('customer', 'months', 'currentMonth', 'isPaid'));
    }
    

    
}
