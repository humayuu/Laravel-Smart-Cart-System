<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * For Redirect ti Admin Login page
     */
    public function LoginPage()
    {
        return view('admin.login');
    }

    /**
     * For Admin Login
     */
    public function AdminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {

            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->back()->with('error', 'Wrong email or password');

            }

        } catch (Exception $e) {
            Log::error('Error in Admin Login '.$e->getMessage());

            return redirect()->back()->with('error', 'Error Admin login');
        }

    }

    /**
     * For Redirect to Admin Dashboard
     */
    public function AdminDashboard()
    {
        $products = Product::orderBy('id', 'DESC')
            ->paginate(5);

        return view('admin.dashboard', compact('products'));
    }

    /**
     * For Admin Logout
     */
    public function AdminLogout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login.page');
    }
}
