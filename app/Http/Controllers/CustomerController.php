<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Package;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_name' => 'required|string',
            'user_id' => 'required|string|unique:customers,user_id',
            'phone' => 'required|string',
            'address' => 'required|string',
            'package_id' => 'required|exists:packages,id',
            'starting_date' => 'required|date',
        ]);
    
        // Create customer
        $customer = Customer::create([
            'user_name' => $validated['user_name'],
            'user_id' => $validated['user_id'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'package_id' => $validated['package_id'],
            'starting_date' => $validated['starting_date'],
        ]);
    
        // Get package for monthly bill
        $package = Package::findOrFail($validated['package_id']);
    
        // Format month as YYYY-MM
        $billMonth = now()->format('Y-m');
    
        // Create bill for current month
        Bill::create([
            'customer_id' => $customer->id,
            'month' => $billMonth,
            'amount' => $package->monthly_bill,
            'is_paid' => false,
        ]);
    
        return response()->json(['status' => 'success']);
    }


    public function getCustomers()
    {
        $customers = Customer::with('package')->get()->map(function ($customer) {
            return [
                'id' => $customer->id,
                'user_name' => $customer->user_name,  // Updated to 'user_name' from 'name'
                'phone' => $customer->phone,
                'address' => $customer->address,
                'starting_date' => $customer->starting_date,  // Updated to 'starting_date' from 'month'
                'package_name' => $customer->package->name ?? 'N/A'
            ];
        });
    
        return response()->json(['customers' => $customers]);
    }
    
    public function getCustomer($id)
    {
        $customer = Customer::with('package')->findOrFail($id);
        return response()->json([
            'customer' => [
                'id' => $customer->id,
                'user_name' => $customer->user_name,  // Updated to 'user_name' from 'name'
                'phone' => $customer->phone,
                'address' => $customer->address,
                'starting_date' => $customer->starting_date,  // Updated to 'starting_date' from 'month'
                'package_name' => $customer->package->name ?? 'N/A'
            ]
        ]);
    }
    
    public function updateCustomer(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        // Updated field names in the update method to match the database
        $customer->update($request->only(['user_name', 'phone', 'address', 'starting_date']));  // Updated keys
        return response()->json(['status' => 'success']);
    }
    
    public function deleteCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return response()->json(['status' => 'success']);
    }
    
} 