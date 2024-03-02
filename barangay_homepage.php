<?php
session_start();

if ($_SESSION['role'] !== 'barangay_official') {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost", "username", "password", "barangay_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $employment_status = $_POST['employment_status'];
        $age = $_POST['age'];
        $income = $_POST['income'];
        $address = $_POST['address'];
        $barangayId = mysqli_real_escape_string($conn, $_POST['barangay_id']); // Sanitize input
        $birthday = $_POST['birthday'];
        $civil_status = $_POST['civil_status'];
        $nationality = $_POST['nationality'];
        $religion = $_POST['religion'];
        $contact_number = $_POST['contact_number'];
        $email = $_POST['email'];

        $sqlInsert = "INSERT INTO residents (name, gender, employment_status, income, age, address, barangay_id, birthday, civil_status, nationality, religion, contact_number, email) VALUES ('$name', '$gender', '$employment_status', '$income', '$age', '$address', '$barangayId', '$birthday', '$civil_status', '$nationality', '$religion', '$contact_number', '$email')";

        if (mysqli_query($conn, $sqlInsert)) {
            echo "Resident information saved successfully.";
            header("Location: barangay_homepage.php");
            exit();
        } else {
            echo "Error: " . $sqlInsert . "<br>" . mysqli_error($conn);
        }
    } elseif (isset($_POST['edit'])) {
        // Display the form fields with the selected resident's information for editing
        $residentId = $_POST['resident_id'];
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $employment_status = $_POST['employment_status'];
        $income = $_POST['income'];
        $age = $_POST['age'];
        $address = $_POST['address'];
        $barangayId = mysqli_real_escape_string($conn, $_POST['barangay_id']); // Sanitize input
        $birthday = $_POST['birthday'];
        $civil_status = $_POST['civil_status'];
        $nationality = $_POST['nationality'];
        $religion = $_POST['religion'];
        $contact_number = $_POST['contact_number'];
        $email = $_POST['email'];
        $editing = true; // Set a flag for editing
    } elseif (isset($_POST['update'])) {
        $residentId = $_POST['resident_id'];
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $employment_status = $_POST['employment_status'];
        $income = $_POST['income'];
        $age = $_POST['age'];
        $address = $_POST['address'];
        $barangayId = mysqli_real_escape_string($conn, $_POST['barangay_id']); // Sanitize input
        $birthday = $_POST['birthday'];
        $civil_status = $_POST['civil_status'];
        $nationality = $_POST['nationality'];
        $religion = $_POST['religion'];
        $contact_number = $_POST['contact_number'];
        $email = $_POST['email'];

        $sqlUpdate = "UPDATE residents SET name='$name', gender='$gender', employment_status='$employment_status', income='$income', age='$age', address='$address', barangay_id='$barangayId', birthday='$birthday', civil_status='$civil_status', nationality='$nationality', religion='$religion', contact_number='$contact_number', email='$email' WHERE id=$residentId";

        if (mysqli_query($conn, $sqlUpdate)) {
            echo "Resident information updated successfully.";

            // Redirect to avoid form resubmission on page refresh
            header("Location: barangay_homepage.php");
            exit();
        } else {
            echo "Error updating resident information: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['delete'])) {
        $residentId = $_POST['resident_id'];

        $sqlDelete = "DELETE FROM residents WHERE id=$residentId";

        if (mysqli_query($conn, $sqlDelete)) {
            echo "Resident information deleted successfully.";

            // Redirect to avoid form resubmission on page refresh
            header("Location: barangay_homepage.php");
            exit();
        } else {
            echo "Error deleting resident information: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['cancel'])) {
        // Reset form fields
        unset($residentId, $name, $gender, $employment_status, $income, $age, $address, $barangayId, $birthday, $civil_status, $nationality, $religion, $contact_number, $email, $editing);
    }
}

// Fetch resident information from the database
$sqlResidents = "SELECT * FROM residents";
$resultResidents = mysqli_query($conn, $sqlResidents);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"  crossorigin="anonymous"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="print-styles.css" media="print">
         <title>Barangay Homepage</title>
    <style>
          table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f5f5f5;
    }
        
    </style>
 
</head>
<body>
    <h1><?php echo $_SESSION['username']; ?></h1>

    <form action="barangay_homepage.php" method="post">
        
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>" required><br>

        <label>Gender:</label>
        <select name="gender" required>
            <option value="Male" <?php echo (isset($gender) && $gender === 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo (isset($gender) && $gender === 'Female') ? 'selected' : ''; ?>>Female</option>
        </select><br>

        <label>Employment Status:</label>
        <select name="employment_status" required>
            <option value="Employed" <?php echo (isset($employment_status) && $employment_status === 'Employed') ? 'selected' : ''; ?>>Employed</option>
            <option value="Unemployed" <?php echo (isset($employment_status) && $employment_status === 'Unemployed') ? 'selected' : ''; ?>>Unemployed</option>
        </select><br>

        <label>Income:</label>
        <input type="number" name="income" value="<?php echo isset($income) ? $income : ''; ?>" required><br>

        <label>Age:</label>
        <input type="number" name="age" value="<?php echo isset($age) ? $age : ''; ?>" required><br>

        <label>Address:</label>
        <input type="text" name="address" value="<?php echo isset($address) ? $address : ''; ?>" required><br>

        <label>Barangay:</label>
        <input type="text" name="barangay_id" value="<?php echo isset($barangayId) ? $barangayId : ''; ?>" required><br>

        <label>Birthday:</label>
        <input type="date" name="birthday" value="<?php echo isset($birthday) ? $birthday : ''; ?>" required><br>

        <label>Civil Status:</label>
        <select name="civil_status" required>
            <option value="Single" <?php echo (isset($civil_status) && $civil_status === 'Single') ? 'selected' : ''; ?>>Single</option>
            <option value="Married" <?php echo (isset($civil_status) && $civil_status === 'Married') ? 'selected' : ''; ?>>Married</option>
            <option value="Divorced" <?php echo (isset($civil_status) && $civil_status === 'Divorced') ? 'selected' : ''; ?>>Divorced</option>
            <option value="Widowed" <?php echo (isset($civil_status) && $civil_status === 'Widowed') ? 'selected' : ''; ?>>Widowed</option>
        </select><br>

        <label>Nationality:</label>
        <input type="text" name="nationality" value="<?php echo isset($nationality) ? $nationality : ''; ?>" required><br>

        <label>Religion:</label>
        <input type="text" name="religion" value="<?php echo isset($religion) ? $religion : ''; ?>" required><br>

        <label>Contact Number:</label>
        <input type="tel" name="contact_number" value="<?php echo isset($contact_number) ? $contact_number : ''; ?>" required><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required><br>

        <?php if (isset($editing)) : ?>
            <input type="hidden" name="resident_id" value="<?php echo $residentId; ?>">
            <button type="submit" name="update">Update</button>
            <button type="submit" name="delete" onclick="return confirmDelete()">Delete</button>
            <button type="submit" name="cancel" onclick="return confirmCancel()">Cancel</button>
        <?php else : ?>
            <button type="submit" name="create">Create</button>
        <?php endif; ?>
    </form>

    <br>
    
    <button onclick="printTable()">Print Table</button>
<br>

<h2>Resident Information</h2>
<?php
if (mysqli_num_rows($resultResidents) > 0) {
    echo "<table id='resident-table' >"; 
    echo "<tr><th>Resident</th><th>Name</th><th>Gender</th><th>Employment Status</th><th>Income</th><th>Age</th><th>Address</th><th>Barangay</th><th>Birthday</th><th>Civil Status</th><th>Nationality</th><th>Religion</th><th>Contact Number</th><th>Email</th><th>Action</th></tr>";
    $residentNumber = 1;
    while ($row = mysqli_fetch_assoc($resultResidents)) {
             echo "<tr>";
            echo "<td>" . $residentNumber . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['gender'] . "</td>";
            echo "<td>" . $row['employment_status'] . "</td>";
            echo "<td>" . $row['income'] . "</td>";
            echo "<td>" . $row['age'] . "</td>";
            echo "<td>" . $row['address'] . "</td>";
            echo "<td>" . $row['barangay_id'] . "</td>";
            echo "<td>" . $row['birthday'] . "</td>";
            echo "<td>" . $row['civil_status'] . "</td>";
            echo "<td>" . $row['nationality'] . "</td>";
            echo "<td>" . $row['religion'] . "</td>";
            echo "<td>" . $row['contact_number'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>
                    <form action='barangay_homepage.php' method='post' style='display:inline;'>
                        <input type='hidden' name='resident_id' value='" . $row['id'] . "'>
                        <input type='hidden' name='name' value='" . $row['name'] . "'>
                        <input type='hidden' name='gender' value='" . $row['gender'] . "'>
                        <input type='hidden' name='employment_status' value='" . $row['employment_status'] . "'>
                        <input type='hidden' name='income' value='" . $row['income'] . "'>
                        <input type='hidden' name='age' value='" . $row['age'] . "'>
                        <input type='hidden' name='address' value='" . $row['address'] . "'>
                        <input type='hidden' name='barangay_id' value='" . $row['barangay_id'] . "'>
                        <input type='hidden' name='birthday' value='" . $row['birthday'] . "'>
                        <input type='hidden' name='civil_status' value='" . $row['civil_status'] . "'>
                        <input type='hidden' name='nationality' value='" . $row['nationality'] . "'>
                        <input type='hidden' name='religion' value='" . $row['religion'] . "'>
                        <input type='hidden' name='contact_number' value='" . $row['contact_number'] . "'>
                        <input type='hidden' name='email' value='" . $row['email'] . "'>
                        <button type='submit' name='edit'>Edit</button>
                        <button type='submit' name='delete' onclick='return confirmDelete()'>Delete</button>
                    </form>
                  </td>";
            echo "</tr>";
            $residentNumber++; 
        }
        echo "</table>";
    } else {
        echo "No resident information available.";
    }
    ?>

    <br>
    <a href="logout.php">Logout</a>

    <script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this resident?");
    }
   
    function printTable() {
    const tableRows = document.querySelectorAll('#resident-table tbody tr');
    const tableData = [14];

    // Extract data from each row and push it to the tableData array
    tableRows.forEach(row => {
        const rowData = [];
        row.querySelectorAll('td').forEach(cell => {
            rowData.push(cell.innerText);
        });
        tableData.push(rowData);
    });



    printJS({
        printable: 'resident-table',
        type: 'html',
        documentTitle: 'Residents Information',
        showModal: true,
        onPrintDialogClose: function () {
            console.log('Print dialog closed.');
        },
        gridData: tableData,
        style: `
            h2 {
                font-size: 24px; /* Adjust the font size as needed */
                text-align: center;
            }
            table {
                width: 120px;
                border-collapse: collapse;
            }
            th, td {
                border: 2px solid black;
                padding: 5px;
                text-align: center;
            }
        `,
    });
}

    // Display alert after successful update
    <?php if (isset($updateSuccess) && $updateSuccess) : ?>
        alert("Resident information updated successfully!");
    <?php endif; ?>
    


     // Tables nalang, and  barangay number 4- something sa database 


</script>
</body>
</html>
