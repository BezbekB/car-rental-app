<?php
require_once('../../../config/auth.php');
requireRole(['pracownik']);
require_once('../../../config/db.php');

$userid = $_SESSION['user_id'];

$stmt = $pdo->prepare("select oddzial.Nazwa, oddzial.Adres, sum(platnosc.Kwota) as suma from osoba join wypozyczenie on wypozyczenie.PracownikOsobaID = osoba.OsobaID join samochod on samochod.SamochodID = wypozyczenie.SamochodID join oddzial on oddzial.OddzialID = samochod.OddzialID join platnosc on platnosc.WypozyczenieID = wypozyczenie.WypozyczenieID where osoba.UzytkownikID = ? and platnosc.StatusPlatnosciID = 1 group by oddzial.OddzialID");
$stmt->execute([$userid]);
$branch = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Carenteo | Moj oddzial</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="../../style/style.css">
</head>
<body>

<?php require_once('../../components/header.php'); ?>

<main class="account-main">
<h1>Mój oddział</h1>

<?php if (empty($branch)): ?>
      <p>Brak danych o zarobkach oddziału</p>
<?php else: ?>
<table class="admin-users-table">
      <tr>
            <th>Nazwa</th>
            <th>Adres</th>
            <th>Zarobek</th>
      </tr>

      <tr>
            <td><?=$branch['Nazwa']?></td>
            <td><?=$branch['Adres']?></td>
            <td><?=$branch['suma']?></td>
      </tr>

</table>
<?php endif; ?>
</main>

<?php require_once('../../components/footer.php'); ?>

</body>
</html>