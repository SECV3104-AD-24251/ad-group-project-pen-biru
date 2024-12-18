<table class="table table-bordered">
    <thead>
        <tr>
            <th>Status</th>
            <th>Remarks</th>
            <th>Changed At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($complaint->histories as $history)
        <tr>
            <td>{{ ucfirst($history->status) }}</td>
            <td>{{ $history->remarks }}</td>
            <td>{{ $history->changed_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
