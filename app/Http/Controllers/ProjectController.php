<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // If the user is a developer, fetch projects where they are the lead or participating
        if ($user->role === 'Developer') {
            $projects = Project::where('lead_developer_id', $user->id)
                ->orWhereHas('developers', function ($query) use ($user) {
                    $query->where('users.id', $user->id);
                })
                ->get();
        } else {
            // If the user is a manager, fetch all projects
            $projects = Project::all();
        }

        return view('dashboard', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $developers = User::where('role', 'Developer')->get();

        return view('projects.create', compact('developers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'project_name' => 'required',
            'business_unit_name' => 'required',
            'start_date' => 'required|date',
            'duration' => 'required|numeric',
            'lead_developer_id' => 'required|exists:users,id,role,Developer',
            'other_developers' => 'array|exists:users,id,role,Developer',
            'last_report' => 'nullable|date',
        ]);

        $project = Project::create($validatedData);

        $project->lead_developer_id = $request->input('lead_developer_id');

        if ($request->has('other_developers')) {
            $project->developers()->attach($request->input('other_developers'));
        }

        return redirect()->route('dashboard')->with('success', 'Project created successfully');
    }

    public function edit($id)
    {
        // Fetch the project by ID
        $project = Project::findOrFail($id);
        
        // Fetch developers
        $developers = User::where('role', 'Developer')->get();

        return view('projects.edit', compact('project', 'developers'));

        if (auth()->user()->isManager()) {
            // Return the edit view for managers
            return view('projects.edit', compact('project'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'project_name' => 'required',
            'business_unit_name' => 'required',
            'start_date' => 'required|date',
            'duration' => 'required|numeric',
            'lead_developer_id' => 'required|exists:users,id,role,Developer',
            'other_developers' => 'array|exists:users,id,role,Developer',
        ]);
    
        // Update the project
        $project = Project::findOrFail($id);
        $project->update($validatedData);
    
        $project->lead_developer_id = $request->input('lead_developer_id');
        $project->developers()->sync($request->input('other_developers', []));

        return redirect()->route('dashboard')->with('success', 'Project updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Delete the project by ID
        $project = Project::findOrFail($id);
        $project->delete();
    
        return redirect()->route('dashboard')->with('success', 'Project deleted successfully');
    }

    public function showUpdateProgressForm($id)
    {
        $project = Project::findOrFail($id);
    
        if (auth()->user()->id !== $project->lead_developer_id) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to edit progress for this project.');
        }
    
        return view('projects.update-progress', compact('project'));
    }

    public function updateProgress(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        // Validate and update only the allowed fields
        $validatedData = $request->validate([
            'end_date' => 'nullable|date',
            'development_methodology' => 'required|in:Agile Development,DevOps Deployment,Waterfall Development,Rapid Application Development',
            'system_platform' => 'required|in:Web-based App,Mobile App,Stand-alone App',
            'deployment_type' => 'required|in:Cloud,On-premises',
            'status' => 'required|in:Ahead of Schedule,On Schedule,Delayed,Completed',
            'last_report' => 'nullable|date',
        ]);

        // Update the project with the validated data
        $project->update($validatedData);

        return redirect()->route('dashboard')->with('success', 'Project progress updated successfully');
    }
}
