<?php
$dataPath = "../data_people.json";
$people = [];

if (file_exists($dataPath)) {
  $people = json_decode(file_get_contents($dataPath), true);
}
?>

<div class="compact-view mt-5">
  <div class="row g-3">
    <?php foreach ($people as $row): ?>
      <div class="col-6 col-md-4 col-lg-2" data-aos="fade-up">
        <div class="minimal-card text-center">
          <img src="../assets/img/uploaded/<?= htmlspecialchars($row['photo']) ?>"
            alt="<?= htmlspecialchars($row['name']) ?>"
            class="avatar img-fluid" loading="lazy">
          <div class="info">
            <h4 class="mb-0"><?= htmlspecialchars($row['name']) ?></h4>
            <small><?= htmlspecialchars($row['role']) ?></small>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<br><br><br><br><br>
<div class="heading">
    <div class="container">
      <div class="row d-flex justify-content-center text-center">
        <div class="col-lg-8">
          <h1 class="heading-title">Produk</h1>
          <p class="mb-0">
            Kami menyediakan produk second dengan kualitas tinggi, harga rendah, dan kepercayaan penuh
          </p>
        </div>
      </div>
    </div>
  </div>

<section id="doctors" class="doctors section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="doctor-directory mb-5">
      <div class="directory-bar p-3 p-md-4 rounded-3">
        <div class="row g-3 align-items-end">
          <div class="col-lg-4 d-flex flex-column">
            <label for="product-search" class="form-label mb-0">Cari Produk</label>
            <div class="position-relative">
              <i class="bi bi-search search-icon"></i>
              <input id="product-search" type="text" class="form-control search-input" placeholder="Tulis Nama Produk">
            </div>
          </div>

          <div class="col-lg-3 d-flex flex-column">
            <label class="form-label mb-0">Kategori</label>
            <select id="product-category" class="form-select">
              <option value="*">Semua Kategori</option>
            </select>
          </div>

          <div class="col-lg-3 d-flex flex-column">
            <label class="form-label mb-0">Harga</label>
            <select id="product-price" class="form-select">
              <option value="*">Semua Harga</option>
              <option value="asc">Rendah ke Tinggi</option>
              <option value="desc">Tinggi ke Rendah</option>
            </select>
          </div>

          <div class="col-lg-2 d-flex align-items-end">
            <button id="applyFilters" class="btn btn-appointment w-100">Terapkan</button>
          </div>
        </div>
      </div>


      <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
        <ul class="directory-filters isotope-filters" data-aos="fade-up" data-aos-delay="200">
        </ul>
        <div class="row gy-4 isotope-container" id="productContainer" data-aos="fade-up" data-aos-delay="300">
        </div>
      </div>

      <div class="single-profile mt-5">
        <div id="productDetail" class="single-profile mt-5" style="display: none;">
          <div class="row align-items-center g-4">
            <div class="col-lg-5" data-aos="fade-right" data-aos-delay="150">
              <div class="profile-media">
                <img id="detailImage" src="" class="img-fluid" alt="">
              </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left" data-aos-delay="200">
              <div class="profile-content">
                <h3 class="name mb-1" id="detailName"></h3>
                <p class="title mb-3" id="detailCategory"></p>
                <p class="bio mb-3" id="detailHarga"></p>
                <p class="bio mb-3 text-break" id="detailDesc"></p>
                <a href="https://wa.me/6289526486226?text=Halo%2C%20saya%20ingin%20menanyakan%20harga%20dan%20spesifikasi%20produk.%20Apakah%20masih%20tersedia%3F" class="btn btn-appointment w-30">Beli Sekarang</a>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
</main>