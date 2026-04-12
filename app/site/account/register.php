<?php
require_once('../../config/db.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
      $login = htmlspecialchars(trim($_POST['login']));
      $password = trim($_POST['password']);
      $firstName = htmlspecialchars(trim($_POST['firstName']));
      $lastName = htmlspecialchars(trim($_POST['lastName']));
      $dateOfBirth = $_POST['dateOfBirth'];
      $pesel = htmlspecialchars(trim($_POST['pesel']));
      $phoneNumber = htmlspecialchars(trim($_POST['phoneNumber']));
      $email = htmlspecialchars(trim($_POST['email']));
      $address = htmlspecialchars(trim($_POST['address']));
      $drivingLicenseNumber = htmlspecialchars(trim($_POST['drivingLicenseNumber']));
      $expirationDateOfLicenseNumber = $_POST['expirationDateOfLicenseNumber'];
      $roleId = 1;

      $errors = [];

      if(empty($login) || strlen($login) < 3) $errors[] = "Login musi mieć min. 3 znaki";

      if(strlen($password) < 6) $errors[] = "Hasło musi mieć min. 6 znaków";
      
      if(empty($firstName) || empty($lastName)) $errors[] = "Imię i nazwisko są wymagane";

      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Niepoprawny email";
      
      if(strlen($pesel) != 11) $errors[] = "Pesel musi mieć dokładnie 11 cyfr";

      if(strlen($phoneNumber) < 9) $errors[] = "Niepoprawny numer telefonu";

      if(empty($drivingLicenseNumber)) $errors[] = "Numer prawa jazdy jest wymagany";

      if(empty($expirationDateOfLicenseNumber)) $errors[] = "Data ważności prawa jazdy jest wymagana";

      $stmt = $pdo->prepare("SELECT 1 From Uzytkownik Where Login = ?");
      $stmt->execute([$login]);
      if($stmt->rowCount() > 0) $errors[] = "Taki login już istnieje";
      
      $stmt = $pdo->prepare("SELECT 1 From Osoba Where PESEL = ?");
      $stmt->execute([$pesel]);
      if($stmt->rowCount() > 0) $errors[] = "Taki PESEL już istnieje";

      $stmt = $pdo->prepare("SELECT 1 From Osoba Where NrPrawaJazdy = ?");
      $stmt->execute([$drivingLicenseNumber]);
      if($stmt->rowCount() > 0) $errors[] = "Taki numer prawa jazdy już istnieje";

      $passwordHash = password_hash($password, PASSWORD_DEFAULT);

      if(empty($errors))
      {
      try{
                  $pdo->beginTransaction();

                  $stmt = $pdo->prepare("INSERT INTO Uzytkownik(Login, Haslo, RolaID) VALUES(?, ?, ?)");
                  $stmt->execute([$login, $passwordHash, $roleId]);

                  $userId = $pdo->lastInsertId();

                  $stmt = $pdo->prepare("INSERT INTO Osoba(Imie, Nazwisko, DataUrodzenia, PESEL, NrTelefonu, Email, Adres, NrPrawaJazdy, DataWaznosciPrawaJazdy, UzytkownikID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                  $stmt->execute([$firstName, $lastName, $dateOfBirth, $pesel, $phoneNumber, $email, $address, $drivingLicenseNumber, $expirationDateOfLicenseNumber, $userId]);

                  $pdo->commit();
                  $success = "Udało się zarejestrować!";
      }
            catch(Exception $e)
            {
                  $pdo->rollBack();
                  $errors[] = "Błąd rejestracji: " . $e->getMessage();
            }
      }
       
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Rejestracja</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../style/style.css">
</head>
<body>
      <?php require_once('../components/header.php'); ?>
      <main class="account-main">
            <form action="" method="POST" autocomplete="off">
                  <h1>Rejestracja</h1>
                  <input type="text" name="login" placeholder="Login" autocomplete="off">
                  <input type="password" name="password" placeholder="Hasło" autocomplete="off">
                  <input type="text" name="firstName" placeholder="Imię">
                  <input type="text" name="lastName" placeholder="Nazwisko">
                  <label class="date-label">Data urodzenia</label>
                  <input type="date" name="dateOfBirth" placeholder="Data Urodzenia">
                  <input type="text" name="pesel" placeholder="PESEL">
                  <input type="text" name="phoneNumber" placeholder="Numer Telefonu">
                  <input type="email" name="email" placeholder="Email">
                  <input type="text" name="address" placeholder="Adres">
                  <input type="text" name="drivingLicenseNumber" placeholder="Numer Prawa Jazdy">
                  <label class="date-label">Data ważności prawa jazdy</label>
                  <input type="date" name="expirationDateOfLicenseNumber" placeholder="Data Ważności Prawa Jazdy">
                  <button type="submit">Zarejestruj Się</button>
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
                  <p class="login-link">
                        Masz konto? <a href="./login.php">Zaloguj się</a>
                  </p>
            </form>
           
      </main>
      <?php require_once('../components/footer.php') ?>
</body>
</html>