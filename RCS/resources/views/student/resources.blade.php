<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classroom Resource Viewer</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Basic styling */
        /* Basic styling */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;

            background-image: url('{{ asset('images/Background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        h1 {
            text-align: center;
            padding: 20px;
            color: #004aad;
        }
        form, #room-layout {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        label {
            font-weight: 600;
        }
        select, .resource {
            margin-top: 10px;
            padding: 10px;
        }
        .resource {
            display: inline-block;
            width: 80px;
            height: 40px;
            text-align: center;
            line-height: 40px;
            margin: 5px;
            border-radius: 5px;
            font-weight: bold;
            color: white;
            cursor: pointer;
        }
        .usable {
            background-color: #28a745;
        }
        .unusable {
            background-color: #dc3545;
        }
        .row {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }
        .group {
            display: flex;
        }
        .aisle {
            width: 30px;
        }
        .projector {
            text-align: center;
            font-weight: bold;
            color: white;
            background-color: #004aad;
            margin: 10px auto;
            width: 120px;
            height: 40px;
            line-height: 40px;
            border-radius: 5px;
            cursor: pointer;
        }
        /* Status Indicator */
        .status-indicator {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 20px;
        }

        .status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: #333;
        }

        .square {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            display: inline-block;
        }

        .square.green {
            background-color: #28a745;
        }

        .square.red {
            background-color: #dc3545;
        }

        .navbar {
        max-width: 100vw; /* Ensures it doesn't go beyond the viewport width */
        width: 100%;
        box-sizing: border-box;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #004aad;
        padding: 10px 20px;
        color: white;
        overflow-x: hidden; /* Prevents horizontal scrolling */
    }

    .navbar-menu {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .navbar-menu li {
        margin: 0 10px;
    }

    .navbar-menu a {
        text-decoration: none;
        color: white;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .navbar {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .navbar-menu {
            flex-direction: column;
            width: 100%;
        }

        .navbar-menu li {
            margin: 5px 0;
        }
    }
    </style>
</head>
<body>
    <nav class="navbar student">
            <div class="navbar-brand">Resource Complaint System</div>
            <ul class="navbar-menu">
                <li><a href="/student-dashboard">Home</a></li>
                <li><a href="{{ route('complaints.create') }}">Create Complaints</a></li>
                <li><a href="{{ route('student.resources') }}">Classroom Resources</a></li>
                <li><a href="{{ route('logout') }}" class="logout-btn">Logout</a></li>
            </ul>
        </nav>
    <h1>Classroom Resource Viewer</h1>
    <form>
        <label for="room">Select Room:</label>
        <select id="room" required>
            <option value="" disabled selected>Select a room...</option>
            @foreach ($rooms as $room)
                <option value="{{ $room }}">{{ $room }}</option>
            @endforeach
        </select>
    </form>
    <div id="room-layout" style="display: none;">
        <h3>Room Layout</h3>
        <div class="status-indicator">
            <div class="status">
                <div class="square green"></div>
                <span>Working properly</span>
            </div>
            <div class="status">
                <div class="square red"></div>
                <span>Unusable</span>
            </div>
        </div>
        <div id="resources">
            <div id="projector" class="projector">Projector</div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const roomDropdown = document.getElementById('room');
        const roomLayout = document.getElementById('room-layout');
        const resourcesContainer = document.getElementById('resources');
        const projector = document.getElementById('projector'); // Get the existing projector element

        roomDropdown.addEventListener('change', () => {
            const room = roomDropdown.value;

            // Make the projector consistent: ensure it's centered and has the correct color
            projector.style.backgroundColor = '#004aad'; // Set the correct color
            projector.style.margin = '10px auto'; // Center the projector

            fetch(`/student/resources/${room}`)
                .then(response => response.json())
                .then(data => {
                    // Clear only the PCs and rows, leaving the projector intact
                    const children = Array.from(resourcesContainer.children).filter(
                        child => !child.classList.contains('projector')
                    );
                    children.forEach(child => resourcesContainer.removeChild(child));

                    roomLayout.style.display = 'block';

                    let currentRow = null;
                    data.forEach((resource, index) => {
                        if (index % 6 === 0) {
                            // Create a new row after every 6 PCs
                            currentRow = document.createElement('div');
                            currentRow.className = 'row';
                            resourcesContainer.appendChild(currentRow);

                            // Create two groups in the row
                            const groupLeft = document.createElement('div');
                            groupLeft.className = 'group';
                            currentRow.appendChild(groupLeft);

                            const aisle = document.createElement('div');
                            aisle.className = 'aisle';
                            currentRow.appendChild(aisle);

                            const groupRight = document.createElement('div');
                            groupRight.className = 'group';
                            currentRow.appendChild(groupRight);
                        }

                        // Add PCs to the appropriate group
                        const pcGroup = Math.floor((index % 6) / 3) === 0 ? currentRow.children[0] : currentRow.children[2];
                        const resourceDiv = document.createElement('div');
                        resourceDiv.className = `resource ${resource.condition.toLowerCase()}`;
                        resourceDiv.textContent = resource.resource;
                        resourceDiv.addEventListener('click', () => handleResourceClick(resource.resource));
                        pcGroup.appendChild(resourceDiv);
                    });
                })
                .catch(error => console.error('Error fetching resources:', error));
        });

        // Add click event for the projector
        projector.addEventListener('click', () => handleResourceClick('Projector'));

        // Function to handle resource clicks using SweetAlert2
        function handleResourceClick(resourceName) {
            Swal.fire({
                title: `Make a complaint about ${resourceName}?`,
                text: "Do you want to proceed?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, proceed",
                cancelButtonText: "Cancel",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the complaints/create page
                    window.location.href = '/complaints/create';
                }
            });
        }
    </script>
</body>
</html>
