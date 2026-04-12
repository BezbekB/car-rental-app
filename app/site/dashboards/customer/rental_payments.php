<?php
require_once('../../../config/auth.php');
requireRole(['klient']);
require_once('../../../config/db.php');

$id = $_GET['id'];

$stmtPrice = $pdo->prepare("SELECT Kwota From Platnosc WHERE WypozyczenieID = ?");
$stmtPrice->execute([$id]);
$priceRow = $stmtPrice->fetch(PDO::FETCH_ASSOC);
$price = $priceRow['Kwota'];

$stmtPaymentMethod = $pdo->prepare("SELECT * FROM MetodaPlatnosci");
$stmtPaymentMethod->execute();
$methods = $stmtPaymentMethod->fetchAll(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD'] === "POST")
{
      $method = $_POST['method'];
      $date = date("Y-m-d");

      $stmt = $pdo->prepare("UPDATE Platnosc SET DataPlatnosci = ?, MetodaPlatnosciID = ?, StatusPlatnosciID = ? WHERE WypozyczenieID = ?");
      $stmt->execute([$date, $method, 1, $id]);

      header('Location: ./active_rentals.php');
      exit;
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Płatność</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
<?php require_once('../../components/header.php'); ?>
<main class="account-main">
      <h1 class="title">Opłata za wypożyczenie</h1>
      <form action="" method="POST">
            <?php if(isset($price)): ?>
                  <p><?= $price ?></p>
            <?php endif; ?>
            <label class="date-label">Metoda Płatności</label>
            <select name="method">
                  <?php foreach($methods as $method): ?>
                        <option value="<?=  $method['MetodaPlatnosciID']?>"><?= $method['MetodaPlatnosci'] ?></option>
                  <?php endforeach; ?>
            </select>
            <button type="submit" class="btn pay-btn">Zapłać</button>
      </form>
</main>
<?php require_once('../../components/footer.php'); ?>
</body>
</html>
