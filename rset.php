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
    <link rel="stylesheet" href="rest.css">
</head>
<body>
    <h1>Restaurant</h1>
    <div class="container">
        <div class="sea-card">
            <img src="20241114_192750.jpg" alt="">
            <h2>SHAWATI ADEN</h2>
            <p>Location:SHAYKH UTHMAN,ADEN ,YEMEN </p>
        </div>
        <div class="sea-card">
            <img src="20241114_192835.jpg" alt="Diplomatic Club">
            <h2>ALMARASIM</h2>
            <p>Location: SHAYKH UTHMAN,ADEN ,YEMEN </p>
        </div>
        <div class="sea-card">
            <img src="20241114_192856.jpg" alt=" Al-Ghadeer Resort">
            <h2>ICE PALACE</h2>
            <p>Location: MAIN SET , ALMAALA ,ADEN ,YEMEN</p>

        </div>
    
    
    
    
        <div class="sea-card">
            <img src="20241114_200713.jpg" alt="Tiger code Sea">
            <h2>DAKH</h2>
            <p>Location: ALMAALA ,ADEN,YEMEN</p>
        </div>
        <div class="sea-card">
            <img src="8.jpg" alt="Ras Omran sea">
            <h2>HONEST</h2>
            <p>Location: SHAYKH UTHMAN,ADEN ,YEMEN </p>
        </div>
        <div class="sea-card">
            <img src="20241114_205205.jpg" alt="Sea of Haswa">
            <h2>KING FAISAL RD</h2>
            <p>Location:CRATER,ADEN,YEMEN</p>
        </div>
    
    
    
    
    
    
    
    
    
    
    
    
    </div>
    <a href="resLog.php" class="goto-button">Lets Take order</a>

    
</body>
</html>