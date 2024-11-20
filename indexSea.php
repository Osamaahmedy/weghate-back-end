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
    <link rel="stylesheet" href="css/sea.css">
</head>
<body>
<div style="text-align: center;">
        <a href="logout.php" style="text-decoration: none; padding: 10px 20px; background-color: #ffa343; color: white; border-radius: 5px;">تسجيل الخروج</a>
    </div>
    <h1>Seas</h1>
<div class="container">
    <div class="sea-card">
        <img src="Elephant Bay Resort.jpg" alt="Elephant Bay Resort">
        <h2>Elephant Bay Resort</h2>
        <p>Location: Aden-At-Tawahi</p>
    </div>
    <div class="sea-card">
        <img src="Diplomatic Club.jpg" alt="Diplomatic Club">
        <h2>Diplomatic Club</h2>
        <p>Location: Aden-At-Tawahi</p>
    </div>
    <div class="sea-card">
        <img src="Al-Ghadeer Resort.JPG" alt=" Al-Ghadeer Resort">
        <h2>Al-Ghadeer Resort</h2>
        <p>Location: Aden-Al Buraiqeh</p>
    </div>




    <div class="sea-card">
        <img src="Tiger code Sea.jpeg" alt="Tiger code Sea">
        <h2>Tiger code Sea</h2>
        <p>Location: Aden-Al Buraiqeh</p>
    </div>
    <div class="sea-card">
        <img src="Ras Omran sea.jpg" alt="Ras Omran sea">
        <h2>Ras Omran sea</h2>
        <p>Location: Aden-Al Buraiqeh</p>
    </div>
    <div class="sea-card">
        <img src="Sea of Haswa.jpg" alt="Sea of Haswa">
        <h2>Sea of Haswa</h2>
        <p>Location: Aden-Al Haswa</p>
    </div>












</div>

    
    <script src="sea.js"></script>
</body>
</html>