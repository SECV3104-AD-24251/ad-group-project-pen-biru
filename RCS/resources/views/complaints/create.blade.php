<!DOCTYPE html>
<html>
<head>
    <title>Submit Complaint</title>
</head>
<body>
    <h1>Submit a Complaint</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="block_name">Block Name:</label>
        <select name="block_name" id="block_name" required>
            <option value="">Select a block</option>
            @foreach($blocks as $block)
                <option value="{{ $block }}">{{ $block }}</option>
            @endforeach
        </select>
        <br>

        <label for="room">Room:</label>
        <input type="text" name="room" id="room" required>
        <br>

        <label for="resource_type">Resource Type:</label>
        <select name="resource_type" id="resource_type" required>
            <option value="">Select a resource</option>
            @foreach($resources as $resource)
                <option value="{{ $resource }}">{{ $resource }}</option>
            @endforeach
        </select>
        <br>

        <label for="description">Description:</label>
        <textarea name="description" id="description"></textarea>
        <br>

        <label for="image">Upload an Image:</label>
        <input type="file" name="image" id="image">
        <br>

        <button type="submit">Submit</button>
    </form>

    <h2>Status of Resources</h2>
    <ul>
        @foreach($statuses as $status)
            <li>{{ $status->status }} - {{ $status->created_at }} 
                <a href="{{ route('complaints.history', $status->complaint_id) }}">Detail</a>
            </li>
        @endforeach
    </ul>
</body>
</html>
