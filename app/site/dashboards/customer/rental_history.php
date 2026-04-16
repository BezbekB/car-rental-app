<?php
require_once('../../../config/auth.php');
requireRole(['klient']);
require_once('../../../config/db.php');

$userId = $_SESSION['user_id'];

$stmtUser = $pdo->prepare("SELECT OsobaID FROM Osoba WHERE UzytkownikID = ?");
$stmtUser->execute([$userId]);
$osoba = $stmtUser->fetch(PDO::FETCH_ASSOC);

if (!$osoba) {
    die("Nie znaleziono danych klienta.");
}

$osobaID = $osoba['OsobaID'];

$stmt = $pdo->prepare("SELECT W.WypozyczenieID, W.NrUmowy, W.DataWypozyczenia, W.PlanowanaDataZwrotu, W.RzeczywistaDataZwrotu, W.KosztCalkowity, S.Marka, S.Model, S.RokProdukcji, (SELECT Sciezka FROM ZdjecieSamochodu Z WHERE Z.SamochodID = S.SamochodID ORDER BY ZdjecieID DESC LIMIT 1) AS Zdjecie FROM Wypozyczenie W JOIN Samochod S ON W.SamochodID = S.SamochodID
WHERE W.KlientOsobaID = ? AND W.StatusWypozyczeniaID = 2 ORDER BY W.DataWypozyczenia DESC");
$stmt->execute([$osobaID]);
$rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Historia Wypożyczeń</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
<?php require_once('../../components/header.php'); ?>
<main class="account-main">
      <h1>Historia wypożyczeń</h1>

      <div class="rentals-container">
            <?php if (empty($rentals)): ?>
                  <p style="color:white; font-size:1.3em;">Brak zakończonych wypożyczeń.</p>
            <?php else: ?>
                  <?php foreach ($rentals as $rental): ?>
                        <div class="rental-card">
                              <img src="../../assets<?= $rental['Zdjecie'] ?>" class="car-photo">
                              <div class="rental-info">
                                    <h3><?= $rental['Marka'] . " " . $rental['Model'] ?> (<?= $rental['RokProdukcji'] ?>)</h3>
                                    <p><strong>Nr umowy:</strong> <?= $rental['NrUmowy'] ?></p>
                                    <p><strong>Data wypożyczenia:</strong> <?= $rental['DataWypozyczenia'] ?></p>
                                    <p><strong>Planowany zwrot:</strong> <?= $rental['PlanowanaDataZwrotu'] ?></p>
                                    <p><strong>Rzeczywisty zwrot:</strong> <?= $rental['RzeczywistaDataZwrotu'] ?></p>
                                    <p><strong>Koszt całkowity:</strong> <?= $rental['KosztCalkowity'] ?> zł</p>
                              </div>
                        </div>
                  <?php endforeach; ?>
            <?php endif; ?>
      </div>

</main>
<?php require_once('../../components/footer.php'); ?>
</body>
</html>
