<?php
$title = 'Registration';
require_once 'template/header.php';
require 'form.php';

?>

<h1>Registration Form</h1>

<form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
  <div class="row">
    <div class="col">
      <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $firstName; ?>" placeholder="First name" required>
        <span class="text-danger"><?= $firstNameError; ?></span>
      </div>
    </div>
    <div class="col">
      <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $lastName; ?>" placeholder="Last name">
        <span class="text-danger"><?= $lastNameError; ?></span>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <div class="form-group">
        <label for="mobile_number">Mobile Number</label>
        <input type="tel" class="form-control" id="mobile_number" name="mobile_number" value="<?= $mobileNumber; ?>" placeholder="Mobile Number" required>
        <span class="text-danger"><?= $mobileNumberError; ?></span>
      </div>
    </div>
    <div class="col">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= $email; ?>" placeholder="Email" required>
        <span class="text-danger"><?= $emailError; ?></span>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        <span class="text-danger"><?= $passwordError; ?></span>
      </div>
    </div>
    <div class="col">
      <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
        <span class="text-danger"><?= $confirmPasswordError; ?></span>
      </div>
    </div>
  </div>
  <span class="text-danger"><?= $passwordMatchError; ?></span>

  <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-2 pt-0">Require Class:</legend>
      <div class="col-sm-10">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="require_class" id="business" value="business" <?php if (isset($_POST['require_class']) && $_POST['require_class'] === "business") {
                                                                                                              echo 'checked="checked"';
                                                                                                            } ?>>
          <label class="form-check-label" for="business">
            Business
          </label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="require_class" id="economy" value="economy" <?php if (isset($_POST['require_class']) && $_POST['require_class'] === "economy") {
                                                                                                            echo 'checked="checked"';
                                                                                                          } ?>>
          <label class="form-check-label" for="economy">
            Economy
          </label>
        </div>
      </div>
    </div>
    <span class="text-danger"><?= $requireClassError; ?></span>
  </fieldset>

  <section id="business_class_options">
    <div class="row">
      <div class="form-group col-md-4">
        <label for="preferred_meal">Preferred Meal</label>
        <select id="preferred_meal" class="form-control" name="preferred_meal">
          <option value="" selected>Choose...</option>
          <option value="tuna" <?php if (isset($_POST['preferred_meal']) && $_POST['preferred_meal'] === "tuna") {
                                  echo "selected";
                                } ?>>Tuna</option>
          <option value="salamon" <?php if (isset($_POST['preferred_meal']) && $_POST['preferred_meal'] === "salamon") {
                                    echo "selected";
                                  } ?>>Salamon</option>
          <option value="beef" <?php if (isset($_POST['preferred_meal']) && $_POST['preferred_meal'] === "beef") {
                                  echo "selected";
                                } ?>>Beef</option>
          <option value="chicken" <?php if (isset($_POST['preferred_meal']) && $_POST['preferred_meal'] === "chicken") {
                                    echo "selected";
                                  } ?>>Chicken</option>
        </select>
        <span class="text-danger"><?= $preferredMealError; ?></span>
      </div>
    </div>

    <div class="form-group">
      <label for="notes">Notes:</label>
      <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Write your notes here"><?= $notes; ?></textarea>
      <span class="text-danger"><?= $notesError; ?></span>
    </div>
  </section>

  <button type="submit" class="btn btn-info">Register</button>

</form>

<?php require_once 'template/footer.php'; ?>