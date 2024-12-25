
<a href="DeleteReservation.php?reservation_id=<?= $reservation_id ?>" class="btn btn-danger">ลบ</a>

<?php
if (isset($_GET['reservation_id'])) {
    require 'connect.php';

    $stmt = $conn->prepare('DELETE FROM reservations WHERE reservation_id = :reservation_id');
    $stmt->bindParam(':reservation_id', $_GET['reservation_id']);

    if ($stmt->execute()) {
        echo "ลบการจองสำเร็จ!";
    } else {
        echo "เกิดข้อผิดพลาด!";
    }
}
?>
