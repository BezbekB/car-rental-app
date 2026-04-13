<?php
require_once('../../../config/auth.php');
requireRole(['klient']);
require_once('../../../config/db.php');

$id = $_GET['id'];

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $mileage = $_POST['mileage'];

    $stmtMileage = $pdo->prepare("SELECT Przebieg, SamochodID FROM Samochod JOIN Wypozyczenie ON Samochod.SamochodID = Wypozyczenie.SamochodID WHERE WypozyczenieID = ?");
    $stmtMileage->execute([$id]);
    $mileageRow = $stmtMileage->fetch(PDO::FETCH_ASSOC);

    $errors = [];


    if(!is_numeric($mileage) || $mileage < $mileageRow['Przebieg']) $errors[] = "Przebieg jest nieprawidłowy!";

    if(empty($errors))
    {
        try{
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("UPDATE Wypozyczenie SET StatusWypozyczeniaID = ? WHERE WypozyczenieID = ?");
            $stmt2 = $pdo->prepare("UPDATE Samochod SET Przebieg = ? WHERE SamochodID = ?");
            $stmt->execute([2, $id]);
            $stmt2->execute([$mileage, $mileageRow['SamochodID']]);

            $pdo->commit();

            header("Location: ../klient.php");
            exit;
        }
        catch(Exception $e)
        {
            $pdo->rollBack();
            $errors[] = "Błąd podczas aktualizacji statusu lub przebiebgu: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Konto Klienta</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
      <?php require_once('../../components/header.php'); ?>
      <main class="admin-customer-main">
        <h1>Zwrot Samochodu</h1>
        <form action="" method="POST">
            <input type="text" placeholder="Przebieg Końcowy" name="mileage">
            <button type="submit">Oddaj</button>
            <?php if(isset($errors)):?>
                <ul class="error-list">
                    <?php foreach($errors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </form>
      
      </main>
      <?php require_once('../../components/footer.php'); ?>
</body>
</html>
