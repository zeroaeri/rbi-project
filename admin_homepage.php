<?php
session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$database_name = 'barangay_db';
$conn = mysqli_connect("localhost", "username", "password", $database_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the barangays table exists
$sqlCheckTable = "SHOW TABLES LIKE 'barangays'";
$resultCheckTable = mysqli_query($conn, $sqlCheckTable);

if (mysqli_num_rows($resultCheckTable) == 0) {
    die("Error: The 'barangays' table doesn't exist in the database.");
}

// Check if the residents table exists
$sqlCheckResidentTable = "SHOW TABLES LIKE 'residents'";
$resultCheckResidentTable = mysqli_query($conn, $sqlCheckResidentTable);

if (mysqli_num_rows($resultCheckResidentTable) == 0) {
    die("Error: The 'residents' table doesn't exist in the database.");
}

// Get the total population in Manila
$sqlTotalManilaPopulation = "SELECT COUNT(id) as total_population FROM residents";
$resultTotalManilaPopulation = mysqli_query($conn, $sqlTotalManilaPopulation);

// Check if the query was successful
if ($resultTotalManilaPopulation) {
    $rowTotalManilaPopulation = mysqli_fetch_assoc($resultTotalManilaPopulation);
    $totalManilaPopulation = $rowTotalManilaPopulation['total_population'];
} else {
    die("Error fetching total population: " . mysqli_error($conn));
}

// Display the total population in Manila
echo "<h1>Welcome, {$_SESSION['username']}!</h1>";
echo "<h2>Total Population in Manila: {$totalManilaPopulation}</h2>";


// Get the total number of barangays in Manila
$sqlTotalBarangays = "SELECT COUNT(id) as total_barangays FROM barangays";
$resultTotalBarangays = mysqli_query($conn, $sqlTotalBarangays);

// Check if the query was successful
if ($resultTotalBarangays) {
    $rowTotalBarangays = mysqli_fetch_assoc($resultTotalBarangays);
    $totalBarangays = $rowTotalBarangays['total_barangays'];
} else {
    die("Error fetching total barangays: " . mysqli_error($conn));
}

// Display the total number of barangays in Manila
echo "<h2>Total Barangays in Manila: {$totalBarangays}</h2>";


// Get the total number of employed people in Manila
$sqlTotalEmployed = "SELECT COUNT(id) as total_employed FROM residents WHERE employment_status = 'Employed'";
$resultTotalEmployed = mysqli_query($conn, $sqlTotalEmployed);

// Check if the query was successful
if ($resultTotalEmployed) {
    $rowTotalEmployed = mysqli_fetch_assoc($resultTotalEmployed);
    $totalEmployed = $rowTotalEmployed['total_employed'];
} else {
    die("Error fetching total employed people: " . mysqli_error($conn));
}

// Display the total number of employed people in Manila
echo "<h2>Total Employed People in Manila: {$totalEmployed}</h2>";

// Get the total number of males in Manila
$sqlTotalMales = "SELECT COUNT(id) as total_males FROM residents WHERE gender = 'Male'";
$resultTotalMales = mysqli_query($conn, $sqlTotalMales);

// Check if the query was successful
if ($resultTotalMales) {
    $rowTotalMales = mysqli_fetch_assoc($resultTotalMales);
    $totalMales = $rowTotalMales['total_males'];
} else {
    die("Error fetching total males: " . mysqli_error($conn));
}

// Get the total number of females in Manila
$sqlTotalFemales = "SELECT COUNT(id) as total_females FROM residents WHERE gender = 'Female'";
$resultTotalFemales = mysqli_query($conn, $sqlTotalFemales);

// Check if the query was successful
if ($resultTotalFemales) {
    $rowTotalFemales = mysqli_fetch_assoc($resultTotalFemales);
    $totalFemales = $rowTotalFemales['total_females'];
} else {
    die("Error fetching total females: " . mysqli_error($conn));
}

// Display the total number of males and females in Manila
echo "<h2>Total number of males in Manila: {$totalMales}</h2>";
echo "<h2>Total number of females in Manila: {$totalFemales}</h2>";

// Get the total number of seniors in Manila
$sqlTotalSeniors = "SELECT COUNT(id) as total_seniors FROM residents WHERE age >= 60";
$resultTotalSeniors = mysqli_query($conn, $sqlTotalSeniors);

// Check if the query was successful
if ($resultTotalSeniors) {
    $rowTotalSeniors = mysqli_fetch_assoc($resultTotalSeniors);
    $totalSeniors = $rowTotalSeniors['total_seniors'];
} else {
    die("Error fetching total seniors: " . mysqli_error($conn));
}

// Display the total number of seniors in Manila
echo "<h2>Total Seniors in Manila: {$totalSeniors}</h2>";

// Display the search bar for barangays
echo "<form method='post' action='' onsubmit='return validateForm()'>";
echo "<label for='barangayInput'>Enter Barangay:</label>";
echo "<input type='text' name='barangayInput' id='barangayInput'>";
echo "<input type='submit' name='showResidents' value='Show Residents'>";
echo "</form>";

// Check if the showResidents button is clicked
if (isset($_POST['showResidents'])) {
    $enteredBarangay = mysqli_real_escape_string($conn, $_POST['barangayInput']);
    $sqlResidents = "SELECT * FROM residents WHERE barangay_id IN (SELECT id FROM barangays WHERE barangay_name LIKE '%$enteredBarangay%')";
}

// JavaScript for form validation
echo "<script>
    function validateForm() {
        var barangayInput = document.getElementById('barangayInput').value;
        if (barangayInput.trim() === '') {
            alert('Please enter a Barangay.');
            return false;
        }
        return true;
    }
</script>";

if (isset($sqlResidents)) {
    $resultResidents = mysqli_query($conn, $sqlResidents);

    // Display the residents table
    echo "<h2>Resident Information</h2>";
    echo "<table id='residentTable' class='display'>";
    $residentNumber = 1; // Initialize resident number
    echo "<thead><tr><th>Resident</th><th>ID</th><th>Name</th><th>Gender</th><th>Employment Status</th><th>Income</th><th>Age</th><th>Address</th><th>Birthday</th><th>Civil Status</th><th>Nationality</th><th>Religion</th><th>Contact Number</th><th>Email</th></tr></thead>";
    echo "<tbody>";
    while ($row = mysqli_fetch_assoc($resultResidents)) {
        echo "<tr>";
        echo "<td>{$residentNumber}</td>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['gender']}</td>";
        echo "<td>{$row['employment_status']}</td>";
        echo "<td>{$row['income']}</td>";
        echo "<td>{$row['age']}</td>";
        echo "<td>{$row['address']}</td>";
        echo "<td>{$row['birthday']}</td>";
        echo "<td>{$row['civil_status']}</td>";
        echo "<td>{$row['nationality']}</td>";
        echo "<td>{$row['religion']}</td>";
        echo "<td>{$row['contact_number']}</td>";
        echo "<td>{$row['email']}</td>";
        echo "</tr>";
        $residentNumber++;
    }
    echo "</tbody>";
    echo "</table>";

    // Display the Barangay Dashboard
    echo "<h2>Barangay Dashboard</h2>";

    if (isset($_POST['showResidents']) || isset($_POST['searchResidents'])) {
        $selectedBarangayId = isset($_POST['showResidents']) ? $_POST['barangayInput'] : null;

        if ($selectedBarangayId !== null) {
            // Employment Status Counts
            $sqlEmploymentStatus = "SELECT employment_status, COUNT(id) as count FROM residents WHERE barangay_id = $selectedBarangayId GROUP BY employment_status";
            $resultEmploymentStatus = mysqli_query($conn, $sqlEmploymentStatus);

            if (!$resultEmploymentStatus) {
                die("Error in Employment Status query: " . mysqli_error($conn));
            }

            echo "<h4>Employment Status</h4>";
            echo "<ul>";
            while ($rowEmploymentStatus = mysqli_fetch_assoc($resultEmploymentStatus)) {
                echo "<li>{$rowEmploymentStatus['employment_status']}: {$rowEmploymentStatus['count']}</li>";
            }
            echo "</ul>";

            // Age Group Counts
            $sqlAgeGroups = "SELECT 
                                SUM(CASE WHEN age < 18 THEN 1 ELSE 0 END) AS kids,
                                SUM(CASE WHEN age BETWEEN 18 AND 29 THEN 1 ELSE 0 END) AS teens,
                                SUM(CASE WHEN age BETWEEN 30 AND 59 THEN 1 ELSE 0 END) AS adults,
                                SUM(CASE WHEN age >= 60 THEN 1 ELSE 0 END) AS seniors
                            FROM residents WHERE barangay_id = $selectedBarangayId";
            $resultAgeGroups = mysqli_query($conn, $sqlAgeGroups);

            if (!$resultAgeGroups) {
                die("Error in Age Groups query: " . mysqli_error($conn));
            }

            echo "<h4>Age Groups</h4>";
            echo "<ul>";
            $rowAgeGroups = mysqli_fetch_assoc($resultAgeGroups);
            echo "<li>Kids (below 18): {$rowAgeGroups['kids']}</li>";
            echo "<li>Teens (18 - 29): {$rowAgeGroups['teens']}</li>";
            echo "<li>Adults (30 - 59): {$rowAgeGroups['adults']}</li>";
            echo "<li>Seniors (60 and above): {$rowAgeGroups['seniors']}</li>";
            echo "</ul>";

            // Gender Distribution
            $sqlGenderDistribution = "SELECT gender, COUNT(id) as count FROM residents WHERE barangay_id = $selectedBarangayId GROUP BY gender";
            $resultGenderDistribution = mysqli_query($conn, $sqlGenderDistribution);

            if (!$resultGenderDistribution) {
                die("Error in Gender Distribution query: " . mysqli_error($conn));
            }

            echo "<h4>Gender Distribution</h4>";
            echo "<ul>";
            while ($rowGenderDistribution = mysqli_fetch_assoc($resultGenderDistribution)) {
                echo "<li>{$rowGenderDistribution['gender']}: {$rowGenderDistribution['count']}</li>";
            }
            echo "</ul>";

            // Total Population
            $sqlTotalPopulation = "SELECT COUNT(id) as total_population FROM residents WHERE barangay_id = $selectedBarangayId";
            $resultTotalPopulation = mysqli_query($conn, $sqlTotalPopulation);
            $rowTotalPopulation = mysqli_fetch_assoc($resultTotalPopulation);

            if (!$resultTotalPopulation) {
                die("Error in Total Population query: " . mysqli_error($conn));
            }

            echo "<h4>Total Population</h4>";
            echo "<p>{$rowTotalPopulation['total_population']}</p>";
        }
    } else {
        echo "<p>Please select a barangay or perform a search to view the dashboard.</p>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('#residentTable').DataTable({
                "columnDefs": [
                    { "orderable": false, "targets": [0, 6, 7, 8, 9, 11, 12] } // Indexes of the columns to make non-orderable
                ]
            });
        });
        
    </script>
    <title>Admin Homepage</title>
</head>
<body>
    <a href="logout.php">Logout</a>
</body>
</html>
