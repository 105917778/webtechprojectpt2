<?php
// process_eoi.php
include 'settings.php';  // Connects using $conn from settings.php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: apply.php');
    exit();
}

// --- Collect & sanitize form inputs ---
$job_code      = strtoupper(trim($_POST['job_code'] ?? ''));
$first_name    = trim($_POST['first_name'] ?? '');
$last_name     = trim($_POST['last_name'] ?? '');
$dob           = trim($_POST['dob'] ?? '');
$gender        = trim($_POST['gender'] ?? '');
$street        = trim($_POST['street_address'] ?? '');
$suburb        = trim($_POST['suburb_town'] ?? '');
$state         = trim($_POST['state'] ?? '');
$postcode      = trim($_POST['postcode'] ?? '');
$email         = trim($_POST['email'] ?? '');
$phone         = trim($_POST['phone'] ?? '');
$skills        = isset($_POST['skills']) ? implode(", ", $_POST['skills']) : '';
$other_skills  = trim($_POST['other_skills'] ?? '');

// --- Merge skills and other skills (optional) ---
if (!empty($other_skills)) {
    $skills = $skills ? "$skills, $other_skills" : $other_skills;
}

// --- Validation ---
$errors = [];
if (!preg_match('/^[A-Z]{3}\d{2}$/', $job_code)) $errors[] = "Invalid Job Code.";
if (!preg_match('/^[a-zA-Z]{1,20}$/', $first_name)) $errors[] = "Invalid First Name.";
if (!preg_match('/^[a-zA-Z]{1,20}$/', $last_name)) $errors[] = "Invalid Last Name.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid Email.";
if (!preg_match('/^\d{4}$/', $postcode)) $errors[] = "Postcode must be 4 digits.";
if (!preg_match('/^\d{8,12}$/', $phone)) $errors[] = "Phone number must be 8-12 digits.";

// Validate DOB format (YYYY-MM-DD)
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
    $errors[] = "Invalid Date of Birth format. Use YYYY-MM-DD.";
}

if ($errors) {
    echo "<h3>Submission Error</h3><ul>";
    foreach ($errors as $e) echo "<li>$e</li>";
    echo "</ul><a href='apply.php'>Go Back</a>";
    exit();
}

// --- Insert into database ---
$sql = "INSERT INTO eoi 
(job_ref, first_name, last_name, dob, gender, street, suburb, stat_e, postcode, email, phone, skills, stat_us)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'New')";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die("SQL prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param(
    $stmt,
    "ssssssssisss",
    $job_code,
    $first_name,
    $last_name,
    $dob,
    $gender,
    $street,
    $suburb,
    $state,
    $postcode,
    $email,
    $phone,
    $skills
);

if (!mysqli_stmt_execute($stmt)) {
    die("Database insert failed: " . mysqli_error($conn));
}

$eoi_number = mysqli_insert_id($conn);

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EOI Submission Success</title>
    <link href="resources/styles.css" rel="stylesheet">
</head>
<body>
    <div class="confirmation-box">
        <h2>Application Submitted!</h2>
        <p>Thank you for submitting your Expression of Interest.</p>
        <h3>Your Confirmation Number:</h3>
        <span class="eoi-number"><?php echo htmlspecialchars($eoi_number); ?></span>
        <div class="confirmation-links">
            <a href="jobs.php">Return to Job Listings</a>
            <a href="index.php">Go to Homepage</a>
        </div>
    </div>
</body>
</html>
