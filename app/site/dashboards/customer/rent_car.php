<?php
require_once('../../../config/auth.php');
requireRole(['klient']);
require_once('../../../config/db.php');

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT CenaZaDzien FROM Samochod WHERE SamochodID = ?");
$stmt->execute([$id]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);
$pricePerDay = $car['CenaZaDzien'];

if($_SERVER['REQUEST_METHOD'] == "POST")
{
      $dateOfRent = $_POST['dateOfRent'];
      $plannedReturnDate = $_POST['plannedReturnDate'];
      $agreement = $_POST['agreement'];
      $totalCost = $_POST['totalCost'];
      
      $stmtClient = $pdo->prepare("SELECT OsobaID FROM Osoba Where UzytkownikID = ?");
      $stmtClient->execute([$_SESSION['user_id']]);
      $clientRow = $stmtClient->fetch(PDO::FETCH_ASSOC);
      $clientID = $clientRow['OsobaID'];

      $stmtEmployee = $pdo->query("SELECT Osoba.OsobaID From Osoba Join Uzytkownik ON Osoba.UzytkownikID = Uzytkownik.UzytkownikID WHERE Uzytkownik.RolaID = 2 ORDER BY RAND() LIMIT 1");
      $employeeRow = $stmtEmployee->fetch(PDO::FETCH_ASSOC);
      $employeeID = $employeeRow['OsobaID'];

      try{
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("INSERT INTO Wypozyczenie (SamochodID, KlientOsobaID, PracownikOsobaID, DataWypozyczenia, PlanowanaDataZwrotu, RzeczywistaDataZwrotu, StatusWypozyczeniaID, KosztCalkowity, NrUmowy) VALUES (?, ?, ?, ?, ?, NULL, ?, ?, ?)");
            $stmt->execute([$id, $clientID, $employeeID, $dateOfRent, $plannedReturnDate, 1, $totalCost, $agreement]);

            $rentID = $pdo->lastInsertId();
            $stmtPayment = $pdo->prepare("INSERT INTO Platnosc (WypozyczenieID, Kwota, DataPlatnosci, MetodaPlatnosciID, StatusPlatnosciID) VALUES (?, ?, NULL, NULL, 2)");
            $stmtPayment->execute([$rentID, $totalCost]);

            $updateCar = $pdo->prepare("UPDATE Samochod SET StatusSamochoduID = 2 WHERE SamochodID = ?");
            $updateCar->execute([$id]);

            $pdo->commit();

            header('Location: ../../index.php');
            exit;
      }
      catch(Exception $e)
      {
            $pdo->rollBack();
            $errors[] = "Błąd podczas wypożyczania: " . $e->getMessage();
      }
}


?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Wypożyczenie</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
<?php require_once('../../components/header.php'); ?>
<main class="account-main">
      <form action="" method="POST" id="rentForm">
            <label class="date-label">Data Wypożyczenia</label>
            <input type="date" name="dateOfRent">
            <label class="date-label">Planowana Data Zwrotu</label>
            <input type="date" name="plannedReturnDate">
            <label class="date-label">Numer Umowy</label>
            <input type="text" name="agreement" readonly>
            <label class="date-label">Koszt Całkowity</label>
            <input type="hidden" name="pricePerDay" value="<?= $pricePerDay ?>">
            <input type="text" name="totalCost" readonly>
            <button type="button" name="calcBtn">Podlicz Koszt i Wygeneruj Umowę</button>
            <button type="submit">Wypożycz</button>
            <?php if(isset($errors)):?>
                <ul class="error-list">
                        <?php foreach($errors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                </ul>
            <?php endif; ?>
      </form>
</main>
<?php require_once('../../components/footer.php'); ?>

<script>
      const rentForm = document.getElementById("rentForm");
      const pricePerDay = parseFloat(rentForm.pricePerDay.value); 

      function generateAgreementNumber() {
            const timestamp = Date.now(); 
            const random = Math.floor(1000 + Math.random() * 9000); 
            return `AGR-${timestamp}-${random}`;
      }



      rentForm.calcBtn.addEventListener("click", () => 
      {
            const dateStart = rentForm.dateOfRent.value;
            const dateEnd = rentForm.plannedReturnDate.value;

            if (!dateStart || !dateEnd) {
                  alert("Wybierz obie daty!");
                  return;
            }

            const start = new Date(dateStart);
            const end = new Date(dateEnd);

            if (end <= start) {
                  alert("Data zwrotu musi być późniejsza niż data wypożyczenia.");
                  return;
            }

            const diffTime = end - start;
            const days = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            const totalCost = days * pricePerDay;
            rentForm.totalCost.value = totalCost;

            rentForm.agreement.value = generateAgreementNumber();

      })
</script>
</body>
</html>
