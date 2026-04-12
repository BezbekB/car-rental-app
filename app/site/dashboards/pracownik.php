<?php
require_once('../../config/auth.php');
requireRole(['pracownik']);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Carenteo | Panel Pracownika</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <link rel="stylesheet" href="../style/style.css">
</head>
<body>
<?php require_once('../components/header.php'); ?>
<main class="admin-customer-main">
    <h1>Panel Pracownika</h1>

    <div class="admin-customer-grid">
        <a href="./common/add_car.php" class="admin-customer-card">
            <h2>Dodawanie Samochodów</h2>
            <p>Zarejestruj nowy samochód w systemie</p>
        </a>
        <a href="./employee/supported_rentals.php" class="admin-customer-card">
            <h2>Obsługiwane Wypożyczenia</h2>
            <p>Zarządzaj wypożyczeniami przypisanymi do twojego konta</p>
        </a>

    </div>
</main>
<?php require_once('../components/footer.php'); ?>
</body>
</html>