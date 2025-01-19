<?php
include("database.php");

$appointmentSuccess = false;
$newsletterSuccess = false;

if (isset($_POST["submit"])) {
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $country_code = filter_input(INPUT_POST, "country_code", FILTER_SANITIZE_SPECIAL_CHARS);
    $mobile = filter_input(INPUT_POST, "mobile", FILTER_SANITIZE_NUMBER_INT);
    $appointment_date = filter_input(INPUT_POST, "appointment_date", FILTER_SANITIZE_STRING);
    $time_slot = filter_input(INPUT_POST, "time_slot", FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, "message", FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($name) || empty($email) || empty($mobile) || empty($appointment_date) || empty($time_slot) || empty($message)) {
        echo "Please fill in all required fields!";
    } else {
        $sql = "INSERT INTO appointments (name, email, country_code, mobile, appointment_date, time_slot, message) 
                VALUES ('$name', '$email', '$country_code', '$mobile', '$appointment_date', '$time_slot', '$message')";

        if (mysqli_query($conn, $sql)) {
            $appointmentSuccess = true;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

if (isset($_POST['newsletter_submit'])) {
    $email = filter_input(INPUT_POST, 'newsletter_email', FILTER_SANITIZE_EMAIL);

    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = "INSERT INTO newsletter_subscriptions (email) VALUES ('$email')";

        if (mysqli_query($conn, $sql)) {
            $newsletterSuccess = true;
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Please enter a valid email address.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindEase - Book an Appointment</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <style>
        /* General Reset for body, headings, and other elements */
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

        /* Appointment Form Section Styling */
        .appointment-form {
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

        .appointment-form input:focus,
        .appointment-form select:focus,
        .appointment-form textarea:focus {
            border-color: #3498db;
            outline: none;
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

        /* Floating Emergency Button */
        .floating-emergency {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #e74c3c;
            color: white;
            padding: 15px;
            border-radius: 50%;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            transition: background-color 0.3s ease;
        }

        .floating-emergency a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        .floating-emergency:hover {
            background-color: #c0392b;
        }

        /* Mobile Number Container Styles */
        .mobile-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .mobile-container select,
        .mobile-container input {
            width: 100%;
        }

        /* Newsletter Section Styling */
        #newsletter {
            background-color: #f7f9fc;
            padding: 40px 20px;
            margin: 30px 0;
            text-align: center;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }

        #newsletter:hover {
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        #newsletter h2 {
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 15px;
            font-weight: 700;
        }

        #newsletter p {
            font-size: 1rem;
            color: #7f8c8d;
            margin-bottom: 25px;
            font-weight: 500;
        }

        .newsletter-form {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            max-width: 500px;
            margin: 0 auto;
        }

        .newsletter-form input {
            padding: 12px 20px;
            width: 70%;
            border-radius: 30px;
            border: 1px solid #ccc;
            font-size: 1rem;
            transition: all 0.3s ease-in-out;
            outline: none;
            background: #fff;
        }

        .newsletter-form input:focus {
            border-color: #3498db;
            box-shadow: 0 0 10px rgba(52, 152, 219, 0.5);
        }

        .newsletter-form button {
            padding: 12px 20px;
            background: linear-gradient(45deg, #3498db, #2980b9);
            color: white;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s ease, transform 0.2s ease;
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: 600;
        }

        .newsletter-form button:hover {
            background: linear-gradient(45deg, #2980b9, #1c6ea4);
            transform: translateY(-2px);
        }

        .newsletter-form button:active {
            transform: translateY(0);
        }

        .newsletter-form button span::before {
            content: "📩";
            margin-right: 5px;
        }

        /* Responsive Design for Newsletter */
        @media (max-width: 768px) {
            .newsletter-form {
                flex-direction: column;
                gap: 10px;
            }

            .newsletter-form input,
            .newsletter-form button {
                width: 100%;
            }
        }



/* Modal Styles */
.modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1050; /* Ensure it's above the navigation bar */
    left: 50%;
    top: 10px; /* Position it just below the top of the viewport */
    transform: translateX(-50%);
    width: 80%; /* Adjust width as needed */
    max-width: 500px; /* Limit the width */
    background-color: rgba(255, 255, 255, 0.95); /* Add a slight transparency for better UX */
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    padding: 20px;
    transition: opacity 0.3s ease-in-out, top 0.3s ease-in-out;
}

.modal-content {
    text-align: center;
    color: #333;
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 1.5rem;
    color: #aaa;
    cursor: pointer;
}

.close-btn:hover {
    color: #333;
}


.modal-content h2 {
    color: #2ecc71;
    font-size: 2rem;
}

.modal-content p {
    color: #333;
    font-size: 1.2rem;
    margin-bottom: 20px;
}




    </style>
</head>

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

<main>
<!-- Hero Section -->
<section class="hero">
    <div>
        <img src="https://media.istockphoto.com/id/1479494606/vector/mental-health-concept.jpg?s=612x612&w=0&k=20&c=frJSKdP-5fNTvhqHEuSFVB47wxMRH_y866ebJhuUTTU=" alt="Mental Health Support">
    </div>
    <div class="hero-text">
        <h1>Supporting Your Mental Well-Being</h1>
        <p>Your mental health is important. Book an appointment with us today.</p>
    </div>
</section>

<!-- Appointment Form -->
<div class="appointment-form">
    <h2>Book Your Appointment</h2>
    <form method="POST" action="">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <div class="mobile-container">
            <select name="country_code" required>
                <option value="+1">United States (+1)</option>
                <option value="+44">United Kingdom (+44)</option>
                <option value="+91">India (+91)</option>
                <option value="+61">Australia (+61)</option>
                <option value="+81">Japan (+81)</option>
                <option value="+49">Germany (+49)</option>
                <option value="+33">France (+33)</option>
                <option value="+55">Brazil (+55)</option>
            </select>
            <input type="text" name="mobile" placeholder="Mobile Number" required>
        </div>
        <input type="date" name="appointment_date" required>
        <select name="time_slot" required>
            <option value="10:00 AM">10:00 AM</option>
            <option value="11:00 AM">11:00 AM</option>
            <option value="12:00 PM">12:00 PM</option>
            <option value="1:00 PM">1:00 PM</option>
            <option value="2:00 PM">2:00 PM</option>
        </select>
        <textarea name="message" placeholder="Additional Information or Message" rows="4" cols="50"></textarea>
        <button type="submit" name="submit">Book Appointment</button>
    </form>
</div>

<!-- Success Modal -->
<div id="successModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2>Success!</h2>
        <p>Your submission was successful.</p>
    </div>
</div>



<!-- Floating Emergency Button -->
<div class="floating-emergency">
    <a href="tel:+91112">Emergency Help</a>
</div>

<!-- Newsletter Section -->
<div id="newsletter">
    <h2>Subscribe to Our Newsletter</h2>
    <p>Stay updated with our latest news and tips on mental wellness</p>
    <form method="POST" action="">
        <div class="newsletter-form">
            <input type="email" name="newsletter_email" placeholder="Your Email Address" required>
            <button type="submit" name="newsletter_submit">
                <span></span>Subscribe
            </button>
        </div>
    </form>
</div>
</main>


<footer>
    <div class="contact-info">
        <h3>Contact Us</h3>
        <p><strong>Email:</strong> support@mindease.com</p>
        <p><strong>India:</strong> +91 9876543210</p>
        <p><strong>USA:</strong> +1 (800) 123-4567</p>
        <p><strong>UK:</strong> +44 7911 123456</p>
        <p><strong>Singapore:</strong> +65 1234 5678</p>
        <p><strong>Address:</strong> 123 Wellness Ave, Suite 456, New York, NY, 10001, USA</p>
    </div>
    <p>MindEase - Your mental health matters.</p>
</footer>

<script>
    // Function to open the modal
  // Function to open the modal and ensure it's above the nav
function openModal() {
    const modal = document.getElementById("successModal");
    modal.style.display = "block";
    modal.style.top = "10px"; // Just below the top of the viewport
}

// Function to close the modal
function closeModal() {
    const modal = document.getElementById("successModal");
    modal.style.display = "none";
}



    // Show success popup and refresh the page for Appointment Form
    <?php if ($appointmentSuccess): ?>
    openModal(); // Show the modal
    setTimeout(function() {
        window.location.reload(); // Refresh the page after 2 seconds
    }, 2000);
<?php endif; ?>

<?php if ($newsletterSuccess): ?>
    openModal(); // Show the modal
    setTimeout(function() {
        window.location.reload(); // Refresh the page after 2 seconds
    }, 2000);
<?php endif; ?>

</script>


</body>
</html>