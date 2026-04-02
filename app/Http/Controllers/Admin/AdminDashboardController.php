<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Loan;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalLoans = Loan::count();
        $activeLoans = Loan::where('status', 'active')->count();

        return view('admin.dashboard', compact('totalUsers', 'totalLoans', 'activeLoans'));
    }
}