<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>

    body {
        background: url('{{ asset('images/Background.jpg') }}') no-repeat center center fixed;
        background-size: cover;   
        min-height: 100vh;
        overflow-x: hidden; 
        color: white; 
    }
    .container {
        background: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3); /* Subtle shadow for better contrast */
    }
    /* Targeting table data cells within the table */
.table td {
    color: black; /* Set text color to black */
}


    /* Table styling */
    .table, .table th {
        color: white; 
    }

    /* Table header styling */
    .table-dark th {
        color: white; 
    }

    /* Heading styling */
    h2, h1 {
        color: white; 
    }

    /* Form elements (dropdown, buttons, etc.) */
    label, .form-select, .btn {
        color: white; /* Set form elements' text color to white */
    }

    /* Badge for suitability status */
    .badge {
        color: white; /* Set badge text color to white */
    }

    /* Adjusted button colors for contrast */
    .btn-success, .btn-danger, .btn-primary {
        color: white; /* Button text color */
    }

    label[for="block"], label[for="room_name"] {
        color: white;
    }

    /* Ensure the dropdown text is also black */
    #block, #room_name {
        color: black;
    }

    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar staff">
        <div class="navbar-brand">Booking Status</div>
        <ul class="navbar-menu">
            <li><a href="/staff-dashboard">Home</a></li>
            <li><a href="{{ route('maintenance-bookings.status') }}">View Booking Status</a></li>
            <li><a href="/condition">Resources</a></li>
            <li><a href="{{ route('logout') }}" class="logout-btn">Logout</a></li>
        </ul>
    </div>
    <div class="container mt-5">
        <h2 class="mb-4">List of Maintenance Bookings</h2>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Task</th>
                    <th>Block Name</th>
                    <th>Room</th>
                    <th>Priority</th>
                    <th>Suitability</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendingBookings as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->date }}</td>
                        <td>{{ $booking->time }}</td>
                        <td>{{ $booking->task }}</td>
                        <td>{{ $booking->block_name }}</td>
                        <td>{{ $booking->room }}</td>
                        <td>{{ $booking->priority }}</td>
                         <!-- Conflict Checker -->
                        <td>
                            <span class="badge {{ $booking->is_suitable ? 'bg-success' : 'bg-danger' }}">
                                {{ $booking->is_suitable ? 'Suitable' : 'Not Suitable' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('maintenance-bookings.approve', $booking->id) }}" class="btn btn-success">Approve</a>
                            <a href="{{ route('maintenance-bookings.disapprove', $booking->id) }}" class="btn btn-danger">Disapprove</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2 class="mt-5 mb-4">Booking History</h2>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Task</th>
                    <th>Block Name</th>
                    <th>Room</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Update Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($history as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->date }}</td>
                        <td>{{ $booking->time }}</td>
                        <td>{{ $booking->task }}</td>
                        <td>{{ $booking->block_name }}</td>
                        <td>{{ $booking->room }}</td>
                        <td>{{ $booking->priority }}</td>
                        <td>{{ ucfirst($booking->booking_status) }}</td>
                        <td>
                            <form action="{{ route('maintenance-bookings.updateStatus', $booking->id) }}" method="POST">
                                @csrf
                                <select name="booking_status" class="form-select">
                                    <option value="approved" {{ $booking->booking_status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="disapproved" {{ $booking->booking_status == 'disapproved' ? 'selected' : '' }}>Disapproved</option>
                                </select>
                                <button type="submit" class="btn btn-primary mt-1">Update</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Dropdown menu and FullCalendar integration -->
    <div class="container mt-5">
        <h2>Timetable Checker</h2>

        <!-- Dropdown for Block -->
        <div class="mb-3">
            <label for="block">Select Block:</label>
            <select id="block" class="form-select">
                <option value="">-- Select Block --</option>
                @foreach ($blocks as $block)
                    <option value="{{ $block }}">{{ $block }}</option>
                @endforeach
            </select>
        </div>

        <!-- Dropdown for Room -->
        <div class="mb-3">
            <label for="room_name">Select Classroom:</label>
            <select id="room_name" class="form-select" disabled>
                <option value="">-- Select Classroom --</option>
            </select>
        </div>

        <!-- FullCalendar Integration -->
        <div id="calendar"></div>
    </div>

    <script>
        $(document).ready(function () {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay'
                },
                events: [], // Placeholder for dynamic events
                eventColor: '#378006', // Set a default color
                allDaySlot: false,
                slotMinTime: '08:00:00', // Start displaying time from 8:00 AM
                slotMaxTime: '17:00:00', // Stop displaying time after 5:00 PM
                height: 'auto' // Automatically adjust height to content
            });

            calendar.render();

            // Fetch classrooms when block is selected
            $('#block').on('change', function () {
                const block = $(this).val();
                const roomSelect = $('#room_name');

                if (block) {
                    $.get('/get-classrooms-by-block', { block: block }, function (data) {
                        roomSelect.empty().append('<option value="">-- Select Classroom --</option>');
                        data.forEach(room => {
                            roomSelect.append(`<option value="${room}">${room}</option>`);
                        });
                        roomSelect.prop('disabled', false);
                        updateTimetable(calendar); // Update timetable on block change
                    });
                } else {
                    roomSelect.prop('disabled', true).empty().append('<option value="">-- Select Classroom --</option>');
                    calendar.removeAllEvents(); // Clear calendar events
                }
            });

            // Update timetable when a room is selected
            $('#room_name').on('change', function () {
                updateTimetable(calendar);
            });

            function updateTimetable(calendarInstance) {
                const block = $('#block').val();
                const roomName = $('#room_name').val();

                if (block && roomName) {
                    $.get('/get-filtered-timetable', { block: block, room_name: roomName }, function (data) {
                        calendarInstance.removeAllEvents(); // Clear existing events

                        if (data.length > 0) {
                            data.forEach(slot => {
                                const dayToNumber = {
                                    'Monday': 1,
                                    'Tuesday': 2,
                                    'Wednesday': 3,
                                    'Thursday': 4,
                                    'Friday': 5,
                                    'Saturday': 6,
                                    'Sunday': 7
                                };

                                // Add event for each timetable slot
                                calendarInstance.addEvent({
                                    title: `${slot.subject} (${slot.instructor})`,
                                    start: getDateForDay(dayToNumber[slot.day], slot.start_time),
                                    end: getDateForDay(dayToNumber[slot.day], slot.end_time)
                                });
                            });
                        }
                    });
                } else {
                    calendarInstance.removeAllEvents(); // Clear events if filters are deselected
                }
            }

            // Helper function to get the start/end time for a specific day in the week
            function getDateForDay(dayOfWeek, time) {
                const now = new Date();
                const diff = dayOfWeek - now.getDay();
                const targetDate = new Date(now);

                targetDate.setDate(now.getDate() + (diff < 0 ? diff + 7 : diff)); // Get next week's date if needed
                targetDate.setHours(...time.split(':').map(Number));
                targetDate.setSeconds(0);

                return targetDate.toISOString(); // Return in ISO format for FullCalendar
            }
        });
    </script>
</body>
</html>
