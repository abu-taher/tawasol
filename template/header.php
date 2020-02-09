<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/app.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="./template/style.css">
  <title><?= $config['app_name'] . ' | ' . $title; ?></title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?= $config['app_url']; ?>"><?= $config['app_name'] ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <?php if (!isset($_SESSION['logged_in'])) : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= $config['app_url']; ?>registration.php">Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= $config['app_url']; ?>login.php">Login</a>
          </li>
        <?php else : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= $config['app_url']; ?>logout.php">Logout</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>
  <div class="container mt-5">