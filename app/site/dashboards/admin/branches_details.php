<?php
require_once('../../../config/auth.php');
requireRole(['admin']);
require_once('../../../config/db.php');

$stmt = $pdo->prepare("Select oddzial.nazwa, oddzial.adres, sum(kwota) as suma from oddzial join samochod on samochod.OddzialID = oddzial.OddzialID join wypozyczenie on wypozyczenie.SamochodID = samochod.SamochodID join platnosc on platnosc.WypozyczenieID = wypozyczenie.WypozyczenieID WHERE platnosc.StatusPlatnosciID = 1 group by oddzial.oddzialid");
$stmt->execute();
$branches = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Dane oddziałów</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
<?php require_once('../../components/header.php'); ?>
<main class="account-main">
<h1>Dane oddziałów</h1>

<?php if (empty($branches)): ?>
    <p>Brak danych o zarobkach oddziałów</p>
<?php else: ?>
<table class="admin-users-table">
      <tr>
            <th>Oddział</th>
            <th>Adres</th>
            <th>Zarobek</th>
      </tr>

      <?php foreach ($branches as $branch): ?>
      <tr>
            <td><?=$branch['nazwa']?></td>
            <td><?=$branch['adres'] ?></td>
            <td><?=$branch['suma'] ?></td>
      </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>
</main>
<?php require_once('../../components/footer.php'); ?>
</body>
</html>
