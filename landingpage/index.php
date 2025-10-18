<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Home</title>
  <meta name="description" content="" />
  <meta name="keywords" content="" />

  <link href="assets/img/logogmc.png" rel="icon" />
  <link href="assets/img/logogmc.png" rel="apple-touch-icon" />
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
    rel="stylesheet" />

  <link
    href="assets/vendor/bootstrap/css/bootstrap.min.css"
    rel="stylesheet" />
  <link
    href="assets/vendor/bootstrap-icons/bootstrap-icons.css"
    rel="stylesheet" />
  <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
  <link
    href="assets/vendor/glightbox/css/glightbox.min.css"
    rel="stylesheet" />
  <link
    href="assets/vendor/fontawesome-free/css/all.min.css"
    rel="stylesheet" />
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

  <link href="assets/css/main.css" rel="stylesheet" />
  <style>
    .product-card {
      background: #fff;
      border-radius: 0.5rem;
      overflow: hidden;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
    }

    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .product-media img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      display: block;
    }

    .product-content h3.product-name {
      font-size: 1.1rem;
      margin-bottom: 0.25rem;
    }

    .product-content p.product-title {
      color: #6c757d;
      font-size: 0.9rem;
    }

    .product-content p.product-desc {
      font-size: 0.85rem;
      margin-top: 0.25rem;
    }

    .product-actions a {
      margin-right: 5px;
      font-size: 0.8rem;
    }

    .isotope-container {
      position: relative;
    }

    .btn-soft {
      display: inline-block;
      padding: 0.3rem 0.6rem;
      background-color: #f0f0f0;
      border-radius: 4px;
      text-align: center;
      cursor: pointer;
      color: #333;
      text-decoration: none;
    }

    #detailDesc {
      white-space: normal;
      word-wrap: break-word;
      overflow-wrap: anywhere;
    }
  </style>
</head>

<body class="index-page">
  <?php include 'includes/header.php'; ?>

  <main class="main">
    <?php
    if (isset($_GET['page'])) {
      $page = $_GET['page'];
      $file = "pages/$page.php";
      if (file_exists($file)) {
        include $file;
      } else {
        echo "<div class='text-gray-400 italic'>Halaman masih dalam pengembangan...</div>";
      }
    } else {
      include "pages/main.php";
    }
    ?>
  </main>
  <?php include 'includes/footer.php'; ?>
  <a
    href="#"
    id="scroll-top"
    class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>


  <script>
    const API_BASE = "/adminpage/adminpage";
    const productContainer = document.getElementById('productContainer');
    const categorySelect = document.getElementById('product-category');
    const priceSelect = document.getElementById('product-price');
    const searchInput = document.getElementById('product-search');
    const applyBtn = document.getElementById('applyFilters');
    const filterContainer = document.querySelector('.directory-filters');

    let allProducts = [];
    let iso = null;

    async function loadProducts() {
      try {
        const res = await fetch(`${API_BASE}/get_product.php`);
        const data = await res.json();
        allProducts = data;

        populateCategories(data);
        renderFilters(data);
        renderProducts(data);
      } catch (err) {
        console.error("Load products error:", err);
        productContainer.innerHTML = '<p>Failed to load products.</p>';
      }
    }

    function populateCategories(data) {
      const categories = [...new Set(data.map(p => p.kategori).filter(Boolean))];
      categorySelect.innerHTML = '<option value="*">All Categories</option>';
      categories.forEach(cat => {
        const opt = document.createElement('option');
        opt.value = cat;
        opt.textContent = cat;
        categorySelect.appendChild(opt);
      });
    }

    function renderFilters(data) {
      const categories = [...new Set(data.map(p => p.kategori).filter(Boolean))];
      let html = `<li data-filter="*" class="filter-active">All</li>`;
      categories.forEach(cat => {
        const filterClass = '.filter-' + cat.toLowerCase().replace(/\s+/g, '-');
        html += `<li data-filter="${filterClass}">${cat}</li>`;
      });
      filterContainer.innerHTML = html;

      filterContainer.querySelectorAll('li').forEach(li => {
        li.addEventListener('click', () => {
          filterContainer.querySelectorAll('li').forEach(i => i.classList.remove('filter-active'));
          li.classList.add('filter-active');
          const filterValue = li.getAttribute('data-filter');
          if (iso) iso.arrange({
            filter: filterValue
          });
        });
      });
    }

    function renderProducts(data) {
      productContainer.innerHTML = '';
      if (!data.length) {
        productContainer.innerHTML = '<p>No products found.</p>';
        return;
      }

      data.forEach(p => {
        const col = document.createElement('div');
        col.className = `col-lg-3 col-md-6 product-item filter-${p.kategori.toLowerCase().replace(/\s+/g,'-')} mb-4`;
        col.innerHTML = `
      <div class="product-card h-100 shadow-sm rounded overflow-hidden p-2">
        <img src="${p.photo ? `/adminpage/landingpage/assets/img/uploaded/${p.photo}` : 'https://via.placeholder.com/150'}" class="img-fluid rounded mb-2" style="height:180px; object-fit:cover;" />
        <h5 class="mb-1">${p.name}</h5>
        <p class="mb-1 text-muted">${p.kategori ?? ''}</p>
        <p class="mb-2">Rp ${Number(p.harga).toLocaleString()}</p>
        <a href="#" class="btn btn-sm btn-soft mt-auto view-product-btn">View Product</a>
      </div>
    `;
        const btnDetail = col.querySelector('.view-product-btn');
        btnDetail.addEventListener('click', (e) => {
          e.preventDefault();

          document.getElementById('detailImage').src = p.photo ? `/adminpage/landingpage/assets/img/uploaded/${p.photo}` : 'https://via.placeholder.com/150';
          document.getElementById('detailName').textContent = p.name;
          document.getElementById('detailCategory').textContent = p.kategori;
          document.getElementById('detailDesc').textContent = p.deskripsi;
          document.getElementById('detailHarga').textContent = p.harga ? `Rp ${Number(p.harga).toLocaleString()}` : '-';

          document.getElementById('productDetail').style.display = 'block';
          const offset = 80;
          const elementPosition = document.getElementById('productDetail').getBoundingClientRect().top + window.pageYOffset;
          window.scrollTo({
            top: elementPosition - offset,
            behavior: 'smooth'
          });
        });
        productContainer.appendChild(col);
      });

      if (iso) {
        iso.reloadItems();
        iso.arrange();
      } else {
        iso = new Isotope(productContainer, {
          itemSelector: '.product-item',
          layoutMode: 'masonry',
          gutter: 16
        });
      }
    }

    function applyFilters() {
      let filtered = [...allProducts];

      const searchValue = searchInput.value.toLowerCase();
      if (searchValue) filtered = filtered.filter(p => p.name.toLowerCase().includes(searchValue));

      const selectedCategory = categorySelect.value;
      if (selectedCategory !== '*') filtered = filtered.filter(p => p.kategori === selectedCategory);

      const selectedPrice = priceSelect.value;
      if (selectedPrice === 'asc') filtered.sort((a, b) => a.harga - b.harga);
      else if (selectedPrice === 'desc') filtered.sort((a, b) => b.harga - a.harga);

      renderProducts(filtered);
    }

    applyBtn.addEventListener('click', applyFilters);
    document.addEventListener('DOMContentLoaded', loadProducts);



    document.addEventListener('DOMContentLoaded', () => {
      const navLinks = document.querySelectorAll('#navmenu a');

      const currentUrl = window.location.href;

      navLinks.forEach(link => {
        link.classList.remove('active');

        if (currentUrl.includes(link.getAttribute('href'))) {
          link.classList.add('active');
        }

        if (link.closest('ul ul') && link.classList.contains('active')) {
          const parentLi = link.closest('li.dropdown');
          if (parentLi) parentLi.querySelector('a').classList.add('active');
        }
      });
    });
  </script>


  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <script src="assets/js/main.js"></script>
</body>

</html>