<?php
session_start();

// Logout logic
if(isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>University Bus Ticket System</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .navbar {
            background-color: #5bc0de; /* Light blue color */
            padding: 20px 0;
        }

        .navbar .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            color: #fff;
            font-size: 24px;
            font-weight: bold;
        }

        .nav-menu {
            list-style: none;
            display: flex;
        }

        .nav-menu li {
            margin-right: 20px;
        }

        .nav-menu li a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            transition: color 0.3s;
        }

        .nav-menu li a:hover {
            color: #ffcc00;
        }

        .menu-toggle {
            display: none;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
        }

        .hero {
            background-color: #f5f5f5;
            padding: 100px 0;
            text-align: center;
        }

        .hero-title {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .hero-description {
            font-size: 18px;
            color: #555;
        }

        @media screen and (max-width: 768px) {
            .nav-menu {
                display: none;
            }

            .menu-toggle {
                display: block;
            }

            .menu-toggle:hover {
                color: #ffcc00;
            }

            .nav-menu.active {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 70px;
                left: 0;
                width: 100%;
                background-color: #5bc0de; /* Light blue color */
                z-index: 1000;
            }

            .nav-menu.active li {
                margin: 10px 0;
            }

            .nav-menu.active li a {
                font-size: 16px;
            }
        }

        /* Style for the image container */
        .image-container {
            width: 100%;
            overflow: hidden; /* Hide overflow */
            white-space: nowrap; /* Prevent line breaks */
            position: relative; /* Needed for absolute positioning of images */
        }

        /* Style for individual images */
        .image-container img {
            width: 300x; /* Set fixed width for images */
            height: 200px; /* Set fixed height for images */
            display: inline-block; /* Display images inline */
            margin-right: 10px; /* Add some space between images */
        }

        /* Style for the paragraph */
        p {
            margin-top: 20px; /* Add some space between images and text */
            text-align: justify; /* Justify text */
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }

        /* Developer section styles */
        .developer-section {
            background-color: #f9f9f9;
            padding: 50px 0;
            text-align: center;
        }

        .developer-section h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .developer-list {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .developer {
            width: calc(50% - 20px);
            margin: 10px;
            padding: 20px;
            text-align: left;
        }

        .developer img {
            width: 200px;
            height: 200px;
            /* border-radius: 50%; */
            margin-right: 20px;
        }

        .developer h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .developer p {
            font-size: 16px;
            color: #666;
        }
        .developer-info a {
            display: inline-block;
            margin-right: 10px;
            color: #5bc0de;
            font-size: 24px; /* Adjust the font size as needed */
        }
        /* Footer styles */
        /* .footer {
            background-color: #5bc0de;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        .footer-icons {
            margin-bottom: 20px;
        }

        .footer-icons a {
            display: inline-block;
            margin: 0 10px;
            color: #fff;
            font-size: 24px;
            text-decoration: none;
        } */
        .footer {
    background-color: #5bc0de;
    color: #fff;
    padding: 40px 20px;
}

.footer-logo-wrap img {
    max-width: 80px;
    display: block;
    margin-left: auto;
    margin-right: auto; 
    width: 50%;
}

.footer-menu-wrap {
    display: flex;
    justify-content: space-between;
}

.footer-menu-wrap h5 {
    font-size: 18px;
    color: #fff;
}

.footer-menu-wrap ul {
    list-style: none;
}

.footer-menu-wrap ul li {
    margin-bottom: 10px;
}

.footer-menu-wrap ul li a {
    color: #fff;
    text-decoration: none;
}

.social-share {
    margin-bottom: 20px;
}

/* .social-share a {
    display: inline-block;
    margin-right: 10px;
    color: #fff;
    font-size: 24px;
} */
.social-share {
    margin-bottom: 20px;
    display: flex;
    justify-content: center; /* Horizontally center the items */
}

.social-share a {
    display: inline-block;
    margin: 0 5px; /* Adjust margin as needed */
    color: #fff;
    font-size: 24px;
}
.address {
    text-align: center;
}
.footer-copyright {
    background-color: #5bc0de;
    padding: 10px 20px;
    text-align: center;
}

.footer-copyright a {
    color: #fff;
    text-decoration: none;
}

.footer-copyright a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    <header class="navbar">
        <div class="container">
            <div class="logo">University Bus Ticket System</div>
            <div class="menu-toggle">&#9776;</div>
            <ul class="nav-menu">
                <!-- <li><a href="index.php">Home</a></li> -->
                <li><a href="booking_c.php">Book Ticket</a></li>
                <li><a href="view_bookings.php">View Bookings</a></li>
                <?php if(isset($_SESSION['username'])): ?>
                    <li><a href="user_dashboard.php">Dashboard</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="user_reviews.php">user_reviews</a></li>
                    <li><a href="?logout" class="logout-link">Logout</a></li>
                <?php else: ?>
                <li><a href="admin_login.php">Admin</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>

    </header>

    <div class="container">
        <div class="hero">
            <?php if(isset($_SESSION['username'])): ?>
            <h1 class="hero-title">Welcome, <?php echo $_SESSION['username']; ?>!</h1>
            <?php else: ?>
            <h1 class="hero-title">Welcome to University Bus Ticket System</h1>
            <?php endif; ?>
            <!-- <p class="hero-description">Book your bus tickets conveniently online!</p> -->
            <div class="image-container" id="imageContainer">
                <!-- Image gallery -->
                <img src="bus.jpg" alt="Image 1">
                <img src="bus1.jpg" alt="Image 2">
                <img src="busus.jpg" alt="Image 3">
            </div>

            <!-- Description -->
            <p>BRAC University, located in Dhaka, Bangladesh, provides transportation services for its students, faculty, and staff through its BRACU Bus Service. This service is designed to facilitate commuting to and from the university campus, easing transportation challenges for those who rely on public transport. The BRACU Bus Service typically operates on designated routes and schedules, catering to various areas in and around Dhaka to accommodate the university community's needs. It's common for educational institutions, especially those in urban areas, to offer such services to ensure accessibility and convenience for their members. For specific details about routes, schedules, and any associated fees, individuals should consult with the university's transportation department or administration.</p>
        </div>
    </div>

    <section class="developer-section">
        <div class="container">
            <h2>Meet the Developers</h2>
            <div class="developer-list">
                <!-- Developer 1 -->
                <div class="developer">
                    <img src="photo.jpg" alt="Developer 1">
                    <div class="developer-info">
                        <h3>Md. Mostafijur Rahman</h3>
                        <!-- Icons with links -->
                        <a href="mailto:mostafijur.bd76@gmail.com"><i class="fa-solid fa-envelope"></i></a>
                        <a href="https://www.linkedin.com/in/cadmostafijur/" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
                        <a href="https://www.facebook.com/cadmostafijur" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                        <a href="https://github.com/cadmostafijur" target="_blank"><i class="fa-brands fa-github"></i></a>
                    </div>
                </div>
                <div class="developer">
                    <img src="bondhon.jpg" alt="Developer 1">
                    <div class="developer-info">
                        <h3>Samiul haque Bondhon</h3>
                        <!-- Icons with links -->
                        <a href="mailto:bondhon0101@gmail.com"><i class="fa-solid fa-envelope"></i></a>
                        <a href="https://www.facebook.com/samiul1haque2bondhon?mibextid=ZbWKwL" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                        <a href="https://github.com/Bondhon1" target="_blank"><i class="fa-brands fa-github"></i></a>
                    </div>
                </div>
                <!-- Developer 2 -->
                <div class="developer">
                <img src="sadman.jpg" alt="Developer 2">
                    <div class="developer-info">
                        <h3>Md. Sadman Hasin Khan Jahen</h3>
                        <!-- Icons with links -->
                        <a href="sadmanjahen90@gmail.com"><i class="fa-solid fa-envelope"></i></a>
                        <a href="https://www.facebook.com/sadman.jahen" target="_blank"><i class="fa-brands fa-facebook"></i>
                    
                    </div>
                </div>
                <!-- Add more developers as needed -->
                <div class="developer">
                <img src="Tahsen.jpg" alt="Developer 2">
                <div class="developer-info">
                        <h3>Tahseen Tanha</h3>
                        <!-- Icons with links -->
                        <a href="mailto: ttaaudit17@gmail.com"><i class="fa-solid fa-envelope"></i></a>
                        
                        <a href="https://www.facebook.com/profile.php?id=100004882068178&mibextid=ZbWKwL" target="_blank"><i class="fa-brands fa-facebook"></i>
                    </div>
                </div>
                <div class="developer">
                <img src="provat.png" alt="Developer 2">
                <div class="developer-info">
                        <h3>Provat Saha</h3>
                        <!-- Icons with links -->
                        <a href="mailto:provat.saha@g.bracu.ac.bd"><i class="fa-solid fa-envelope"></i></a>
                        <a href="https://www.facebook.com/ProvatSahaa/" target="_blank"><i class="fa-brands fa-facebook"></i></a> 
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- <footer class="footer">
        <div class="container">
            <div class="footer-icons">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-instagram"></i></a>
                <a href="#"><i class="fa fa-linkedin"></i></a>
            </div>
            <div class="footer-links">
                <a href="#">Privacy Policy</a> |
                <a href="#">Terms of Service</a> |
                <a href="#">Contact Us</a>
            </div>
        </div>
    </footer> -->
    <footer class="footer">
    <div class="footer-top bg-cover">
        <div class="footer-logo-wrap pad-tb">
            <a href="/"><img src="braculogo.png" alt="bracu_logo"></a>
        </div>
        <div class="row footer-menu-wrap pad-tb">

        </div>
        <div class="row text-center pad-tb">
            <div class="small-12 columns">
                <div class="social-share">
                    <a target="_blank" href="https://www.facebook.com/BRACUniversity"><i class="fa-solid fa-envelope"></i></a>
                    <a target="_blank" href="https://twitter.com/BRACUniversity"><i class="fa-brands fa-twitter"></i></a>
                    <a target="_blank" href="https://www.youtube.com/bracuniversity"><i class="fa-brands fa-youtube"></i></a>
                    <a target="_blank" href="https://www.linkedin.com/school/58028/"><i class="fa-brands fa-linkedin"></i></a>
                    <a target="_blank" href="https://instagram.com/BRACUniversity"><i class="fa-brands fa-instagram"></i></a>
                </div>
                <div class="color-oil avenir-heavey address">Brac University | Kha 224 Bir Uttam Rafiqul Islam Avenue, Merul Badda, Dhaka | Tel: +88 09638464646</div>
            </div>
        </div>
    </div>
    <div class="footer-copyright strip-bg-oil color-white text-center">
        <div class="row">
            <div class="columns small-12"> &copy; 2024 Brac University. All rights reserved. | <a href="https://github.com/cadmostafijur">Develop[ed By cadmostafijur </a></div>
        </div>
    </div>
</footer>


    <script>
        const menuToggle = document.querySelector('.menu-toggle');
        const navMenu = document.querySelector('.nav-menu');

        menuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
        });
    </script>
</body>
</html>
