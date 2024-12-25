<?php
if (isset($_POST['submit'])) {
    require 'connect.php';

    $stmt = $conn->prepare(
        'UPDATE reservations SET 
        check_in_date = :check_in_date, 
        check_out_date = :check_out_date, 
        status = :status 
        WHERE reservation_id = :reservation_id'
    );
    $stmt->bindParam(':check_in_date', $_POST['check_in_date']);
    $stmt->bindParam(':check_out_date', $_POST['check_out_date']);
    $stmt->bindParam(':status', $_POST['status']);
    $stmt->bindParam(':reservation_id', $_POST['reservation_id']);

    if ($stmt->execute()) {
        echo "แก้ไขข้อมูลสำเร็จ!";
    } else {
        echo "เกิดข้อผิดพลาด!";
    }
}
?>
