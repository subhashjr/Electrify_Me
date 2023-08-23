<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredEmail = $_POST["email"];
    $enteredPassword = $_POST["password"];
    $loginError = "";

    // Connect to your database (replace with your database credentials)
    $db_host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "data";
  
    // Create connection
    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($enteredEmail) || empty($enteredPassword)) {
        if (empty($enteredEmail)) {
            $emailError = "Please enter your email.";
        }
        if (empty($enteredPassword)) {
            $passwordError = "Please enter your password.";
        }
    } else {
        $sql = "SELECT * FROM users WHERE email = '$enteredEmail' AND password = '$enteredPassword'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            session_start();
            $_SESSION['email'] = $enteredEmail;
            // Redirect to HomePage.html
            header("Location: HomePage.html");
            exit();
        } else {
            $loginError = "Invalid email or password.";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
    <link rel="stylesheet" href="login1.css">

    <title>EV</title>
    <style>
        #video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <video id="video-background" autoplay muted loop>
        <source src="video2.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <header class="text-gray-600 body-font">
        <div class="container mx-auto flex flex-nowrap p-5 flex-col md:flex-row items-center">
            <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="2"
                    class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
                    <path
                        d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5">
                    </path>
                </svg>
                <a class="ml-3 text-white text-xl hover:text-gray-900" href="#">ELECTRIFY-ME</a>
            </a>
            <nav class="md:ml-auto md:mr-auto flex flex-wrap items-center text-base justify-center">
                
            </nav>
        </div>
    </header>
    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto flex flex-nowrap items-center">
            <div class="cont">
                <p class="lt" style="color: black;">WELCOME TO</p>
                <section class="anime">
                    <div class="first">EV</div>
                    <div class="second">Station</div>
                    <div class="third">Finder</div>
                </section>
            </div>
            <div class="lg:w-2/6 md:w-1/2 bg-gray-300 rounded-lg p-8 flex flex-col md:ml-auto w-full mt-10 md:mt-0">
                <h2 class="text-black text-lg font-medium title-font mb-5">Log In</h2>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="relative mb-4">
                        <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
                        <input type="email" id="email" name="email"
                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        <?php if (!empty($emailError)) echo '<span id="email-error" class="text-red-500 text-xs">' . $emailError . '</span>' ?>
                    </div>
                    <div class="relative mb-4">
                        <label for="password" class="leading-7 text-sm text-gray-600">Password</label>
                        <input type="password" id="password" name="password"
                            class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        <?php if (!empty($passwordError)) echo '<span id="password-error" class="text-red-500 text-xs">' . $passwordError . '</span>' ?>
                    </div>
                    <button id="login-btn"
                        class="text-gray-50 bg-gray-600 border-0 py-2 px-8 focus:outline-none hover:bg-gray-900 hover:text-white rounded text-lg">Login</button>
                    <a class="text-xs text-gray-500 mt-3" id="forgot" href="index1.php">New User?Sign Up</a>
                    <?php if (!empty($loginError)) echo '<p id="login-error" class="text-red-500 text-xs mt-3">' . $loginError . '</p>' ?>
                </form>
            </div>
        </div>
    </section>

    <!-- Rest of the code -->

    <script>
        document.getElementById("login-btn").addEventListener("click", function () {
            var emailInput = document.getElementById("email");
            var passwordInput = document.getElementById("password");
            var emailError = document.getElementById("email-error");
            var passwordError = document.getElementById("password-error");

            emailError.classList.add("hidden");
            passwordError.classList.add("hidden");

            var enteredEmail = emailInput.value.trim();
            var enteredPassword = passwordInput.value.trim();

            if (enteredEmail === "") {
                emailError.classList.remove("hidden");
            }

            if (enteredPassword === "") {
                passwordError.classList.remove("hidden");
            }
        });
    </script>

</body>

</html>
