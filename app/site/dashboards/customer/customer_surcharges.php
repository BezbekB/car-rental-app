<?php
require_once('../../../config/auth.php');
requireRole(['klient']);
require_once('../../../config/db.php');

$stmtUser = $pdo->prepare("SELECT OsobaID FROM Osoba WHERE UzytkownikID = ?");
$stmtUser->execute([$_SESSION['user_id']]);
$userRow = $stmtUser->fetch(PDO::FETCH_ASSOC);
$osobaID = $userRow['OsobaID'];

$stmtSurcharges = $pdo->prepare("SELECT Doplata.DoplataID, Doplata.Kwota, TypDoplaty.TypDoplaty, Wypozyczenie.NrUmowy FROM Doplata JOIN TypDoplaty ON Doplata.TypDoplatyID = TypDoplaty.TypDoplatyID JOIN Wypozyczenie ON Wypozyczenie.WypozyczenieID = Doplata.WypozyczenieID WHERE Wypozyczenie.KlientOsobaID = ? ORDER BY Doplata.DoplataID DESC");
$stmtSurcharges->execute([$osobaID]);
$surcharges = $stmtSurcharges->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Konto Klienta</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
<?php require_once('../../components/header.php'); ?>
<main class="account-main">

      <h1>Twoje dopłaty</h1>

      <?php if (empty($surcharges)): ?>
            <p>Nie masz żadnych dopłat.</p>
      <?php else: ?>
            <table class="table">
                  <tr>
                        <th>Typ dopłaty</th>
                        <th>Kwota</th>
                        <th>Nr umowy</th>
                        <th>Akcja</th>
                  </tr>

                  <?php foreach ($surcharges as $s): ?>
                        <tr>
                              <td><?= $s['TypDoplaty'] ?></td>
                              <td><?= $s['Kwota'] ?> zł</td>
                              <td><?= $s['NrUmowy'] ?></td>
                              <td>
                                    <a class="btn" href="surcharge_payment.php?id=<?= $s['DoplataID'] ?>">Opłać dopłatę</a>
                              </td>
                        </tr>
                  <?php endforeach; ?>
            </table>
      <?php endif; ?>

</main>
<?php require_once('../../components/footer.php'); ?>
</body>
</html>
