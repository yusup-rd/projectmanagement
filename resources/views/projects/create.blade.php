@extends('layouts.layout')

@section('content')
    <div class="container">
        <h2>Add New Project</h2>
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="project_name">Project Name:</label>
                <input type="text" class="form-control" id="project_name" name="project_name" required>
            </div>

            <div class="form-group">
                <label for="business_unit_name">Business Unit Name:</label>
                <input type="text" class="form-control" id="business_unit_name" name="business_unit_name" required>
            </div>

            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>

            <div class="form-group">
                <label for="duration">Duration (in days):</label>
                <input type="number" class="form-control" id="duration" name="duration" required>
            </div>

            <div class="form-group">
                <label for="pic_id">PIC:</label>
                <select class="form-control" id="pic_id" name="pic_id" required>
                    @foreach($managers as $manager)
                        <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="lead_developer_id">Lead Developer:</label>
                <select class="form-control" id="lead_developer_id" name="lead_developer_id" required>
                    @foreach($developers as $developer)
                        <option value="{{ $developer->id }}">{{ $developer->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="other_developers">Other Developers (optional):</label>
                <select class="form-control" id="other_developers" name="other_developers[]" multiple>
                    @foreach($developers as $developer)
                        <option value="{{ $developer->id }}" data-is-lead="{{ $developer->isLeadDeveloper() ? 'true' : 'false' }}">
                            {{ $developer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Save Project</button>
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
