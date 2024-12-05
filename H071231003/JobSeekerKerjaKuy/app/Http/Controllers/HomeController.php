<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return view('dashboard.admin.home');
            } elseif (Auth::user()->role === 'employer') {
                return view('dashboard.employer.home');
            } return view('dashboard.jobSeeker.home');
        } else {
            return redirect('login');
        }
    }
}
