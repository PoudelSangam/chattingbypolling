<?php include_once "./header.php"; ?>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <!-- Wrapper -->
  <div class="wrapper bg-white p-8 shadow-lg rounded-lg max-w-md w-full">
    <section class="form signup">
      <header class="text-2xl font-bold text-center text-blue-600 mb-6">Signup</header>
      
      <!-- Signup Form -->
      <form action="#" method="POST" enctype="multipart/form-data"> <!-- Added method attribute -->
        <div class="error-txt text-red-500 mb-4 hidden"></div>
        
        <!-- Name Details -->
        <div class="name-details grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4"> <!-- Responsive grid -->
          <div class="field input">
            <label for="fname" class="text-gray-700">First Name</label>
            <input type="text" name="fname" id="fname" placeholder="First Name" required
                   class="mt-2 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>
          <div class="field input">
            <label for="lname" class="text-gray-700">Last Name</label>
            <input type="text" name="lname" id="lname" placeholder="Last Name" required
                   class="mt-2 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>
        </div>
        
        <!-- Email Field -->
        <div class="field input mb-4">
          <label for="email" class="text-gray-700">Email Address</label>
          <input type="email" name="email" id="email" placeholder="Enter your email address" required
                 class="mt-2 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        
        <!-- Password Field -->
        <div class="field input mb-4 relative">
          <label for="password" class="text-gray-700">Password</label>
          <input type="password" name="password" id="password" placeholder="Enter your password" required
                 class="mt-2 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          <i class="fas fa-eye absolute top-10 right-3 text-gray-500 cursor-pointer" onclick="togglePasswordVisibility()"></i> <!-- Added function to toggle password visibility -->
        </div>

        <!-- Image Upload Field -->
        <div class="field image mb-4">
          <label for="image" class="text-gray-700">Select Image</label>
          <input type="file" name="image" id="image" accept="image/*" required
                 class="mt-2 block w-full text-gray-700 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          <p class="text-sm text-gray-500 mt-1">Preferred format: JPG, PNG, GIF</p> <!-- Additional guidance -->
        </div>
        
        <!-- Submit Button -->
        <div class="field button">
          <input type="submit" value="Continue"
                 class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
        </div>
      </form>
      
      <!-- Link to Login Page -->
      <div class="link text-center mt-6 text-gray-700">
        Already signed up? <a href="index.php" class="text-blue-600 hover:underline">Login now</a>
      </div>
    </section>
  </div>
  

  <script src="javascript/signup.js"></script>
  <script>
    function togglePasswordVisibility() {
      const passwordField = document.getElementById('password');
      const eyeIcon = document.querySelector('.fa-eye');
      if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
      } else {
        passwordField.type = "password";
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
      }
    }
  </script>
</body>
</html>