@extends('layouts.layout')

@section('content')
    <div class="container">
        <h2>Edit Project</h2>
        <form action="{{ route('projects.update', $project->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="project_name">Project Name:</label>
                <input type="text" class="form-control" id="project_name" name="project_name" value="{{ $project->project_name }}" required>
            </div>

            <div class="form-group">
                <label for="business_unit_name">Business Unit Name:</label>
                <input type="text" class="form-control" id="business_unit_name" name="business_unit_name" value="{{ $project->business_unit_name }}" required>
            </div>

            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $project->start_date }}" required>
            </div>

            <div class="form-group">
                <label for="duration">Duration (in days):</label>
                <input type="number" class="form-control" id="duration" name="duration" value="{{ $project->duration }}" required>
            </div>

            <div class="form-group">
                <label for="lead_developer_id">Lead Developer:</label>
                <select class="form-control" id="lead_developer_id" name="lead_developer_id" required>
                    @foreach($developers as $developer)
                    <option value="{{ $developer->id }}" {{ $developer->id == $project->lead_developer_id ? 'selected' : '' }}>
                        {{ $developer->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="other_developers">Other Developers (optional):</label>
                <select class="form-control" id="other_developers" name="other_developers[]" multiple>
                    @foreach($developers as $developer)
                        <option value="{{ $developer->id }}" {{ in_array($developer->id, $project->developers->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $developer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Project</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var leadDeveloperSelect = document.getElementById('lead_developer_id');
            var otherDevelopersSelect = document.getElementById('other_developers');
    
            function updateOtherDevelopersSelect() {
                var leadDeveloperId = leadDeveloperSelect.value;
                Array.from(otherDevelopersSelect.options).forEach(function (option) {
                    var developerId = option.value;
                    option.disabled = developerId === leadDeveloperId;
                    option.style.color = option.disabled ? 'gray' : '';
                });
                otherDevelopersSelect.value = []; 
            }
            leadDeveloperSelect.addEventListener('change', updateOtherDevelopersSelect);
            updateOtherDevelopersSelect(); 
        });
    </script>
@endsection
