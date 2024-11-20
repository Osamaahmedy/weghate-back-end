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
    <link rel="stylesheet" href="hotel.css">
</head>
<body>
    <style>.home .home-box {
        width: 100%;
        height: 100%;
        background: linear-gradient(rgba(49, 54, 59, 0.1), rgba(0,0,0,.1));
        background-image:url(imageh/1822b3342f3e6b4a011040284dcb9423.jpg) ;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        padding: .5rem;
        border-radius: .5rem;
    }</style>
    <section class="home">
        <div class="home-box">
            <nav>
                <div class="logo bars">
                    <div class="bar">
                        <i class="fa fa-bars"></i>
                    </div>
                    
                    <h3> <span>HO</span>TELS</h3>
                </div>
                <div class="menu active">
                    <div class="close">
                        <i class="fa fa-close"></i>
                    </div>
                    <header>


                        <ul>
                            <li><a href="#">home</a></li>
                            <li><a href="#">about</a></li>
                            <li><a href="#">Hotel</a></li>
            
                        </ul>
                    </header>
                   
                </div>
            
            </nav>

            <div class="content">
                <h5> <span>HO</span>TELS</h5>
                <h1>Hello.Salut.Hola</h1>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tempore, dicta! Tempora provident alias veniam optio quos suscipit, asperiores possimus maxime nihil eveniet itaque a, iste velit! Quisquam, iste? Expedita, laudantium!</p>

            </div>
        </div>
    </section>
    <h1>WELCOME</h1>
    <section class="feature">
        <div class="feature-content">
        <div class="row">
        <div class="row-img">
        <img src="imageh/Screenshot_٢٠٢٤١١٠٤-٢٢٤٦٥٤_Google.jpg">
        </div>
        <a href="h.php">colar hotel</a>
        </div>
      
        <div class="row">
            <div  class="row-img">
            <img src="imageh/Screenshot_٢٠٢٤١١٠٤-٢٢٥٢٥٥_Google.jpg">
            </div>
            <a href="h1.php">marriott hotel</a>
            </div>
            <div class="row">
                <div class="row-img">
                <img src="imageh/Screenshot_٢٠٢٤١١٠٤-٢٢٥٥١٢_Google.jpg">
                </div>
                <a href="h2.php">setystar hotel</a>
                </div>
        

                    <div class="row">
                        <div class="row-img">
                        <img src="imageh/Screenshot_٢٠٢٤١١٠٦-١٦٠٧٤٧_Google.jpg">
                        </div>
                        <a href="h3.php">rotana hotel</a>
                        </div>

                        </section>
                       <h1>        </h1>
            
                
                        
</body>
</html>