<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AgentAccessCode;
use Illuminate\Support\Str;

class SalesAgentController extends Controller
{
    
        public function index()
        {
            // Load agents with latest access code
            $agents = User::where('is_agent', 1)->with('latestAccessCode')->get();
            return view('admin.agents.index', compact('agents'));
        }
     

    public function create()
    {
        return view('admin.agents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
        ]);

        // Create agent in users table
        $agent = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt(Str::random(8)), // random password
            'is_agent' => 1,
        ]);

        // Generate access code for the agent
        $this->createAccessCode($agent);

        return redirect()->route('admin.agents.index')
            ->with('success', "Agent created successfully. Access code sent.");
    }

    public function edit($id)
    {
        $agent = User::findOrFail($id);
        return view('admin.agents.edit', compact('agent'));
    }

    public function update(Request $request, $id)
    {
        $agent = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone,' . $agent->id,
            'email' => 'required|email|unique:users,email,' . $agent->id,
            'id_number' => 'nullable|string',
            'password' => 'nullable|confirmed|min:6',
        ]);

        $data = $request->only(['name', 'phone', 'email', 'id_number']);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $agent->update($data);

        return redirect()->route('admin.agents.index')
            ->with('success', 'Agent updated successfully');
    }

    public function generateAccessCode(User $agent)
    {
        $code = $this->createAccessCode($agent);
        return back()->with('success', "Access code {$code} generated for {$agent->name}");
    }

    /**
     * Helper to create a new access code for a given agent.
     */
    protected function createAccessCode(User $agent): string
    {
        $code = strtoupper(Str::random(6));

        AgentAccessCode::create([
            'sales_agent_id' => $agent->id,
            'code' => $code,
            'used' => false,
        ]);

        return $code;
    }
}