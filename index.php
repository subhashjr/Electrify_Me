<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      overflow: hidden;
    }

    #video-background {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      object-fit: cover;
    }

    .content {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .adminn{
      display: flex;
      position: fixed;
      bottom: 20px;
      justify-content: center;
      align-items: center;
      text-decoration: underline;
      color: white;
      width: 100%;
    }
  </style>
  
  <title>Welcome Page</title>
</head>
<body>
  <video id="video-background" autoplay muted loop>
    <source src="video.mp4" type="video/mp4">
    Your browser does not support the video tag.
  </video>
  
  <div class="content">
    <h1 class="text-4xl font-bold mb-8" style="color: white;">Welcome!</h1>
    <div class="flex gap-4">
      <a href="index1.php" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded">
        Sign Up
      </a>
      <a href="login1.php" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded">
        Login
      </a>
    </div>
  </div>
  <div class="adminn">
    <a href="adminlogin1.php">Admin Login</a>
  </div>
</body>
</html>
