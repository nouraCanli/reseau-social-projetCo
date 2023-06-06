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
  <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@800&display=swap" rel="stylesheet" />
  <title>Document</title>
</head>

<body class="bg-gray-900">
  <?php

  if (isset($_POST["email"])) {
    $new_email = $_POST["email"];
    $new_lastname = $_POST["lastname"];
    $new_firstname = $_POST["firstname"];
    $new_password = $_POST["password"];
    $new_repeat_password = $_POST["repeat_password"];

    if (isset($_FILES['avatar'])) {
      // Le chemin du fichier à uploader
      $tmpName = $_FILES['avatar']['tmp_name'];
      // Le nom du fichier à uploader
      $name = $_FILES['avatar']['name'];
      $size = $_FILES['avatar']['size'];
      $error = $_FILES['avatar']['error'];

      // explode() = split()  
      $tabExtension = explode('.', $name);
      $extension = strtolower(end($tabExtension));
      //Tableau des extensions que l'on accepte
      $extensions = ['jpg', 'png', 'jpeg', 'gif'];

      $maxSize = 4000000;

      if (in_array($extension, $extensions) && $size <= $maxSize && $error == 0) {
        // Pour cela on va utiliser la fonction PHP uniqid(). Elle attend 2 paramètres. Le premier est une chaîne de caractère qui servira de préfixe et le deuxième est un booléen (true / false) qui permets d’augmenter la taille de la chaîne générée pour plus de sécurité.
        $uniqueName = uniqid('', true);
        //uniqid génère quelque chose comme ca : 5f586bf96dcd38.73540086
        $file = $uniqueName . "." . $extension;
        // 2 paramètres : le chemin du fichier que l’on veut uploader et le chemin vers lequel on souhaite l’uploader.
        move_uploaded_file($tmpName, './avatars/' . $file);
      } else {
        $file = 'default.jpg';
        // echo "Une erreur est survenue";
      }
    }


    include "config.php";
    $mysqli = config();

    $new_email = $mysqli->real_escape_string($new_email);
    $new_lastname = $mysqli->real_escape_string($new_lastname);
    $new_firstname = $mysqli->real_escape_string($new_firstname);
    $new_password = $mysqli->real_escape_string($new_password);

    if ($new_password === $new_repeat_password) {
      $select = mysqli_query($mysqli, "SELECT * FROM users WHERE EMAIL= '" . $new_email . "'");
      if (mysqli_num_rows($select)) {
        exit("Ce nom d'utilisateur existe déjà");
      } else {
        $new_password = md5($new_password);

        $lInstructionSql = "INSERT INTO users(`ID`, `EMAIL`, `LASTNAME`, `FIRSTNAME`, `PASSWORD`, `AVATAR`)
        VALUES (NULL,"
          . "'" . $new_email . "',"
          . "'" . $new_lastname . "',"
          . "'" . $new_firstname . "',"
          . "'" . $new_password . "',"
          . "'./avatars/" . $file . "');";
        // . "NULL);";

        $ok = $mysqli->query($lInstructionSql);
        if (!$ok) {
          echo "Sorry. Registration failed." . $mysqli->error;
        } else {
          header("location:login.php");
          // echo "OK";
        }
      }
    } else {
      echo '<script type="text/javascript">alert("Passwords different"); </script>';
    }
  }



  ?>
  <div class="relative">
    <h1 class="mukta text-center text-transparent bg-clip-text bg-gradient-to-r from-purple-500 to-indigo-700 text-6xl fixed p-10 top-0 left-0 right-0 bg-gray-900">
      Touiter.
    </h1>
  </div>

  <div class="flex flex-col h-screen font-mono">
    <div class="w-full px-10 text-center m-auto sm:max-w-[450px]">
      <h1 class="text-gray-500 text-xl">Signup</h1>
      <form enctype="multipart/form-data" action="signup.php" method="post" class="flex flex-col text-gray-400">
        <input type="email" placeholder="Email" name="email" class="placeholder-gray-500 mt-5 rounded-xl h-14 bg-gray-900 border border-solid border-gray-700 text-sm p-5 focus:outline-none focus:border-purple-500" />

        <input type="text" placeholder="Lastname" name="lastname" class="placeholder-gray-500 mt-5 rounded-xl h-14 bg-gray-900 border border-solid border-gray-700 text-sm p-5 focus:outline-none focus:border-purple-500" />
        <input type="text" placeholder="Firstname" name="firstname" class="placeholder-gray-500 mt-5 rounded-xl h-14 bg-gray-900 border border-solid border-gray-700 text-sm p-5 focus:outline-none focus:border-purple-500" />
        <input type="password" placeholder="Password" name="password" class="placeholder-gray-500 mt-5 rounded-xl h-14 bg-gray-900 border border-solid border-gray-700 text-sm p-5 focus:outline-none focus:border-purple-500" />
        <input type="password" placeholder="Repeat Password" name="repeat_password" class="placeholder-gray-500 mt-5 rounded-xl h-14 bg-gray-900 border border-solid border-gray-700 text-sm p-5 focus:outline-none focus:border-purple-500" />

        <input type="file" name="avatar" class="block text-sm text-slate-500 mt-5 file:py-2 file:px-4 file:rounded-xl file:border file:border-solid file:border-gray-700 file:bg-gray-900 file:text-sm file:text-gray-400 hover:file:bg-violet-100" />
        <button type="submit" class="text-center text-gray-400 mt-5 rounded-xl h-14 focus:outline-none focus:border-purple-500 bg-gradient-to-r from-purple-500 to-indigo-700 transition-transform hover:scale-[1.03] duration-500 ease-out">
          Register
        </button>
      </form>
      <div class="mt-10"><p class="text-gray-500 text-sm">You're already registered ? <a href="./login.php">Signin</a></p></div>
    </div>
  </div>
</body>

</html>