<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;

class PackageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'package_name' => 'required|string|max:255',
            'monthly_bill' => 'required|numeric',
        ]);

        Package::create([
            'name' => $request->package_name,
            'monthly_bill' => $request->monthly_bill,
        ]);

        return response()->json(['status' => 'success']);
    }



    public function getPackages()
    {
        $packages = Package::all();
        return response()->json(['packages' => $packages]);
    }


    public function getPackage($id)
    {
        $package = Package::find($id);
        return response()->json(['package' => $package]);
    }


    public function updatePackage(Request $request, $id)
    {
        $package = Package::find($id);
        if ($package) {
            $package->name = $request->package_name;
            $package->monthly_bill = $request->monthly_bill;
            $package->save();
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error', 'message' => 'Package not found']);
    }


    public function deletePackage($id)
    {
        $package = Package::find($id);
        if ($package) {
            $package->delete();
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error', 'message' => 'Package not found']);
    }
}
