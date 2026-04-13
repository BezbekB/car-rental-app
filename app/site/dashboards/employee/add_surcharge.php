<?php
require_once('../../../config/auth.php');
requireRole(['pracownik']);

$id = $_GET['id'];

$stmtSurchargeTypes = $pdo->prepare("SELECT TypDoplatyID, TypDoplaty FROM TypDoplaty");
$stmtSurchargeTypes->execute();
$surchargeTypes = $stmtSurchargeTypes->fetchAll(PDO::FETCH_ASSOC);

$stmtDates = $pdo->prepare("SELECT PlanowanaDataZwrotu, RzeczywistaDataZwrotu FROM Wypozyczenie WHERE WypozyczenieID = ?");
$stmtDates->execute([$id]);
$dates = $stmtDates->fetch(PDO::FETCH_ASSOC);

$planned = new DateTime($dates['PlanowanaDataZwrotu']);
$actual = new DateTime($dates['RzeczywistaDataZwrotu']);
$diff = $planned->diff($actual);

$delay = $actual > $planned;

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
      $typeID = $_POST['surchargeType'];

      $stmtInsert = $pdo->prepare("INSERT INTO Doplaty (WypozyczenieID, TypDoplatyID, DataDoplaty) VALUES (?, ?, NOW())");
      $stmtInsert->execute([$id, $typeID]);

      header("Location: ./supported_rentals.php");
      exit;
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Naliczanie Dopłaty</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
<?php require_once('../../components/header.php'); ?>
<main class="admin-customer-main">
    <h1>Dopłata</h1>

    <form action="" method="POST">
        <select name="surchargeType">
            <?php foreach($surchargeTypes as $type): ?>
                  <?php if($type['TypDoplaty'] == "Opóźnienie" && !$delay) continue; ?>
                  <option value="<?= $type['TypDoplatyID'] ?>"><?= $type['TypDoplaty'] ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Dodaj Dopłatę</button>
    </form>
</main>
<?php require_once('../../components/footer.php'); ?>
</body>
</html>
