<?php
require_once('../../../config/auth.php');
requireRole(['klient', 'pracownik']);

require_once('../../../config/db.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
      $firstName = htmlspecialchars(trim($_POST['firstName']));
      $lastName = htmlspecialchars(trim($_POST['lastName']));
      $dateOfBirth = $_POST['dateOfBirth'];
      $phoneNumber = htmlspecialchars(trim($_POST['phoneNumber']));
      $email = htmlspecialchars(trim($_POST['email']));
      $address = htmlspecialchars(trim($_POST['address']));

      $errors = [];
      
      if(empty($firstName) || empty($lastName)) $errors[] = "Imię i nazwisko są wymagane";

      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Niepoprawny email";

      if(strlen($phoneNumber) < 9) $errors[] = "Niepoprawny numer telefonu";

      if(empty($address)) $errors[] = "Niepoprawny adres";

      if(empty($errors))
      {
            try{
                  $stmt = $pdo->prepare("UPDATE Osoba SET Imie = ?, Nazwisko = ?, DataUrodzenia = ?, NrTelefonu = ?, Email = ?, Adres = ? WHERE UzytkownikID = ?");
                  $stmt->execute([$firstName, $lastName, $dateOfBirth, $phoneNumber, $email, $address, $_SESSION['user_id']]);
                  $success = "Dane zostały zaaktualizowane!";
            }
            catch(Exception $e)
            {
                  $errors[] = "Błąd podczas zmiany danych: " . $e->getMessage();
            }
      }
}

$stmt = $pdo->prepare("SELECT * FROM Osoba Where UzytkownikID = ?");
$stmt->execute([$_SESSION['user_id']]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Dane Osobowe</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
<?php require_once('../../components/header.php'); ?>
<main class="account-main">
      <form action="" method="POST" autocomplete="off">
            <h1>Dane Osobowe</h1>
            <label class="date-label">Imię</label>
            <input type="text" name="firstName" placeholder="Imię" value="<?= $data['Imie'] ?>">
            <label class="date-label">Nazwisko</label>
            <input type="text" name="lastName" placeholder="Nazwisko" value="<?= $data['Nazwisko'] ?>">
            <label class="date-label">Data urodzenia</label>
            <input type="date" name="dateOfBirth" placeholder="Data Urodzenia" value="<?= $data['DataUrodzenia'] ?>">
            <label class="date-label">Numer Telefonu</label>
            <input type="text" name="phoneNumber" placeholder="Numer Telefonu" value="<?= $data['NrTelefonu'] ?>">
            <label class="date-label">Email</label>
            <input type="email" name="email" placeholder="Email" value="<?= $data['Email'] ?>">
            <label class="date-label">Adres</label>
            <input type="text" name="address" placeholder="Adres" value="<?= $data['Adres'] ?>">
            <button type="submit">Zaaktualizuj Dane</button>
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
