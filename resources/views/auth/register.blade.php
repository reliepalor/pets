<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Paw Haven | Register</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="/images/paw.png" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    body {
      font-family: 'Montserrat', sans-serif;
    }

    .glass-button {
      @apply w-full py-4 px-6 rounded-2xl text-white font-bold text-lg text-center backdrop-blur-md;
      background: rgba(90, 135, 255, 0.25);
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
      transition: all 0.3s ease;
    }

    .glass-button:hover {
      background: rgba(90, 135, 255, 0.4);
      transform: scale(1.02);
    }

    .glass-button:active {
      transform: scale(0.98);
      background: rgba(90, 135, 255, 0.6);
    }

    .password-toggle {
      @apply absolute right-3 top-3 text-white cursor-pointer;
    }
  </style>
</head>
<body class="min-h-screen overflow-hidden">

  <!-- Background Video -->
  <div class="fixed inset-0 z-0">
    <video autoplay muted loop playsinline class="w-full h-full object-cover">
      <source src="/videos/dogvideo.mp4" type="video/mp4" />
      Your browser does not support the video tag.
    </video>
    <div class="absolute inset-0 bg-black bg-opacity-30"></div>
  </div>

  <!-- Register Form -->
  <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md p-10 bg-white/10 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20">

      <!-- Header -->
      <div class="flex justify-center items-center mb-6 space-x-3">
        <h2 class="text-4xl font-extrabold text-white text-center">Paw Haven</h2>
        <img src="/images/paw.png" alt="Paw Icon" width="50" height="50" />
      </div>

      <!-- Form -->
      <form action="#" method="POST">
        @csrf

        <!-- Name -->
        <div class="mb-5">
          <label for="name" class="block text-white mb-1">Name</label>
          <input id="name" name="name" type="text" required
            class="w-full px-4 py-3 bg-white/10 text-white border border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>

        <!-- Email -->
        <div class="mb-5">
          <label for="email" class="block text-white mb-1">Email</label>
          <input id="email" name="email" type="email" required
            class="w-full px-4 py-3 bg-white/10 text-white border border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>

      <!-- Password -->
<div class="mb-5">
  <label for="password" class="block text-white mb-1">Password</label>
  <div class="relative">
    <input id="password" name="password" type="password" required
      class="w-full px-4 py-3 pr-12 bg-white/10 text-white border border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
      <svg id="togglePassword" class="h-5 w-5 text-white cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M2.458 12C3.732 7.943 7.522 5 12 5s8.268 2.943 9.542 7.001c-1.274 4.058-5.064 7.001-9.542 7.001S3.732 16.059 2.458 12z" />
      </svg>
    </div>
  </div>
</div>

<!-- Confirm Password -->
<div class="mb-8">
  <label for="password_confirmation" class="block text-white mb-1">Confirm Password</label>
  <div class="relative">
    <input id="password_confirmation" name="password_confirmation" type="password" required
      class="w-full px-4 py-3 pr-12 bg-white/10 text-white border border-white/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
      <svg id="toggleConfirm" class="h-5 w-5 text-white cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M2.458 12C3.732 7.943 7.522 5 12 5s8.268 2.943 9.542 7.001c-1.274 4.058-5.064 7.001-9.542 7.001S3.732 16.059 2.458 12z" />
      </svg>
    </div>
  </div>
</div>

        <input type="hidden" name="role" value="user" />

        <!-- Submit Button -->
        <button type="submit" class="glass-button mb-6 w-full h-[5vh] rounded-lg text-white">
          Register
        </button>

        <!-- Link to Login -->
        <div class="text-center">
          <a href="{{route('login')}}" class="text-sm text-white underline hover:text-gray-200">
            Already have an account?
          </a>
        </div>
      </form>
    </div>
  </div>

  <!-- Password toggle script -->
  <script>
    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("password");

    togglePassword.addEventListener("click", () => {
      const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
      passwordInput.setAttribute("type", type);
      togglePassword.classList.toggle("text-gray-300");
    });

    const toggleConfirm = document.getElementById("toggleConfirm");
    const confirmInput = document.getElementById("password_confirmation");

    toggleConfirm.addEventListener("click", () => {
      const type = confirmInput.getAttribute("type") === "password" ? "text" : "password";
      confirmInput.setAttribute("type", type);
      toggleConfirm.classList.toggle("text-gray-300");
    });
  </script>
</body>
</html>
