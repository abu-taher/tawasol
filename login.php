<?php
$title = 'login';
require_once 'template/header.php';

if ($_SESSION['success_message']) {
  echo "<div class='alert alert-success'>" . $_SESSION['success_message'] . "</div>";
}
$_SESSION['success_message'] = '';

if (isset($_SESSION['logged_in'])) {
  echo "<script>location.href = 'index.php'</script>";
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = mysqli_escape_string($mysqli, $_POST['email']);
  $password = mysqli_escape_string($mysqli, $_POST['password']);

  if (empty($email)) { array_push($errors, 'Email is required'); }
  if (empty($password)) { array_push($errors, 'Password is required'); }

  if (!count($errors)) {
    $userExists = $mysqli->query("SELECT id, email, password, verified FROM users WHERE email = '$email' limit 1");

    if (!$userExists->num_rows) {
      array_push($errors, "Your email, {$email} does not exist in our records");
    } else {
      $foundUser = $userExists->fetch_assoc();
      if (password_verify($password, $foundUser['password']) && $foundUser['verified'] == '1') {
        // login
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $foundUser['id'];
        $_SESSION['email'] = $foundUser['email'];
        echo "<script>location.href = 'index.php'</script>";
      } elseif (password_verify($password, $foundUser['password']) && $foundUser['verified'] == '0') {
        $_SESSION['email'] = $foundUser['email'];
        echo "<script>location.href = 'activate.php'</script>";
      }else {
        array_push($errors, "Wrong credentials");
      }
    }

  }

}

?>

<h1>Login</h1>

<?php if (count($errors)) : ?>
<ul class="alert alert-danger">
  <?php foreach ($errors as $error) : ?>
    <li><?= $error; ?></li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>

<form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="email">Your Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
      </div>
    </div>
    <div class="col-md-12">
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
      </div>
    </div>
  </div>

  <button type="submit" class="btn btn-info">Login</button>

</form>

<?php require_once 'template/footer.php'; ?>