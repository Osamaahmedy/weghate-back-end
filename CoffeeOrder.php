<?php

require 'vendor/autoload.php'; // تحميل Composer autoload
require 'DB.php';
require('fpdf186/fpdf.php');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

if (!isset($_SESSION['last_request_time'])) {
    $_SESSION['last_request_time'] = 0;
}

$current_time = time();
$wait_time = 60; // 1 minute

if ($current_time - $_SESSION['last_request_time'] < $wait_time) {
    echo "Please  wait  a minute and than renew your request !";
    exit;
}

// Process booking logic here

$_SESSION['last_request_time'] = $current_time;

    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $phoneNumber = mysqli_real_escape_string($conn, $_POST['phoneNumber']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $age = (int) $_POST['age'];
    $coffeeName = mysqli_real_escape_string($conn, $_POST['coffeeName']);
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $coffeeorder= $_POST['coffeeorder'];
    

    $locationLink = "https://www.google.com/maps?q=$latitude,$longitude";

    // Validate age
    if ($age < 18) {
        echo 'Age is below the required minimum.';
        exit;
    }
    
    // Generate unique identifier
    $uniqueId = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1)) . random_int(100000, 999999);
    $RN =  random_int(100000, 999999);
    // Insert data into the database
    $insertQuery = "INSERT INTO `coffeeorder` (firstName, lastName, phoneNumber, coffeeName, email, coffeeorder, uniqueId, latitude, longitude,  locationLink , age) 
                    VALUES ('$firstName', '$lastName', '$phoneNumber', '$coffeeName', '$email', '$coffeeorder', '$uniqueId', '$latitude', '$longitude', '$locationLink' ,'$age' )";
    $insert = mysqli_query($conn, $insertQuery);
    
    if ($insert) {
        // إنشاء كود QR
        $qrData = "Name: $firstName $lastName\nPhone: $phoneNumber\nEmail: $email\nUnique ID: $uniqueId\nAge: $age\nlatitude: $latitude\nlongitude: $longitude\nCoffee Order: $coffeeorder\nYour location :$locationLink\nCoffee Name: $coffeeName";
        $qrCode = new QrCode($qrData);
        $qrCode->setSize(150);
        $writer = new PngWriter();
        $qrFile = 'qrcode.png';
        $writer->write($qrCode)->saveToFile($qrFile);


        

        
        // إعداد بيانات الجدول
        $data = array(
            "Name" => "$firstName $lastName",
            "Confirmation ID" => $uniqueId,
            "Phone Number" => $phoneNumber,
            "Email Address" => $email,
            "Age" => $age,
            "latitude" => $latitude,
            "longitude" => $longitude,
            "coffee Name" => $coffeeName,
            "coffee Order " => $coffeeorder
           
        );
        
        $pdf = new FPDF();
        $pdf->AddPage();
        
        // إضافة الشعار
        $pdf->Image('C:\xampp\htdocs\weghate\1731172903205.jpg', 86, 5, 40  );
        $pdf->Ln(20);
        // إضافة عنوان
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->Cell(0, 50, ' Coffee Order Services ', 0, 1, 'C');
        $pdf->Ln(5);
        // اسم ورقم
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 0, "MR: $firstName $lastName", 0, 1, 'L');
        $pdf->Cell(0, 0, "Reg.NO : $RN", 0, 1, 'R');
        
        // إضافة مسافة قبل الجدول
        $pdf->Ln(20);
      
// Calculate the position to center the table
$cellWidth = 60;
$cellHeight = 10;
$totalWidth = $cellWidth * 2;
$cellPadding = 2;
$tableStartX = ($pdf->GetPageWidth() - $totalWidth) / 2;
// Set table colors
$pdf->SetFillColor(240, 240, 240); // Light gray background (بدلاً من اللون البنفسجي الفاتح)
$pdf->SetTextColor(0, 0, 0); // Black text color (لون النص الأسود)
$pdf->SetDrawColor(0, 0, 0); // Black border color (لون الحدود الأسود)

// Display the table
foreach ($data as $key => $value) {
    $pdf->SetX($tableStartX);
    $pdf->Cell($cellWidth, $cellHeight, $key, 1, 0, 'C', true);
    $pdf->Cell($cellWidth, $cellHeight, $value, 1, 1, 'C', true);
}


// تغيير لون رمز QR إلى الأصفر
function changeQrColor($filename, $newFilename, $r, $g, $b) {
    $image = imagecreatefrompng($filename);
    imagealphablending($image, false);
    imagesavealpha($image, true);

    $width = imagesx($image);
    $height = imagesy($image);

    // تغيير الألوان من الأسود إلى الأصفر
    for ($x = 0; $x < $width; $x++) {
        for ($y = 0; $y < $height; $y++) {
            $rgb = imagecolorat($image, $x, $y);
            $colors = imagecolorsforindex($image, $rgb);
            if ($colors['red'] == 0 && $colors['green'] == 0 && $colors['blue'] == 0) {
                $yellow = imagecolorallocate($image, $r, $g, $b);
                imagesetpixel($image, $x, $y, $yellow);
            }
        }
    }

    imagepng($image, $newFilename);
    imagedestroy($image);
}

// تغيير لون QR إلى أصفر (255, 255, 0)
$newQrFile = 'yellow_qr_code.png';
changeQrColor($qrFile, $newQrFile, 255, 255, 0);

// الآن، يمكنك استخدام ملف QR الجديد في الـ PDF
$pdf->Cell(0, 50, 'QR Code:', 0, 1, 'C');

// الحصول على عرض وارتفاع الصفحة
$pageWidth = $pdf->GetPageWidth();
$pageHeight = $pdf->GetPageHeight();

// تحديد حجم الصورة (مثال: 50x50)
$imageWidth = 50;
$imageHeight = 50;

// حساب الإحداثيات المطلوبة (المنتصف)
$x = ($pageWidth - $imageWidth) / 2;
$y = ($pageHeight - $imageHeight) / 1;

// إدراج الصورة في المنتصف
$pdf->Image($newQrFile, $x, $y, $imageWidth, $imageHeight);

        // إخراج ملف PDF
        $pdfFile = 'Coffee_Order_Services.pdf';
        $pdf->Output($pdfFile, 'F');
        // إرسال البريد الإلكتروني
        $mail = new PHPMailer(true);
        
        try {
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'your-email@gmail.com'; // Your email
            $mail->Password = 'your-password'; // Your email password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            
            // إعدادات البريد الإلكتروني للعميل
            $mail->setFrom('your-email@gmail.com', 'Coffee Order Services ');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Coffee Order  Confirmation';
            $mail->Body = "
            <h1>Coffee Order Services </h1>
            <p>Name: $firstName $lastName</p>
            <p>Email: $email</p>
             <p>coffee Name: $coffeeName</p>
            <p> Your Location: <a href='$locationLink'>View on Google Maps</a></p>
        ";

            $mail->addAttachment($pdfFile);
            
            $mail->send();
            
            // إعدادات البريد الإلكتروني للمسؤول
            $mail->clearAddresses();
            $mail->addAddress('your-email@gmail.com');
            $mail->Subject = ' New Coffee Order Services  Request';
            $mail->Body = "
            <h1>Coffee Order Services </h1>
            <p>Name: $firstName $lastName</p>
            <p>Email: $email</p>
              <p>coffee Name: $coffeeName</p>
            <p>Location: <a href='$locationLink'>View on Google Maps</a></p>
        ";

            $mail->addAttachment($pdfFile);
            
            $mail->send();
            
            echo 'Registration successful and emails sent!';
        } catch (Exception $e) {
            echo "Registration successful, but email sending failed. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo 'Registration failed: ' . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>