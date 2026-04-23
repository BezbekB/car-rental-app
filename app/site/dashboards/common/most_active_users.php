<?php
require_once('../../../config/auth.php');
requireRole(['admin', 'pracownik']);
require_once('../../../config/db.php');

$stmt = $pdo->prepare("SELECT Osoba.OsobaID, Osoba.Imie, Osoba.Nazwisko, Osoba.Email, Osoba.Adres, COUNT(Wypozyczenie.WypozyczenieID) AS IloscWypozyczen FROM Osoba Join Wypozyczenie ON Wypozyczenie.KlientOsobaID = Osoba.OsobaID JOIN Uzytkownik ON Uzytkownik.UzytkownikID = Osoba.UzytkownikID WHERE Uzytkownik.RolaID = 1 Group By Osoba.OsobaID ORDER BY IloscWypozyczen DESC limit 5");
$stmt->execute();
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Najbardziej Aktywni Klienci</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
<?php require_once('../../components/header.php'); ?>
<main class="account-main">
<h1>Top 5 Najbardziej aktywnych klientów</h1>

<?php if (empty($clients)): ?>
    <p>Brak danych o wypożyczeniach.</p>
<?php else: ?>
<table class="admin-users-table">
      <tr>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>Email</th>
            <th>Adres</th>
            <th>Ilość wypożyczeń</th>
      </tr>

      <?php foreach ($clients as $client): ?>
      <tr>
            <td><?= $client['Imie'] ?></td>
            <td><?= $client['Nazwisko'] ?></td>
            <td><?= $client['Email'] ?></td>
            <td><?= $client['Adres'] ?></td>
            <td><?= $client['IloscWypozyczen'] ?></td>
      </tr>
      <?php endforeach; ?>
</table>
<?php endif; ?>
</main>
<?php require_once('../../components/footer.php'); ?>
</body>
</html>