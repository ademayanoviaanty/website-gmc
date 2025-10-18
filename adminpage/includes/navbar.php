
<div id="navbar"
  class="fixed top-0 left-56 right-0 z-40 
            flex justify-between items-center 
            px-6 py-3 
            bg-white/50 backdrop-blur-md 
            border-b border-gray-200/50 
            transition-all duration-300">

  <div id="sidebarToggle" class="text-gray-400 text-lg select-none cursor-pointer">
    |→
  </div>

  <div class="flex items-center space-x-4">

    <div class="relative">
      <img
        src="assets/img/logogmc.png"
        alt="User profile picture"
        class="rounded-full w-10 h-10 cursor-pointer"
        id="profileButton" />

      <div id="profileDropdown"
        class="hidden absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg 
            border border-gray-100 p-4 text-gray-700 font-sans z-50">
        <div class="flex items-center space-x-3 mb-4">
          <img class="w-10 h-10 rounded-full object-cover"
            src="assets/img/logogmc.png" alt="">
          <div>
            <p class="font-semibold text-gray-900 text-sm">Admin</p>
          </div>
        </div>
        <!-- <ul class="space-y-3 text-sm">
          <li><a href="#" class="flex items-center space-x-3 text-gray-500 hover:text-gray-700"><i class="fas fa-home w-5"></i> <span>Home</span></a></li>
        </ul> -->
        <div class="border-t border-gray-100 mt-4 pt-4">
          <a href="../logout.php" class="flex items-center space-x-3 text-gray-500 hover:text-gray-700 text-sm">
            <i class="fas fa-sign-out-alt w-5"></i>
            <span>Logout</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>