<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="contact.css">
</head>

<body>

    <div class="container contact-container">
        <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="homepage/homepage.php">
                    <img src="./asset/Logo.png" alt="Logo" height="50">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="./homepage/homepage.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./information.php">Informations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./aboutus/aboutus.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="./profile/profile.php" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Profile
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="./registered-events/registered-events.php">Daftar Event</a></li>
                                <li><a class="dropdown-item" href="./profile/profile.php">Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="header-title text-center text-white">
            <h1>Contact Us</h1>
            <p>Have a problem or want to post your event here? Let me know.</p>
        </div>
        
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="contact-card">
                    <img src="https://img.icons8.com/?size=100&id=7wYUnaFDlYka&format=png&color=40C057" alt="WhatApps">
                    <h5>Chat Us</h5>
                    <p>Phone: +62 81212343797</p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="contact-card">
                    <img src="https://img.icons8.com/color/96/000000/gmail--v1.png" alt="Gmail Icon">
                    <h5>Email Us</h5>
                    <p>Email: menarik.nih.events@gmail.com</p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="contact-card">
                    <img src="https://img.icons8.com/color/96/000000/instagram-new--v1.png" alt="Instagram Icon">
                    <h5>Follow Us</h5>
                    <p>Instagram: @menarik.nih.events</p>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>