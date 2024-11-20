<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form</title>

</head>
<body>
   
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f9;
            margin: 0;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            position: relative;
        }

        input,
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        #loading {
            display: none;
            margin: 1px;
           
            text-align: center;
            font-size: 18px;
            color: #007bff;
        }

        #responseMessage {
            margin-top: 10px;
            font-size: 16px;
            color: #007bff;
            text-align: center;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function getLocationAndSubmit() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(sendPosition, showError);
            } else {
                showMessage("Geolocation is not supported by this browser.", true);
            }
        }

        function sendPosition(position) {
            $('#latitude').val(position.coords.latitude);
            $('#longitude').val(position.coords.longitude);
            submitForm();
        }

        function showError(error) {
            showMessage("Unable to retrieve location: " + error.message, true);
        }

        function submitForm() {
            $('#loading').show();
            $('#responseMessage').text('');
            $.ajax({
                url: 'FoodOrder.php',
                type: 'POST',
                data: $('#bookingForm').serialize(),
                success: function (response) {
                    $('#loading').hide();
                    showMessage(response, false);
                },
                error: function () {
                    $('#loading').hide();
                    showMessage('An error occurred while sending data.', true);
                }
            });
        }

        function showMessage(message, isError) {
            $('#responseMessage').text(message).css('color', isError ? 'red' : '#007bff');
        }
    </script>
</head>

<body>
    <form id="bookingForm">
        <input type="text" name="firstName" placeholder="First Name" required>
        <input type="text" name="lastName" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phoneNumber" placeholder="Phone Number" required>
        <input type="text" name="resturantName" placeholder="Resturant Name" required>
        <input type="text" name="food" placeholder="Food" required>
        <input type="text" name="drinks" placeholder="Drinks" required>
        <input type="text" name="age" placeholder="Age" required>
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
        <button type="button" onclick="getLocationAndSubmit()">Submit</button>
        <div id="loading">Sending...</div>
        <div id="responseMessage"></div>
    </form>


</body>
</html>