<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    /**
     * For Redirect ti Admin Login page
     */
    public function LoginPage()
    {
        return view('admin.login');
    }
}
