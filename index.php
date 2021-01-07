<?php
include("includes/init.php");
include("js.js"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" type="text/css" href="styles/site.css" />
  <meta name="description" content="welcome to ArtForChange">
  <meta name="keywords" content="non-profit student-run organization">
  <title>ArtForChange - Home</title>


</head>

<body>

  <head>
    <?php include("includes/header.php") ?>
    <div id="showcase">
      <div class="container">
        <div class="showcase-content">
          <h1>Welcome to <span class="text-highlight">ArtForChange</span> </h1>
          <p>AFC(ArtForChange) is a non-profit global organization committed to bring access to
            books for children whose family may not have the ability to purchase them. The organization
            raises
            its money by collecting local artworks (especially from high school students) and selling them
            at art
            fairs or online. People can keep track of the money earned from sales and the process of
            donation
            through email and our website.</p>
          <a herf="learn_about_us.php">LEARN ABOUT US</a>
        </div>

      </div>
    </div>
  </head>



  <div id="slider">
    <figure>
      <img src="images/artwork1.jpg" alt="artwork1">
      <!-- Source: Nancy Niu -->
      Source: <cite>Nancy Niu</cite>
      <img src="images/artwork2.jpg" alt="artwork2">
      <!-- Image Source: (original work) BIXIN ZHANG -->
      Source: <cite>Bixin Zhang</cite>
      <img src="images/artwork3.jpg" alt="artwork3">
      <!-- Source: David Zhang -->
      Source: <cite>David Zhang</cite>
      <img src="images/artwork4.jpg" alt="artwork4">
    </figure>
  </div>
  <!-- Source: Jessica Goodwill, Nancy Niu, Bixin Zhang, David Zhang -->
  Source: <cite>Jessica Goodwill, Nancy Niu, Bixin Zhang, and David Zhang</cite>

  <p>UPDATE on 2/12: We have raised xxx dollars. xxxx.xx dollars are been used in buying xxxx.</p>

  <?php include("includes/footer.php") ?>

</body>

</html>
