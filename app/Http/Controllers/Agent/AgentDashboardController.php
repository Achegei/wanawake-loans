<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AgentAccessCode;

class AgentDashboardController extends Controller
{
    public function index()
        {
            $user = auth()->user();

            $loansCount = $user->agentLoans()->count();
            $pendingLoans = $user->agentLoans()->where('status', 'pending')->count();
            $paidLoans = $user->agentLoans()->where('status', 'paid')->count();

            $codes = $user->accessCodes()
            ->where('used', false) // only unused
            ->latest()
            ->take(5)
            ->get();
            $loans = $user->agentLoans()->with('user')->latest()->take(5)->get();

            return view('agents.dashboard', compact(
                'loansCount',
                'pendingLoans',
                'paidLoans',
                'codes',
                'loans'
            ));
        }

    public function generateCode()
    {
        $user = auth()->user();

        // 🔒 Check if agent already has an unused code
        $existingCode = AgentAccessCode::where('sales_agent_id', $user->id)
            ->where('used', false)
            ->latest()
            ->first();

        if ($existingCode) {
            return response()->json([
                'success' => false,
                'message' => 'You already have an unused code',
                'code' => $existingCode->code
            ]);
        }

        // ✅ Generate new code
        $code = strtoupper(\Str::random(6));

        $accessCode = AgentAccessCode::create([
            'sales_agent_id' => $user->id,
            'code' => $code,
            'used' => false,
        ]);

        return response()->json([
            'success' => true,
            'code' => $accessCode->code
        ]);
    }

    public function loans(Request $request)
    {
        $query = auth()->user()->loans()->with('user');

        // Filter by date if provided
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $loans = $query->orderBy('created_at', 'desc')->get();

        return view('agents.loans.index', compact('loans'));
    }
}