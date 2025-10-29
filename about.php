<!-- Github Live Link is here: https://carolinecowley.github.io/webProjectPt1/about.html -->

<?php
//$query = "SELECT * FROM about";
//$result = mysqli_query($conn, $query);
?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
include 'settings.php';
$conn = @mysqli_connect($host, $user, $pass, $db); 

if (!$conn) {
  echo "<p>Database connection failure</p>";
  exit();
}

// Create table if it doesn't exist
$create_table = "CREATE TABLE IF NOT EXISTS about (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    student_id VARCHAR(20) NOT NULL,
    contribution TEXT NOT NULL
)";

if (!mysqli_query($conn, $create_table)) {
    die("Error creating table: " . mysqli_error($conn));
}

// Check if table is empty and insert data
$check_query = "SELECT COUNT(*) as count FROM about";
$check_result = mysqli_query($conn, $check_query);
$row_count = mysqli_fetch_assoc($check_result);

if ($row_count['count'] == 0) {
    $insert_data = "INSERT INTO about (name, student_id, contribution) VALUES 
        ('Caroline Cowley', '106079682', 'Developed the Jobs page.<br>Favourite language: Python - \"Simple and versatile.\"'),
        ('Amnah Saad', '105917778', 'Responsible for the About page.<br>Favourite language: Ruby - \"Not as common but after Swift, it was the first programming language I learnt.\"'),
        ('Khuong Duy Phan', '105559662', 'Built the Apply page.<br>Favourite language: Python - \"Simple and easy to use.\"'),
        ('Duy Kiet Nguyen', '105062270', 'Worked on the Home page.<br>Favourite language: JavaScript - \"Suitable for learning Fullstack.\"')";
    
    if (!mysqli_query($conn, $insert_data)) {
        die("Error inserting data: " . mysqli_error($conn));
    }
}

$query = "SELECT * FROM about";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html> 
<html lang="en">
  <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>About Us (G04) | LifeReady</title>
  <link href="resources/styles.css" rel="stylesheet">
  <style>
    :root {
      --gap: 1rem;
      --max: 900px;
      --primary-color: #0d2b52;
      --primary-color-light: #184a8e;
      --background-color: #fafafa;
      --text-color: #111111;
      --border-color: #e5e7eb;
      --hover-bg: #d6e0f5;
      --hover-link: #0a1f3b;
    }
    body {
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
      line-height: 1.5;
      margin: 0;
      color: var(--text-color);
      background: var(--background-color);
    }
    header, footer {
      background: var(--primary-color);
      color: #ffffff;
      padding: 1rem;
      text-align: center;
    }
    header a, footer a, nav a {
      color: #ffffff;
      text-decoration: none;
      transition: color 0.3s ease;
    }
    header a:focus, header a:hover,
    footer a:focus, footer a:hover,
    nav a:focus, nav a:hover {
      text-decoration: underline;
      color: var(--hover-link);
    }
    main {
      padding: 1.25rem;
      max-width: var(--max);
      margin: 0 auto;
    }
    h1, h2 {
      text-align: center;
      color: var(--primary-color);
    }
    section {
      margin-bottom: 4rem;
    }

    .group-details {
      max-width: 600px;
      margin: 2rem auto;
      text-align: left;
    }

    .group-details ul {
      list-style-position: inside;
      padding-left: 0;     
    }

    .group-details li {
      text-align: left;
    }

    .group-details .nested {
      /*margin-top: 0.5rem; */
      list-style-position: inside;
    }

    /* Definition list styling with student ID on right */
    dl dt {
      font-weight: 700;
      margin-top: 1rem;
      color: var(--primary-color-light);
      display: flex;
      justify-content: space-between;
      align-items: baseline;
    }
    dl dt span.student-id {
      font-weight: 400;
      color: #555555;
      font-size: 0.9rem;
      font-family: monospace, monospace;
    }
    dl dd {
      margin-left: 1rem;
      margin-bottom: 1rem;
    }
    table {
      border-collapse: collapse;
      width: 100%;
      max-width: var(--max);
      margin: 0 auto;
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 8px;
      box-shadow: 0 1px 6px rgba(0,0,0,0.04);
      transition: box-shadow 0.3s ease;
    }
    table:hover {
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    caption {
      font-weight: 700;
      font-size: 1.25rem;
      margin: 0.75rem 0;
      color: var(--primary-color);
    }
    th, td {
      border: 1px solid var(--border-color);
      padding: 0.75rem 1rem;
      text-align: left;
    }
    th {
      background: var(--primary-color-light);
      color: #ffffff;
      font-weight: 700; /* ensure bold */
    }
    tbody tr:nth-child(even) {
      background: #f3f6fb;
    }
    tbody tr:hover {
      background: var(--hover-bg);
      cursor: default;
    }
    figure {
      max-width: 300px;
      margin: 1rem auto;
      text-align: center;
      border: 2px solid var(--primary-color-light);
      border-radius: 8px;
      padding: 0.5rem;
      box-shadow: 0 2px 8px rgba(24, 74, 142, 0.3);
    }
    figure img {
      max-width: 100%;
      height: auto;
      border-radius: 6px;
    }
    figure figcaption {
      font-style: italic;
      color: var(--primary-color-light);
      margin-top: 0.5rem;
    }
    ul.nested {
      list-style-type: disc;
      margin-left: 1.5rem;
    }
  </style>
</head>
<body>
 <!-- <header>
    <a href="index.html"><strong>LifeReady</strong></a>
    <nav aria-label="Primary" style="margin-top: 0.5rem;">
      <a href="index.html">Home</a> ·
      <a href="about.html" aria-current="page">About</a> ·
      <a href="apply.html">Apply</a> ·
      <a href="jobs.html">Jobs</a> ·
      <a href="mailto:info@companyname.com">Contact</a> 
    </nav>
  </header> -->

   <?php include 'header.inc'; ?> 

    <!-- <header>
      <div class="header-container">
        <div class="company-name"><a href="index.php">LifeReady</a></div>
        <div class="company-slogan">
          <p>Preparing the next generation.</p>
        </div>
        <nav class="nav">
          <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="jobs.php">Jobs</a></li>
            <li><a href="apply.php">Apply</a></li>
            <li><a href="mailto:info@lifeready.com">Contact</a></li>
          </ul>
        </nav>
      </div>
    </header> -->

  <main>
    <h1>About Us</h1>

    <!-- Group name and class day/time nested list -->
    <section class="group-details">
      <h2>Group Details</h2>
      <ul>
        <li><strong>Group Name:</strong> G04 LifeReady Developers</li>
        <li><strong>Class Day/Time:</strong>
          <ul class="nested">
            <li>Wednesday 12:30 PM - 2:30 PM</li>
          </ul>
        </li>
      </ul>
    </section>

    <!-- Group photo with figure and border -->
    <section>
      <h2>Our Team</h2>
      <figure>
        <img src="resources/photo_caroline.JPG" 
        alt="Photos of G04 LifeReady Team">
        <figcaption>G04 LifeReady Developers team - Caroline</figcaption>
      </figure>

      <figure>
        <img src="resources/photo_amnah.jpg" 
        alt="Photos of G04 LifeReady Team">
        <figcaption>G04 LifeReady Developers team - Amnah</figcaption>
      </figure>

      <figure>
        <img src="resources/photo_duy.JPG" 
        alt="Photos of G04 LifeReady Team">
        <figcaption>G04 LifeReady Developers team - Duy </figcaption>
      </figure>

      <figure>
        <img src="resources/photo_kai.JPG"  
        alt="Photos of G04 LifeReady Team">
        <figcaption>G04 LifeReady Developers team - Kai </figcaption>
      </figure>

    </section>

    <!-- Contributions with student ID on right -->
    <section>

      <h2>Our Contributions</h2>
      <dl>
          <?php
            while ($row = mysqli_fetch_assoc($result)) {
            echo "<dt>{$row['name']} <span class='student-id'>({$row['student_id']})</span></dt>";
            echo "<dd>{$row['contribution']}</dd>";
            }
          ?>
      </dl>

      <!-- <dl>
          <dt>Caroline Cowley <span class="student-id">(106079682)</span></dt>
        <dd>Developed the Jobs page.<br>
          Favourite language: Python - "Simple and versatile."</dd>

        <dt>Amnah Saad <span class="student-id">(105917778)</span></dt>
        <dd>Responsible for the About page.<br>
          Favourite language: Ruby - "Not as common but after Swift, it was the first programming language I learnt."</dd>

        <dt>Khuong Duy Phan <span class="student-id">(105559662)</span></dt>
        <dd>Built the Apply page.<br>
          Favourite language: Python - "Simple and easy to use."</dd>

        <dt>Duy Kiet Nguyen <span class="student-id">(105062270)</span></dt>
        <dd>Worked on the Home page.<br>
          Favourite language: JavaScript - "Suitable for learning Fullstack."</dd>
      </dl> -->

    </section>

    <!-- Facts Table -->
    <section>
      <h2>Fun Facts</h2>
      <table>
        <caption>Get to know us! </caption>
        <thead>
          <tr>
            <th>Name</th>
            <th>Keyboard shortcut you overuse?</th>
            <th>Favourite Coding Snack</th>
            <th>Pet's name?</th>
            <th>Dark mode or Light mode?</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Caroline</td>
            <td>Ctrl X and Ctrl V</td>
            <td>Carrots</td>
            <td>A cat, Kevin</td>
            <td>Dark mode, all the time</td>
          </tr>
          <tr>
            <td>Amnah</td>
            <td>Ctrl Z</td>
            <td>Green apples</td>
            <td>Don't have one but would want a cat</td>
            <td>Dark mode, usually</td>
          </tr>
          <tr>
            <td>Duy</td>
            <td>Alt+F4</td>
            <td>Fries</td>
            <td>Ben</td>
            <td>Dark mode</td>
          </tr>
          <tr>
            <td>Kai</td>
            <td>Ctrl C</td>
            <td>One-bite snacks</td>
            <td>No pets</td>
            <td>Dark mode always</td>
          </tr>
        </tbody>
      </table>
    </section>
  </main>

  <!--<footer>
    <p>&copy; <span id="year">2025</span> LifeReady • <a href="mailto:info@lifeready.org">info@lifeready.org</a></p>
    <script>
      document.getElementById('year').textContent = new Date().getFullYear();
    </script>
  </footer> -->

  <?php include 'footer.inc'; ?>

   <!-- <footer class="footer">
      <div class="footer-container">
        <div class="footer-links">
        <a href="https://jira.example.com" target="_blank">Jira Repository</a>
        <a href="https://github.com/CarolineCowley/webProjectPt1" target="_blank">
          GitHub Repository
        </a>
      </div>
      <div class="footer-contact">
        <a href="mailto:info@lifeready.com">info@lifeready.com</a>
      </div>
      <p>&copy; 2025 LifeReady. All rights reserved.</p>
    </div>
  </footer> -->

</body>
</html>
