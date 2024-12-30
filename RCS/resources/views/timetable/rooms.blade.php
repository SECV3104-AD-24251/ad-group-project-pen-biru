<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Room</title>
</head>
<body>
    <header>
        <h1>Room Booking System</h1>
    </header>
    <main>
        <h2>Select Room</h2>
        <form action="{{ route('timetable.weekly') }}" method="GET">
            <label for="room">Room:</label>
            <select name="room" id="room">
                @foreach ($rooms as $room)
                    <option value="{{ $room->room_name }}">{{ $room->room_name }}</option>
                @endforeach
            </select>
            <label for="week">Week:</label>
            <select name="week" id="week">
                <option value="1">Week 1</option>
                <option value="2">Week 2</option>
                <option value="3">Week 3</option>
                <option value="4">Week 4</option>
            </select>
            <button type="submit">View Timetable</button>
        </form>
    </main>
    <footer>
        <p>&copy; {{ date('Y') }} Room Booking System</p>
    </footer>
</body>
</html>
