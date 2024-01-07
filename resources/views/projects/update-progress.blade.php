@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="my-4">Update Project Progress</h2>
    <form method="POST" action="{{ route('projects.update-progress', $project->id) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="end_date">End Date:</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $project->end_date }}">
                </div>
    
                <div class="form-group">
                    <label for="development_methodology">Development Methodology:</label>
                    <select class="form-control" id="development_methodology" name="development_methodology" required>
                        <option value="Agile Development" {{ $project->development_methodology == 'Agile Development' ? 'selected' : '' }}>Agile Development</option>
                        <option value="DevOps Deployment" {{ $project->development_methodology == 'DevOps Deployment' ? 'selected' : '' }}>DevOps Deployment</option>
                        <option value="Waterfall Development" {{ $project->development_methodology == 'Waterfall Development' ? 'selected' : '' }}>Waterfall Development</option>
                        <option value="Rapid Application Development" {{ $project->development_methodology == 'Rapid Application Development' ? 'selected' : '' }}>Rapid Application Development</option>
                    </select>
                </div>
                
    
                <div class="form-group">
                    <label for="system_platform">System Platform:</label>
                    <select class="form-control" id="system_platform" name="system_platform" required>
                        <option value="Web-based App" {{ $project->system_platform == 'Web-based App' ? 'selected' : '' }}>Web-based App</option>
                        <option value="Mobile App" {{ $project->system_platform == 'Mobile App' ? 'selected' : '' }}>Mobile App</option>
                        <option value="Stand-alone App" {{ $project->system_platform == 'Stand-alone App' ? 'selected' : '' }}>Stand-alone App</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="deployment_type">Deployment Type:</label>
                    <select class="form-control" id="deployment_type" name="deployment_type" required>
                        <option value="Cloud" {{ $project->deployment_type == 'Cloud' ? 'selected' : '' }}>Cloud</option>
                        <option value="On-premises" {{ $project->deployment_type == 'On-premises' ? 'selected' : '' }}>On-premises</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="Ahead of Schedule" {{ $project->status == 'Ahead of Schedule' ? 'selected' : '' }}>Ahead of Schedule</option>
                        <option value="On Schedule" {{ $project->status == 'On Schedule' ? 'selected' : '' }}>On Schedule</option>
                        <option value="Delayed" {{ $project->status == 'Delayed' ? 'selected' : '' }}>Delayed</option>
                        <option value="Completed" {{ $project->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                
            
                <div class="form-group">
                    <label for="last_report">Report Date:</label>
                    <input type="date" class="form-control" id="last_report" name="last_report"  value="{{ $project->last_report }}" required>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Progress</button>
    </form>
</div>
@endsection
