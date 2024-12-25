<?php
// นำเข้าการเชื่อมต่อฐานข้อมูลจาก connect.php
require 'connect.php';

// ตรวจสอบการส่งข้อมูลจากฟอร์ม
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    $sql = "INSERT INTO customers (first_name, last_name) VALUES ('$first_name', '$last_name')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registration successful!');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .form-container h1 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group input:focus {
            border-color: #007bff;
            outline: none;
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h1>Register</h1>
        <form method="post">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" placeholder="Enter first name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" placeholder="Enter last name" required>
            </div>
            <button type="submit" class="btn">Register</button>
        </form>
    </div>
</body>

</html>