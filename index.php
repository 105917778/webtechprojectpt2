<!-- Github Live Link is here: https://carolinecowley.github.io/webProjectPt1/about.html -->
 
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeReady - Find Your Future</title>
<link href="resources/styles.css" rel="stylesheet">    <style>
      @media (max-width: 768px) {
        /* Styles for tablets and smaller devices */

        /* Adjust header and navigation for smaller screens */
        .header-container {
          flex-direction: column;
          text-align: center;
        }

        .nav ul {
          flex-direction: column;
          padding-top: 1rem;
        }

        .nav li {
          margin: 0.5rem 0;
        }

        .company-slogan {
          display: none; /* Hide the slogan on small screens to save space */
        }
        
        /* Adjust the main content sections to stack vertically */
        .company-details,
        .main-content {
          flex-direction: column;
        }

        .company-details img,
        .hero-image img {
          margin-top: 1rem;
          width: 100%;
        }

        .cta-button {
          display: block; /* Make the button full-width */
          text-align: center;
        }
      }

      header {
      background: #0d2b52;
    }

      body {
        background-image: url("./resources/images.jpeg");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
      }
      .main-content {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4rem 2rem;
        background-color: #e9ecef;
        gap: 2rem;
      }

      .hero-content {
        flex: 1;
      }

      .hero-content h2 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
      }

      .hero-content p {
        font-size: 1.2rem;
        margin-bottom: 1.5rem;
      }

      .cta-button {
        display: inline-block;
        padding: 1rem 2rem;
        background-color: #004690;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s;
      }

      .cta-button:hover {
        background-color: #0056b3;
      }

      .hero-image {
        flex: 1;
        text-align: right;
      }

      .hero-image img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
      }

      /* Company Details Section */
      .company-details {
        padding: 4rem 2rem;
        background-color: #fff;
        text-align: center;
      }

      .details-container {
        max-width: 800px;
        margin: 0 auto;
      }

      .company-details h3 {
        font-size: 2rem;
        margin-bottom: 1rem;
        color: #444;
      }

      .company-details img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin-top: 2rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }
    </style>
  </head>

  
  <body>
    
  <?php include 'header.inc'; ?>

   <!-- <header class="header">
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
      <!-- company detail section -->
      <div class="company-details">
        <div class="details-container">
          <div class="company-name"><a href="#">LifeReady</a></div>
          <p>
            A non-profit driven by the power of technology to create positive
            social change. We mobilize a network of skilled volunteers to help
            other non-profits and community groups build their digital capacity.
            From website development to data management, our work empowers
            organizations to expand their reach and impact. Join our community
            of tech volunteers and make a real difference.
          </p>
          <img src="resources/image.png" alt="A photo of the company's office, team, or products.">
        </div>
      </div>
      <!-- main content section -->
      <div class="main-content">
        <div class="hero-content">
          <h2 style="color: #007bff">Join Our Team</h2>
          <!--<p>
            A brief description of your company and what you're looking for.
          </p>-->
          <a href="jobs.php" class="cta-button">See Open Positions</a>
        </div>
        <!--<div class="hero-image">
          <img src="images/hero-image.jpg" alt="A team of people working together">
        </div>-->
      </div>
    </main>

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
