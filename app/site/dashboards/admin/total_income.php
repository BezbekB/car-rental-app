<?php
require_once('../../../config/auth.php');
requireRole(['admin']);
require_once('../../../config/db.php');

$stmt = $pdo->prepare("SELECT SUM(Kwota) AS Przychod FROM (SELECT Platnosc.Kwota FROM Platnosc WHERE Platnosc.StatusPlatnosciID = 2 UNION ALL SELECT Doplata.Kwota FROM Doplata WHERE Doplata.StatusDoplatyID = 2) AS combined");
$stmt->execute();
$total = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Całkowity Przychód</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
<?php require_once('../../components/header.php'); ?>
<main class="account-main">
<h1>Całkowity przychód</h1>

<table class="admin-users-table">
            <tr>
                  <th>Opis</th>
                  <th>Kwota</th>
            </tr>
            <tr>
                  <td>Łączny przychód firmy</td>
                  <td><?= $total['Przychod'] ?> zł</td>
            </tr>
</table>
</main>
<?php require_once('../../components/footer.php'); ?>
</body>
</html>