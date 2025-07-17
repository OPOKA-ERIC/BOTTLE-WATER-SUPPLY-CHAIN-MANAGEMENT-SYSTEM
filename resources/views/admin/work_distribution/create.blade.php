@extends('layouts.app', ['activePage' => 'work-distribution', 'title' => 'Create Work Distribution'])

@section('content')
<div class="container mt-5 pt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Create Work Distribution Task</h2>
        <a href="{{ route('admin.work-distribution.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">New Task</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.work-distribution.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Task Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-control" id="category" name="category" required>
                        <option value="">Select Category</option>
                        @foreach(\App\Models\TaskCategory::active()->get() as $cat)
                            <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="priority" class="form-label">Priority</label>
                    <select class="form-control" id="priority" name="priority" required>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="due_date" class="form-label">Due Date</label>
                    <input type="text" class="form-control datepicker" id="due_date" name="due_date" required autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location" required>
                </div>
                <div class="mb-3">
                    <label for="contact" class="form-label">Contact</label>
                    <input type="text" class="form-control" id="contact" name="contact" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="/light-bootstrap/js/plugins/bootstrap-datepicker.js"></script>
<script>
    $(document).ready(function() {
        if ($('.datepicker').length) {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                startDate: new Date(),
                autoclose: true,
                todayHighlight: true
            });
        }
    });
</script>
@endpush

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