<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource Condition Audit</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
            color: #333;
        }

        h1 {
            text-align: center;
            padding: 20px 0;
            color: #004aad;
        }

        form, #room-layout, #update-modal {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        label {
            font-weight: 600;
            margin-right: 10px;
        }

        select, button {
            padding: 8px 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: 'Poppins', sans-serif;
        }

        button {
            background-color: #004aad;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #003c8f;
        }

        .resource {
            display: inline-block;
            width: 80px;
            height: 40px;
            border-radius: 5px;
            border: 1px solid #ddd;
            text-align: center;
            line-height: 40px;
            margin: 8px;
            cursor: pointer;
            font-weight: 600;
            color: #fff;
        }

        .usable {
            background-color: #28a745;
        }

        .unusable {
            background-color: #dc3545;
        }

        #update-modal {
            position: fixed;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -30%);
            width: 300px;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            z-index: 1000;
        }

        #update-modal h3 {
            color: #004aad;
            margin-bottom: 10px;
        }

        #update-modal button {
            width: 100%;
            margin-top: 10px;
        }

        #room-layout {
            display: none;
            text-align: center;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar staff">
        <div class="navbar-brand">Resource Condition Audit</div>
        <ul class="navbar-menu">
            <li><a href="/staff-dashboard">Home</a></li>
            <li><a href="{{ route('maintenance-bookings.status') }}">View Booking Status</a></li>
            <li><a href="/condition">Resources</a></li>
        </ul>
    </div>

    <!-- Room Selection -->
    <form id="room-selection-form">
        <label for="room">Select Room:</label>
        <select name="room" id="room" required>
            <option value="" disabled selected>Choose a room...</option>
            <option value="CGMTL Room">CGMTL Room</option>
            <option value="CCNA Room">CCNA Room</option>
            <option value="BK1">BK1</option>
            <option value="BK2">BK2</option>
            <option value="BK3">BK3</option>
            <option value="MPK1">MPK1</option>
            <option value="MPK2">MPK2</option>
            <option value="MPK3">MPK3</option>
        </select>

        <button type="submit">View Resource</button>
    </form>

    <!-- Room Layout -->
    <div id="room-layout">
        <h3>Click a resource to update its condition</h3>
        <div class="resource usable" data-resource="Projector">Projector</div>
        <div class="resource usable" data-resource="pc1">PC 1</div>
        <div class="resource usable" data-resource="pc2">PC 2</div>
        <div class="resource usable" data-resource="pc3">PC 3</div>
        <div class="resource usable" data-resource="pc4">PC 4</div>
        <div class="resource usable" data-resource="pc5">PC 5</div>
        <!-- Repeat for PCs 6 to 25 -->
        @for ($i = 6; $i <= 25; $i++)
            <div class="resource usable" data-resource="pc{{ $i }}">PC {{ $i }}</div>
        @endfor
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Modal for updating resource condition -->
    <div id="update-modal" style="display: none;">
        <h3>Update Condition</h3>
        <p>Resource: <span id="selected-resource"></span></p>
        <form id="update-form">
            @csrf
            <input type="hidden" name="room" id="room-input">
            <input type="hidden" name="resource" id="resource-input">

            <label for="condition">Condition:</label>
            <select name="condition" id="condition" required>
                <option value="USABLE">USABLE</option>
                <option value="UNUSABLE">UNUSABLE</option>
            </select>

            <button type="submit">Update</button>
            <button type="button" onclick="closeModal()">Cancel</button>
        </form>
    </div>

    <script>
        document.getElementById('room-selection-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const room = document.getElementById('room').value;
            document.getElementById('room-input').value = room;
            document.getElementById('room-layout').style.display = 'block';
        });

        document.querySelectorAll('.resource').forEach(function (resource) {
            resource.addEventListener('click', function () {
                const resourceName = this.getAttribute('data-resource');
                document.getElementById('selected-resource').innerText = resourceName;
                document.getElementById('resource-input').value = resourceName;
                document.getElementById('update-modal').style.display = 'block';
                document.getElementById('overlay').style.display = 'block';
            });
        });

        document.getElementById('update-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch("{{ route('updateCondition') }}", {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                closeModal();
                location.reload();
            })
            .catch(error => console.error('Error:', error));
        });

        function closeModal() {
            document.getElementById('update-modal').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }
    </script>
</body>
</html>
