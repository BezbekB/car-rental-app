<?php
require_once('../../../config/auth.php');
requireRole(['klient']);
require_once('../../../config/db.php');

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT Doplata.DoplataID, Doplata.Kwota, Doplata.Opis, TypDoplaty.TypDoplaty, Wypozyczenie.NrUmowy, Doplata.StatusDoplatyID FROM Doplata JOIN TypDoplaty ON Doplata.TypDoplatyID = TypDoplaty.TypDoplatyID JOIN Wypozyczenie ON Doplata.WypozyczenieID = Wypozyczenie.WypozyczenieID WHERE Doplata.DoplataID = ?");
$stmt->execute([$id]);
$surcharge = $stmt->fetch(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD'] == "POST")
{
      $stmtPay = $pdo->prepare("UPDATE Doplata SET StatusDoplatyID = 1 WHERE DoplataID = ?");
      $stmtPay->execute([$id]);

      header("Location: ./customer_surcharges.php");
      exit;

}


?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Opłacenie Dopłaty</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
<?php require_once('../../components/header.php'); ?>
<main class="account-main">

      <h1>Opłacenie dopłaty</h1>
      <form action="" method="POST">
            <div class="payment-box">
                  <p><strong>Typ dopłaty:</strong> <?= $surcharge['TypDoplaty'] ?></p>
                  <p><strong>Opis:</strong> <?= $surcharge['Opis'] ?></p>
                  <p><strong>Kwota:</strong> <?= $surcharge['Kwota'] ?> zł</p>
                  <p><strong>Nr umowy:</strong> <?= $surcharge['NrUmowy'] ?></p>
                  <p><strong>Status:</strong> <?= $surcharge['StatusDoplatyID'] == 1 ? "Opłacona" : "Nieopłacona" ?></p>
            <button type="submit">Opłać dopłatę</button>
      </div>


      </form>

</main>
<?php require_once('../../components/footer.php'); ?>
</body>
</html>
