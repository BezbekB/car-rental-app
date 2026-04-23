<?php
require_once('../../config/auth.php');
requireGuest();
require_once('../../config/db.php');

$errors = [];

if($_SERVER['REQUEST_METHOD'] == "POST")
{
      $login = trim($_POST['login']);
      $password = trim($_POST['password']);

      if(empty($login) || empty($password))
      {
            $errors[] = "Podaj login i hasło";
      }
      

      if(empty($errors))
      {
            $stmt = $pdo->prepare("SELECT * FROM Uzytkownik Where Login = ?");
            $stmt->execute([$login]);
            $user = $stmt->fetch();

            if($user && password_verify($password, $user['Haslo']))
            {
                  $_SESSION['user_id'] = $user['UzytkownikID'];
                  $_SESSION['login'] = $user['Login'];
                  $_SESSION['rola'] = $user['RolaID'];

                  switch($_SESSION['rola'])
                  {
                        case 1:
                              $_SESSION['rola'] = 'klient';
                              header("Location: ../dashboards/klient.php");
                              break;
                        case 2:
                              $_SESSION['rola'] = 'pracownik';
                              header("Location: ../dashboards/pracownik.php");
                              break;
                        case 3:
                              $_SESSION['rola'] = 'admin';
                              header("Location: ../dashboards/admin.php");
                  }
                  
                  exit;
            }
            else
            {
                  $errors[] = "Niepoprawny login lub hasło";
            }
      

            
      }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Logowanie</title>
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
                  <h1>Logowanie</h1>
                  <input type="text" name="login" placeholder="Login">
                  <input type="password" name="password" placeholder="Hasło">
                  <button type="submit">Zaloguj Się</button>
                  <?php if(isset($errors)):?>
                        <ul class="error-list">
                              <?php foreach($errors as $error): ?>
                                    <li><?= $error ?></li>
                              <?php endforeach; ?>
                        </ul>
                  <?php endif; ?>
                  <p class="login-link">
                        Nie masz konta? <a href="./register.php">Zarejestruj się</a>
                  </p>
            </form>
      </main>
      <?php require_once('../components/footer.php') ?>
</body>
</html>