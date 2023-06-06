<?php
session_start();
if (isset($_SESSION["connected_id"])) {
  $userId = intval($_SESSION["connected_id"]);
} else {
  header("location:login.php");
  exit();
}
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
  <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@800&display=swap" rel="stylesheet" />
  <title>Touite - Home</title>
</head>

<body class="bg-gray-900">
  <?php

  include "config.php";
  $mysqli = config();

  $fetchUser = "SELECT * FROM users WHERE ID = '$userId' ";
  $lesInformations = $mysqli->query($fetchUser);
  $user = $lesInformations->fetch_assoc();


  if (isset($_POST['message'])) {

    $postContent = $_POST['message'];
    $postContent = $mysqli->real_escape_string($postContent);

    $lInstructionSql = "INSERT INTO messages "

      . "(ID, ID_USER, CONTENT, CREATED_AT ) "
      . "VALUES (NULL, "
      . $userId . ", "
      . "'" . $postContent . "', "
      . "NOW());";

    $ok = $mysqli->query($lInstructionSql);
    if (!$ok) {
      echo "Impossible d'ajouter le message: " . $mysqli->error;
    } else {
      echo "Message posté";
    }
  }

  $fetchData = "
  SELECT * FROM messages
  JOIN users ON users.ID = messages.ID_USER
  ORDER BY messages.CREATED_AT DESC
  ";


  ?>
  <header class="flex justify-between px-10 py-5 border-b-[1px] border-b-gray-700">
    <h1 class="mukta text-transparent bg-clip-text bg-gradient-to-r from-purple-500 to-indigo-700 text-3xl bg-gray-900">
      Touiter.
    </h1>

    <div>
      <button class="text-center text-gray-400 px-5 h-10 mr-5 rounded-xl focus:outline-none focus:border-purple-500 border-[1px] border-purple-500 transition-transform hover:scale-[1.03] duration-500 ease-out">
        Edit profil
      </button>
      <a href="logout.php"><button class="text-center text-gray-400 px-5 h-10 rounded-xl border-[1px] border-purple-500 focus:outline-none focus:border-purple-500 transition-transform hover:scale-[1.03] duration-500 ease-out">
          Logout
        </button></a>
    </div>
  </header>

  <div class="flex flex-col items-center m-10 font-mono mx-auto px-10 sm:max-w-3xl">
    <img class="rounded-full w-20 h-20 object-cover" src="<?php echo $user["AVATAR"] ?>" alt="" />
    <p class="text-xl mt-5">
      <span class="text-gray-500">Welcome</span>
      <span class="text-gray-200"><?php echo $user["LASTNAME"] ?></span>
      <span class="text-gray-200"><?php echo $user["FIRSTNAME"] ?></span>
    </p>
    <form action="home.php" method="post" class="w-full m-5 text-gray-400">
      <textarea name="message" class="w-full placeholder-gray-700 mt-5 rounded-xl h-60 bg-gray-900 border border-solid border-gray-700 text-sm p-5 focus:outline-none focus:border-purple-500"></textarea>
      <div class="flex justify-between mt-5">
        <input type="file" name="picture" class="block text-sm text-slate-500 file:py-2 file:px-4 file:rounded-xl file:border file:border-solid file:border-gray-700 file:bg-gray-900 file:text-sm file:text-gray-400 hover:file:bg-violet-100" />
        <button type="submit" class="text-center text-gray-400 px-5 rounded-xl h-10 focus:outline-none focus:border-purple-500 bg-gradient-to-r from-purple-500 to-indigo-700 transition-transform hover:scale-[1.03] duration-500 ease-out">
          Touit
        </button>
      </div>
    </form>
  </div>
  <?php
  $lesInformations = $mysqli->query($fetchData);
  if (!$lesInformations) {
    echo ("Échec de la requete : " . $mysqli->error);
  }
  while ($post = $lesInformations->fetch_assoc()) {

    // echo "<pre>" . print_r($post, 1) . "</pre>";
  ?>
    <div class="message flex flex-col justify-between mx-auto px-10 text-gray-400 text-sm font-mono sm:max-w-3xl">
      <div class="border-[0.5px] border-solid border-gray-700"></div>

      <div class="flex mt-10">

        <img class="rounded-full w-10 h-10 object-cover" src="<?php echo $post["AVATAR"] ?>" alt="" />


        <div class="text ml-5">
          <p class="text-lg">
            <span class="text-gray-200"><?php echo $post["LASTNAME"] ?></span>
            <span class="text-gray-200"><?php echo $post["FIRSTNAME"] ?></span>
            <span class="text-gray-500"><?php echo $post["CREATED_AT"] ?></span>
          </p>
          <p class="mt-5">
            <?php echo $post["CONTENT"] ?>
          </p>
          <div class="icons flex mb-10">
            <div class="icon-message flex w-6 mt-5">
              <img src="./img/icon-message.svg" alt="" />
              <p class="ml-2">20</p>
            </div>
            <div class="icon-heart flex w-6 mt-5 ml-12">
              <img src="./img/icon-heart.svg" alt="" />
              <p class="ml-2">20</p>
            </div>
          </div>
        </div>
      </div>
    </div>

  <?php } ?>
</body>

</html>