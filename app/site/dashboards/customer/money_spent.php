<?php
require_once('../../../config/auth.php');
requireRole(['klient']);
require_once('../../../config/db.php');

$stmtClient = $pdo->prepare("SELECT OsobaID FROM Osoba WHERE UzytkownikID = ?");
$stmtClient->execute([$_SESSION['user_id']]);
$client = $stmtClient->fetch(PDO::FETCH_ASSOC);
$klientID = $client['OsobaID'];

$stmt = $pdo->prepare("SELECT SUM(Kwota) AS Wydane FROM (SELECT Platnosc.Kwota FROM Platnosc JOIN Wypozyczenie ON Wypozyczenie.WypozyczenieID = Platnosc.WypozyczenieID WHERE Platnosc.StatusPlatnosciID = 1 AND Wypozyczenie.KlientOsobaID = ? UNION ALL SELECT Doplata.Kwota FROM Doplata JOIN Wypozyczenie ON Wypozyczenie.WypozyczenieID = Doplata.WypozyczenieID WHERE Doplata.StatusDoplatyID = 1 AND Wypozyczenie.KlientOsobaID = ?) AS combined");
$stmt->execute([$klientID, $klientID]);
$total = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Wydane Pieniądze</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
<?php require_once('../../components/header.php'); ?>
<main class="account-main">
<h1>Twoje wydatki</h1>

<table class="admin-users-table">
            <tr>
                  <th>Opis</th>
                  <th>Kwota</th>
            </tr>
            <tr>
                  <td>Łącznie wydane na wypożyczenia i dopłaty</td>
                  <td><?= number_format($total['Wydane'] ?? 0, 2, ',', ' ') ?> zł</td>
            </tr>
</table>

</main>
<?php require_once('../../components/footer.php'); ?>
</body>
</html>
