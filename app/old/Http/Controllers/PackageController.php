<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return view('packages.index', compact('packages'));
    }

    public function upgrade(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id'
        ]);

        $user = auth()->user();
        $package = Package::findOrFail($request->package_id);

        // Here you would typically handle payment processing
        // For this example, we'll just update the package
        $user->update(['package_id' => $package->id]);

        return redirect()->route('dashboard')
            ->with('success', 'Package upgraded successfully!');
    }
}