<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bill;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BillController extends Controller
{
    public function getBills()
    {
        $bills = Bill::with('customer')->get()->map(function ($bill) {
            return [
                'id' => $bill->id,
                'customer_name' => $bill->customer->user_name ?? 'N/A',
                'customer_phone' => $bill->customer->phone ?? 'N/A',
                'month' => Carbon::parse($bill->month . '-01')->format('F Y'), // e.g., "May 2025"
                'amount' => $bill->amount,
                'is_paid' => $bill->is_paid,
            ];
        });

        return response()->json(['bills' => $bills]);
    }

    public function sendSms(Bill $bill)
    {
        Log::info("SMS to {$bill->customer->phone}: Your bill for {$bill->month} (৳{$bill->amount}) is " . ($bill->is_paid ? 'paid' : 'unpaid') . ".");

        return response()->json(['status' => 'success']);
    }

    public function changeStatus(Bill $bill)
    {
        $bill->is_paid = !$bill->is_paid;
        $bill->save();

        return response()->json(['status' => 'success']);
    }

    public function deleteBill(Bill $bill)
    {
        $bill->delete();

        return response()->json(['status' => 'success']);
    }
}
