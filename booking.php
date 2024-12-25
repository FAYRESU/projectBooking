<?php
// เชื่อมต่อฐานข้อมูล
require 'connect.php';

// ดึงข้อมูลห้องพักจากฐานข้อมูล
$sql = "SELECT * FROM reservations";
$result = $conn->query($sql);

// เมื่อผู้ใช้จองห้อง
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = $_POST['room_id'];
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];

    // เช็คว่าห้องว่างหรือไม่
    $check_sql = "SELECT * FROM bookings WHERE room_id = $room_id AND ('$check_in_date' BETWEEN check_in_date AND check_out_date OR '$check_out_date' BETWEEN check_in_date AND check_out_date)";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "<script>alert('This room is already booked for the selected dates!');</script>";
    } else {
        $insert_sql = "INSERT INTO bookings (room_id, check_in_date, check_out_date) VALUES ($room_id, '$check_in_date', '$check_out_date')";
        if ($conn->query($insert_sql) === TRUE) {
            echo "<script>alert('Room booked successfully!');</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Booking</title>
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
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 800px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #218838;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .alert {
            color: red;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Room Booking</h1>
        <form method="post">
            <table>
                <thead>
                    <tr>
                        <th>Room ID</th>
                        <th>Room Number</th>
                        <th>Floor Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['room_id']; ?></td>
                                <td><?php echo $row['room_number']; ?></td>
                                <td><?php echo $row['floor_number']; ?></td>
                                <td>
                                    <!-- Booking Form for each Room -->
                                    <div class="form-group">
                                        <label for="check_in_date">Check-in Date</label>
                                        <input type="date" name="check_in_date" required class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="check_out_date">Check-out Date</label>
                                        <input type="date" name="check_out_date" required class="form-control">
                                    </div>
                                    <button type="submit" name="room_id" value="<?php echo $row['room_id']; ?>"
                                        class="btn">Book</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No rooms available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </form>
    </div>
</body>

</html>