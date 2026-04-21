<?php
require_once('../../../config/auth.php');
requireRole(['pracownik']);
require_once('../../../config/db.php');

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
$daysLate = $delay ? $diff->days : 0;

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $typeID = $_POST['surchargeType'];
    $opis = $_POST['opis'];
    $kwota = $_POST['kwota'];

    foreach($surchargeTypes as $t){
        if($t['TypDoplatyID'] == $typeID){
            $typeName = $t['TypDoplaty'];
            break;
        }
    }


    $stmtInsert = $pdo->prepare("
        INSERT INTO Doplata (WypozyczenieID, TypDoplatyID, Opis, DataNaliczenia, Kwota, StatusDoplatyID)
        VALUES (?, ?, ?, CURDATE(), ?, ?)
    ");
    $stmtInsert->execute([$id, $typeID, $opis, $kwota, 2]);

    header("Location: ./supported_rentals.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Konto Pracownika</title>
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
                <option value="<?= $type['TypDoplatyID'] ?>"><?= $type['TypDoplaty'] ?></option>
            <?php endforeach; ?>
        </select>

        <input type="text" name="kwota" placeholder="Kwota dopłaty">
        <input type="text" name="opis" placeholder="Opis dopłaty">

    <button type="submit">Dodaj Dopłatę</button>
</form>

</main>
<?php require_once('../../components/footer.php'); ?>
</body>
</html>

