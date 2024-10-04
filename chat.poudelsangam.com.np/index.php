<?php include_once "./header.php"; ?>
<link rel="manifest" href="/manifest.json">

<style>
    
     #installModal {
  background-color: rgba(0, 0, 0, 0.5);
}
        .primary {
            background: #3BEF80;
        }
        .text-primary {
            color: #3BEF80;
        }
        .login-with-google-btn {
              
        display: flex;
        align-items: center;
            display: inline-block;
            transition: background-color 0.3s, box-shadow 0.3s;
            padding: 12px 16px 12px 30px;
            border: none;
            border-radius: 3px;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 1px 1px rgba(0, 0, 0, 0.25);
            color: #757575;
            font-size: 14px;
            font-weight: 500;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            background-image: url("data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj48cGF0aCBkPSJNMTcuNiA5LjJsLS4xLTEuOEg5djMuNGg0LjhDMTMuNiAxMiAxMyAxMyAxMiAxMy42djIuMmgzYTguOCA4LjggMCAwIDAgMi42LTYuNnoiIGZpbGw9IiM0Mjg1RjQiIGZpbGwtcnVsZT0ibm9uemVybyIvPjxwYXRoIGQ9Ik05IDE4YzIuNCAwIDQuNS0uOCA2LTIuMmwtMy0yLjJhNS40IDUuNCAwIDAgMS04LTIuOUgxVjEzYTkgOSAwIDAgMCA4IDV6IiBmaWxsPSIjMzRBODUzIiBmaWwtcnVsZT0ibm9uemVybyIvPjxwYXRoIGQ9Ik00IDEwLjdDNDAtNiA1LTVIazkgOWUwMCwwIDUgMyIvPjwvZz48cGF0aCBkPSJNOCAyYzEuMyAwIDIuNS40IDMuNCAxLjNMMTUgMi4zQTkgOSAwIDAgMCAxIDVsMyAyLjRhNS40IDUuNCAwIDAgMSA1LTMuN3oiIGZpbGw9IiNFQTRDMzUiIGZpbGwtcnVsZT0ibm9uemVybyIvPjxwYXRoIGQ9Ik05IDMuNmMxLjMgMCAyLjUuNCAzLjQgMS4zTDE1IDIuM0E5IDkgMCAwIDAgMSA1bDMgMi40YTUuNCA1LjQgMCAwIDEgNS0zLjZ6IiBmaWxsPSIjRkZGRkZGIiBmaWwtcnVsZT0ibm9uemVybyIvPjwvc3ZnPjwvZz48L3N2Zz4=");
            background-color: white;
            background-repeat: no-repeat;
            background-position: 10px center;
        }
        .login-with-google-btn:hover {
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 2px 4px rgba(0, 0, 0, 0.25);
        }
        .login-with-google-btn:active {
            background-color: #eeeeee;
        }
        .login-with-google-btn:focus {
            outline: none;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 2px 4px rgba(0, 0, 0, 0.25), 0 0 0 3px #c8dafc;
        }
        .login-with-google-btn:disabled {
            filter: grayscale(100%);
            background-color: #ebebeb;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 1px 1px rgba(0, 0, 0, 0.25);
            cursor: not-allowed;
        }
        .send-mail-btn {
            position: absolute;
            top: 10px;
            right: 10px;
        }
       
 #status {
  position: fixed;
  top: 105px;
  left: 0;
  text-align: center;
  font-size: 18px;
  z-index: 1000;
}
</style>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="wrapper bg-white p-8 shadow-lg rounded-lg max-w-md w-full">
    <section class="form Login">
      <header class="text-2xl font-bold text-center text-blue-600 mb-6">Login</header>

      <form action="#">
        <div class="error-txt text-red-500 mb-4 hidden"></div>

        <div class="field input mb-4">
          <label for="email" class="text-gray-700">Email Address</label>
          <input type="text" name="email" id="email" placeholder="Enter your email address"
                 class="mt-2 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="field input mb-4 relative">
          <label for="password" class="text-gray-700">Password</label>
          <input type="password" name="password" id="password" placeholder="Enter your password"
                 class="mt-2 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          <i class="fas fa-eye absolute top-10 right-3 text-gray-500 cursor-pointer"></i>
        </div>

        <div class="field button">
          <input type="submit" value="Continue"
                 class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition">
        </div>
      </form>

      <div class="link text-center mt-6 text-gray-700">
        Not yet signed up? <a href="signup.php" class="text-blue-600 hover:underline">Signup now</a>
      </div>
    </section>
  </div>
      <!-- Modal -->
<div id="installModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
  <div class="bg-white w-full max-w-md mx-auto rounded-lg shadow-lg p-6">
    <h3 class="text-lg font-semibold mb-4">Install the App</h3>
    <p class="mb-6">Get quick access to this app by installing it on your device.</p>
    <div class="flex justify-end">
      <button id="installAppButton" class="mr-2 py-2 px-4 bg-blue-500 text-white rounded-lg">Install</button>
      <button id="closeModalButton" class="py-2 px-4 bg-gray-300 rounded-lg">Close</button>
    </div>
  </div>
</div>
  
   <script src="scripts.js"></script>
  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/login.js"></script>
  
</body>
</html>
