@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="my-4">Dashboard</h2>
    @if(auth()->check())
        <p>Welcome, {{ auth()->user()->name }}!</p>
    @endif
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Project Name</th>
                    <th>Business Unit</th>
                    <th>Start Date</th>
                    <th>Duration</th>
                    <th>End Date</th>
                    <th>Lead Developer</th>
                    <th>Other Developers</th>
                    <th>Info</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($projects))
                @foreach($projects as $project)
                <tr>
                    <td>{{ $project->project_name }}</td>
                    <td>{{ $project->business_unit_name }}</td>
                    <td>{{ $project->start_date }}</td>
                    <td>{{ $project->duration }} days</td>
                    <td>{{ $project->end_date }}</td>
                    <td>{{ $project->leadDeveloper->name }}</td>
                    <td>
                        @foreach($project->developers as $developer)
                            {{ $developer->name }}<br>
                        @endforeach
                    </td>
                    <td>
                        @if($project)
                            <div>
                                <strong>Methodology:</strong>
                                {{ $project->development_methodology ?: 'Not set' }}<br/>
                                <strong>Platform:</strong>
                                {{ $project->system_platform ?: 'Not set' }}<br/>
                                <strong>Deployment:</strong>
                                {{ $project->deployment_type ?: 'Not set' }}<br/>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div>
                            <p>{{ $project->status}}</p>
                            <p>{{ $project->last_report ? 'Last Update: ' . \Carbon\Carbon::parse($project->last_report)->format('Y-M-d') : 'Not set' }}</p>
                        </div>
                    </td>
                    <td>                    
                        @if(auth()->user()->isLeadDeveloper())
                            @if($project->lead_developer_id === auth()->user()->id)
                                <a href="{{ route('projects.update-progress-form', $project->id) }}" class="btn btn-primary">Update Progress</a>
                            @else
                                <p>No Action Allowed</p>
                            @endif
                        @elseif(auth()->user()->isManager())
                            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary btn-custom-width">Edit</a>
                            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-custom-width">Delete</button>
                            </form>
                        @else
                            <p>No Action Allowed</p>
                        @endif
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
