<?php
$serverName = 'localhost';    // ชื่อโฮสต์
$userName = 'root';           // ชื่อผู้ใช้ MySQL (ค่าเริ่มต้นคือ root)
$userPassword = '';           // รหัสผ่าน MySQL (ค่าเริ่มต้นมักเว้นว่าง)
$dbname = 'reservation';      // ชื่อฐานข้อมูล

try {
    // สร้างการเชื่อมต่อ PDO
    $conn = new PDO(
        "mysql:host=$serverName;dbname=$dbname;charset=UTF8",
        $userName,
        $userPassword
    );

    // ตั้งค่าการแสดงข้อผิดพลาด (Error Mode)
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Connected successfully"; // ทดสอบว่าเชื่อมต่อสำเร็จ
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage(); // แสดงข้อผิดพลาดถ้าเชื่อมต่อไม่ได้
}
?>