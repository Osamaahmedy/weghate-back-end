<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/entlogin.css">
</head>
<body>
  <style>#loading {
    display: inline-block;
    width: 80px;
    height: 80px;
    border: 8px solid #f3f3f3;
    border-radius: 50%;
    border-top-color: rgb(245, 191, 115);
    animation: spin 1s ease-in-out infinite;
    margin: 1rem auto;
}
@keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
</style>
    
    <form class="booking-form" id="bookingForm">
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
          <label for="coffeeName">Coffee Name</label>
          <input type="text" id="coffeeName" name="coffeeName" placeholder="Coffee Name" required>
        </div>
        <div class="form-group">
          <label for="coffeeOrder">Coffee Order</label>
          <input type="text" id="coffeeorder" name="coffeeorder" placeholder="Coffee Order" required>
        </div>
        <div class="form-group">
          <label for="age">Age</label>
          <input type="text" id="age" name="age" placeholder="Age" required>
        </div>
        <input type="hidden" id="latitude" name="latitude">
        <input type="hidden" id="longitude" name="longitude">
        <button type="button" class="submit-button" onclick="getLocationAndSubmit()">Submit</button>
        <div id="loading"  Style="display: none;"></div>
        <div id="responseMessage" class="response-message"></div>
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
                  url: 'CoffeeOrder.php',
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