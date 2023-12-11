<?php
  if(!isset($_SESSION)) session_start();
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>  
  <title>Webdev-Project</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
 <main>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark" aria-label="navbar">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">Webdev-Project</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav ms-auto mb-2 mb-md-0">
          <?php if (isset($_SESSION['user_id'])) : ?>
            <li class="nav-item me-2">
              <a class="nav-link" aria-current="page" href="/account">Account</a>
            </li>
          <?php else : ?>
            <li class="nav-item me-2">
              <a class="nav-link" aria-current="page" href="/account/login">Login</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
<div class="container">