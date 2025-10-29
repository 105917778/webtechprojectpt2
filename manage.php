<?php
include("header.inc");
include("nav.inc");
include("settings.php"); 
?>

<main>
  <section class="container">
    <h1>Manage EOIs</h1>
    <p>Use this page to view, search, delete, and update EOIs from the database.</p>

    <?php
    if (!$conn) {
      echo "<p style='color:red;'>Database connection failed.</p>";
    } else {
      //  DELETE FUNCTION
      if (isset($_POST['delete'])) {
        $delete_ref = mysqli_real_escape_string($conn, $_POST['delete_ref']);
        $delete_sql = "DELETE FROM eoi WHERE ref='$delete_ref'";
        if (mysqli_query($conn, $delete_sql)) {
          echo "<p style='color:green;'>All EOIs for job reference <strong>$delete_ref</strong> have been deleted.</p>";
        } else {
          echo "<p style='color:red;'>Error deleting EOIs: " . mysqli_error($conn) . "</p>";
        }
      }

      // UPDATE STATUS FUNCTION
      if (isset($_POST['update_status'])) {
        $id = $_POST['eoi_id'];
        $new_status = $_POST['new_status'];
        $update_sql = "UPDATE eoi SET status='$new_status' WHERE EOInumber=$id";
        if (mysqli_query($conn, $update_sql)) {
          echo "<p style='color:green;'>Status updated successfully for EOI #$id.</p>";
        } else {
          echo "<p style='color:red;'>Error updating status: " . mysqli_error($conn) . "</p>";
        }
      }

      //  SEARCH / FILTER FORM
      echo '<form method="get" style="margin-bottom:1rem;">
              <label><strong>Search by Job Reference:</strong></label>
              <input type="text" name="job_ref" placeholder="e.g., A12B3">
              <label><strong>or by Applicant Name:</strong></label>
              <input type="text" name="last_name" placeholder="First or Last Name">
              <label><strong>Sort by:</strong></label>
              <select name="sort">
                <option value="">None</option>
                <option value="first_name">First Name</option>
                <option value="last_name">Last Name</option>
                <option value="stat_us">Status</option>
              </select>
              <button type="submit">Search</button>
              <button type="submit" name="list_all">List All</button>
            </form>';

      //  DELETE FORM
      echo '<form method="post" style="margin-bottom:2rem;">
              <label><strong>Delete EOIs by Job Reference:</strong></label>
              <input type="text" name="delete_ref" required placeholder="e.g., A12B3">
              <button type="submit" name="delete">Delete</button>
            </form>';

      //  SQL QUERY BUILDER
      $sql = "SELECT * FROM eoi WHERE 1";

      if (!empty($_GET['ref'])) {
        $ref = mysqli_real_escape_string($conn, $_GET['ref']);
        $sql .= " AND ref LIKE '%$ref%'";
      }

      if (!empty($_GET['name'])) {
        $name = mysqli_real_escape_string($conn, $_GET['name']);
        $sql .= " AND (firstName LIKE '%$name%' OR lastName LIKE '%$name%')";
      }

      if (!empty($_GET['sort'])) {
        $sort = $_GET['sort'];
        $sql .= " ORDER BY $sort";
      }

      // Default list all if no filters
      if (isset($_GET['list_all']) || (empty($_GET['ref']) && empty($_GET['name']))) {
        $sql = "SELECT * FROM eoi";
        if (!empty($_GET['sort'])) {
          $sort = $_GET['sort'];
          $sql .= " ORDER BY $sort";
        }
      }

      //  EXECUTE QUERY AND DISPLAY RESULTS
      $result = mysqli_query($conn, $sql);

      if ($result && mysqli_num_rows($result) > 0) {
        echo "<table border='1' cellpadding='8' style='border-collapse:collapse; width:100%;'>";
        echo "<tr style='background:#004690; color:white;'>
                <th>EOI #</th>
                <th>Ref</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Update</th>
              </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>
                  <td>{$row['EOInumber']}</td>
                  <td>{$row['ref']}</td>
                  <td>{$row['firstName']}</td>
                  <td>{$row['lastName']}</td>
                  <td>{$row['email']}</td>
                  <td>{$row['status']}</td>
                  <td>
                    <form method='post' style='display:inline;'>
                      <input type='hidden' name='eoi_id' value='{$row['EOInumber']}'>
                      <select name='new_status'>
                        <option value='New'>New</option>
                        <option value='Current'>Current</option>
                        <option value='Final'>Final</option>
                      </select>
                      <button type='submit' name='update_status'>Update</button>
                    </form>
                  </td>
                </tr>";
        }

        echo "</table>";
      } else {
        echo "<p>No EOIs found.</p>";
      }

      mysqli_close($conn);
    }
    ?>
  </section>
</main>

<?php include("footer.inc"); ?>

