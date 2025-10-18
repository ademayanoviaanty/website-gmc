<div class="flex min-h-screen">
  <main id="mainContent" class="flex-1 transition-all duration-300 p-6 overflow-y-auto">
    <div class="flex justify-between items-center mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-900 mb-1">
          Product
        </h1>
        <nav class="flex items-center space-x-2 text-xs text-gray-400 font-semibold">
          <span class="text-gray-900">
            Home
          </span>
          <span>•</span>
          <span>
            Produk
          </span>
        </nav>
      </div>
      <button
        class="inline-flex items-center space-x-2 bg-blue-900 text-white text-sm font-semibold rounded-md px-4 py-2 hover:bg-blue-800 transition"
        type="button">
        <i class="fas fa-user-plus"></i>
        <span>
          Tambah Produk
        </span>
      </button>
    </div>

    <section class="bg-white rounded-xl border border-gray-100 p-6 shadow-md hover:shadow-lg transition-shadow">
      <!-- <div class="flex flex-col md:flex-row md:items-center md:space-x-4 mb-4 space-y-2 md:space-y-0">
        <input
          id="searchInput"
          class="w-full md:flex-1 border border-gray-200 rounded-md px-4 py-2 text-sm text-gray-400 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
          placeholder="Search"
          type="search" />

        <select id="kategoriDropdown"
          class="w-full md:w-auto border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
          <option value="">All Kategori</option>
        </select>

        <select id="sortHarga"
          class="w-full md:w-auto border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
          <option value="">Sort Harga</option>
          <option value="asc">Harga Terendah</option>
          <option value="desc">Harga Tertinggi</option>
        </select>

        <button class="w-full md:w-auto border border-gray-300 rounded-md px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition flex items-center justify-center md:justify-start space-x-1"
          type="button">
          <span>Export</span>
          <i class="fas fa-chevron-down text-xs"></i>
        </button>
      </div> -->

      <div class="overflow-x-auto">
        <table class="min-w-[800px] w-full text-left text-sm text-gray-500 border-separate border-spacing-y-2">
          <thead class="text-gray-400 font-semibold border-b border-gray-100">
            <tr>
              <th class="w-10 pl-4 pr-2">
                <input class="cursor-pointer" id="selectAll" type="checkbox" />
              </th>

              <th class="py-3 min-w-[150px]">Nama Produk</th>
              <th class="min-w-[100px]">Harga</th>
              <th class="min-w-[120px]">Kategori</th>
              <th class="min-w-[200px]">Deskripsi</th>
              <th class="pr-4 min-w-[120px]">Aksi</th>
            </tr>
          </thead>
          <tbody id="productTableBody" class="text-gray-700"></tbody>
        </table>
      </div>
    </section>

  </main>

  <div id="addProductModal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
      <h2 class="text-xl font-bold mb-4">Tambah Produk Baru</h2>
      <form action="pages/save_product.php" method="POST" enctype="multipart/form-data" id="addProductForm">
        <input type="hidden" name="oldPhoto" value="" />
        <input type="hidden" name="index" value="" />

        <div>
          <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
          <input type="text" name="name" required
            class="w-full border rounded-md px-3 py-2 mt-1 text-sm focus:ring-2 focus:ring-blue-400" />
        </div>
      
        <div>
          <label class="block text-sm font-medium text-gray-700">Harga</label>
          <input type="text" name="harga" required
            class="w-full border rounded-md px-3 py-2 mt-1 text-sm focus:ring-2 focus:ring-blue-400" />
        </div>
        
        <label class="block text-sm font-medium text-gray-700" for="kategori">Kategori</label>
        <input list="kategoriList" id="kategoriInput" name="kategori"
          placeholder="Pilih kategori..."
          class="w-full border rounded-md px-3 py-2 mt-1 text-sm focus:ring-2 focus:ring-blue-400">
        <datalist id="kategoriList"></datalist>
        
        <div>
          <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
          <textarea name="deskripsi" required
            class="w-full border rounded-md px-3 py-2 mt-1 text-sm focus:ring-2 focus:ring-blue-400"
            rows="4" placeholder="Tulis deskripsi produk..."></textarea>
        </div>
        <br>
        <div>
          <label class="block text-sm font-medium text-gray-700">Photo</label>
          <div class="mt-1 flex items-center space-x-3">
            <img id="photoPreview" src="https://via.placeholder.com/48x48.png?text=👤"
              class="w-12 h-12 rounded-full object-cover border" />
            <input type="file" id="photoInput" name="photo" accept="image/*" class="hidden">
            <label for="photoInput"
              class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
              <i class="fas fa-upload mr-2"></i> Choose Photo
            </label>
          </div>
        </div>
        <div class="flex justify-end space-x-2 mt-4">
          <button type="button" id="cancelModal"
            class="px-4 py-2 text-sm border rounded-md hover:bg-gray-50">
            Cancel
          </button>
          <button type="submit"
            class="px-4 py-2 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700">
            Save
          </button>
        </div>
      </form>
    </div>
  </div>

</div>

</div>