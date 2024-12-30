




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css"/>

</head>
<body class="flex justify-center items-center mt-20">
<div
  style="animation: slideInFromLeft 1s ease-out;"
  class="max-w-md w-full bg-gradient-to-r from-blue-800 to-purple-600 rounded-xl shadow-2xl overflow-hidden p-8 space-y-8"
>
  <h2
    style="animation: appear 2s ease-out;"
    class="text-center text-4xl font-extrabold text-white"
  >
    Welcome
  </h2>
  <p style="animation: appear 3s ease-out;" class="text-center text-gray-200">
    Sign Up
  </p>
  <form method="POST" action="#" class="space-y-6">
  <div class="relative">
      <input
        placeholder="full name"
        class="peer h-10 w-full border-b-2 border-gray-300 text-white bg-transparent placeholder-transparent focus:outline-none focus:border-purple-500"
        required=""
        id="name"
        name="name"
        type="name"
      />
      <label
        class="absolute left-0 -top-3.5 text-gray-500 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-purple-500 peer-focus:text-sm"
        for="email"
        >Full Name</label
      >
    </div>
    <div class="relative">
      <input
        placeholder="john@example.com"
        class="peer h-10 w-full border-b-2 border-gray-300 text-white bg-transparent placeholder-transparent focus:outline-none focus:border-purple-500"
        required=""
        id="email"
        name="email"
        type="email"
      />
      <label
        class="absolute left-0 -top-3.5 text-gray-500 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-purple-500 peer-focus:text-sm"
        for="email"
        >Email address</label
      >
    </div>
    <div class="relative">
      <input
        placeholder="Password"
        class="peer h-10 w-full border-b-2 border-gray-300 text-white bg-transparent placeholder-transparent focus:outline-none focus:border-purple-500"
        required=""
        id="password"
        name="password"
        type="password"
      />
      <label
        class="absolute left-0 -top-3.5 text-gray-500 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-purple-500 peer-focus:text-sm"
        for="password"
        >Password</label
      >
    </div>
   
    <button
      class="w-full py-2 px-4 bg-purple-500 hover:bg-purple-700 rounded-md shadow-lg text-white font-semibold transition duration-200"
      type="submit"
    >
      Sign Up
    </button>
  </form>
  <div class="text-center text-gray-300">
    I have an account?
    <a class="text-purple-300 hover:underline" href="login.php">Sign In</a>
  </div>
</div>

</body>
</html>
