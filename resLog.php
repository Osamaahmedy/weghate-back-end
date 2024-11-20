<?php
// في كل صفحة تحتاج إلى حماية

// بدء الجلسة
session_start();

// التحقق من وجود جلسة
if (!isset($_SESSION['user'])) {
    header('Location: account.html');
    exit;
}

// التحقق من انتهاء الجلسة
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 600)) {
    // إذا انتهت الجلسة بعد `1` دقيقة، قم بتسجيل خروج المستخدم
    header('Location: logout.php');
    exit;
}

// تحديث وقت النشاط
$_SESSION['last_activity'] = time();

// استمرار عرض المحتوى الآن
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="resLog.css">
</head>
<body>
  

    <form id="bookingForm">
        <div class="form-group">
          <label for="firstName">First Name</label>
          <input type="text" id="firstName" name="firstName" placeholder="First Name" required>
        </div>
        <div class="form-group">
          <label for="lastName">Last Name</label>
          <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
          <label for="phoneNumber">Phone Number</label>
          <input type="text" id="phoneNumber" name="phoneNumber" placeholder="Phone Number" required>
        </div>
        <div class="form-group">
          <label for="restaurantName">Resturant Name</label>
          <input type="text" id="restaurantName" name="resturantName" placeholder="Resturant Name" required>
        </div>
        <div class="form-group">
          <label for="food">Food</label>
          <input type="text" id="food" name="food" placeholder="Food" required>
        </div>
        <div class="form-group">
          <label for="drinks">Drinks</label>
          <input type="text" id="drinks" name="drinks" placeholder="Drinks" required>
        </div>
        <div class="form-group">
          <label for="age">Age</label>
          <input type="text" id="age" name="age" placeholder="Age" required>
        </div>
        <input type="hidden" id="latitude" name="latitude">
        <input type="hidden" id="longitude" name="longitude">
        <button type="button" onclick="getLocationAndSubmit()">Submit</button>
        <div id="responseMessage"></div>
        <div id="loading" style="display: none;">Sending...</div>
    
      </form>
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
</body>
</html>