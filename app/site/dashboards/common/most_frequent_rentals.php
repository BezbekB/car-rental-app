<?php
require_once('../../../config/auth.php');
requireRole(['admin', 'pracownik']);
require_once('../../../config/db.php');

$stmt = $pdo->prepare("SELECT Samochod.SamochodID, Samochod.Marka, Samochod.Model, Samochod.RokProdukcji, Samochod.Kolor, Samochod.CenaZaDzien, COUNT(Wypozyczenie.WypozyczenieID) AS IloscWypozyczen FROM Samochod JOIN Wypozyczenie ON Wypozyczenie.SamochodID = Samochod.SamochodID GROUP BY Samochod.SamochodID ORDER BY IloscWypozyczen DESC LIMIT 5");
$stmt->execute();
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Najczęściej Wypożyczane Samochody</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
<?php require_once('../../components/header.php'); ?>
<main class="account-main">
<h1>Top 5 Najczęściej wypożyczanych samochodów</h1>

<?php if (empty($cars)): ?>
    <p>Brak danych o wypożyczeniach.</p>
<?php else: ?>
<table class="admin-users-table">
      <tr>
            <th>Marka</th>
            <th>Model</th>
            <th>Rok</th>
            <th>Kolor</th>
            <th>Cena za dzień</th>
            <th>Ilość wypożyczeń</th>
      </tr>

      <?php foreach ($cars as $car): ?>
      <tr>
            <td><?= $car['Marka'] ?></td>
            <td><?= $car['Model'] ?></td>
            <td><?= $car['RokProdukcji'] ?></td>
            <td><?= $car['Kolor'] ?></td>
            <td><?= $car['CenaZaDzien'] ?> zł</td>
            <td><?= $car['IloscWypozyczen'] ?></td>
      </tr>
      <?php endforeach; ?>
</table>
<?php endif; ?>
</main>
<?php require_once('../../components/footer.php'); ?>
</body>
</html>