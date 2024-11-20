<?php
// بدء الجلسة
session_start();

// إنهاء الجلسة
session_unset();
session_destroy();

// إعادة توجيه المستخدم إلى صفحة تسجيل الدخول بعد تسجيل الخروج
header('Location: account.html');
exit;
?>
