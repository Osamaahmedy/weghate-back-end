<?php
//login.php
require 'vendor/autoload.php';
require 'DB.php';
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// تحميل متغيرات البيئة
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// استخدم مفتاح التشفير من ملف .env
$encryption_key = $_ENV['ENCRYPTION_KEY'];

function encryptData($data, $key) {
    $iv = random_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}
function sendEmail($email, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@gmail.com';
        $mail->Password = 'your-password';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('your-email@gmail.com', 'Osama Ahmed');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        
        return true;
    } catch (Exception $e) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        return false;
    }
}
if (isset($_POST['email'], $_POST['uniqueId'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $uniqueId = mysqli_real_escape_string($conn, $_POST['uniqueId']);

    $query = "SELECT firstName, lastName, uniqueId, lastLogin, uniqueIdCreatedAt FROM `users` WHERE email=?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($row['uniqueId'] === $uniqueId) {
            // عملية تسجيل الدخول ناجحة
            $updateRequestTime = "UPDATE `users` SET lastRequest=NOW() WHERE email=?";
            $stmt = $conn->prepare($updateRequestTime);
            $stmt->bind_param("s", $email);
            $stmt->execute();

            // إنشاء uniqueId جديد وتشفيره
            $newUniqueId = strtoupper(substr($row['firstName'], 0, 1) . substr($row['lastName'], 0, 1)) . random_int(1000000, 9999999);
            $encryptedNewUniqueId = encryptData($newUniqueId, $encryption_key);
            $newTime = date('Y-m-d H:i:s');

            // تحديث قاعدة البيانات بـ uniqueId المشفر الجديد
            $updateQuery = "UPDATE `users` SET uniqueId=?, uniqueIdCreatedAt=?, lastLogin=NOW() WHERE email=?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("sss", $encryptedNewUniqueId, $newTime, $email);
            $stmt->execute();

            // إرسال البريد الإلكتروني
            $subject = 'Your New Unique ID';
            $body = "Your new unique ID is {$newUniqueId}. Please use it to log in.";
            sendEmail($email, $subject, $body);

            echo 'Login successful! Your new unique ID has been sent to your email. Click on Let`s go Link ... ';
           
         
// تعيين الجلسة
$_SESSION['user'] = $email;


exit();
        } else {
            // إذا كان uniqueId غير صحيح، قم بإنشاء قيمة جديدة
            $newUniqueId = strtoupper(substr($row['firstName'], 0, 1) . substr($row['lastName'], 0, 1)) . random_int(1000000, 9999999);
            $currentTime = date('Y-m-d H:i:s');

            $updateQuery = "UPDATE `users` SET uniqueId=?, uniqueIdCreatedAt=? WHERE email=?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("sss", $newUniqueId, $currentTime, $email);
            $stmt->execute();

            // إرسال البريد الإلكتروني
            $subject = 'Your Unique ID';
            $body = "Your unique ID is {$newUniqueId}. Please use it to log in.";
            sendEmail($email, $subject, $body);

            echo 'Incorrect unique ID. A new unique ID has been sent to your email.';
        }
    } else {
        echo 'Email not found.';
    }

    // وظيفة لحذف uniqueId بعد دقيقة
    $deleteQuery = "DELETE FROM `users` WHERE (NOW() > DATE_ADD(uniqueIdCreatedAt, INTERVAL 1 MINUTE))";
    mysqli_query($conn, $deleteQuery);
}
?>