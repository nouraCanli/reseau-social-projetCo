<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./css/index.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Mukta:wght@800&display=swap"
      rel="stylesheet"
    />
    <title>Touiter - Login</title>
  </head>

  <body class="bg-gray-900">
    <?php
    
    
    $enCoursDeTraitement = isset($_POST['email']);
    if ($enCoursDeTraitement) {
      $emailAVerifier = $_POST["email"];
      $passwordAVerifier = $_POST["password"];
      
      include "config.php";
      $mysqli=config();

      $emailAVerifier = $mysqli->real_escape_string($emailAVerifier);
      $passwordAVerifier = $mysqli->real_escape_string($passwordAVerifier);

      $passwordAVerifier=md5($passwordAVerifier);

      $lInstructionSql = "SELECT * "
      . "FROM users "
      . "WHERE "
      . "EMAIL LIKE '" . $emailAVerifier . "'"
      ;
      $res = $mysqli->query($lInstructionSql);
      $user = $res->fetch_assoc();
      if ( ! $user OR $user["PASSWORD"] != $passwordAVerifier)
      {
        echo '<script type="text/javascript">alert("connexion a échoué"); </script>';
                            
      } else
      {
        echo '<script type="text/javascript">alert("Succès"); </script>';
        $_SESSION['connected_id']=$user['ID'];
        echo $user["ID"];
        header("location:home.php");
          
      }
    }

    ?>
  
      <h1
        class="mukta text-center text-transparent bg-clip-text bg-gradient-to-r from-purple-500 to-indigo-700 text-6xl fixed p-10 top-0 left-0 right-0 bg-gray-900"
      >
        Touiter.
      </h1>

    <div class="flex flex-col h-screen font-mono">
      <div class="w-full px-10 text-center m-auto sm:max-w-[450px]">
        <h1 class="text-gray-500 text-xl">Login</h1>
        <form action="login.php" method="post" class="flex flex-col text-gray-400">
          <input
            type="email"
            placeholder="Email"
            name="email"
            class="placeholder-gray-500 mt-5 rounded-xl h-14 bg-gray-900 border border-solid border-gray-700 text-sm p-5 focus:outline-none focus:border-purple-500"
          />

          <input
            type="password"
            placeholder="Password"
            name="password"
            class="placeholder-gray-500 mt-5 rounded-xl h-14 bg-gray-900 border border-solid border-gray-700 text-sm p-5 focus:outline-none focus:border-purple-500"
          />
          <button
            type="submit"
            class="text-center text-gray-400 mt-5 rounded-xl h-14 focus:outline-none focus:border-purple-500 bg-gradient-to-r from-purple-500 to-indigo-700 transition-transform hover:scale-[1.03] duration-500 ease-out"
          >
            Signin
          </button>
        </form>
        <div class="mt-10"><p class="text-gray-500 text-sm">You're not yet registered ? <a href="./signup.php">Register</a></p></div>
      </div>
    </div>
  </body>
</html>
