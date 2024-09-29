<?php
    session_start();

    $errors = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $facebook = trim($_POST['facebook']);
            $phone = trim($_POST['phone']);
            $gender = $_POST['gender'] ?? '';
            $country = $_POST['country'] ?? '';
            $skills = $_POST['skills'] ?? [];
            $biography = trim($_POST['biography']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            //validate and sanitize
            if (empty($name) || !preg_match("/^[a-zA-Z\s]+$/", $name)) {
                $errors['name'] = "Required, only letters and spaces are allowed.";
            }
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Required, must be a valid email format.";
            }
            if (empty($facebook) || !filter_var($facebook, FILTER_VALIDATE_URL)) {
                $errors['facebook'] = "Required, must be a valid URL format.";
            }
            if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password)) {
                $errors['password'] = "Required, must be at least 8 characters, combination of alphanumeric characters, must have atleast 1 uppercase letter.";
            }
            if ($password !== $confirm_password) {
                $errors['confirm_password'] = "Must match the password.";
            }
            if (empty($phone) || !is_numeric($phone)) {
                $errors['phone'] = "Required, must be a valid number, it is numeric.";
            }
            if (empty($gender)) {
                $errors['gender'] = "Required.";
            }
            if (empty($country)) {
                $errors['country'] = "Required, must be selected from the dropdown.";
            }
            if (empty($skills)) {
                $errors['skills'] = "Required, at least one checkbox must be selected.";
            }
            if (strlen($biography) > 200) {
                $errors['biography'] = "Required, max length of 200 characters.";
            }
            

            //no error => store data
            if (empty($errors)) {
                $_SESSION['user_data'] = [
                    'name' => $name,
                    'email' => $email,
                    'facebook' => $facebook,
                    'phone' => $phone,
                    'gender' => $gender,
                    'country' => $country,
                    'skills' => implode(", ", $skills),
                    'biography' => $biography
                ];
                header("Location: about.php");
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mt-4 p-5 bg-primary text-white text-center rounded">Registration Form</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
                <?php if (isset($errors['name'])): ?>
                    <div class="text-danger"><?php echo $errors['name']; ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                <?php if (isset($errors['email'])): ?>
                    <div class="text-danger"><?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="facebook" class="form-label">Facebook URL</label>
                <input type="text" class="form-control" id="facebook" name="facebook" value="<?php echo isset($facebook) ? htmlspecialchars($facebook) : ''; ?>">
                <?php if (isset($errors['facebook'])): ?>
                    <div class="text-danger"><?php echo $errors['facebook']; ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
                <?php if (isset($errors['password'])): ?>
                    <div class="text-danger"><?php echo $errors['password']; ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                <?php if (isset($errors['confirm_password'])): ?>
                    <div class="text-danger"><?php echo $errors['confirm_password']; ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>">
                <?php if (isset($errors['phone'])): ?>
                    <div class="text-danger"><?php echo $errors['phone']; ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Gender</label><br>
                <input type="radio" name="gender" value="male" <?php echo (isset($gender) && $gender === 'male') ? 'checked' : ''; ?>> Male
                <input type="radio" name="gender" value="female" <?php echo (isset($gender) && $gender === 'female') ? 'checked' : ''; ?>> Female
                <?php if (isset($errors['gender'])): ?>
                    <div class="text-danger"><?php echo $errors['gender']; ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <select class="form-select" id="country" name="country">
                    <option value="">Select your country</option>
                    <option value="Philippines" <?php echo (isset($country) && $country === 'Philippines') ? 'selected' : ''; ?>>Philippines</option>
                    <option value="USA" <?php echo (isset($country) && $country === 'USA') ? 'selected' : ''; ?>>USA</option>
                    <option value="Japan" <?php echo (isset($country) && $country === 'Japan') ? 'selected' : ''; ?>>Japan</option>
                    <option value="South Korea" <?php echo (isset($country) && $country === 'South Korea') ? 'selected' : ''; ?>>South Korea</option>
                </select>
                <?php if (isset($errors['country'])): ?>
                    <div class="text-danger"><?php echo $errors['country']; ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Skills</label><br>
                <input type="checkbox" name="skills[]" value="HTML" <?php echo (isset($skills) && in_array('HTML', $skills)) ? 'checked' : ''; ?>> HTML
                <input type="checkbox" name="skills[]" value="CSS" <?php echo (isset($skills) && in_array('CSS', $skills)) ? 'checked' : ''; ?>> CSS
                <input type="checkbox" name="skills[]" value="JS" <?php echo (isset($skills) && in_array('JS', $skills)) ? 'checked' : ''; ?>> JS
                
                <?php if (isset($errors['skills'])): ?>
                    <div class="text-danger"><?php echo $errors['skills']; ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="biography" class="form-label">Biography</label>
                <textarea class="form-control" id="biography" name="biography" rows="3"><?php echo isset($biography) ? htmlspecialchars($biography) : ''; ?></textarea>
                <?php if (isset($errors['biography'])): ?>
                    <div class="text-danger"><?php echo $errors['biography']; ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>

