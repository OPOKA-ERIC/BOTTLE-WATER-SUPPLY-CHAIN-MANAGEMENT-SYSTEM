@extends('layouts.app', ['activePage' => 'work-distribution', 'title' => 'Task Assignment History'])

@section('content')
<div class="container mt-5 pt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Assignment History for Task: {{ $task->title }}</h2>
        <a href="{{ route('admin.work-distribution.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">Assignment/Reassignment Audit Trail</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th>Old Assignee</th>
                            <th>New Assignee</th>
                            <th>Changed By</th>
                            <th>Reason</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($audits as $audit)
                        <tr>
                            <td>{{ $audit->oldAssignee?->name ?? 'N/A' }}</td>
                            <td>{{ $audit->newAssignee?->name ?? 'N/A' }}</td>
                            <td>{{ $audit->changer?->name ?? 'N/A' }}</td>
                            <td>{{ $audit->reason }}</td>
                            <td>{{ $audit->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No assignment history found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @php($statusAudits = $task->statusAudits()->with('changer')->latest()->get())
    <div class="card mt-4">
        <div class="card-header bg-info text-white">Status Change Audit Trail</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th>Old Status</th>
                            <th>New Status</th>
                            <th>Changed By</th>
                            <th>Reason</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($statusAudits as $audit)
                        <tr>
                            <td>{{ ucfirst($audit->old_status) ?? 'N/A' }}</td>
                            <td>{{ ucfirst($audit->new_status) }}</td>
                            <td>{{ $audit->changer?->name ?? 'N/A' }}</td>
                            <td>{{ $audit->reason }}</td>
                            <td>{{ $audit->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No status change history found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header bg-secondary text-white">Task Comments</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.work-distribution.addComment', $task->id) }}">
                @csrf
                <div class="form-group">
                    <label for="comment">Add Comment</label>
                    <textarea class="form-control" id="comment" name="comment" rows="2" required></textarea>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_internal" id="is_internal" value="1">
                    <label class="form-check-label" for="is_internal">Internal (visible to admins only)</label>
                </div>
                <button type="submit" class="btn btn-primary">Add Comment</button>
            </form>
            <hr>
            <h5>All Comments</h5>
            <ul class="list-group">
                @forelse($comments as $comment)
                    <li class="list-group-item">
                        <strong>{{ $comment->user->name }}</strong>
                        <span class="text-muted">({{ $comment->formatted_date }})</span>
                        @if($comment->is_internal)
                            <span class="badge badge-warning">Internal</span>
                        @endif
                        <br>
                        {{ $comment->comment }}
                    </li>
                @empty
                    <li class="list-group-item text-muted">No comments yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
    {{-- Feedback and Review Section --}}
    @if($task->status === 'completed')
        <div class="card mt-4">
            <div class="card-header bg-success text-white">Feedback & Review</div>
            <div class="card-body">
                {{-- Worker Feedback --}}
                @if(!$task->feedback && auth()->id() === $task->assigned_to)
                    <form method="POST" action="{{ route('admin.work-distribution.feedback', $task->id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="feedback">Your Feedback on this Task</label>
                            <textarea class="form-control" id="feedback" name="feedback" rows="2" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Submit Feedback</button>
                    </form>
                @elseif($task->feedback)
                    <div class="mb-3">
                        <h5>Worker Feedback</h5>
                        <div class="alert alert-info mb-0">
                            <strong>{{ $task->feedback->user->name }}:</strong> {{ $task->feedback->feedback }}
                            <br>
                            <small class="text-muted">{{ $task->feedback->created_at->format('Y-m-d H:i') }}</small>
                        </div>
                    </div>
                @endif

                {{-- Supervisor Review --}}
                @if(!$task->review && auth()->user() && auth()->user()->isAdmin())
                    <form method="POST" action="{{ route('admin.work-distribution.review', $task->id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="rating">Rate Worker Performance (1-5)</label>
                            <input type="number" class="form-control w-25" id="rating" name="rating" min="1" max="5" required>
                        </div>
                        <div class="form-group">
                            <label for="review">Supervisor Review (optional)</label>
                            <textarea class="form-control" id="review" name="review" rows="2"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                    </form>
                @elseif($task->review)
                    <div class="mb-3">
                        <h5>Supervisor Review</h5>
                        <div class="alert alert-primary mb-0">
                            <strong>{{ $task->review->supervisor->name }}:</strong> 
                            <span>Rating: <b>{{ $task->review->rating }}/5</b></span>
                            <br>
                            @if($task->review->review)
                                <span>{{ $task->review->review }}</span><br>
                            @endif
                            <small class="text-muted">{{ $task->review->created_at->format('Y-m-d H:i') }}</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection 