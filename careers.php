<?php
// Database connection
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "mindease";  // Ensure the database name is correct
$conn = "";

try {
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    if (!$conn) {
        throw new mysqli_sql_exception('Database connection failed: ' . mysqli_connect_error());
    }
} catch (mysqli_sql_exception $e) {
    echo "Error: " . $e->getMessage();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $country_code = $_POST['country_code'];
    $mobile_number = $_POST['mobile_number'];
    $cover_letter = $_POST['cover_letter'];

    // Handle file uploads
    $resume = $_FILES['resume']['name'];
    $cv = $_FILES['cv']['name'];

    // Save uploaded files
    $resume_path = "uploads/" . $resume;
    $cv_path = "uploads/" . $cv;

    move_uploaded_file($_FILES['resume']['tmp_name'], $resume_path);
    move_uploaded_file($_FILES['cv']['tmp_name'], $cv_path);

    // Insert into database
    $sql = "INSERT INTO jobapplications (name, email, country_code, mobile_number, cover_letter, resume, cv)
            VALUES ('$name', '$email', '$country_code', '$mobile_number', '$cover_letter', '$resume', '$cv')";

    if (mysqli_query($conn, $sql)) {
        $success_message = "Application submitted successfully!";
    } else {
        $error_message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindEase Careers</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body, h1, h2, p, ul, li {
            margin: 0;
            padding: 0;
            font-family: 'Avenir', sans-serif;
        }

        /* Global Styles */
        body {
            background-color: #f4f4f9;
            color: #333;
            line-height: 1.6;
        }

        h1, h2 {
            color: #34495e;
        }

        /* Header Styles */
        header {
            background-color: #2c3e50;
            color: white;
            padding: 30px 0;
            text-align: center;
        }

        header .website-name {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
        }

        header .website-name h1 {
            font-size: 3rem;
            letter-spacing: 2px;
        }

        header .website-name .logo {
            width: 80px;
            height: 80px;
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        nav ul li {
            margin: 0 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-size: 1.1rem;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: #3498db;
        }

        /* Hero Section Styles */
        .hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 40px;
            background-color: #ecf0f1;
            border-radius: 10px;
            margin: 120px 0;
        }

        .hero img {
            width: 45%;
            border-radius: 10px;
        }

        .hero-text {
            max-width: 50%;
        }

        .hero-text h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .hero-text p {
            font-size: 1.2rem;
            color: #7f8c8d;
        }

        .job-listings {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 50px;
        }

        .job-listing {
            background-color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            width: 300px;
            transition: transform 0.3s ease;
        }

        .job-listing:hover {
            transform: translateY(-10px);
        }

        .job-listing h3 {
            color: #2c3e50;
            font-size: 1.6rem;
            margin-bottom: 10px;
        }

        .job-listing p {
            font-size: 1.1rem;
            color: #7f8c8d;
            margin-bottom: 15px;
        }

      
    .apply-btn {
        display: inline-block;
        padding: 12px 25px;
        background: linear-gradient(145deg, #3498db, #2980b9);
        color: white;
        font-size: 1.1rem;
        font-weight: 600;
        text-transform: uppercase;
        border: none;
        border-radius: 50px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: all 0.3s ease;
        letter-spacing: 1px;
    }

    .apply-btn:hover {
        background: linear-gradient(145deg, #2980b9, #3498db);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        transform: translateY(-4px);
    }

    .apply-btn:active {
        transform: translateY(0);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }



        .appointment-form {
            display: none;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            margin: 30px auto;
            width: 100%;
            max-width: 700px;
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        }

        .appointment-form h2 {
            text-align: center;
            color: #34495e;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .appointment-form input,
        .appointment-form select,
        .appointment-form textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
            box-sizing: border-box;
        }

        .appointment-form button {
            width: 100%;
            padding: 14px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1rem;
            transition: background-color 0.3s;
        }

        .appointment-form button:hover {
            background-color: #2980b9;
        }

    </style>
</head>
<body>
<header>
        <div class="website-name">
            <img src="https://t3.ftcdn.net/jpg/03/35/16/66/360_F_335166628_b2M3WgWbbZqxNHsRt6ZxHzk1dtCrWhVx.jpg" alt="Logo" class="logo">
            <h1>MindEase</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="careers.php">Careers</a></li>
            </ul>
        </nav>
    </header>
<br><br><br><br><br><br><br><br><br><br><br><br>
<!-- Job Listings Section -->
<section class="job-listings">
    <!-- Example Job Listing -->
   
    <div class="job-listing">
        <h2>Therapist</h2>
        <p>Location: New York</p>
        <p>We are looking for a compassionate therapist to join our team and provide counseling services to individuals in need of mental health support.</p>
        <button class="apply-btn" onclick="showApplicationForm()">Apply Now</button>
    </div>
    <div class="job-listing">
        <h2>Psychologist</h2>
        <p>Location: London</p>
        <p>Join our growing team to help people understand and manage their mental health. We are seeking a qualified psychologist with experience in individual therapy.</p>
        <button class="apply-btn" onclick="showApplicationForm()">Apply Now</button>
    </div>
    <div class="job-listing">
        <h2>Social Worker</h2>
        <p>Location: California</p>
        <p>We need a dedicated social worker to assist clients in navigating mental health challenges and connecting them with available resources.</p>
        <button class="apply-btn" onclick="showApplicationForm()">Apply Now</button>
    </div>
    <div class="job-listing">
        <h2>Clinical Psychologist</h2>
        <p>Location: Melbourne</p>
        <p>We are looking for a clinical psychologist to diagnose and treat patients experiencing mental health disorders. Experience in CBT is a plus.</p>
        <button class="apply-btn" onclick="showApplicationForm()">Apply Now</button>
    </div>
    <div class="job-listing">
        <h2>Occupational Therapist</h2>
        <p>Location: Toronto</p>
        <p>Help clients with mental health issues improve their ability to perform everyday activities by offering tailored interventions and therapies.</p>
        <button class="apply-btn" onclick="showApplicationForm()">Apply Now</button>
    </div>
    <div class="job-listing">
        <h2>Wellness Coordinator</h2>
        <p>Location: Singapore</p>
        <p>Join our team as a Wellness Coordinator to promote mental well-being by organizing support programs and events for employees and clients.</p>
        <button class="apply-btn" onclick="showApplicationForm()">Apply Now</button>
    </div>


    <!-- Add more job listings here dynamically from the database -->
</section>


<!-- Application Form Modal -->
<div class="appointment-form" id="applicationForm">
    <h2>Application Form</h2>
    <form action="careers.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="country_code" placeholder="Country Code" required>
        <input type="text" name="mobile_number" placeholder="Mobile Number" required>
        <textarea name="cover_letter" placeholder="Cover Letter" required></textarea>
        <b>Upload Resume:</b><input type="file" name="resume" placeholder="Upload Resume" required>
        <b>Upload CV:</b><input type="file" name="cv" placeholder="Upload CV" required>
        <button type="submit">Submit</button>
    </form>
</div>

<script>
    // Function to display the application form modal
    function showApplicationForm() {
        document.getElementById('applicationForm').style.display = 'block';
    }

    // Close the application form modal when clicked outside
    window.onclick = function(event) {
        if (event.target == document.getElementById('applicationForm')) {
            document.getElementById('applicationForm').style.display = 'none';
        }
    }
</script>

</body>
</html>
