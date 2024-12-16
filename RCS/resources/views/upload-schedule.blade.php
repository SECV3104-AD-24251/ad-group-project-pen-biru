<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Timetable</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .upload-box {
            border: 2px dashed #007bff;
            border-radius: 10px;
            padding: 50px;
            text-align: center;
            cursor: pointer;
            color: #007bff;
        }
        .upload-box.dragover {
            background-color: #f0f8ff;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Upload Timetable</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('upload.schedule') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="uploadBox" class="upload-box">
                <p>Drag and drop your Excel file here, or click to upload</p>
                <input type="file" name="file" id="fileInput" accept=".xlsx, .xls" style="display: none;">
            </div>
            <button type="submit" class="btn btn-primary mt-3">Upload</button>
        </form>
    </div>

    <script>
        const uploadBox = document.getElementById('uploadBox');
        const fileInput = document.getElementById('fileInput');

        uploadBox.addEventListener('click', () => fileInput.click());
        uploadBox.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadBox.classList.add('dragover');
        });
        uploadBox.addEventListener('dragleave', () => uploadBox.classList.remove('dragover'));
        uploadBox.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadBox.classList.remove('dragover');
            fileInput.files = e.dataTransfer.files;
        });
    </script>
</body>
</html>
