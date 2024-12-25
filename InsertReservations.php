<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มการจอง</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        select:focus {
            border-color: #007bff;
            outline: none;
        }

        .btn {
            padding: 12px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #218838;
        }

        .alert {
            color: red;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>เพิ่มการจอง</h1>
        <form action="InsertReservation.php" method="POST">
            <div class="form-group">
                <label for="customer_id">รหัสลูกค้า:</label>
                <input type="text" name="customer_id" id="customer_id" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="room_id">รหัสห้อง:</label>
                <input type="text" name="room_id" id="room_id" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="check_in_date">วันที่เช็คอิน:</label>
                <input type="date" name="check_in_date" id="check_in_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="check_out_date">วันที่เช็คเอาท์:</label>
                <input type="date" name="check_out_date" id="check_out_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="status">สถานะ:</label>
                <select name="status" id="status" class="form-control">
                    <option value="Pending">Pending</option>
                    <option value="Confirmed">Confirmed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>
            <button type="submit" name="submit" class="btn">เพิ่มการจอง</button>
        </form>
        <?php
        if (isset($_POST['submit'])) {
            require 'connect.php';

            // Prepare the SQL statement
            $stmt = $conn->prepare(
                'INSERT INTO reservations (customer_id, room_id, check_in_date, check_out_date, status) 
                VALUES (:customer_id, :room_id, :check_in_date, :check_out_date, :status)'
            );

            // Bind form values to the prepared statement
            $stmt->bindParam(':customer_id', $_POST['customer_id']);
            $stmt->bindParam(':room_id', $_POST['room_id']);
            $stmt->bindParam(':check_in_date', $_POST['check_in_date']);
            $stmt->bindParam(':check_out_date', $_POST['check_out_date']);
            $stmt->bindParam(':status', $_POST['status']);

            // Execute the statement and check for success
            if ($stmt->execute()) {
                echo "<p class='alert' style='color: green;'>เพิ่มการจองสำเร็จ!</p>";
            } else {
                echo "<p class='alert'>เกิดข้อผิดพลาด!</p>";
            }
        }
        ?>
    </div>
</body>

</html>