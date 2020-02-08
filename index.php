<?php
$title = 'Home Page';
require_once 'template/header.php';

if (!isset($_SESSION['logged_in'])) {
  echo "<script>location.href = 'registration.php'</script>";
}

$email = $_SESSION['email'];

$userDetails = $mysqli->query("SELECT * FROM users WHERE email = '$email' limit 1");
$foundUser = $userDetails->fetch_assoc();

echo '<pre>';
var_dump($foundUser);
echo '</pre>';

?>

<table class="table table-hover">
  <tbody>
    <tr>
      <th scope="row">First Name</th>
      <td><?= $foundUser['f_name'] ?></td>
    </tr>
    <?php if ($foundUser['l_name']) : ?>
    <tr>
      <th scope="row">Last Name</th>
      <td><?= $foundUser['l_name'] ?></td>
    </tr>
    <?php endif; ?>
    <tr>
      <th scope="row">Mobile Number</th>
      <td><?= $foundUser['mobile'] ?></td>
    </tr>
    <tr>
      <th scope="row">Email</th>
      <td><?= $foundUser['email'] ?></td>
    </tr>
    <tr>
      <th scope="row">Required Class</th>
      <td><?= $foundUser['require_class'] ?></td>
    </tr>
    <?php if ($foundUser['preferred_meal']) : ?>
    <tr>
      <th scope="row">Preferred Meal</th>
      <td><?= $foundUser['preferred_meal'] ?></td>
    </tr>
    <?php endif; ?>
    <?php if ($foundUser['notes']) : ?>
    <tr>
      <th scope="row">Notes</th>
      <td><?= $foundUser['notes'] ?></td>
    </tr>
    <?php endif; ?>
  </tbody>
</table>

<?php require_once 'template/footer.php'; ?>