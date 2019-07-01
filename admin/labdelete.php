<?php 

session_start();
include '../conn.php';
$id = $_GET['id'];

$lab_data = mysqli_fetch_assoc(mysqli_query($myDB,"SELECT * FROM lab WHERE id_lab='$id' "));
$lab_name = $lab_data['nama_lab'];

$sql = "DELETE FROM lab WHERE id_lab='$id' ";

if ($myDB->query($sql) === TRUE) {
    $_SESSION['success'] = 'Succes Delete ' .$lab_name;
    header('location: ../admin/index');
} else {
    $_SESSION['error'] = "Error Delete Item";
    header('location: '. $_SERVER['HTTP_REFERER']);
}
?>