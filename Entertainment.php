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
    <title>Cafes & Chalets</title>
    <link rel="stylesheet" href="css/Entertainment.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Amiri&display=swap">
    
</head>
<body>
    <div class="container">
        <h1>Cafes and Chalets</h1>

        <div class="category">
            <h2>Cafes</h2>
            <div class="items">
                <div class="item">
                    <img src="imges/adencafe.jpg" alt="Cafe 1">
                    <div class="details">
                        <h3>Aden Cafe</h3>
                        <p>Location: Al-Mansoura  St., Aden</p>
                    </div>
                </div>
                <div class="item">
                    <img src="imges/cupcoffee.jpg" alt="Cafe 2">
                    <div class="details">
                        <h3>Cup Coffee</h3>
                        <p>Location: Al-Malla  St., Aden</p>
                    </div>
                </div>
                <div class="item">
                    <img src="imges/keef.jpg" alt="Cafe 3">
                    <div class="details">
                        <h3>Keef Cafe</h3>
                        <p>Location: Al-Sheikh  St., Aden</p>
                    </div>
                </div>
                <div class="item">
                    <img src="imges/las.jpg" alt="Cafe 4">
                    <div class="details">
                        <h3>Las Cafe</h3>
                        <p>Location: Al-Mansoura  St., Aden</p>
                    </div>
                </div>
                <div class="item">
                    <img src="imges/tome.jpg" alt="Cafe 5">
                    <div class="details">
                        <h3>Tome Cafe</h3>
                        <p>Location: Al-Mansoura  St., Aden</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="category">
            <h2>Chalets</h2>
            <div class="items">
                <div class="item">
                    <img src="imges/calmChalet.jpg" alt="Park 1">
                    <div class="details">
                        <h3>Calm Chalet</h3>
                        <p>Location: Al-Mansoura , Aden</p>
                    </div>
                </div>
                <div class="item">
                    <img src="imges/familyChalet.jpg" alt="Park 2">
                    <div class="details">
                        <h3>Family Chalet</h3>
                        <p>Location: Al-Mansoura , Aden</p>
                    </div>
                </div>
                <div class="item">
                    <img src="imges/farhChalet.jpg" alt="Park 3">
                    <div class="details">
                        <h3>Farh Chalet</h3>
                        <p>Location: Al-Mansoura , Aden</p>
                    </div>
                </div>
                <div class="item">
                    <img src="imges/qutaybiChalet.jpg" alt="Park 4">
                    <div class="details">
                        <h3>Al-Qutaybi Chalet</h3>
                        <p>Location: Al-Mansoura , Aden</p>
                    </div>
                </div>
            </div>
        </div>
    
    </div>  
    <a href="entlogin.php" class="goto-button">Lets Sign Up</a>
    <!-- <div class="center-button">
        <button>Let's Sign Up</button>
      </div> -->
    <script src="js/entertainment.js"></script>
</body>
</html>