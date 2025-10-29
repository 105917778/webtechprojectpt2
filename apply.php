<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'settings.php';


function get_value($field, $data) {
    return isset($data[$field]) ? htmlspecialchars($data[$field]) : '';
}

function display_error($field, $errors) {
    if (isset($errors[$field])) {
        return '<div class="error-message">' . htmlspecialchars($errors[$field]) . '</div>';
    }
    return '';
}

function is_checked($field, $value, $data) {
    if ($field === 'skills') {
        if (isset($data[$field]) && is_array($data[$field])) {
            return in_array($value, $data[$field]) ? 'checked' : '';
        }
    } else {
        if (isset($data[$field]) && $data[$field] === $value) {
            return ($field === 'state') ? 'selected' : 'checked';
        }
    }
    return '';
}

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];

unset($_SESSION['errors']);
unset($_SESSION['form_data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LifeReady - Volunteer Application</title>
  <link href="resources/styles.css" rel="stylesheet">
  <style>
    .error-message {
        color: #ef4444;
        font-size: 0.9em;
        margin-top: 5px;
        font-weight: 500;
    }
    .validation-error-box {
        background-color: #fee;
        border: 1px solid #f00;
        color: #b00;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-weight: bold;
        text-align: center;
    }
    
    header {
      background: #0d2b52;
    }

    body {
      background: #f9fafc; 
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
      line-height: 1.55;
      color: #111;
      margin: 0;
    }

    main {
      padding: 2rem 0;
    }

    .container {
      max-width: 720px;
      margin: 0 auto;
      padding-inline: 16px;
    }

    form {
      width: 100%;
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 12px;
      padding: 1.5rem 16px;
      box-shadow: 0 1px 6px rgba(0, 0, 0, 0.05);
    }

    h1 {
      text-align: center;
      color: #111;
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 1rem;
    }

    .field { display: grid; gap: 0.4rem; }
    .inline { display: grid; grid-template-columns: 1fr; gap: 0.5rem; }

    label { font-weight: 600; }

    input, select, textarea {
      width: 100%;
      max-width: 100%;
      border: 1px solid #cbd5e1;
      border-radius: 8px;
      padding: 0.6rem 0.7rem;
      font: inherit;
      background: #fff;
      box-sizing: border-box;
    }

    fieldset {
      border: 1px solid #e5e7eb;
      border-radius: 10px;
      padding: 0.75rem 1rem;
      min-width: 0;
    }

    legend {
      font-weight: 600;
      padding: 0 0.3rem;
    }

    .checkboxes, .radios {
      display: grid;
      gap: 0.35rem;
      margin-top: 0.25rem;
    }

    .actions {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
      align-items: center;
      justify-content: center;
    }

    button {
      border: 0;
      border-radius: 10px;
      padding: 0.7rem 1.1rem;
      font-weight: 600;
      cursor: pointer;
      background: #004690;
      color: #fff;
    }

    .secondary { background: #e5e7eb; color: #111; }

    form#applicationForm input:invalid,
    form#applicationForm select:invalid,
    form#applicationForm textarea:invalid {
      border-color: #cbd5e1;
      box-shadow: none;
      outline: none;
    }

    form#applicationForm .touched:invalid,
    form#applicationForm.was-validated :invalid {
      border-color: #cbd5e1;
      box-shadow: none;
    }

    @media (min-width: 900px) {
      .form-grid {
        grid-template-columns: 1fr 1fr;
        column-gap: 10px;
      }

      .span-2 {
        grid-column: span 2;
      }

      .inline {
        grid-template-columns: 160px 1fr;
        align-items: start;
      }
    }

    
    .nav a,
    .nav a:visited {
      color: #fff;
      text-decoration: none;
    }

    .nav a:hover,
    .nav a:focus {
      text-decoration: underline;
      color: #a7c7ff;
    }

    .company-name a {
      color: #fff;
      text-decoration: none;
      font-size: 1.6rem;
      font-weight: 800;
      letter-spacing: 0.2px;
    }

    .company-slogan {
      color: #fff;
      font-size: 0.9rem;
      font-weight: 500;
      font-style: normal;
      margin: 0;
      letter-spacing: 0.3px;
    }

  </style>
</head>

<body>
  <?php include 'header.inc'; ?> 
  <!--<header class="header">
    <div class="header-container">
      <div class="company-name"><a href="index.html">LifeReady</a></div>
      <div class="company-slogan">
        <p>Preparing the next generation.</p>
      </div>
      <nav class="nav">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">About Us</a></li>
          <li><a href="jobs.php">Jobs</a></li>
          <li><a href="apply.php" aria-current="page">Apply</a></li>
          <li><a href="mailto:info@lifeready.com">Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>-->

  <main>
    <section class="container">
      <h1>Volunteer Application (EOI)</h1>
      <p style="text-align:center;">All fields will be validated on the server.</p>

        <?php if (!empty($errors)): ?>
        <div class="validation-error-box">
            Please correct the following errors and resubmit the form.
        </div>
        <?php endif; ?>

      <!--<form id="applicationForm" action="process_eoi.php" method="POST" novalidate>-->
      <form action="process_eoi.php" method="post">

        <div class="form-grid">

          <div class="field">
            <label for="ref">Job reference number</label>
            <input type="text" id="ref" name="job_code" placeholder="e.g., WEB01" 
                   value="<?php echo get_value('job_code', $form_data); ?>">
            <?php echo display_error('job_code', $errors); ?>
          </div>

          <div class="field">
            <label for="firstName">First name</label>
            <input type="text" id="firstName" name="first_name" placeholder="Given name"
                   value="<?php echo get_value('first_name', $form_data); ?>">
            <?php echo display_error('first_name', $errors); ?>
          </div>

          <div class="field">
            <label for="lastName">Last name</label>
            <input type="text" id="lastName" name="last_name" placeholder="Family name"
                   value="<?php echo get_value('last_name', $form_data); ?>">
            <?php echo display_error('last_name', $errors); ?>
          </div>

          <div class="field">
            <label for="dob">Date of birth</label>
            <input type="date" id="dob" name="dob" placeholder="dd/mm/yyyy"
                   value="<?php echo get_value('dob', $form_data); ?>">
            <?php echo display_error('dob', $errors); ?>
          </div>

          <fieldset class="span-2">
            <legend>Gender</legend>
            <div class="radios">
              <label><input type="radio" name="gender" value="Male" <?php echo is_checked('gender', 'Male', $form_data); ?>> Male</label>
              <label><input type="radio" name="gender" value="Female" <?php echo is_checked('gender', 'Female', $form_data); ?>> Female</label>
              <label><input type="radio" name="gender" value="Prefer not to say" <?php echo is_checked('gender', 'Prefer not to say', $form_data); ?>> Prefer not to say</label>
            </div>
            <?php echo display_error('gender', $errors); ?>
          </fieldset>

          <div class="field span-2">
            <label for="address">Street address</label>
            <input type="text" id="address" name="street_address" placeholder="123 Example St"
                   value="<?php echo get_value('street_address', $form_data); ?>">
            <?php echo display_error('street_address', $errors); ?>
          </div>

          <div class="field">
            <label for="suburb">Suburb/Town</label>
            <input type="text" id="suburb" name="suburb_town" placeholder="e.g., Footscray"
                   value="<?php echo get_value('suburb_town', $form_data); ?>">
            <?php echo display_error('suburb_town', $errors); ?>
          </div>

          <div class="field">
            <label for="state">State</label>
            <select id="state" name="state">
              <option value="">Choose...</option>
              <option value="VIC" <?php echo is_checked('state', 'VIC', $form_data); ?>>VIC</option>
              <option value="NSW" <?php echo is_checked('state', 'NSW', $form_data); ?>>NSW</option>
              <option value="QLD" <?php echo is_checked('state', 'QLD', $form_data); ?>>QLD</option>
              <option value="NT" <?php echo is_checked('state', 'NT', $form_data); ?>>NT</option>
              <option value="WA" <?php echo is_checked('state', 'WA', $form_data); ?>>WA</option>
              <option value="SA" <?php echo is_checked('state', 'SA', $form_data); ?>>SA</option>
              <option value="TAS" <?php echo is_checked('state', 'TAS', $form_data); ?>>TAS</option>
              <option value="ACT" <?php echo is_checked('state', 'ACT', $form_data); ?>>ACT</option>
            </select>
            <?php echo display_error('state', $errors); ?>
          </div>

          <div class="field">
            <label for="postcode">Postcode</label>
            <input type="text" id="postcode" name="postcode" placeholder="3000"
                   value="<?php echo get_value('postcode', $form_data); ?>">
            <?php echo display_error('postcode', $errors); ?>
          </div>

          <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="you@example.org"
                   value="<?php echo get_value('email', $form_data); ?>">
            <?php echo display_error('email', $errors); ?>
          </div>

          <div class="field">
            <label for="phone">Phone number</label>
            <input type="tel" id="phone" name="phone" placeholder="0412345678"
                   value="<?php echo get_value('phone', $form_data); ?>">
            <?php echo display_error('phone', $errors); ?>
          </div>

          <fieldset class="span-2">
            <legend>Skills (select all that apply)</legend>
            <div class="checkboxes">
              <label><input type="checkbox" name="skills[]" value="Software Development" <?php echo is_checked('skills', 'Software Development', $form_data); ?>> Software Development</label>
              <label><input type="checkbox" name="skills[]" value="UI/UX Design" <?php echo is_checked('skills', 'UI/UX Design', $form_data); ?>> UI/UX Design</label>
              <label><input type="checkbox" name="skills[]" value="Project Management" <?php echo is_checked('skills', 'Project Management', $form_data); ?>> Project Management</label>
              <label><input type="checkbox" name="skills[]" value="IT Support" <?php echo is_checked('skills', 'IT Support', $form_data); ?>> IT Support</label>
              <label><input type="checkbox" name="skills[]" value="Other" <?php echo is_checked('skills', 'Other', $form_data); ?>> Other (please specify below)</label>
            </div>
            <?php echo display_error('skills', $errors); ?>
          </fieldset>

          <div class="field span-2">
            <label for="otherSkills">Other skills</label>
            <textarea id="otherSkills" name="other_skills" rows="3" placeholder="Other skills..."><?php echo get_value('other_skills', $form_data); ?></textarea>
            <?php echo display_error('other_skills', $errors); ?>
          </div>
        </div>

        <div class="actions">
          <button type="submit">Submit Application</button>
          <button type="reset" class="secondary">Reset Form</button>
        </div>
      </form>
    </section>
  </main>

  <?php include 'footer.inc'; ?>
  <!--<footer class="footer">
    <div class="footer-container">
      <div class="footer-links">
        <a href="https://jira.example.com" target="_blank">Jira Repository</a>
        <a href="https://github.com/CarolineCowley/webProjectPt1" target="_blank">GitHub Repository</a>
      </div>
      <div class="footer-contact">
        <a href="mailto:info@lifeready.com">info@lifeready.com</a>
      </div>
      <p>&copy; 2025 LifeReady. All rights reserved.</p>
    </div>
  </footer>-->
</body>
</html>