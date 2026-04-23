<?php
require_once('../../../config/auth.php');
requireRole(['admin', 'pracownik']);
require_once('../../../config/db.php');

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM Samochod WHERE SamochodID = ?");
$stmt->execute([$id]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

$typesFuel = $pdo->query("SELECT * FROM TypPaliwa")->fetchAll(PDO::FETCH_ASSOC);
$typesGear = $pdo->query("SELECT * FROM SkrzyniaBiegow")->fetchAll(PDO::FETCH_ASSOC);
$typesBody = $pdo->query("SELECT * FROM TypNadwozia")->fetchAll(PDO::FETCH_ASSOC);
$branches = $pdo->query("SELECT * FROM Oddzial")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $marka = $_POST['marka'];
      $model = $_POST['model'];
      $kolor = $_POST['kolor'];
      $paliwo = $_POST['paliwo'];
      $skrzynia = $_POST['skrzynia'];
      $nadwozie = $_POST['nadwozie'];
      $moc = $_POST['moc'];
      $rok = $_POST['rok'];
      $cena = $_POST['cena'];
      $rejestracja = $_POST['rejestracja'];
      $vin = $_POST['vin'];
      $przebieg = $_POST['przebieg'];
      $oddzial = $_POST['oddzial'];
      $opis = $_POST['opis'];

      $update = $pdo->prepare("UPDATE Samochod SET Marka = ?, Model = ?, Kolor = ?, TypPaliwaID = ?, SkrzyniaID = ?, TypNadwoziaID = ?, Moc = ?, RokProdukcji = ?, 
      CenaZaDzien = ?, NrRejestracyjny = ?, VIN = ?, Przebieg = ?, OddzialID = ?, Opis = ? WHERE SamochodID = ?");

      $update->execute([$marka, $model, $kolor, $paliwo, $skrzynia, $nadwozie,$moc, $rok, $cena, $rejestracja, $vin, $przebieg, $oddzial, $opis, $id]);

      header("Location: ../common/search_cars.php");
      exit;
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Edycja Samochodu</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
<?php require_once('../../components/header.php'); ?>
<main class="account-main">
    <h1>Edytuj Samochód</h1>

    <form method="POST">
            <input type="text" name="marka" value="<?= $car['Marka'] ?>" placeholder="Marka" required>
            <input type="text" name="model" value="<?= $car['Model'] ?>" placeholder="Model" required>
            <input type="text" name="kolor" value="<?= $car['Kolor'] ?>" placeholder="Kolor" required>

            <select name="paliwo">
                  <?php foreach ($typesFuel as $t): ?>
                  <option value="<?= $t['TypPaliwaID'] ?>" <?= $t['TypPaliwaID'] == $car['TypPaliwaID'] ? 'selected' : '' ?>>
                        <?= $t['TypPaliwa'] ?>
                  </option>
                  <?php endforeach; ?>
            </select>

            <select name="skrzynia">
                  <?php foreach ($typesGear as $t): ?>
                  <option value="<?= $t['SkrzyniaID'] ?>" <?= $t['SkrzyniaID'] == $car['SkrzyniaID'] ? 'selected' : '' ?>>
                        <?= $t['SkrzyniaBiegow'] ?>
                  </option>
                  <?php endforeach; ?>
            </select>

            <select name="nadwozie">
                  <?php foreach ($typesBody as $t): ?>
                  <option value="<?= $t['TypNadwoziaID'] ?>" <?= $t['TypNadwoziaID'] == $car['TypNadwoziaID'] ? 'selected' : '' ?>>
                        <?= $t['TypNadwozia'] ?>
                  </option>
                  <?php endforeach; ?>
            </select>

            <input type="number" name="moc" value="<?= $car['Moc'] ?>" placeholder="Moc (KM)" required>
            <input type="number" name="rok" value="<?= $car['RokProdukcji'] ?>" placeholder="Rok produkcji" required>
            <input type="number" name="cena" value="<?= $car['CenaZaDzien'] ?>" placeholder="Cena za dzień" required>
            <input type="text" name="rejestracja" value="<?= $car['NrRejestracyjny'] ?>" placeholder="Nr rejestracyjny" required>
            <input type="text" name="vin" value="<?= $car['VIN'] ?>" placeholder="VIN" required>
            <input type="number" name="przebieg" value="<?= $car['Przebieg'] ?>" placeholder="Przebieg" required>

            <select name="oddzial">
                  <?php foreach ($branches as $b): ?>
                  <option value="<?= $b['OddzialID'] ?>" <?= $b['OddzialID'] == $car['OddzialID'] ? 'selected' : '' ?>>
                        <?= $b['Nazwa'] ?>
                  </option>
                  <?php endforeach; ?>
            </select>

            <textarea name="opis" placeholder="Opis"><?= $car['Opis'] ?></textarea>

            <button type="submit">Zapisz zmiany</button>
    </form>
</main>
<?php require_once('../../components/footer.php'); ?>
</body>
</html>