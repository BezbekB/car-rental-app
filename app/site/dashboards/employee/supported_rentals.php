<?php
require_once('../../../config/auth.php');
requireRole(['pracownik']);
require_once('../../../config/db.php');

$stmtEmployee = $pdo->prepare("SELECT OsobaID FROM Osoba WHERE UzytkownikID = ?");
$stmtEmployee->execute([$_SESSION['user_id']]);
$employeeRow = $stmtEmployee->fetch(PDO::FETCH_ASSOC);
$employeeID = $employeeRow['OsobaID'];

$stmt = $pdo->prepare("SELECT W.WypozyczenieID, W.DataWypozyczenia, W.PlanowanaDataZwrotu, W.KosztCalkowity, W.NrUmowy, SW.StatusWypozyczenia, SP.StatusPlatnosci, S.Marka, S.Model, (SELECT Sciezka From ZdjecieSamochodu WHERE ZdjecieSamochodu.SamochodID = S.SamochodID order by ZdjecieSamochodu.Sciezka DESC LIMIT 1) as Zdjecie, O2.Imie AS KlientImie, O2.Nazwisko AS KlientNazwisko FROM Wypozyczenie W JOIN Samochod S ON W.SamochodID = S.SamochodID JOIN Platnosc P ON P.WypozyczenieID = W.WypozyczenieID JOIN StatusWypozyczenia SW ON SW.StatusWypozyczeniaID = W.StatusWypozyczeniaID JOIN StatusPlatnosci SP ON SP.StatusPlatnosciID = P.StatusPlatnosciID JOIN Osoba O1 ON O1.OsobaID = W.PracownikOsobaID JOIN Osoba O2 ON O2.OsobaID = W.KlientOsobaID WHERE W.PracownikOsobaID = ? ORDER BY W.DataWypozyczenia DESC;");
$stmt->execute([$employeeID]);
$rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Obsługiwane Wypożyczenia</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
<?php require_once('../../components/header.php'); ?>
<main class="account-main">
      <h1 class="title">Twoje Obsługiwane Wypożyczenia</h1>
      <?php if (empty($rentals)): ?>
            <p>Nie masz obsługiwanych wypożyczeń</p>
      <?php endif; ?>
      <div class="rentals-container">
            <?php foreach ($rentals as $rental): ?>
                  <div class="rental-card">
                        <img src="../../assets<?= $rental['Zdjecie'] ?>" class="car-photo">
                        <div class="rental-info">
                              <h3><?= $rental['Marka'] . " " . $rental['Model'] ?></h3>
                              <p><strong>Data wypożyczenia:</strong> <?= $rental['DataWypozyczenia'] ?></p>
                              <p><strong>Planowany zwrot:</strong> <?= $rental['PlanowanaDataZwrotu'] ?></p>
                              <p><strong>Kwota:</strong> <?= $rental['KosztCalkowity'] ?> zł</p>
                              <p><strong>Nr umowy:</strong> <?= $rental['NrUmowy'] ?></p>
                              <p><strong>Klient:</strong> <?= $rental['KlientImie'] . " " . $rental['KlientNazwisko'] ?></p>
                              <p><strong>Status wypożyczenia:</strong> <?= $rental['StatusWypozyczenia'] ?></p>
                              <p><strong>Status płatności:</strong> <?= $rental['StatusPlatnosci'] ?></p>
                        </div>
                        <div class="rental-actions">
                              
                        </div>
                  </div>
            <?php endforeach; ?>
      </div>
</main>
<?php require_once('../../components/footer.php'); ?>
</body>
</html>
