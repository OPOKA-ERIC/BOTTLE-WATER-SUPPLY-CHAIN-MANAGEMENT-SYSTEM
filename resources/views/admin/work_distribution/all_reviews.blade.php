@extends('layouts.app', ['activePage' => 'task-reviews', 'title' => 'All Task Reviews'])

@section('content')
<style>
    @media (min-width: 992px) {
        .task-reviews-content-fix {
            padding-left: 40px !important;
        }
    }
    @media (max-width: 991px) {
        .task-reviews-content-fix {
            padding-left: 0 !important;
        }
    }
    .task-reviews-content-fix {
        margin-top: 70px !important;
        min-height: 100vh;
    }
</style>
<div class="container mt-5 pt-4 task-reviews-content-fix">
    <h2>All Task Reviews</h2>
    <div class="card mt-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th>Task</th>
                            <th>Supervisor</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                        <tr>
                            <td><a href="{{ route('admin.work-distribution.history', $review->task_id) }}">{{ $review->task->title ?? 'N/A' }}</a></td>
                            <td>{{ $review->supervisor->name ?? 'N/A' }}</td>
                            <td><span class="badge badge-primary">{{ $review->rating }}/5</span></td>
                            <td>{{ $review->review }}</td>
                            <td>{{ $review->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No reviews found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3 px-3">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 