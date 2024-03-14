<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
       
        if (Auth::check()) {
            $user = Auth::user();

            return Inertia::render('Dashboard', [
                'user' => $user
            ]);
        } else {
            return redirect()->route('login');
        }
    }
}
