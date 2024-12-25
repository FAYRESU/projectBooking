<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการการจอง</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table th,
        .table td {
            text-align: center;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .search-container {
            margin-bottom: 15px;
        }

        .search-input {
            width: 100%;
            max-width: 300px;
        }

        .btn-custom {
            margin: 5px;
        }
    </style>
</head>

<body>

    <div class="container mt-4">
        <h2 class="text-center mb-4">รายการการจอง</h2>

        <!-- Search Box -->
        <div class="search-container d-flex justify-content-between">
            <input type="text" id="searchInput" class="form-control search-input" placeholder="ค้นหาการจอง...">
            <button class="btn btn-success btn-custom" id="searchButton">ค้นหา</button>
        </div>

        <!-- Reservations Table -->
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>รหัสการจอง</th>
                    <th>รหัสลูกค้า</th>
                    <th>รหัสห้อง</th>
                    <th>วันที่เช็คอิน</th>
                    <th>วันที่เช็คเอาท์</th>
                    <th>สถานะ</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // เชื่อมต่อฐานข้อมูลก่อน
                require 'connect.php';

                // ดึงข้อมูลการจองจากฐานข้อมูล
                $stmt = $conn->query('SELECT * FROM reservations');

                // แสดงข้อมูลในตาราง
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                    <td>{$row['reservation_id']}</td>
                    <td>{$row['customer_id']}</td>
                    <td>{$row['room_id']}</td>
                    <td>{$row['check_in_date']}</td>
                    <td>{$row['check_out_date']}</td>
                    <td>{$row['status']}</td>
                    <td>
                        <a href='EditReservation.php?reservation_id={$row['reservation_id']}' class='btn btn-warning btn-custom'>แก้ไข</a>
                        <a href='DeleteReservation.php?reservation_id={$row['reservation_id']}' class='btn btn-danger btn-custom'>ลบ</a>
                    </td>
                </tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Add Reservation Button -->
        <a href="InsertReservations.php" class="btn btn-primary btn-custom">เพิ่มการจอง</a>
    </div>

    <!-- Link to Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom JavaScript for search functionality -->
    <script>
        document.getElementById('searchButton').addEventListener('click', function () {
            var searchValue = document.getElementById('searchInput').value.toLowerCase();
            var rows = document.querySelectorAll('table tbody tr');

            rows.forEach(function (row) {
                var cells = row.querySelectorAll('td');
                var match = false;

                cells.forEach(function (cell) {
                    if (cell.textContent.toLowerCase().includes(searchValue)) {
                        match = true;
                    }
                });

                if (match) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>

</body>

</html>