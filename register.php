<?php include('server.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: "class",
    }

    // Function to toggle dark mode
    function toggleTheme() {
      document.body.classList.toggle("dark");
    }
  </script>
  <link rel="stylesheet" href="./style.css">
</head>
<body>
    <main>
      
      <div class="relative flex flex-col h-[100vh] items-center justify-center bg-white dark:bg-black transition-bg">
        <div class="absolute inset-0 overflow-hidden">
          <div class="jumbo absolute -inset-[10px] opacity-50"></div>
        </div>
        <div class="relative flex flex-col items-center">
          <h1 class="flex items-center text-5xl font-bold text-gray-800 dark:text-white dark:opacity-80 transition-colors mb-8">
            Register
            <span class="ml-1 rounded-xl bg-current p-2 text-[0.7em] leading-none">
              <span class="text-white dark:text-black">//</span>
            </span>
          </h1>
        <!-- Register form -->
        <form id="RegisterForm" class="bg-white bg-opacity-70 dark:bg-gray-800 dark:bg-opacity-70 shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full max-w-md" method="post"  action="register.php">
          <?php include('errors.php'); ?>
            <div class="input-Email">
                <label class="block text-gray-700 dark:text-white text-sm font-bold mb-2" for="name">Email</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="Example@skiff.com" name="email" required>
            </div>
            <div class="input-username">
                <label class="block text-gray-700 dark:text-white text-sm font-bold mb-2" for="username">Username</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Username" name="username" required>
            </div>
            <div class="input-Adress">
                <label class="block text-gray-700 dark:text-white text-sm font-bold mb-2" for="adress">Adress</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="adress" type="text" placeholder="no,st,area,ZIP code,city,state" name="adress" required>
            </div>
            <div class="input-password">
                <label class="block text-gray-700 dark:text-white text-sm font-bold mb-2" for="password">Password</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************" name="password_1" required>
            </div>
            <div class="input-password 2">
                <label class="block text-gray-700 dark:text-white text-sm font-bold mb-2" for="password">Re-Enter Password</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************" name="password_2" required>
            </div>
            <div class="flex items-center justify-between">
                <button onclick="redi()" type="submit" id="submit" name="reg_user" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" >register</button>
                <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="http://localhost/read2rent/login.php">Have an account?</a>
            </div>
          </form>
        </div>
        <div class="mt-4">
          <button onclick="toggleTheme()" id="toggleTheme" class="fixed top-4 right-4 px-4 py-2 bg-gray-400 text-gray-800 rounded-md">Toggle Theme</button>
        </div>
      </div>
    </main>
</body>
</html>