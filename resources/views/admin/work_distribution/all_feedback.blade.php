@extends('layouts.app', ['activePage' => 'task-feedback', 'title' => 'All Task Feedback'])

@section('content')
<style>
    @media (min-width: 992px) {
        .task-feedback-content-fix {
            padding-left: 40px !important;
        }
    }
    @media (max-width: 991px) {
        .task-feedback-content-fix {
            padding-left: 0 !important;
        }
    }
    .task-feedback-content-fix {
        margin-top: 70px !important;
        min-height: 100vh;
    }
</style>
<div class="container mt-5 pt-4 task-feedback-content-fix">
    <h2>All Task Feedback</h2>
    <div class="card mt-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th>Task</th>
                            <th>Worker</th>
                            <th>Feedback</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($feedbacks as $feedback)
                        <tr>
                            <td><a href="{{ route('admin.work-distribution.history', $feedback->task_id) }}">{{ $feedback->task->title ?? 'N/A' }}</a></td>
                            <td>{{ $feedback->user->name ?? 'N/A' }}</td>
                            <td>{{ $feedback->feedback }}</td>
                            <td>{{ $feedback->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No feedback found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3 px-3">
                {{ $feedbacks->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 