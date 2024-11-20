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
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="h.css">
</head>
<body>

        <div class="view">
        <div class="child">
            <h1>DOUBLE</h1>
            <img src="imageh/r1.jpg" alt="">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque ea molestiae libero neque possimus. A necessitatibus quas aut assumenda sed similique, ipsa facere debitis consequatur inventore laboriosam fugit fuga hic.</p>
        <h2>prise 85$</h2>
        </div>
        

    </div>
    <div class="view">
        <div class="child">
            <h1>SINGL</h1>
            <img src="imageh/r2.jpg" alt="">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque ea molestiae libero neque possimus. A necessitatibus quas aut assumenda sed similique, ipsa facere debitis consequatur inventore laboriosam fugit fuga hic.</p>
        <h2>prise 75$</h2>
        </div>
        <div class="view">
            <div class="child">
                <h1>SWEET</h1>
                <img src="imageh/r3.jpg" alt="">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque ea molestiae libero neque possimus. A necessitatibus quas aut assumenda sed similique, ipsa facere debitis consequatur inventore laboriosam fugit fuga hic.</p>
            <h2>prise 180$</h2>
            </div>
           
    </div>
    <div class = "book">
        <H2>choose room type!</H2>
       
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
            display: grid;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 19px 13px rgb(0 0 0 / 27%);
    max-width: 400px;
    width: 100%;
    position: relative;
    justify-items: center;



        }

        input,
        button {
            width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #dddddd8a;
    border-radius: 4px;
    background-color: #4b46463d
        }

        button {
            background-color: #898c8f;
    color: white;
    border: none;
    cursor: pointer;
    width: 106%;
        }

        button:hover {
            background-color: #2e2f31;
        }

        #loading {
            display: none;
            margin: 1px;
           
            text-align: center;
            font-size: 18px;
            color: white;
        }

        #responseMessage {
            margin-top: 10px;
            font-size: 16px;
            color: white;
            text-align: center;
        }
        label{
            color: black;
            text-transform: capitalize;
    transform: translateX(-180px);
        }
    </style>
   
</head>

<body>
    <form id="bookingForm">
        <input type="text" name="firstName" placeholder="First Name" required>
        <input type="text" name="lastName" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="tel" name="phoneNumber" placeholder="Phone Number" required>
        <input type="number" name="night" placeholder="Night" required>
        <input type="text" name="carID" placeholder="Number of people" required>
        <input type="text" name="PersonalID" placeholder="PersonalID" required>
        <input type="number" name="age" placeholder="Age" required>
        <Label>suite</Label>
        <input type="text" name="suite" value="No" placeholder="suite" required>
        <Label>room</Label>
        <input type="text" name="room" value="No" required>
        <Label style=" transform: translateX(-170px);">apartment</Label>
        <input type="text" name="apartment" value="No" required>
        <Label>Vip</Label>
        <input type="text" name="vip" value="No" required>
        <input type="text" name="hotelName" placeholder="hotelName" required>
        
        <button type="button" onclick="getLocationAndSubmit()">Submit</button>
        <div id="loading" style="display:none;">Sending...</div>
        <div id="responseMessage"></div>
    </form>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Toggle value between "no" and "yes" on focus
            $('input[name="suite"], input[name="room"], input[name="apartment"], input[name="vip"]').focus(function() {
                $(this).val($(this).val() === 'No' ? 'Yes' : 'No');
            });
    
            $('#bookingForm').submit(function(event) {
                event.preventDefault();
                $('#loading').show();
                $('#responseMessage').hide();
    
                $.ajax({
                    url: 'hotel.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#loading').hide();
                        $('#responseMessage').text(response).show();
                    },
                    error: function() {
                        $('#loading').hide();
                        $('#responseMessage').text('Error processing the request.').show();
                    }
                });
            });
        });
    
        function getLocationAndSubmit() {
            // Additional logic for location if needed
            $('#bookingForm').submit();
        }
    </script>

                </form>

            </div>
            <h1>       </h1>
    
            

</body>
</html>