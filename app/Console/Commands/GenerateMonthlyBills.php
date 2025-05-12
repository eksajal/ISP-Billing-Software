<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customer;
use App\Models\Bill;
use Carbon\Carbon;

class GenerateMonthlyBills extends Command
{
    protected $signature = 'generate:monthly-bills';
    protected $description = 'Generate monthly bills for all active customers';

    public function handle(): void
    {
        $month = Carbon::now()->format('Y-m');

        $customers = Customer::with('package')->where('is_active', true)->get();

        $count = 0;

        foreach ($customers as $customer) {
            // Check if bill already exists for this month
            $alreadyExists = Bill::where('customer_id', $customer->id)
                ->where('month', $month)
                ->exists();

            if (!$alreadyExists) {
                Bill::create([
                    'customer_id' => $customer->id,
                    'month'       => $month,
                    'amount'      => $customer->package->monthly_bill,
                ]);
                $count++;
            }
        }

        $this->info("✅ Monthly bills generated for {$count} customers.");
    }
}
