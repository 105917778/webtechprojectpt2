
<?php
include 'settings.php';
?>

<?php
session_start();
require_once('settings.php');
if (empty($db)) {
    die("Error: Database name is not set in settings.php");
}

// Connect to database
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset
mysqli_set_charset($conn, "utf8mb4");

// Your query
$sql = 'SELECT title, description, responsibilities, code, salary FROM jobs ORDER BY job_id DESC';
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$jobs = array();
while ($row = mysqli_fetch_assoc($result)) {
    $jobs[] = $row;
}

mysqli_free_result($result);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="resources/styles.css" rel="stylesheet">
        <meta charset="utf-8">
        <meta name="description" content="Lists for the non-profit">
        <meta name="keywords" content="Jobs, software, engineering, ">
        <meta name="author" content="Caroline, Duy, Amnah and Kai">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="resources/styles.css" rel="stylesheet">
        <title>LifeReady Jobs List</title>
        <style>
            
            header {
      background: #0d2b52;
    }
    
            body{
                position: relative
            }
            #jobs-description{
                text-align : center;
                padding: 2.5em;
            } 

            #jobs-container{
                position: relative;
            }

            #jobs-aside{
                position: absolute;
                right: 0;
                width : 25%;
                text-align : center;
                border : 1px solid gray;
                border-radius : 10px;
                padding : .3em;
                margin-right : 5em;
            }

            #jobs-list{
                width : 60%;
                padding : .7em;
            }

            #jobs-application{
                width: 100%;
                background-color: #e9ecef;;
                padding: 1em;
            }


            .salary{
                text-align : right;
                color : #666
            }

            .alphanumeric-code{
                float: left;
                color : #666
            }

            .jobs-individual{
                padding : .7em;
                border-bottom : 2px solid darkgray;
            }

            .cta-button {
                display: inline-block;
                padding: 1rem 2rem;
                background-color: #004690;
                color: #fff;
                text-decoration: none;
                border-radius: 5px;
                transition: background-color 0.3s;
                margin: 1em;
            }

            .cta-button:hover{
                background-color: #0056b3;
            }

            .jobs-description-list{
                color:#666; font-size:1.1em;
            }
        </style>
    </head>
    <body>
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
                        <li><a href="jobs.php">Jobs</a></li> <li><a href="apply.php">Apply</a></li>
                        <li><a href="mailto:info@lifeready.com">Contact</a></li>
                    </ul>
                </nav>
            </div>
        </header> -->

        <section id="jobs-description">
            <h2>We're hiring!</h2>
            <p style="color:#666; font-size:1.1em;">LifeReady is seeking to employ people in a variety of tech-based positions, 
                including front-end web development and database management. Regardless of position, 
                you will be part of a great team of motivated and capable individuals.
                The benefits of joing LifeReady include:
            </p>
            <ul style="list-style-position:inside;">
                <li class="jobs-description-list">Joining a warm and friendly team of like-minded people</li>
                <li class="jobs-description-list">Excellent experience in the world of computer science</li>
                <li class="jobs-description-list">Knowing that you're making a difference in the lives of young people everywhere</li>
            </ul>
        </section>

        <div id="jobs-container">
            <aside id="jobs-aside">
                <h2>Required Experience</h2>
                <p>
                    All of our tech positions require at least a
                    <strong>bachelor's in computer science or equivalent</strong>, and
                    applicants with more experience will always be prefered.
                </p>
            </aside>

            <section id="jobs-list">
                <?php if (empty($jobs)): ?>
                    <p style="padding: 1em;">There are currently no job openings available. Please check back later!</p>
                <?php else: 
                    foreach ($jobs as $job): 
                        $responsibilities_list = explode("\n", $job['responsibilities']);
                ?>
                <div class="jobs-individual">
                    <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                    
                    <p>
                        <?php echo nl2br(htmlspecialchars($job['description'])); ?>
                    </p>
                    
                    <?php if (!empty($job['responsibilities'])): ?>
                    <ol>
                        <?php foreach ($responsibilities_list as $responsibility): ?>
                        <?php if (trim($responsibility) !== ''):  ?>
                        <li><?php echo htmlspecialchars(trim($responsibility)); ?></li>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </ol>
                    <?php endif; ?>

                    <div class="alphanumeric-code">Code: <?php echo htmlspecialchars($job['code']); ?></div>
                    
                    <div class="salary"><?php echo htmlspecialchars($job['salary']); ?></div>
                    
                    <div style="clear: both;"></div> 
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </section>
            </div>
        <div id="jobs-application">
            <h1>Apply now!</h1>
            <a class="cta-button" href="apply.php">Apply Here</a>
        </div>

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