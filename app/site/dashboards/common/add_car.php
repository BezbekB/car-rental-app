<?php
require_once('../../../config/auth.php');
requireRole(['admin', 'pracownik']);
require_once('../../../config/db.php');

$fuelTypes = $pdo->query("SELECT * FROM TypPaliwa")->fetchAll(PDO::FETCH_ASSOC);
$gearboxTypes = $pdo->query("SELECT * From SkrzyniaBiegow")->fetchAll(PDO::FETCH_ASSOC);
$bodyTypes = $pdo->query("SELECT * From TypNadwozia")->fetchAll(PDO::FETCH_ASSOC);
$branches = $pdo->query("SELECT * From Oddzial")->fetchAll(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD'] == "POST")
{
      $brand = htmlspecialchars(trim($_POST['brand']));
      $model = htmlspecialchars(trim($_POST['model']));
      $color = htmlspecialchars(trim($_POST['color']));
      $fuelType = $_POST['fuelType'];
      $gearboxType = $_POST['gearboxType'];
      $bodyType = $_POST['bodyType'];
      $power = $_POST['power'];
      $yearOfProduction = $_POST['yearOfProduction'];
      $pricePerDay = $_POST['pricePerDay'];
      $registrationNumber = htmlspecialchars(trim($_POST['registrationNumber']));
      $vin = $_POST['vin'];
      $mileage = $_POST['mileage'];
      $branch = $_POST['branch'];
      

      $errors = [];

      if (empty($brand)) $errors[] = "Marka jest wymagana";
      if (empty($model)) $errors[] = "Model jest wymagany";
      if (empty($color)) $errors[] = "Kolor jest wymagany";
      if (!is_numeric($power) || $power <= 0) $errors[] = "Moc musi być liczbą dodatnią";
      if (!is_numeric($yearOfProduction) || $yearOfProduction <= 1885) $errors[] = "Rok produkcji jest nieprawidłowy";
      if ($pricePerDay <= 0) $errors[] = "Cena musi być większa od 0";
      if (strlen($vin) !== 17) $errors[] = "VIN musi mieć 17 znaków";
      if ($mileage < 0) $errors[] = "Przebieg nie może być ujemny";

      if (!empty($_FILES['photos']['name'][0])) {
            if (count($_FILES['photos']['name']) > 10) {
                  $errors[] = "Możesz dodać maksymalnie 10 zdjęć.";
            }
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            foreach ($_FILES['photos']['type'] as $type) {
                  if (!in_array($type, $allowedTypes)) {
                        $errors[] = "Dozwolone formaty zdjęć to JPG, PNG i WEBP.";
                        break;
                  }
            }
      } else 
      {
            $errors[] = "Musisz dodać przynajmniej jedno zdjęcie samochodu.";
      }

      $description = htmlspecialchars(trim($_POST['description']));


      if(empty($errors))
      {
            try{
                  $pdo->beginTransaction();

                  $stmt = $pdo->prepare("INSERT INTO Samochod (Marka, Model, Kolor, TypPaliwaID, SkrzyniaID, TypNadwoziaID, Moc, RokProdukcji, CenaZaDzien, StatusSamochoduID, NrRejestracyjny, VIN, Przebieg, OddzialID, Opis) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?, ?, ?, ?, ?)");
                  $stmt->execute([$brand, $model, $color, $fuelType, $gearboxType, $bodyType, $power, $yearOfProduction, $pricePerDay, $registrationNumber, $vin, $mileage, $branch, $description]);


                  $carID = $pdo->lastInsertId();

                  $uploadDir = "../../assets/uploads/cars/";

                  if(!file_exists($uploadDir))
                  {
                        mkdir($uploadDir, 0777, true);
                  }

                  foreach ($_FILES['photos']['tmp_name'] as $key => $tmp) {
                        if ($_FILES['photos']['error'][$key] === UPLOAD_ERR_OK) {

                        $fileName = uniqid() . "_" . basename($_FILES['photos']['name'][$key]);
                        $targetPath = $uploadDir . $fileName;

                        move_uploaded_file($tmp, $targetPath);

                        $pathInDb = "/uploads/cars/" . $fileName;

                        $stmt = $pdo->prepare("INSERT INTO ZdjecieSamochodu (SamochodID, Sciezka) VALUES (?, ?)");
                        $stmt->execute([$carID, $pathInDb]);
                        }
                  }

                  $pdo->commit();

                  $success = "Samochód został dodany!";
            }
            catch(Exception $e)
            {
                  $pdo->rollBack();
                  $errors[] = "Błąd dodawania samochodu: " . $e->getMessage();
            }
      }

}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Dodawanie Samochodu</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
<?php require_once('../../components/header.php'); ?>
<main class="account-main">
      <form action="" method="POST" autocomplete="off" enctype="multipart/form-data">
            <h1>Rejestracja</h1>
            <input type="text" name="brand" placeholder="Marka">
            <input type="text" name="model" placeholder="Model">
            <input type="text" name="color" placeholder="Kolor">
            <label class="date-label">Typ Paliwa</label>
            <select name="fuelType">
                  <?php foreach($fuelTypes as $fuelType): ?>
                        <option value="<?= $fuelType['TypPaliwaID'] ?>"><?= $fuelType['TypPaliwa'] ?></option>
                  <?php endforeach; ?>
            </select>
            <label class="date-label">Skrzynia Biegów</label>
            <select name="gearboxType">
                  <?php foreach($gearboxTypes as $gearboxType): ?>
                        <option value="<?= $gearboxType['SkrzyniaID'] ?>"><?= $gearboxType['SkrzyniaBiegow'] ?></option>
                  <?php endforeach; ?>
            </select>
            <label class="date-label">Typ Nadwozia</label>
            <select name="bodyType">
                  <?php foreach($bodyTypes as $bodyType): ?>
                        <option value="<?= $bodyType['TypNadwoziaID'] ?>"><?= $bodyType['TypNadwozia'] ?></option>
                  <?php endforeach; ?>
            </select>    
            <input type="number" name="power" placeholder="Moc">
            <input type="number" name="yearOfProduction" placeholder="Rok Produkcji">
            <input type="number" name="pricePerDay" placeholder="Cena Za Dzień">
            <input type="text" name="registrationNumber" placeholder="Numer Rejestracyjny">
            <input type="text" name="vin" placeholder="VIN">
            <input type="number" name="mileage" placeholder="Przebieg">
            <label class="date-label">Oddział</label>
            <select name="branch">
                  <?php foreach($branches as $branch): ?>
                        <option value="<?= $branch['OddzialID'] ?>"><?= $branch['Nazwa'] ?></option>
                  <?php endforeach; ?>
            </select> 
            <label class="date-label">Zdjęcia Samochodu</label>
            <input type="file" name="photos[]" multiple accept="image/*">
            <textarea name="description" placeholder="Opis samochodu" rows="5"></textarea>
            <button type="submit">Dodaj Samochód</button>
            <?php if(isset($errors)):?>
                  <ul class="error-list">
                        <?php foreach($errors as $error): ?>
                              <li><?= $error ?></li>
                        <?php endforeach; ?>
                  </ul>
            <?php endif; ?>
            <?php if(isset($success)): ?>
                  <p class="success"><?= $success ?></p>
            <?php endif; ?>
      </form>
</main>
<?php require_once('../../components/footer.php'); ?>
</body>
</html>