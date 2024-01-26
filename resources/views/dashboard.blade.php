@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="my-4">Dashboard</h2>
    @if(auth()->check())
        <p>Welcome, {{ auth()->user()->name }}!</p>
    @endif
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-rounded">
            <thead class="thead-dark">
                <tr>
                    <th>Project</th>
                    <th>Dates</th>
                    <th>Team</th>
                    <th>Details</th>
                    <th>Progress</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($projects))
                @foreach($projects as $project)
                <tr>
                    <td>
                        <p class="font-weight-bold">{{ $project->project_name }}</p>
                        <p class="text-muted">{{ $project->business_unit_name }}</p>
                    </td>
                    <td>
                        <strong>Start Date:</strong> {{ $project->start_date }}<br><br>
                        <strong>Duration:</strong> {{ $project->duration }} days<br><br>
                        <strong>End Date:</strong> {{ $project->end_date ?: 'Not set' }}
                    </td>
                    <td>
                        <strong>PIC:</strong> {{ $project->pic->name }}<br><br>
                        <strong>Lead Developer:</strong> {{ $project->leadDeveloper->name }}<br><br>
                        <strong>Other Developers:</strong>
                        @forelse($project->developers as $developer)
                            {{ $developer->name }}<br>
                        @empty
                            None
                        @endforelse
                    </td>
                    <td>
                        <strong>Methodology:</strong> {{ $project->development_methodology ?: 'Not set' }}<br><br>
                        <strong>Platform:</strong> {{ $project->system_platform ?: 'Not set' }}<br><br>
                        <strong>Deployment:</strong> {{ $project->deployment_type ?: 'Not set' }}
                    </td>
                    <td>
                        <strong>Status:</strong> {{ $project->status?: 'No status' }}<br><br>
                        <strong>Last Update:</strong> {{ $project->last_report ?: 'No updates' }}<br><br>
                        <strong>Description:</strong>
                        <p class="text-break">{{ $project->description ?: 'No description' }}</p>
                    </td>
                    <td class="align-middle text-center">                    
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
                                <button type="submit" class="btn btn-danger btn-custom-width" onclick="confirmDelete({{ $project->id }})">Delete</button>
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

<script>
    function confirmDelete(projectId) {
        var result = confirm("Are you sure you want to delete this project?");
        if (result) {
            // If user confirms, proceed with the deletion
            window.location.href = "{{ url('projects/destroy') }}" + "/" + projectId;
        }
    }
</script>

@endsection
