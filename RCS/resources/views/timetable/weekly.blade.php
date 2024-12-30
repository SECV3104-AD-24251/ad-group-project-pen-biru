<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Timetable</title>
</head>
<body>
    <header>
        <h1>Room Booking System</h1>
    </header>
    <main>
        <h2>Timetable for Room {{ $room }}</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Slot</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($timetable as $slot)
                <tr>
                    <td>{{ $slot->date }}</td>
                    <td>{{ ucfirst($slot->slot) }}</td>
                    <td>{{ ucfirst($slot->status) }}</td>
                    <td>
                        @if ($slot->status == 'available')
                        <form action="{{ route('timetable.book') }}" method="POST">
                            @csrf
                            <input type="hidden" name="room" value="{{ $room }}">
                            <input type="hidden" name="date" value="{{ $slot->date }}">
                            <input type="hidden" name="slot" value="{{ $slot->slot }}">
                            <input type="text" name="description" placeholder="Description">
                            <button type="submit">Book</button>
                        </form>
                        @else
                        Booked
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
    <footer>
        <p>&copy; {{ date('Y') }} Room Booking System</p>
    </footer>
</body>
</html>
