<?php
require 'connect.php';

$sql_select = 'SELECT * FROM reservations ORDER BY reservation_id';
$stmt_s = $conn->prepare($sql_select);
$stmt_s->execute();

if (isset($_GET['reservation_id'])) {
    $query_select = 'SELECT * FROM reservations WHERE reservation_id=?';
    $stmt = $conn->prepare($query_select);
    $params = array($_GET['reservation_id']);
    $stmt->execute($params);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบว่าข้อมูลถูกต้องหรือไม่
    if (isset($_POST['reservation_id'], $_POST['check_in_date'], $_POST['check_out_date'], $_POST['status'], $_POST['customer_id'], $_POST['room_id'])) {
        try {
            $query_update = 'UPDATE reservations SET check_in_date=?, check_out_date=?, status=?, customer_id=?, room_id=? WHERE reservation_id=?';
            $stmt = $conn->prepare($query_update);

            $reservation_id = $_POST['reservation_id'];
            $check_in_date = $_POST['check_in_date'];
            $check_out_date = $_POST['check_out_date'];
            $status = $_POST['status'];
            $customer_id = $_POST['customer_id'];
            $room_id = $_POST['room_id'];

            // ผูกข้อมูลและส่งคำสั่ง
            $stmt->bindParam(1, $check_in_date, PDO::PARAM_STR);
            $stmt->bindParam(2, $check_out_date, PDO::PARAM_STR);
            $stmt->bindParam(3, $status, PDO::PARAM_STR);
            $stmt->bindParam(4, $customer_id, PDO::PARAM_INT);
            $stmt->bindParam(5, $room_id, PDO::PARAM_INT);
            $stmt->bindParam(6, $reservation_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $message = 'Successfully updated the reservation';
                $type = 'success';
            } else {
                $message = 'Failed to update the reservation';
                $type = 'error';
            }
        } catch (PDOException $e) {
            $message = 'Error: ' . $e->getMessage();
            $type = 'error';
        }

        // แสดงผลลัพธ์ผ่าน SweetAlert
        echo '
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
        <script type="text/javascript">        
            $(document).ready(function(){
                swal({
                    title: "' . ucfirst($type) . '!",
                    text: "' . $message . '",
                    type: "' . $type . '",
                    timer: 2500,
                    showConfirmButton: false
                }, function(){
                    window.location.href = "index.php";
                });
            });                    
        </script>
        ';
    } else {
        $message = 'ข้อมูลไม่ครบถ้วน กรุณาตรวจสอบอีกครั้ง';
        $type = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>อัปเดตการจอง</title>
    <style>
        .container {
            margin-top: 50px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            margin-top: 6px;
            margin-bottom: 16px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .row {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="index.php?reservation_id=<?php echo $result['reservation_id']; ?>" method="POST">
            <div class="row">
                <div class="col-md-3">
                    <label for="reservation_id">หมายเลขการจอง:</label>
                    <input type="text" name="reservation_id" class="form-control" required
                        value="<?php echo $result['reservation_id']; ?>" readonly>
                </div>
                <div class="col-md-3">
                    <label for="customer_id">รหัสลูกค้า:</label>
                    <input type="text" name="customer_id" class="form-control" required
                        value="<?php echo $result['customer_id']; ?>">
                </div>
                <div class="col-md-3">
                    <label for="room_id">รหัสห้อง:</label>
                    <input type="text" name="room_id" class="form-control" required
                        value="<?php echo $result['room_id']; ?>">
                </div>
                <div class="col-md-3">
                    <label for="check_in_date">วันที่เช็คอิน:</label>
                    <input type="date" name="check_in_date" class="form-control" required
                        value="<?php echo $result['check_in_date']; ?>">
                </div>
                <div class="col-md-3">
                    <label for="check_out_date">วันที่เช็คเอาท์:</label>
                    <input type="date" name="check_out_date" class="form-control" required
                        value="<?php echo $result['check_out_date']; ?>">
                </div>
                <div class="col-md-3">
                    <label for="status">สถานะการจอง:</label>
                    <select name="status" class="form-select">
                        <option value="confirmed" <?php echo ($result['status'] == 'confirmed') ? 'selected' : ''; ?>>
                            ยืนยันแล้ว</option>
                        <option value="pending" <?php echo ($result['status'] == 'pending') ? 'selected' : ''; ?>>
                            รอดำเนินการ</option>
                        <option value="canceled" <?php echo ($result['status'] == 'canceled') ? 'selected' : ''; ?>>ยกเลิก
                        </option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <input type="submit" name="submit" value="อัปเดตข้อมูล" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>

</body>

</html>