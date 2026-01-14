<?php
// File: index.php

// File penyimpanan komentar
$komentar_file = 'komentar.json';

// Ambil komentar yang sudah ada
$komentar_list = [];
if(file_exists($komentar_file)){
    $komentar_list = json_decode(file_get_contents($komentar_file), true);
}

// Proses form komentar jika dikirim
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nama = trim($_POST['nama'] ?? '');
    $ulasan = trim($_POST['ulasan'] ?? '');
    $rating = intval($_POST['rating'] ?? 0);

    if($nama && $ulasan && $rating > 0){
        $komentar_list[] = [
            'nama' => htmlspecialchars($nama),
            'ulasan' => htmlspecialchars($ulasan),
            'rating' => $rating,
            'waktu' => date('Y-m-d H:i:s')
        ];
        // Simpan ke file JSON
        file_put_contents($komentar_file, json_encode($komentar_list, JSON_PRETTY_PRINT));
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SMK Bhakti Nusantara Boja</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    /* (CSS sama seperti versi HTML sebelumnya, bisa dipakai langsung) */
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Roboto',sans-serif; }
    body { background-color:#f2f7ff; color:#1a1a1a; line-height:1.6; }
    header { background-color:#0047ab; color:#fff; padding:20px 0; text-align:center; }
    header img { width:80px; margin-bottom:10px; }
    header h1 { font-size:2em; }
    nav { background-color:#003a8c; display:flex; justify-content:center; padding:10px 0; }
    nav a { color:#fff; text-decoration:none; margin:0 15px; font-weight:bold; transition:0.3s; }
    nav a:hover { color:#ffd700; }
    section { padding:50px 20px; max-width:1200px; margin:auto; }
    .section-title { text-align:center; margin-bottom:40px; font-size:2em; color:#0047ab; }
    .courses, .extracurriculars { display:flex; flex-wrap:wrap; gap:20px; justify-content:center; }
    .course, .activity { background-color:#e0f0ff; padding:20px; border-radius:15px; text-align:center; transition: transform 0.3s; }
    .course:hover { transform:translateY(-10px); box-shadow:0 10px 20px rgba(0,0,0,0.2); }
    .activity:hover { transform:scale(1.05); }
    .course img, .activity img { width:100px; margin-bottom:15px; }
    .school-info { display:flex; flex-wrap:wrap; gap:20px; align-items:center; justify-content:center; }
    .school-info img { width:300px; border-radius:15px; }
    .school-info div { max-width:600px; }
    #pendaftaran { background-color:#0047ab; color:#fff; border-radius:15px; }
    #pendaftaran div { max-width:800px; margin:auto; padding:30px; }
    #pendaftaran ol { padding-left:20px; }
    #pendaftaran li { margin-bottom:15px; font-weight:500; }
    #komentar { padding:50px 20px; }
    .bintang { color:gold; font-size:24px; margin-right:2px; cursor:pointer; }
    .komentar-item { background-color:#cce0ff; padding:10px; border-radius:10px; margin-bottom:10px; }
    footer { background-color:#003a8c; color:#fff; text-align:center; padding:20px 10px; margin-top:50px; }
    @media (max-width:768px){ .school-info { flex-direction:column; } }
  </style>
</head>
<body>

<header>
  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQq__BnGgOWzGNaBK9TRvI1IL3BgTDgDWrR6Q&s" alt="Logo SMK Bhakti Nusantara Boja">
  <h1>SMK Bhakti Nusantara Boja</h1>
</header>

<nav>
  <a href="#jurusan">Jurusan</a>
  <a href="#ekskul">Ekstrakurikuler</a>
  <a href="#profil">Profil Sekolah</a>
  <a href="#pendaftaran">Pendaftaran</a>
  <a href="#komentar">Ulasan</a>
  <a href="#kontak">Kontak</a>
</nav>

<!-- (Bagian Jurusan, Ekstrakurikuler, Profil Sekolah, Pendaftaran sama seperti sebelumnya) -->

<!-- Komentar & Rating -->
<section id="komentar">
  <h2 class="section-title">Ulasan & Komentar</h2>
  <div style="max-width:800px; margin:auto; padding:20px; background-color:#e6f0ff; border-radius:15px;">
    <form method="post">
      <label for="nama">Nama:</label><br>
      <input type="text" id="nama" name="nama" placeholder="Masukkan nama" style="width:100%; padding:8px; margin-bottom:10px;" required><br>

      <label for="ulasan">Komentar / Ulasan:</label><br>
      <textarea id="ulasan" name="ulasan" placeholder="Tulis komentar kamu di sini..." style="width:100%; padding:8px; margin-bottom:10px;" required></textarea><br>

      <label>Rating:</label><br>
      <select name="rating" required style="margin-bottom:10px; padding:5px;">
        <option value="">Pilih rating</option>
        <option value="1">★☆☆☆☆</option>
        <option value="2">★★☆☆☆</option>
        <option value="3">★★★☆☆</option>
        <option value="4">★★★★☆</option>
        <option value="5">★★★★★</option>
      </select><br>

      <button type="submit" style="margin-top:10px; padding:10px 20px; background-color:#0047ab; color:white; border:none; border-radius:5px; cursor:pointer;">Kirim</button>
    </form>

    <h3 style="margin-top:30px;">Komentar Pengunjung:</h3>
    <?php if(!empty($komentar_list)): ?>
      <?php foreach(array_reverse($komentar_list) as $k): ?>
        <div class="komentar-item">
          <strong><?= $k['nama']; ?></strong> - <?= str_repeat('★', $k['rating']); ?><?= str_repeat('☆', 5 - $k['rating']); ?><br>
          <?= $k['ulasan']; ?><br>
          <small><?= $k['waktu']; ?></small>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Belum ada komentar.</p>
    <?php endif; ?>
  </div>
</section>

<footer id="kontak">
  <p>© 2026 SMK Bhakti Nusantara Boja.</p>
  <p>Jl. Kaliwungu km 1, Meteseh, Kecamatan Boja, Kabupaten Kendal, Jawa Tengah, Indonesia</p>
</footer>

</body>
</html>
