<?php
// เชื่อมต่อฐานข้อมูล
require 'connect.php';

// ดึงข้อมูลห้องพักจากฐานข้อมูล
$sql = "SELECT * FROM rooms";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Rooms</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            padding: 8px 15px;
            font-size: 14px;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Available Rooms</h1>
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
                                <a href="booking.php?room_id=<?php echo $row['room_id']; ?>" class="btn">Book Now</a>
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
    </div>
</body>

</html>