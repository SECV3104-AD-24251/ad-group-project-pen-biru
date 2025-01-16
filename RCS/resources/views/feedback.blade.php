<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        form {
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

        .rating {
            margin-bottom: 20px;
        }

        .stars {
            display: flex;
            gap: 5px;
        }

        .stars i {
            font-size: 24px;
            color: lightgray;
            cursor: pointer;
        }

        .stars i.selected {
            color: gold;
        }

        textarea {
            width: 100%;
            height: 80px;
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: 'Poppins', sans-serif;
        }

        button {
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #004aad;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }

        button:hover {
            background-color: #003c8f;
        }
    </style>
</head>
<body>
    <h1>Feedback Form</h1>
    <form id="feedbackForm">
        @csrf
        <div class="rating">
            <label>Resource Availability:</label>
            <div class="stars" id="resourceAvailability"></div>
            <input type="hidden" name="resource_availability" id="resource_availability_rating">
        </div>
        <div class="rating">
            <label>Resource Quality:</label>
            <div class="stars" id="resourceQuality"></div>
            <input type="hidden" name="resource_quality" id="resource_quality_rating">
        </div>
        <div class="rating">
            <label>Ease of Reporting Issues:</label>
            <div class="stars" id="easeReporting"></div>
            <input type="hidden" name="ease_of_reporting" id="ease_reporting_rating">
        </div>
        <div class="rating">
            <label>Ease of Use:</label>
            <div class="stars" id="easeOfUse"></div>
            <input type="hidden" name="ease_of_use" id="ease_of_use_rating">
        </div>
        <div class="rating">
            <label>Response Time:</label>
            <div class="stars" id="responseTime"></div>
            <input type="hidden" name="response_time" id="response_time_rating">
        </div>
        <div class="rating">
            <label>Clarity of Process:</label>
            <div class="stars" id="clarityProcess"></div>
            <input type="hidden" name="clarity_of_process" id="clarity_process_rating">
        </div>
        <div class="rating">
            <label>Overall Experience:</label>
            <div class="stars" id="overallExperience"></div>
            <input type="hidden" name="overall_experience" id="overall_experience_rating">
        </div>
        <textarea name="suggestions" id="suggestions" placeholder="Your suggestions or feedback"></textarea>
        <button type="submit">Submit Feedback</button>
    </form>
    <script>
        function createStarRating(elementId, inputId) {
            const element = document.getElementById(elementId);
            const input = document.getElementById(inputId);

            for (let i = 1; i <= 5; i++) {
                const star = document.createElement('i');
                star.className = "fa fa-star";
                star.addEventListener('click', () => {
                    setRating(element, i);
                    input.value = i;
                });
                element.appendChild(star);
            }
        }

        function setRating(element, rating) {
            Array.from(element.children).forEach((child, index) => {
                child.classList.toggle('selected', index < rating);
            });
        }

        createStarRating('resourceAvailability', 'resource_availability_rating');
        createStarRating('resourceQuality', 'resource_quality_rating');
        createStarRating('easeReporting', 'ease_reporting_rating');
        createStarRating('easeOfUse', 'ease_of_use_rating');
        createStarRating('responseTime', 'response_time_rating');
        createStarRating('clarityProcess', 'clarity_process_rating');
        createStarRating('overallExperience', 'overall_experience_rating');

        const form = document.getElementById('feedbackForm');
        form.addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(form);

    fetch('/submit-feedback', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
        }
    })
        .then(response => {
            if (response.ok) {
                alert('Feedback submitted successfully!');
                window.location.href = '/complaints/create'; // Redirect to the complaints creation page
            } else {
                alert('Failed to submit feedback. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while submitting feedback.');
        });
});

    </script>
</body>
</html>
