<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
  header("Location: ../login.php");
  exit;
}
?>
<?php
$activePage = isset($_GET['page']) ? $_GET['page'] : 'project';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <title>GMC</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&amp;display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: "Inter", sans-serif;
    }

    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }

    ::-webkit-scrollbar-thumb {
      background-color: #cbd5e1;
      border-radius: 3px;
    }

    ul::-webkit-scrollbar {
      width: 6px;
    }

    ul::-webkit-scrollbar-track {
      background: transparent;
    }

    ul::-webkit-scrollbar-thumb {
      background-color: rgba(156, 163, 175, 0.5);
      border-radius: 3px;
    }

    ul {
      scrollbar-width: thin;
      scrollbar-color: rgba(156, 163, 175, 0.5) transparent;
    }
  </style>
</head>

<body class="bg-white text-gray-800">
  <div class="flex min-h-screen">
    <?php include 'includes/sidebar.php'; ?>
    <?php include 'includes/navbar.php'; ?>

    <main class="flex-1 p-6 overflow-y-auto pt-16">
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
        include "pages/project.php";
      }
      ?>
    </main>


  </div>

  <script>
    const profileButton = document.getElementById("profileButton");
    const profileDropdown = document.getElementById("profileDropdown");
    if (profileButton && profileDropdown) {
      profileButton.addEventListener("click", () => {
        profileDropdown.classList.toggle("hidden");
      });
      document.addEventListener("click", (e) => {
        if (!profileButton.contains(e.target) && !profileDropdown.contains(e.target)) {
          profileDropdown.classList.add("hidden");
        }
      });
    }

    const toggleBtn = document.getElementById("sidebarToggle");
    const sidebar = document.getElementById("sidebar");
    const navbar = document.getElementById("navbar");

    toggleBtn.addEventListener("click", () => {
      sidebar.classList.toggle("w-56");
      sidebar.classList.toggle("w-16");

      navbar.classList.toggle("left-56");
      navbar.classList.toggle("left-16");

      if (sidebar.classList.contains("w-16")) {
        toggleBtn.innerText = "←|";
      } else {
        toggleBtn.innerText = "|→";
      }

      document.querySelectorAll(".sidebar-text").forEach(el => {
        el.classList.toggle("hidden");
      });
    });

    (() => {
      const API_BASE = '/adminpage/adminpage';
      const UPLOAD_BASE_URL = '/adminpage/landingpage/assets/img/uploaded/';

      const newProductBtn = document.querySelector('button i.fas.fa-user-plus')?.parentElement || null;
      const addProductModal = document.getElementById("addProductModal");
      const cancelModal = document.getElementById("cancelModal");
      const addProductForm = document.querySelector("#addProductModal form");
      const productTableBody = document.getElementById("productTableBody");
      const photoPreview = document.getElementById("photoPreview");
      const photoInput = document.getElementById("photoInput");
      const selectAll = document.getElementById("selectAll");

      if (!addProductModal || !cancelModal || !addProductForm || !productTableBody || !photoPreview || !photoInput) {
        console.error("Elemen DOM wajib tidak ditemukan.");
        return;
      }

      let productData = [];
      let editingId = null;

      function imgSrc(photo) {
        return photo ? (UPLOAD_BASE_URL + photo) : "https://via.placeholder.com/48x48.png?text=👤";
      }

      function setModal(open) {
        addProductModal.classList.toggle("hidden", !open);
      }

      function resetForm() {
        addProductForm.reset();
        photoPreview.src = "https://via.placeholder.com/48x48.png?text=👤";
        editingId = null;
        addProductForm.index.value = "";
        addProductForm.oldPhoto.value = "";
      }

      async function loadData() {
        try {
          const res = await fetch(`${API_BASE}/get_product.php`, {
            cache: "no-store"
          });
          if (!res.ok) throw new Error('Gagal load data dari server');
          const data = await res.json();
          if (!Array.isArray(data)) throw new Error('Response bukan array');
          productData = data;

          renderTable();
          renderKategoriDropdown();
        } catch (err) {
          console.error(err);
        }
      }

      function renderTable(data = productData) {
        productTableBody.innerHTML = "";
        data.forEach((product) => {
          const tr = document.createElement("tr");
          tr.className = "bg-white rounded shadow border border-gray-100 text-xs md:text-sm";
          tr.innerHTML = `
        <td class="pl-4">
          <input type="checkbox" class="cursor-pointer row-checkbox" data-id="${product.id}" />
        </td>
        <td class="py-3 max-w-[150px] truncate">
          <div class="flex items-center space-x-3">
            <img src="${imgSrc(product.photo)}" class="w-10 h-10 md:w-12 md:h-12 rounded-full object-cover border" />
            <span class="font-semibold">${product.name ?? ''}</span>
          </div>
        </td>
        <td class="max-w-[100px] truncate">${formatHarga(product.harga)}</td>
        <td class="max-w-[100px] truncate">${product.kategori ?? ''}</td>
        <td class="max-w-[200px] truncate">${product.deskripsi ?? ''}</td>
      
        <td class="pr-5 space-x-3 text-gray-400">
          <button class="editBtn" data-id="${product.id}"><i class="fas fa-edit"></i></button>
          <button class="deleteBtn" data-id="${product.id}"><i class="fas fa-trash-alt"></i></button>
        </td>
      `;
          productTableBody.appendChild(tr);
        });
      }


      fetch('/adminpage/adminpage/get_kategori.php')
        .then(res => res.json())
        .then(data => {
          const list = document.getElementById('kategoriList');
          data.forEach(kat => {
            list.innerHTML += `<option value="${kat}">`;
          });
        });


      function applyFilter() {
        const kategoriVal = document.getElementById("kategoriDropdown")?.value || "";
        const sortVal = document.getElementById("sortHarga")?.value || "";

        let filtered = [...productData];

        if (kategoriVal) {
          filtered = filtered.filter(p => p.kategori === kategoriVal);
        }

        if (sortVal === "asc") {
          filtered.sort((a, b) => parseFloat(a.harga) - parseFloat(b.harga));
        } else if (sortVal === "desc") {
          filtered.sort((a, b) => parseFloat(b.harga) - parseFloat(a.harga));
        }

        renderTable(filtered);
      }

      if (newProductBtn) {
        newProductBtn.addEventListener("click", () => {
          resetForm();
          setModal(true);
        });
      }

      cancelModal.addEventListener("click", () => {
        setModal(false);
        resetForm();
      });

      photoInput.addEventListener("change", e => {
        const file = e.target.files[0];
        if (file) photoPreview.src = URL.createObjectURL(file);
      });

      if (selectAll) {
        selectAll.addEventListener("change", (e) => {
          const checked = e.target.checked;
          productTableBody.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = checked);
        });
      }

      addProductForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const fd = new FormData(addProductForm);

        let kategoriVal = fd.get("kategori");
        if (kategoriVal === "__lainnya__") {
          const kategoriBaru = document.getElementById("kategoriLainnyaInput").value.trim();
          if (!kategoriBaru) {
            alert("Isi kategori baru terlebih dahulu!");
            return;
          }
          kategoriVal = kategoriBaru;

          if (!kategoriList.includes(kategoriBaru)) {
            kategoriList.push(kategoriBaru);

            renderKategoriSelect(kategoriBaru);
          }

          fd.set("kategori", kategoriBaru);
        }

        try {
          const res = await fetch(`${API_BASE}/save_product.php`, {
            method: "POST",
            body: fd
          });
          const text = await res.text();
          console.log("Response raw:", text);
          const result = JSON.parse(text);

          if (!result.success) {
            alert("Gagal simpan: " + (result.message || "Unknown error"));
            return;
          }

          await loadData();
          setModal(false);
          resetForm();
        } catch (err) {
          console.error(err);
          alert("Terjadi kesalahan saat menyimpan data.");
        }
      });

      document.addEventListener("DOMContentLoaded", () => {
        renderKategoriSelect();
      });



      productTableBody.addEventListener("click", async (e) => {
        const btn = e.target.closest("button");
        if (!btn) return;

        const id = btn.getAttribute("data-id");
        const product = productData.find(p => String(p.id) === String(id));
        if (!product) return;

        if (btn.classList.contains("editBtn")) {
          editingId = product.id;
          addProductForm.name.value = product.name ?? '';
          addProductForm.harga.value = product.harga ?? '';
          addProductForm.kategori.value = product.kategori ?? '';
          addProductForm.deskripsi.value = product.deskripsi ?? '';
          photoPreview.src = imgSrc(product.photo);
          addProductForm.oldPhoto.value = product.photo ?? '';
          addProductForm.index.value = product.id ?? '';
          setModal(true);
        }

        if (btn.classList.contains("deleteBtn")) {
          if (!confirm("Yakin ingin menghapus data ini?")) return;
          try {
            const fd = new FormData();
            fd.append("id", id);
            const res = await fetch(`${API_BASE}/delete_product.php`, {
              method: 'POST',
              body: fd
            });
            const result = await res.json();
            if (result.success) {
              productData = productData.filter(p => String(p.id) !== String(id));
              renderTable();
            } else alert('Gagal hapus: ' + (result.message || 'Unknown error'));
          } catch (err) {
            console.error(err);
            alert('Terjadi kesalahan saat menghapus.');
          }
        }
      });

      window.addEventListener("DOMContentLoaded", () => {
        loadData();

        document.getElementById("kategoriDropdown")?.addEventListener("change", applyFilter);
        document.getElementById("sortHarga")?.addEventListener("change", applyFilter);
      });
    })();



    function formatHarga(value) {
      const num = parseFloat(value);
      if (isNaN(num)) return value;

      if (num % 1 === 0) {
        return num.toLocaleString('id-ID', {
          minimumFractionDigits: 0
        });
      } else {
        return num.toLocaleString('id-ID', {
          minimumFractionDigits: 2
        });
      }
    }


    const API_BASE = "http://localhost/adminpage/adminpage";

    let productData = [];
    let selectedKategori = "all";

    const kategoriDropdownBtn = document.getElementById("kategoriDropdownBtn");
    const kategoriDropdownMenu = document.getElementById("kategoriDropdownMenu");
    const kategoriFilterList = document.getElementById("kategoriFilterList");
    const kategoriDropdownLabel = document.getElementById("kategoriDropdownLabel");
    const productTableBody = document.getElementById("productTableBody");

    kategoriDropdownBtn.addEventListener("click", () => {
      kategoriDropdownMenu.classList.toggle("hidden");
    });

    function imgSrc(photo) {
      return photo ? `/adminpage/landingpage/assets/img/uploaded/${photo}` : "https://via.placeholder.com/48.png?text=🛒";
    }

    function renderKategoriFilter() {
      if (!Array.isArray(productData) || productData.length === 0) {
        kategoriFilterList.innerHTML = `<li class="px-4 py-2 text-gray-400">Tidak ada kategori</li>`;
        return;
      }

      const categories = [...new Set(productData.map(p => p.kategori).filter(Boolean))];

      kategoriFilterList.innerHTML = `
      <li><a href="#" data-kategori="all" class="block px-4 py-2 hover:bg-gray-100">Semua</a></li>
      ${categories.map(c => `<li><a href="#" data-kategori="${c}" class="block px-4 py-2 hover:bg-gray-100">${c}</a></li>`).join("")}
    `;
    }

    kategoriFilterList.addEventListener("click", (e) => {
      e.preventDefault();
      const kategori = e.target.getAttribute("data-kategori");
      if (!kategori) return;

      selectedKategori = kategori;
      kategoriDropdownLabel.textContent = kategori === "all" ? "Kategori" : kategori;
      kategoriDropdownMenu.classList.add("hidden");

      renderTable();
    });

    function renderTable() {
      productTableBody.innerHTML = "";

      const filtered = productData.filter(p => selectedKategori === "all" || p.kategori === selectedKategori);

      filtered.forEach((p) => {
        const tr = document.createElement("tr");
        tr.className = "bg-white rounded shadow border border-gray-100";
        tr.innerHTML = `
        <td class="pl-4">
          <input type="checkbox" class="cursor-pointer row-checkbox" data-id="${p.id}" />
        </td>
        <td class="py-3">
          <div class="flex items-center space-x-3">
            <img src="${imgSrc(p.photo)}" class="w-12 h-12 rounded-full object-cover border" />
            <span class="font-semibold text-xs md:text-sm">${p.name ?? ''}</span>
          </div>
        </td>
        <td class="text-xs md:text-sm">${p.harga ?? ''}</td>
        <td class="text-xs md:text-sm font-semibold">${p.kategori ?? ''}</td>
        <td class="text-xs md:text-sm font-semibold whitespace-normal break-words max-w-[200px]">${p.deskripsi ?? ''}</td>
        <td class="pr-5 space-x-3 text-gray-400 text-xs md:text-sm">
          <button class="editBtn" data-id="${p.id}"><i class="fas fa-edit"></i></button>
          <button class="deleteBtn" data-id="${p.id}"><i class="fas fa-trash-alt"></i></button>
        </td>
      `;
        productTableBody.appendChild(tr);
      });
    }

    async function loadData() {
      try {
        const res = await fetch(`${API_BASE}/get_product.php`, {
          cache: "no-store"
        });
        const data = await res.json();
        productData = Array.isArray(data) ? data : [];
        renderTable();
        renderKategoriDropdown();
        renderKategoriSelect();
      } catch (err) {
        console.error(err);
      }
    }

    setInterval(loadData, 3000);

    loadData();
  </script>

</body>

</html>