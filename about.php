<?php
session_start();

if (!isset($_SESSION['user_data'])) {
    header("Location: index.php");
    exit();
}

$user_data = $_SESSION['user_data'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container">
    <h1 class="mt-4 p-5 bg-primary text-white text-center rounded">User Details</h1>

    <table class="table table-striped table-bordered mt-4">
        <tr>
            <th>Name</th>
            <td><?php echo htmlspecialchars($user_data['name']); ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo htmlspecialchars($user_data['email']); ?></td>
        </tr>
        <tr>
            <th>Facebook URL</th>
            <td><a href="<?php echo htmlspecialchars($user_data['facebook']); ?>" target="_blank"><?php echo htmlspecialchars($user_data['facebook']); ?></a></td>
        </tr>
        <tr>
            <th>Phone Number</th>
            <td><?php echo htmlspecialchars($user_data['phone']); ?></td>
        </tr>
        <tr>
            <th>Gender</th>
            <td><?php echo ucfirst(strtolower(htmlspecialchars($user_data['gender']))); ?></td>
        </tr>
        <tr>
            <th>Country</th>
            <td><?php echo htmlspecialchars($user_data['country']); ?></td>
        </tr>
        <tr>
            <th>Skills</th>
            <td>
                <?php
                    if (is_array($user_data['skills'])) {
                        echo htmlspecialchars(implode(", ", $user_data['skills']));
                    } else {
                        echo htmlspecialchars($user_data['skills']); // Display as string
                    }
                ?>
            </td>
        </tr>
        <tr>
            <th>Biography</th>
            <td><?php echo nl2br(htmlspecialchars($user_data['biography'])); ?></td>
        </tr>
    </table>


    <div class="d-flex justify-content-end mt-3">
    <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

</body>
</html>
