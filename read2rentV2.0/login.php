<?php include('server.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
          Login
          <span class="ml-1 rounded-xl bg-current p-2 text-[0.7em] leading-none">
            <span class="text-white dark:text-black">//</span>
          </span>
        </h1>
        
        <!-- Login form -->
        <form id="loginForm" class="bg-white bg-opacity-70 dark:bg-gray-800 dark:bg-opacity-70 shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full max-w-md" action="login.php">
        <?php include('errors.php'); ?>
          <div class="mb-4">
            <label class="block text-gray-700 dark:text-white text-sm font-bold mb-2" for="username">Username</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Username" name="username" required>
          </div>
          <div class="mb-6">
            <label class="block text-gray-700 dark:text-white text-sm font-bold mb-2" for="password">Password</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************" name="password" required>
          </div>
         
          <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="login_user">Sign In</button>
            <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">Forgot Password?</a>
          </div>
        </form>
      </div>
      <div class="mt-4">
        <button onclick="toggleTheme()" id="toggleTheme" class="fixed top-4 right-4 px-4 py-2 bg-gray-400 text-gray-800 rounded-md">Toggle Theme</button>
      </div>
    </div>
  </main>

  <script>
    // Function to handle form submission and redirection
    document.getElementById("loginForm").addEventListener("submit", function(event) {
      event.preventDefault(); 
      // Prevent default form submission
      
      // Get username and password from form
      var username = document.getElementById("username").value;
      var password = document.getElementById("password").value;

      // Example of basic validation (replace this with actual validation)
      if (username === "admin" && password === "password123") {
        // Redirect to dashboard.html after successful login
        window.location.href = "dashboard.html";
      } else {
        // Show an alert for invalid credentials (replace this with your desired error handling)
        alert("Invalid username or password");
      }
    });
  </script>
</body>
</html>