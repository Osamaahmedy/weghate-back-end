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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="taxi.css">
   <link rel="stylesheet" href="fontawesome-free-5.15.3-web/css/all.min.css">
   <title>WASILNA</title>
</head>
<body>
    <style> #loading {
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
    }</style>
    <div class="main-container">
        <div class="background-text">
            <h2>book a <span>cab now</span></h2>
        </div>
        <header class="header">
            <a href="#" class="logo" id="logo">WASI <span>LNA</span></a>
            <nav class="navbar">
                <a href="taxi.html">home</a>
                <a href="#main-tariff">Services</a>
                <a href="#testimonials">Customer opinion</a>
                <a href="#fast-booking">features</a>
                <a href="#contact">Contact</a>
            </nav>
            <a href="#" id="menu-bars" class="fas fa-bars"></a>
        </header>
        <div class="taxi-image">
            <img src="images/carmain.png" alt="">
        </div>
    </div>

<!-- home section -->
<div class="home-container" id="contact">
    <div class="home-content">
        <div class="inner-content">
            <h3>best in city</h3>
            <h2>trusted wasilna sservice in county</h2>
            
            <a href="#go" class="booknow">book now</a>
        </div>
        <div class="inner-content">
           <div class="contact-form">
               <div class="form-heading">
                   <h1>book a cab</h1>
               </div>
               <div class="form-fields">
                <form id="bookingForm">
                    <input type="text" name="firstName" placeholder="First Name" required>
                    <input type="text" name="lastName" placeholder="Last Name" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="text" name="phoneNumber" placeholder="Phone Number" required>
                    <input type="text" name="location" placeholder="Location" required>
                    <input type="text" name="age" placeholder="Age" required>
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                
                    <div style="display: flex; flex-direction: column; width: 50%; transform: translateX(107px);" class="select">
                        <label for="vip">VIP</label>
                        <input type="text" id="vip" name="vip" value="no" readonly>
                
                        <label for="car">Car</label>
                        <input type="text" id="car" name="car" value="no" readonly>
                
                        <label for="bus">Bus</label>
                        <input type="text" id="bus" name="bus" value="no" readonly>
                    </div>
                
                    <button style="width: 214px; height: 56px; transform: translateY(2px); outline: none; border: none;" 
                            type="button" onclick="getLocationAndSubmit()">Submit</button>
                
                    <div id="loading">Sending...</div>
                    <div id="responseMessage"></div>
                </form>
                
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    // Function to handle toggle on focus
                    function toggleCheckboxInput(input) {
                        input.addEventListener('focus', () => {
                            input.value = input.value === 'no' ? 'yes' : 'no';
                        });
                    }
                
                    // Apply the toggle function to specific inputs
                    document.querySelectorAll('.select input[type="text"]').forEach(input => {
                        toggleCheckboxInput(input);
                    });
                
                    // Location and form submission logic
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
                            url: 'location.php',
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
                
               </div>
              
              
           </div>
           
        </div>
    </div>
</div>
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
                url: 'location.php',
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
<!-- home section ended -->

<!-- our tariff -->

<div class="main-tariff" id="main-tariff">
    <h1>our <span>Survice</span></h1>
    <div class="inner-tarrif">
        <div class="tarrif-container">
            <div class="inner-box">
                <img src="images/image1.png" alt="">
                <h2>VIP</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat illum officia fugiat, autem facere iste repellendus omnis nemo dolore</p>
                <h3>price: $300 /-</h3>
                <a href="#go">order now</a>
            </div>
        </div>

        <div class="tarrif-container">
            <div class="inner-box">
                <img src="images/image1.png" alt="">
                <h2 class="heading-yellow">CAR</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat illum officia fugiat, autem facere iste repellendus omnis nemo dolore</p>
                <h3 class="yellw-section">price: $20 /-</h3>
                <a href="#go" class="btn-yellow">order now</a>
            </div>
        </div>

        <div class="tarrif-container">
            <div class="inner-box">
                <img src="images/image1.png" alt="">
                <h2>Bus</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat illum officia fugiat, autem facere iste repellendus omnis nemo dolore</p>
                <h3>price: $30 /-</h3>
                <a href="#go">order now</a>
            </div>
        </div>
    </div>
</div>


<!-- our tariff ended -->

<!-- fast booking -->
<div class="fast-booking" id="fast-booking">
    <h1 class="fast-hading">we do best</h1>
    <h2>than you wish</h2>
    <div class="inner-fast">
        <div class="booking-content">
            <div class="icon-fast">
                <span><i class="fas fa-star"></i></span>
            </div>
            <div class="inner-fast-text">
                <h1>Ease of use</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae debitis asperiores adipisci, totam volu</p>
            
            </div>
                
        </div>
        <div class="booking-content">
            <div class="icon-fast">
                <span><i class="fas fa-map-marker-alt"></i></span>
            </div>
            <div class="inner-fast-text">
                <h1>Latest cars</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae debitis asperiores adipisci, totam volu</p>
            
            </div>
        </div>
        <div class="booking-content">
            <div class="icon-fast">
                <span><i class="fas fa-map-marker-alt"></i></span>
            </div>
            <div class="inner-fast-text">
                <h1>Determine the exact location</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae debitis asperiores adipisci, totam volu</p>
            
            </div>
        </div>
        <div class="booking-content">
            <div class="icon-fast">
                <span><i class="fas fa-map-marker-alt"></i></span>
            </div>
            <div class="inner-fast-text">
                <h1>fast booking</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae debitis asperiores adipisci, totam volu</p>
            
            </div>
        </div>
    </div>
</div>




<!-- fast booking end -->



<div class="testimonials" id="testimonials">
    <h1 class="heading-test">happy clients</h1>
    <div class="main-testimonials">
        <div class="inner-test">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe veritatis fugit magnam esse, amet adipisci eaque dolore explicabo quidem laudantium ad, enim, obcaecati optio? Harum porro delectus accusamus assumenda ullam.</p>
            <div class="clients">
                <img src="images/jhon.png" alt="">
                <h1>jhone doe</h1>
            </div>
        </div>
        <div class="inner-test">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe veritatis fugit magnam esse, amet adipisci eaque dolore explicabo quidem laudantium ad, enim, obcaecati optio? Harum porro delectus accusamus assumenda ullam.</p>
            <div class="clients">
                <img src="images/jhon.png" alt="">
                <h1>jhone doe</h1>
            </div>
        </div>
    </div>
</div>































    <script src="script.js"></script>
</body>
</html>

 <!-- <div class="myform">
                <div class="heading">
                    <h2>book cab</h2>
                </div>
                <div class="myfields">
                    <input type="text" placeholder="when">
                    <input type="text" placeholder="when">
                    <input type="text" placeholder="when">
                    <input type="text" placeholder="when">
                    <input type="text" placeholder="when">
                    <input type="text" placeholder="when">
                </div>
                <a href="#">Submit</a>
            </div> -->