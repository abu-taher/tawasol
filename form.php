<?php

// these functions to prevent any possible injection to database
function filterRequiredString($field)
{
  $field = filter_var(trim($field), FILTER_SANITIZE_STRING);

  if (empty($field)) {
    return false;
  } else {
    return $field;
  }
}

function filterString($field)
{
  $field = filter_var(trim($field), FILTER_SANITIZE_STRING);
  if ($field) {
    return $field;
  } else {
    return false;
  }
}

function filterEmail($field)
{
  $field = filter_var(trim($field), FILTER_SANITIZE_EMAIL);

  if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
    return $field;
  } else {
    return false;
  }
}

// this function uses Regular Expression to verify that the number is a valid mobile number in Saudi Arabia
function validateMobileNumber($field)
{
  if (preg_match("/^(\s*|(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7}))$/", $field)) {
    return $field;
  } else {
    return false;
  }
}

// these variables for improve User Experience (UX) so we will show appropriate error if something went wrong and we will save values of other inputs
$firstNameError = $lastNameError = $mobileNumberError = $emailError = $passwordError = $confirmPasswordError = $passwordMatchError = $requireClassError = $preferredMealError = $notesError = '';
$firstName = $lastName = $mobileNumber = $email = $password = $confirmPassword = $requireClass = $preferredMeal = $notes = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $firstName = filterRequiredString($_POST['first_name']);
  $lastName = filterString($_POST['last_name']);
  $mobileNumber = validateMobileNumber($_POST['mobile_number']);
  $email = filterEmail($_POST['email']);
  $password = filterRequiredString(($_POST['password']));
  $confirmPassword = filterRequiredString(($_POST['confirm_password']));
  $requireClass = filterRequiredString(($_POST['require_class']));
  $preferredMeal = filterString($_POST['preferred_meal']);
  $notes = filterString($_POST['notes']);


  if (!$firstName) {
    $firstNameError = 'Your first name is required';
  }

  if (!$mobileNumber) {
    $mobileNumberError = 'a valid mobile number is required';
  }

  if (!$email) {
    $emailError = 'a valid email is required';
  }

  if (!$password) {
    $passwordError = 'Password is required';
  }

  if (!$confirmPassword) {
    $confirmPasswordError = 'Confirm password is required';
  }

  if (!$requireClass) {
    $requireClassError = 'You have to select a class';
  }

  if ($password != $confirmPassword) {
    $passwordMatchError = "Passwords don't match";
  }

  // if there is not error in the form
  if (!$firstNameError && !$lastNameError && !$mobileNumberError && !$emailError && !$passwordError && !$confirmPasswordError && !$passwordMatchError && !$requireClassError && !$preferredMealError && !$notesError) {
    //  validate if the email is not already registered on out database
    $statement = $mysqli->prepare("SELECT * FROM users WHERE email = ? limit 1");
    $statement->bind_param('s', $dbEmail);
    $dbEmail = $email;
    $statement->execute();
    $userExists = $statement->get_result()->num_rows;
    if ($userExists) {
      $emailError = 'Email already registered';
    }
  }

  // if there is not error in the form
  if (!$firstNameError && !$lastNameError && !$mobileNumberError && !$emailError && !$passwordError && !$confirmPasswordError && !$passwordMatchError && !$requireClassError && !$preferredMealError && !$notesError) {

    // generate random alphanumeric strings from a five set of characters for verification code
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
    $verified_code = substr(str_shuffle($permitted_chars), 0, 5);

    // hashing the user password 
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    // create a new user
    $insertQuery = $mysqli->prepare("INSERT INTO users (f_name, l_name, mobile, email, password, require_class, preferred_meal, notes, activation_token) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insertQuery->bind_param("sssssssss", $dbFirstName, $dbLastName, $dbMobileNumber, $dbEmail, $dbPassword, $dbRequireClass, $dbPrefereedMeal, $dbNotes, $dbVerifiedCode);

    $dbFirstName = $firstName;
    $dbLastName = $lastName;
    $dbMobileNumber = $mobileNumber;
    $dbEmail = $email;
    $dbPassword = $password;
    $dbRequireClass = $requireClass;
    $dbPrefereedMeal = $preferredMeal;
    $dbNotes = $notes;
    $dbVerifiedCode = $verified_code;

    $insertQuery->execute();

    if (mail($email, "verification code", "This is your verification code {$dbVerifiedCode}")) {
      $_SESSION['email'] = $email;
      echo "<script>location.href = 'activate.php'</script>";
    } else {
      echo "error";
    }

  }
}