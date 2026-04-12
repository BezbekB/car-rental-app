<?php
require_once('../../config/auth.php');
requireRole(['admin']);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Panel Admina</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../style/style.css">
</head>
<body>
<?php require_once('../components/header.php'); ?>
<main class="admin-customer-main">
    <h1>Panel Admina</h1>

    <div class="admin-customer-grid">
        <a href="./admin/add_employee.php" class="admin-customer-card">
            <h2>Dodawanie Pracowników</h2>
            <p>Zarejestruj nowego pracownika w systemie</p>
        </a>
        <a href="./admin/manage_users.php" class="admin-customer-card">
            <h2>Zarządzanie Użytkownikami</h2>
            <p>Przeglądaj użytkowników i zmieniaj ich</p>
        </a>
        <a href="./common/add_car.php" class="admin-customer-card">
            <h2>Dodawanie Samochodów</h2>
            <p>Zarejestruj nowy samochód w systemie</p>
        </a>
    </div>
</main>
<?php require_once('../components/footer.php'); ?>
</body>
</html>