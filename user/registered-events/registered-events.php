<?php
session_start();
require '../../config/db.php'; 

// Ambil informasi user berdasarkan session user_id
$user_id = $_SESSION['user_id'];

// Ambil event yang sudah didaftarkan oleh user
$registrations = $pdo->prepare("
    SELECT e.id, e.name, e.date, e.location, e.description
    FROM registrations r
    JOIN event e ON r.event_id = e.id
    WHERE r.user_id = ?
");
$registrations->execute([$user_id]);
$events = $registrations->fetchAll(PDO::FETCH_ASSOC);

// Jika user melakukan cancel event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_event_id'])) {
    $cancel_event_id = $_POST['cancel_event_id'];

    // Hapus registrasi dari database
    $stmt = $pdo->prepare("DELETE FROM registrations WHERE user_id = ? AND event_id = ?");
    $stmt->execute([$user_id, $cancel_event_id]);

    // Redirect untuk mencegah form resubmission
    header("Location: registered-events.php?cancel_success=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h2 class="text-center mb-5">Event yang Sudah Didaftarkan</h2>

        <!-- Tombol Kembali ke Halaman Utama -->
        <div class="text-end mb-4">
            <a href="../homepage/homepage.php" class="btn btn-back">Kembali ke Halaman Utama</a>
        </div>

        <!-- Konten yang dibungkus dalam kotak dengan w-50 -->
        <div class="content-box">
            <!-- Cek jika ada success message setelah cancel -->
            <?php if (isset($_GET['cancel_success']) && $_GET['cancel_success'] == 1): ?>
                <div class="alert alert-success">
                    Pendaftaran event berhasil dibatalkan!
                </div>
            <?php endif; ?>

            <!-- Cek jika ada event yang sudah didaftarkan -->
            <?php if (count($events) > 0): ?>
                <div class="row">
                    <?php foreach ($events as $event): ?>
                        <div class="col-12">
                            <div class="event-card">
                                <h5 class="mb-3"><?= htmlspecialchars($event['name']) ?></h5>
                                <p><strong>Tanggal:</strong> <?= htmlspecialchars($event['date']) ?></p>
                                <p><strong>Lokasi:</strong> <?= htmlspecialchars($event['location']) ?></p>
                                <p><strong>Deskripsi:</strong> <?= htmlspecialchars($event['description']) ?></p>

                                <!-- Form untuk Cancel Event -->
                                <form method="POST" action="registered-events.php" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pendaftaran event ini?');">
                                    <input type="hidden" name="cancel_event_id" value="<?= $event['id'] ?>">
                                    <button type="submit" class="btn btn-danger">Batalkan Pendaftaran</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-center mt-3">Anda belum terdaftar di event manapun.</p>
            <?php endif; ?>
        </div> <!-- End of Content Box -->

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
