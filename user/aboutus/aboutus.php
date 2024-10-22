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
            <a class="nav-link" href="contact.php">Contact</a>
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
              <li><a class="dropdown-item" href="logout.php">Logout</a></li>
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

  <section class="team">
    <div class="card">
      <div class="img-container">
        <img src="agnes.jpg" alt="agnes">
        <div class="overlay">
          <p>Lorem Ipsum </p>
        </div>
      </div>
      <h3>Agnes Devita W</h3>
    </div>

    <div class="card">
      <div class="img-container">
        <img src="agnes.jpg" alt="agnes">
        <div class="overlay">
          <p>Lorem Ipsum </p>
        </div>
      </div>
      <h3>Feli Sabatini</h3>
    </div>

    <div class="card">
      <div class="img-container">
        <img src="team3.jpg" alt="karen">
        <div class="overlay">
          <p>Lorem Ipsum </p>
        </div>
      </div>
      <h3>Karen Yapranata</h3>
    </div>

    <div class="card">
      <div class="img-container">
        <img src="team4.jpg" alt="livia">
        <div class="overlay">
          <p>Lorem Ipsum </p>
        </div>
      </div>
      <h3>Livia Junike</h3>
    </div>
  </section>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>