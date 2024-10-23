<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="homepage.php">
        <img src="../asset/Logo.png" alt="Logo" height="50">
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a class="nav-link" href="../homepage/homepage.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../information.php">Informations</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="aboutus.php">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../contact.php">Contact</a>
          </li>
        </ul>

        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="../profile/profile.php" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Profile
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="../registered-events/registered-events.php">Daftar Event</a></li>
              <li><a class="dropdown-item" href="../profile/profile.php">Edit Profile</a></li>
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

  <section class="about-us">
    <div class="header-title text-center text-white mt-5">
      <h1>About Us</h1>
    </div>
  </section>

  <div class="container my-5">
        <div class="row text-center">
        <div class="col-md-12 text-center w-75 mx-auto">
    <p class="lead">MenarikNih Events dipersembahkan oleh 4 manusia kalong. </p>

  <div class="container mt-5">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card">
                <img src="./foto/agnes.jpg" alt="Agnes Devita" class="card-img-top">
                <div class="overlay text-white">
                    <h3>Agnes Devita</h3>
                    <p>apa itu umur 20</p>
                    <a href="#">Instagram</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card">
                <img src="./foto/feli.jpg" alt="Felicia Sabatini" class="card-img-top">
                <div class="overlay text-white">
                    <h3>Felicia Sabatini</h3>
                    <p>Profesional Sleeper</p>
                    <a href="#">Instagram</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card">
                <img src="./foto/karen.jpg" alt="Karen Yapranata" class="card-img-top">
                <div class="overlay text-white">
                    <h3>Karen Yapranata</h3>
                    <p>semangattttttt</p>
                    <a href="#">Instagram</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card">
                <img src="./foto/livia.jpg" alt="Livia Junike" class="card-img-top">
                <div class="overlay text-white">
                    <h3>Livia Junike</h3>
                    <p>Tuhan Yesus, kita usahakan nilai A di semua matkul itu</p>
                    <a href="#">Instagram</a>
                </div>
            </div>
        </div>
    </div>
</div>

 

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>