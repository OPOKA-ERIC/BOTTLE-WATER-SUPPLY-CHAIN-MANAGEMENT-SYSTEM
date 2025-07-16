@if(count($history) > 0)
    <ul class="list-group">
        @foreach($history as $entry)
            <li class="list-group-item list-group-item-{{ $entry['type'] == 'warning' ? 'warning' : ($entry['type'] == 'info' ? 'info' : 'secondary') }}">
                <strong>{{ $entry['action'] }}:</strong> {{ $entry['description'] }}<br>
                <small class="text-muted">{{ $entry['date'] }}</small>
            </li>
        @endforeach
    </ul>
@else
    <div class="text-center text-muted">No history available for this inventory item.</div>
@endif 