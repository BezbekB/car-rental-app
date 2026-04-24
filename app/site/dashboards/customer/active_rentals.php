<?php
require_once('../../../config/auth.php');
requireRole(['klient']);
require_once('../../../config/db.php');

$stmtClient = $pdo->prepare("SELECT OsobaID FROM Osoba WHERE UzytkownikID = ?");
$stmtClient->execute([$_SESSION['user_id']]);
$clientRow = $stmtClient->fetch(PDO::FETCH_ASSOC);
$clientID = $clientRow['OsobaID'];

$stmt = $pdo->prepare("SELECT W.WypozyczenieID, W.DataWypozyczenia, W.PlanowanaDataZwrotu, W.KosztCalkowity, W.NrUmowy, W.StatusWypozyczeniaID, P.StatusPlatnosciID, S.Marka, 
S.Model,  (SELECT Z.Sciezka From ZdjecieSamochodu Z WHERE Z.SamochodID = S.SamochodID ORDER BY Z.Sciezka ASC LIMIT 1) as Zdjecie, O.Imie as PracownikImie, O.Nazwisko as PracownikNazwisko FROM Wypozyczenie W JOIN Samochod S ON W.SamochodID = S.SamochodID JOIN Platnosc P ON P.WypozyczenieID = W.WypozyczenieID JOIN Osoba O ON O.OsobaID = W.PracownikOsobaID WHERE W.KlientOsobaID = ? AND W.StatusWypozyczeniaID = 1");
$stmt->execute([$clientID]);
$rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Aktywne Wypożyczenia</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
<?php require_once('../../components/header.php'); ?>
<main class="account-main">
      <h1 class="title">Twoje aktywne wypożyczenia</h1>
      <?php if (empty($rentals)): ?>
            <p>Nie masz żadnych aktywnych wypożyczeń.</p>
      <?php endif; ?>
      <div class="rentals-container">
            <?php foreach ($rentals as $rental): ?>
                  <div class="rental-card">
                        <img src="../../assets<?= $rental['Zdjecie'] ?>" class="car-photo">
                        <div class="rental-info">
                              <h3><?= $rental['Marka'] . " " . $rental['Model'] ?></h3>
                              <p><strong>Data wypożyczenia:</strong> <?= $rental['DataWypozyczenia'] ?></p>
                              <p><strong>Planowany zwrot:</strong> <?= $rental['PlanowanaDataZwrotu'] ?></p>
                              <p><strong>Pracownik:</strong> <?= $rental['PracownikImie'] . " " . $rental['PracownikNazwisko'] ?></p>
                              <p><strong>Kwota:</strong> <?= $rental['KosztCalkowity'] ?> zł</p>
                              <p><strong>Nr umowy:</strong> <?= $rental['NrUmowy'] ?></p>
                        </div>
                        <div class="rental-actions">
                              <?php if ($rental['StatusPlatnosciID'] == 2): ?>
                                    <a href="./rental_payments.php?id=<?= $rental['WypozyczenieID'] ?>" class="btn pay-btn">Zapłać</a>
                              <?php endif; ?>

                              <?php if ($rental['StatusWypozyczeniaID'] == 1 && $rental['StatusPlatnosciID'] == 1): ?>
                                    <a href="./return_rental.php?id=<?= $rental['WypozyczenieID'] ?>" class="btn return-btn">Oddaj samochód</a>
                              <?php endif; ?>
                        </div>
                  </div>
            <?php endforeach; ?>
      </div>
</main>
<?php require_once('../../components/footer.php'); ?>
</body>
</html>
