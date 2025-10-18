<?php
session_start();

$admin_user = "admin";
$admin_pass = "12345";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user = $_POST['username'];
  $pass = $_POST['password'];

  if ($user === $admin_user && $pass === $admin_pass) {
    $_SESSION['login'] = true;
    header("Location: adminpage/index.php");
    exit;
  } else {
    $error = "Username atau password salah!";
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Log In</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap"
    rel="stylesheet" />
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>

<body class="bg-[#fafafa] min-h-screen flex flex-col justify-center items-center px-4">
  <?php if (!empty($error)) echo "<p style='color:red'>$error</p>"; ?>
  <main class="w-full max-w-md">
    <div class="text-center mb-6">
      
      <h1 class="text-2xl font-bold text-[#1a1a1a] mb-1">Log In</h1>
      <div class="inline-flex items-center justify-center text-[#001bb1] font-semibold text-lg mb-2">
        <svg
          class="w-6 h-6 mr-1"
          fill="none"
          stroke="currentColor"
          stroke-width="3"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
          aria-hidden="true">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M3 12a9 9 0 0118 0 9 9 0 01-18 0z"></path>
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M9 12l3 3 3-3"></path>
        </svg>
        Global Media Computindo
      </div>
    </div>

    <form
      method="POST"
      class="bg-white rounded-xl p-6 shadow-sm"
      autocomplete="off"
      novalidate
      aria-label="Sign in form">
      <div class="mb-4">
        <label
          for="username"
          class="block text-xs font-semibold text-[#1a1a1a] mb-1">Username <span class="text-[#e55353]">*</span></label>
        <input
          id="username"
          name="username"
          type="username"
          required
          class="w-full border border-[#e5e7eb] rounded-md px-3 py-2 text-sm text-[#1a1a1a] placeholder:text-[#001bb1] focus:outline-none focus:ring-2 focus:ring-[#001bb1] focus:border-transparent"
          placeholder=" "
          aria-required="true" />
      </div>

      <div class="mb-3">
        <label
          for="password"
          class="block text-xs font-normal text-[#1a1a1a] mb-1">Password</label>
        <div class="relative">
          <input
            id="password"
            name="password"
            type="password"
            required
            class="w-full border border-[#e5e7eb] rounded-md px-3 py-2 pr-10 text-sm text-[#1a1a1a] placeholder:text-[#001bb1] focus:outline-none focus:ring-2 focus:ring-[#001bb1] focus:border-transparent"
            placeholder=" "
            aria-required="true" />
          <button
            type="button"
            aria-label="Toggle password visibility"
            class="absolute inset-y-0 right-3 flex items-center text-[#6b7280]"
            tabindex="-1">
            <i class="fas fa-eye-slash"></i>
          </button>
        </div>
      </div>

      <button
        type="submit"
        class="w-full bg-[#001bb1] text-white font-semibold text-sm rounded-md py-2 mb-4 hover:bg-[#001bb1] focus:outline-none focus:ring-2 focus:ring-[#007a4a]">
        Sign In
      </button>
    </form>

  </main>
</body>

</html>