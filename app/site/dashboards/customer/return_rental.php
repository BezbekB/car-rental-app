<?php
require_once('../../../config/auth.php');
requireRole(['klient']);
require_once('../../../config/db.php');

$id = $_GET['id'];

$stmt = $pdo->prepare("UPDATE Wypozyczenie SET StatusWypozyczeniaID = ? WHERE WypozyczenieID = ?");
$stmt->execute([2, $id]);
header("Location: ../klient.php");
exit;
?>
