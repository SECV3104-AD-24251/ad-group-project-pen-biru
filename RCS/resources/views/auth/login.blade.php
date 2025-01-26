<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('{{ asset('images/Background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="bg-gray-100 bg-opacity-80">
    <!-- Top Bar -->
    <div class="bg-blue-600 text-white py-4 shadow-md bg-opacity-90">
        <h1 class="text-center text-lg font-bold">Welcome to Resource Complaint System</h1>
    </div>

    <!-- Login Form -->
    <div class="flex items-center justify-center min-h-screen -mt-16">
        <div class="bg-white shadow-md rounded-lg p-8 max-w-sm w-full bg-opacity-90">
            <h1 class="text-2xl font-semibold text-gray-700 text-center mb-6">Login</h1>
            <form action="{{ url('/login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                    <input type="email" name="email" id="email" required
                        class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
                </div>
                <button type="submit"
                    class="w-full bg-blue-500 text-white font-medium py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">
                    Login
                </button>
            </form>
            @if($errors->any())
                <div class="mt-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                    <ul class="text-sm space-y-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
