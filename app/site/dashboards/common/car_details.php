<?php
session_start();
require_once('../../../config/db.php');
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT Samochod.*, TypPaliwa.TypPaliwa,SkrzyniaBiegow.SkrzyniaBiegow, TypNadwozia.TypNadwozia, Oddzial.Nazwa AS Oddzial FROM Samochod JOIN TypPaliwa ON TypPaliwa.TypPaliwaID = Samochod.TypPaliwaID JOIN SkrzyniaBiegow ON SkrzyniaBiegow.SkrzyniaID = Samochod.SkrzyniaID JOIN TypNadwozia ON TypNadwozia.TypNadwoziaID = Samochod.TypNadwoziaID JOIN Oddzial ON Oddzial.OddzialID = Samochod.OddzialID
WHERE Samochod.SamochodID = ?");
$stmt->execute([$id]);
$details = $stmt->fetch(PDO::FETCH_ASSOC);

$photosStmt = $pdo->prepare("SELECT Sciezka FROM ZdjecieSamochodu WHERE SamochodID = ? ORDER BY ZdjecieID DESC");
$photosStmt->execute([$id]);
$photos = $photosStmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Szczegóły Samochodu</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
<?php require_once('../../components/header.php'); ?>
<div class="account-main">
      <div class="car-details-card">

            <div class="car-slider">
                  <button class="slider-btn prev">&lt;</button>

                  <div class="slider-window">
                        <div class="slider-track">
                              <?php foreach ($photos as $photo): ?>
                              <img src="../../assets<?= $photo['Sciezka'] ?>" class="slide-img">
                              <?php endforeach; ?>
                        </div>
                  </div>

                  <button class="slider-btn next">&gt;</button>
            </div>


            <div class="car-details-info">
                  <h1><?= $details['Marka'] . " " . $details['Model'] ?></h1>

                  <div class="car-details-grid">
                        <p><strong>Kolor:</strong> <?= $details['Kolor'] ?></p>
                        <p><strong>Typ paliwa:</strong> <?= $details['TypPaliwa'] ?></p>
                        <p><strong>Skrzynia biegów:</strong> <?= $details['SkrzyniaBiegow'] ?></p>
                        <p><strong>Typ nadwozia:</strong> <?= $details['TypNadwozia'] ?></p>
                        <p><strong>Moc:</strong> <?= $details['Moc'] ?> KM</p>
                        <p><strong>Rok produkcji:</strong> <?= $details['RokProdukcji'] ?></p>
                        <p><strong>Cena za dzień:</strong> <?= $details['CenaZaDzien'] ?> zł</p>
                        <p><strong>Nr rejestracyjny:</strong> <?= $details['NrRejestracyjny'] ?></p>
                        <p><strong>VIN:</strong> <?= $details['VIN'] ?></p>
                        <p><strong>Przebieg:</strong> <?= $details['Przebieg'] ?> km</p>
                        <p><strong>Oddział:</strong> <?= $details['Oddzial'] ?></p>
                        <p><strong>Opis:</strong> <?= $details['Opis'] ?></p>
                  </div>

                  <?php if(!isset($_SESSION['rola'])): ?>
                        <a href="../../account/login.php" class="rent-btn">Wypożycz</a>
                  <?php elseif($_SESSION['rola'] == "klient"): ?>
                        <a href="../customer/rent_car.php?id=<?= $details['SamochodID'] ?>" class="rent-btn">Wypożycz</a>
                  <?php endif; ?>
            </div>

      </div>
</div>


<?php require_once('../../components/footer.php'); ?>

<script>
      const track = document.querySelector('.slider-track');
      const slides = document.querySelectorAll('.slide-img');
      const prev = document.querySelector('.prev');
      const next = document.querySelector('.next');

      let index = 0;

      function updateSlider() {
            track.style.transform = `translateX(-${index * 100}%)`;
      }

      next.addEventListener('click', () => {
            if (index < slides.length - 1) index++;
            updateSlider();
      });

      prev.addEventListener('click', () => {
            if (index > 0) index--;
            updateSlider();
      });
</script>

</body>
</html>
