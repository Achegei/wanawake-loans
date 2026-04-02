<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesAgent;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class SalesAgentController extends Controller
{
    // Show all agents with pagination
    public function index()
    {
        // Use paginate instead of get() so links() works in Blade
        $agents = SalesAgent::withCount('accessCodes')->get();
        return view('agents.index', compact('agents'));
    }

    // Show create form
    public function create()
    {
        return view('agents.create');
    }

    // Store new agent
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => 'required|string|unique:sales_agents,phone',
            'email'     => 'required|email|unique:sales_agents,email',
            'id_number' => 'required|string|unique:sales_agents,id_number',
            'password'  => 'required|string|confirmed|min:6', // password + confirm
        ]);

        // Generate a unique agent code
        $validated['code'] = 'AGT' . strtoupper(Str::random(6));

        // Hash the password
        $validated['password'] = Hash::make($validated['password']);

        // Mark as agent
        $validated['is_agent'] = 1;

        // Create the agent
        $agent = SalesAgent::create($validated);

        return redirect()
            ->route('admin.agents.index')
            ->with('success', "Agent created! Code: {$agent->code}");
    }
    
}