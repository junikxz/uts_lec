<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="information.css">
</head>

<body>

    <section>
        <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="homepage.php">
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
                            <a class="nav-link" href="information.php">Informations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./aboutus/aboutus.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./contact.php">Contact</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="../profile/profile.php" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Profile
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="./registered-events/registered-events.php">Daftar Event</a></li>
                                <li><a class="dropdown-item" href="./profile/profile.php">Edit Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="./logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </section>

    <section class="info-header text-center text-white d-flex align-items-center justify-content-center">
        <div>
            <h1>Information</h1>
        </div>
    </section>

    <div class="container my-5">
        <div class="row text-center">
        <div class="col-md-12 text-center w-75 mx-auto">
    <p class="lead">MenarikNih Events adalah website yang menyediakan kumpulan event yang memudahkan pengguna untuk menemukan acara yang sesuai dengan minat mereka.</p>
</div>


            <div class="menarik">
                <p><span class="kapital">M</span>anajemen</p>
                <p><span class="kapital">E</span>vent</p>
                <p><span class="kapital">N</span>asional</p>
                <p><span class="kapital">A</span>ktif</p>
                <p><span class="kapital">R</span>esponsif</p>
                <p><span class="kapital">I</span>nformasi</p>
                <p><span class="kapital">K</span>olaboratif</p>
                <br>
                <p><span class="kapital">N</span>avigasi</p>
                <p><span class="kapital">I</span>nteraktif</p>
                <p><span class="kapital">H</span>umanis</p>
            </div>
        </div>

        <div class="row how-to-register text-center">
            <div class="col-md-12">
                <h2>Cara Mendaftar Event</h2>
                <div class="card border-primary mt-4 w-50 mx-auto">
                    <div class="card-body">
                        <p>1. Cari event yang diminati melalui fitur pencarian.</p>
                        <p>2. Setelah menemukan event yang diinginkan, klik tombol "Register" untuk mendaftar.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>