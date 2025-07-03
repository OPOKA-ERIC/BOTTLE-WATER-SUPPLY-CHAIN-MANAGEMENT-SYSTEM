@extends('layouts.app', ['activePage' => 'work-distribution', 'title' => 'Create Work Distribution'])

@section('content')
<div class="container mt-4">
    <a href="{{ route('admin.work-distribution.index') }}" class="btn btn-secondary mb-3">&larr; Back to Work Distribution</a>
    <div class="card">
        <div class="card-header bg-primary text-white">Create New Work Distribution</div>
        <div class="card-body">
            <form action="{{ route('admin.work-distribution.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="required_skill">Required Skill</label>
                    <select name="required_skill" id="required_skill" class="form-control">
                        <option value="">-- Select Skill --</option>
                        @foreach($allSkills as $skill)
                            <option value="{{ $skill }}">{{ ucfirst($skill) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="assignee">Assignee</label>
                    <select name="assignee" id="assignee" class="form-control" required>
                        <option value="">-- Select User --</option>
                        @foreach($users as $user)
                            @php $userSkills = is_array($user->skills) ? implode(', ', $user->skills) : ''; @endphp
                            <option value="{{ $user->name }}" data-skills="{{ $userSkills }}">
                                {{ $user->name }} @if($userSkills) ({{ $userSkills }}) @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="due_date">Due Date</label>
                    <input type="date" name="due_date" id="due_date" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const skillSelect = document.getElementById('required_skill');
    const assigneeSelect = document.getElementById('assignee');
    if (skillSelect && assigneeSelect) {
        skillSelect.addEventListener('change', function() {
            const selectedSkill = this.value;
            Array.from(assigneeSelect.options).forEach(option => {
                if (!option.value) return option.style.display = '';
                const userSkills = option.getAttribute('data-skills') || '';
                if (!selectedSkill || userSkills.split(', ').includes(selectedSkill)) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            });
            assigneeSelect.value = '';
        });
    }
});
</script>
@endpush 