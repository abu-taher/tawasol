<?php
$title = 'activate account';
require_once 'template/header.php';

if (isset($_SESSION['email'])) {
  $verification_error = '';
  $userEmail = $_SESSION['email'];

  // find the verfication code of the user that i have his email
  $statement = $mysqli->prepare("SELECT activation_token FROM users WHERE email = ? limit 1");
  $statement->bind_param('s', $dbEmail);
  $dbEmail = $userEmail;
  $statement->execute();
  $userExists = $statement->get_result()->fetch_array(MYSQLI_ASSOC);
  $activation_token = $userExists['activation_token'];

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the code that the user inserted
    $userCodeInput = $_POST['activation'];

    // check if the verification code that user inserted is not equal to that one in the database
    if ($userCodeInput === $activation_token) {
      // change the status of the user to verified user
      $updateQuery = $mysqli->query("UPDATE users SET verified = '1' WHERE email = '$userEmail'");
      // redirect him to login page
      echo "<script>location.href = 'login.php'</script>";
    } else {
      $verification_error = 'The verification code is wrong';
    }
  }
?>
  <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
    <div class="form-group">
      <label for="activation">Enter you activation code</label>
      <input type="text" class="form-control" id="activation" name="activation" required>
      <span class="text-danger"><?= $verification_error; ?></span>
    </div>
    <button type="submit" class="btn btn-primary">Verify</button>
  </form>

<?php } else {
  echo '<h1>You dont have a premission to display this page</h1>';
} ?>

<?php require_once 'template/footer.php'; ?>