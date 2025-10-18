<aside id="sidebar"
  class="flex flex-col w-56 transition-all duration-300 border-r border-gray-200 px-4 py-6 sticky top-0 h-screen overflow-y-auto bg-white">
  <div class="flex items-center space-x-2 mb-8">
    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white font-bold text-lg">
      G
    </div>
    <span class="font-bold text-blue-600 text-lg leading-none sidebar-text">
      GMC
  </div>

  <nav class="flex flex-col space-y-2 text-gray-600 text-sm font-medium">
    <a href="index.php?page=project"
      class="flex items-center space-x-2 px-3 py-2 rounded-md 
  <?php echo $activePage === 'project' ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:text-gray-900'; ?>">
      <i class="fas fa-folder-open text-base"></i>
      <span class="sidebar-text"> Home </span>
    </a>

    <a href="index.php?page=product"
      class="flex items-center space-x-2 px-3 py-2 rounded-md 
  <?php echo $activePage === 'product' ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:text-gray-900'; ?>">
      <i class="fas fa-shopping-cart text-base"></i>
      <span class="sidebar-text"> Produk </span>
    </a>

    <a href="index.php?page=blog"
      class="flex items-center space-x-2 px-3 py-2 rounded-md 
  <?php echo $activePage === 'blog' ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:text-gray-900'; ?>">
      <i class="fas fa-pen-nib text-base"></i>
      <span class="sidebar-text"> Blog </span>
    </a>

    <a href="index.php?page=auth"
      class="flex items-center space-x-2 px-3 py-2 rounded-md 
  <?php echo $activePage === 'auth' ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:text-gray-900'; ?>">
      <i class="fas fa-lock text-base"></i>
      <span class="sidebar-text"> Auth </span>
    </a>

  </nav>
</aside>