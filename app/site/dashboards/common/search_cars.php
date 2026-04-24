<?php
require_once('../../../config/db.php');

$fuelTypes = $pdo->query("SELECT * FROM TypPaliwa")->fetchAll(PDO::FETCH_ASSOC);
$gearboxTypes = $pdo->query("SELECT * FROM SkrzyniaBiegow")->fetchAll(PDO::FETCH_ASSOC);
$bodyTypes = $pdo->query("SELECT * FROM TypNadwozia")->fetchAll(PDO::FETCH_ASSOC);
$branches = $pdo->query("SELECT * FROM Oddzial")->fetchAll(PDO::FETCH_ASSOC);

$cars = [];

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $brand = htmlspecialchars(trim($_POST['brand']));
    $color = htmlspecialchars(trim($_POST['color']));
    $fuel = $_POST['fuel'];
    $gearbox = $_POST['gearbox'];
    $body = $_POST['body'];
    $min_power = $_POST['min_power'];
    $min_year = $_POST['min_year'];
    $max_year = $_POST['max_year'];
    $max_price = $_POST['max_price'];
    $branch = $_POST['branch'];

    $errors = [];

    if ($brand !== "" && strlen($brand) < 2) $errors[] = "Marka musi mieć co najmniej 2 znaki.";
    if ($color !== "" && strlen($color) < 2) $errors[] = "Kolor musi mieć co najmniej 2 znaki.";
    if ($min_power !== "" && (!is_numeric($min_power) || $min_power < 0)) $errors[] = "Minimalna moc musi być liczbą dodatnią.";
    if ($min_year !== "" && (!is_numeric($min_year) || $min_year < 1886)) $errors[] = "Rok od jest nieprawidłowy.";
    if ($max_year !== "" && (!is_numeric($max_year) || $max_year < 1886)) $errors[] = "Rok do jest nieprawidłowy.";
    if ($min_year !== "" && $max_year !== "" && $min_year > $max_year) $errors[] = "Rok od nie może być większy niż rok do.";
    if ($max_price !== "" && (!is_numeric($max_price) || $max_price < 0)) $errors[] = "Cena maksymalna musi być liczbą dodatnią.";

    if (empty($errors)) {

        $query = "SELECT Samochod.*, TypPaliwa.TypPaliwa, SkrzyniaBiegow.SkrzyniaBiegow,TypNadwozia.TypNadwozia, Oddzial.Nazwa AS Oddzial, (SELECT Sciezka FROM ZdjecieSamochodu WHERE SamochodID = Samochod.SamochodID ORDER BY ZdjecieID ASC LIMIT 1) AS Zdjecie FROM Samochod JOIN TypPaliwa ON TypPaliwa.TypPaliwaID = Samochod.TypPaliwaID JOIN SkrzyniaBiegow ON SkrzyniaBiegow.SkrzyniaID = Samochod.SkrzyniaID JOIN TypNadwozia ON TypNadwozia.TypNadwoziaID = Samochod.TypNadwoziaID JOIN Oddzial ON Oddzial.OddzialID = Samochod.OddzialID WHERE StatusSamochoduID = 1";

        $params = [];

        if ($brand !== "") {
            $query .= " AND Samochod.Marka LIKE ?";
            $params[] = "%$brand%";
        }

        if ($color !== "") {
            $query .= " AND Samochod.Kolor LIKE ?";
            $params[] = "%$color%";
        }

        if ($fuel !== "") {
            $query .= " AND Samochod.TypPaliwaID = ?";
            $params[] = $fuel;
        }

        if ($gearbox !== "") {
            $query .= " AND Samochod.SkrzyniaID = ?";
            $params[] = $gearbox;
        }

        if ($body !== "") {
            $query .= " AND Samochod.TypNadwoziaID = ?";
            $params[] = $body;
        }

        if ($min_power !== "") {
            $query .= " AND Samochod.Moc >= ?";
            $params[] = $min_power;
        }

        if ($min_year !== "") {
            $query .= " AND Samochod.RokProdukcji >= ?";
            $params[] = $min_year;
        }

        if ($max_year !== "") {
            $query .= " AND Samochod.RokProdukcji <= ?";
            $params[] = $max_year;
        }

        if ($max_price !== "") {
            $query .= " AND Samochod.CenaZaDzien <= ?";
            $params[] = $max_price;
        }

        if ($branch !== "") {
            $query .= " AND Samochod.OddzialID = ?";
            $params[] = $branch;
        }

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carenteo | Przeglądanie Samochodów</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
<?php require_once('../../components/header.php'); ?>

<main class="account-main">

    <form method="POST" class="filter-form" action="">
        <h1>Filtruj Samochody</h1>

        <input type="text" name="brand" placeholder="Marka" value="<?= $brand ?? '' ?>">
        <input type="text" name="color" placeholder="Kolor" value="<?= $color ?? '' ?>">

        <select name="fuel">
            <option value="">Paliwo (dowolne)</option>
            <?php foreach($fuelTypes as $f): ?>
                <option value="<?= $f['TypPaliwaID'] ?>" <?= (isset($fuel) && $fuel == $f['TypPaliwaID']) ? 'selected' : '' ?>>
                    <?= $f['TypPaliwa'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="gearbox">
            <option value="">Skrzynia (dowolna)</option>
            <?php foreach($gearboxTypes as $g): ?>
                <option value="<?= $g['SkrzyniaID'] ?>" <?= (isset($gearbox) && $gearbox == $g['SkrzyniaID']) ? 'selected' : '' ?>>
                    <?= $g['SkrzyniaBiegow'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="body">
            <option value="">Nadwozie (dowolne)</option>
            <?php foreach($bodyTypes as $b): ?>
                <option value="<?= $b['TypNadwoziaID'] ?>" <?= (isset($body) && $body == $b['TypNadwoziaID']) ? 'selected' : '' ?>>
                    <?= $b['TypNadwozia'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="number" name="min_power" placeholder="Minimalna moc" value="<?= $min_power ?? '' ?>">
        <input type="number" name="min_year" placeholder="Rok od" value="<?= $min_year ?? '' ?>">
        <input type="number" name="max_year" placeholder="Rok do" value="<?= $max_year ?? '' ?>">
        <input type="number" name="max_price" placeholder="Cena max za dzień" value="<?= $max_price ?? '' ?>">

        <select name="branch">
            <option value="">Oddział (dowolny)</option>
            <?php foreach($branches as $br): ?>
                <option value="<?= $br['OddzialID'] ?>" <?= (isset($branch) && $branch == $br['OddzialID']) ? 'selected' : '' ?>>
                    <?= $br['Nazwa'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Filtruj</button>

        <?php if (!empty($errors)): ?>
            <ul class="error-list">
                <?php foreach($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </form>

    <?php if (!empty($cars)): ?>
      <div class="cars-grid">
            <?php foreach ($cars as $car): ?>
                <a class="car-card" href='./car_details.php?id=<?= $car['SamochodID'] ?>'>
                  <div class="car-img-box">
                        <img src="../../assets<?= $car['Zdjecie'] ?>" alt="Zdjęcie samochodu">
                  </div>
                  <div class="car-info">
                        <h3><?= $car['Marka'] . " " . $car['Model'] ?></h3>
                        <p><strong>Paliwo:</strong> <?= $car['TypPaliwa'] ?></p>
                        <p><strong>Skrzynia:</strong> <?= $car['SkrzyniaBiegow'] ?></p>
                        <p><strong>Nadwozie:</strong> <?= $car['TypNadwozia'] ?></p>
                        <p><strong>Moc:</strong> <?= $car['Moc'] ?> KM</p>
                        <p><strong>Rok produkcji:</strong> <?= $car['RokProdukcji'] ?></p>
                        <p><strong>Cena:</strong> <?= $car['CenaZaDzien'] ?> zł / dzień</p>
                        <p><strong>Oddział:</strong> <?= $car['Oddzial'] ?></p>
                  </div>
                  </a>
            <?php endforeach; ?>
      </div>
    <?php endif; ?>
</main>

<?php require_once('../../components/footer.php'); ?>
</body>
</html>
