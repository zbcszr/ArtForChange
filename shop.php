<!DOCTYPE html>
<html lang="en">
<?php
include("includes/init.php"); ?>


<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />

  <title>ArtForChange - Shope</title>

  <link rel="stylesheet" type="text/css" href="styles/site.css" media="all" />
</head>

<body>

  <?php include("includes/header.php");

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tag_name = $_POST['tag'];
    $delete_tags_name = $_POST['deletetag'];
    $add_tags = FALSE;
    $delet_tags = FALSE;

    if (!empty($tag_name)) {
      $show_tags = FALSE;
      $add_tags = TRUE;
      $show_tag_feedback = TRUE;
    }
    if(!empty($delete_tags_name)){
      $delet_tags = TRUE;
    }

    if ($add_tags) {
      $addtag = filter_var($tag_name, FILTER_SANITIZE_STRING);
      $artworkid = filter_var($_GET['addtag'], FILTER_SANITIZE_STRING);

      $params = array(
        ':artworkid' => $artworkid,
        ':addtag' => $addtag
      );
      $sql = "INSERT INTO tags(artwork_id, tag) VALUES (:artworkid,:addtag)";
      exec_sql_query($db, $sql, $params);
      echo '<h3>the tag has been <span class="text-highlight">added^-^</span></h3>';
    }
    if($delet_tags){
      $deletetag = filter_var($delete_tags_name, FILTER_SANITIZE_STRING);
      $artworkid = filter_var($_GET['deletetag'], FILTER_VALIDATE_INT);
      $params = array(
        ':artworkid' => $artworkid,
        ':deletetag' =>$deletetag,
      );
      $sql = "DELETE FROM tags WHERE tags.artwork_id = :artworkid AND tag = :deletetag";
      exec_sql_query($db, $sql, $params);
      echo '<h3>the tag has been <span class="text-highlight">deleted^-^</span></h3>';

    }
  }

  ?>

  <div id="showcase_shop"></div>

  <section id="purchase-info">
    <div class="container">
      <ul class="menu">
        <li><a href="shop.php">ALL</a></li>
        <?php
        $tags = exec_sql_query($db, "SELECT * FROM artworks INNER JOIN tags ON artworks.id = tags.artwork_id")->fetchAll(PDO::FETCH_ASSOC);
        if (count($tags) > 0) {
          foreach ($tags as $tag) {
            echo "<li><a href=" . build_http_shop($tag) . ">" . $tag["tag"] . "</a></li>";
          }
        }
        function build_http_shop($tag)
        {
          return ("shop.php?" . http_build_query(array('search' => strtolower($tag["tag"]))));
        }

        $moreinfo = $_GET['moreinfo'];
        if (!empty($moreinfo)) { //get moreinfo value
          $artworkdisplayed = filter_var($moreinfo, FILTER_SANITIZE_STRING);
          $params = array(
            ':moreinfo' => $moreinfo
          );
          $sql = "SELECT * FROM auctions INNER JOIN artworks on artworks.id = auctions.artwork_id WHERE (title LIKE '%' || :moreinfo || '%')";
          $moreinfodisplay = exec_sql_query($db, $sql, $params);
          if ($moreinfodisplay) {
            $records = $moreinfodisplay->fetchAll();
            if (count($records) > 0) {
              foreach ($records as $record) {
        ?>
                <img src="uploads/artwork/<?php echo $record['id']; ?>.jpg" alt="<?php echo $record['file_name']; ?>" />
              <?php
              }
            }
          }
          $params = array(
            ':moreinfodisplayed' => $moreinfo
          );
          $sql = "SELECT * FROM artworks inner join auctions on artworks.id = auctions.artwork_id INNER JOIN members ON members.id = artworks.member_id INNER JOIN tags ON tags.artwork_id=artworks.id WHERE (title = :moreinfodisplayed)";

          $art = exec_sql_query($db, $sql, $params);
          if ($art) {
            $records = $art->fetchAll();
            if (count($records) > 0) {
              foreach ($records as $record) {
                echo '<span class="text-highlight"> #'.$record['tag'].'</span>';
              ?>
                <h3><?php echo $record['title'] ?></h3>
                <p>This piece of art is done by <?php echo $record['first_name'] . " " . $record['last_name'] . ". He/She is a/an " . $record['bio'] . " and a funfact of him/her is " . $record['funfact'] . " The estimated value is " . $record['estimatedValue'] ?>
                </p>

              <?php
              } ?>
              <section id="add-tag-form">
                <div class="form-info">
                  <form id="addtag" method='post' action="shop.php?<?php echo http_build_query(array('addtag' => strtolower($record['id']))) ?>">
                    <h3>Add a <span class="text-highlight">tag </span> to this artwork!:)</h3>
                    <input type="text" name="tag" id="tag" value='enter here:)' ; />
                    <?php if ($show_tag_feedback) echo "<p>Tag cannot be empty:(</p>" ?>
                    <div class="input">
                      <input type="submit" value="submit" name="submit" />
                    </div>
                  </form>
                </div>
              </section>
              <section id="delete-tag-form">
                <div class="form-info">
                  <form id="delettag" method='post' action="shop.php?<?php echo http_build_query(array('deletetag' => strtolower($record['id']))) ?>">
                    <h3> <span class="text-highlight">OR</span> Delete a tag to this artwork:(</h3>
                    <input type="text" name="deletetag" id="deletetag" value='enter here:)' ; />
                    <div class="input">
                      <input type="submit" value="submit" name="submit" />
                    </div>
                  </form>
                </div>
              </section>

              <?php
            }
          }
        }

        $sticky_search = $_GET['search']; //get search value
        if (!empty($sticky_search)) {
          $params = array(
            ':search' => $sticky_search
          );
          echo " ";
          $sql = "SELECT * FROM artworks inner join auctions on artworks.id = auctions.artwork_id INNER JOIN members ON members.id = artworks.member_id INNER JOIN tags on artworks.id = tags.artwork_id WHERE tag = :search";

          $art = exec_sql_query($db, $sql, $params);
          if ($art) {
            $records = $art->fetchAll();
            if (count($records) > 0) {
              foreach ($records as $record) {
              ?>
                <img src="uploads/artwork/<?php echo $record['id']; ?>.jpg" alt="<?php echo $record['file_name']; ?>" />
                <h3><?php echo $record['title'] ?></h3>
                <p>This piece of art is done by <?php echo $record['first_name'] . " " . $record['last_name'] . ". He/She is a/an " . $record['bio'] . " and a funfact of him/her is " . $record['funfact'] . " The estimated value is " . $record['estimatedValue'] . "." ?> </p>

        <?php
              }
            }
          }
        }
        ?>
      </ul>

      <div class="container">
        <h3> Artwork currently <span class='text-highlight'> in</span> auction:</h3>

        <!-- <div class="image middle">
          <img src="../images/work1.jpg" alt="" />
          <div class="image-content">
            <h1>Image Title</h1>
            <a href="" class="icon1">❤️</a>
            <a href="" class="icon3">➕</a>
          </div>
        </div> -->
        <!-- <div class="image middle">
          <img src="./images/artwork4.jpg" alt="" />
          <div class="image-content">
            <h1>Paper</h1>
            <a href="" class="icon1">❤️</a>
            <a href="donation.php?purchase=Castle" class="icon2">💰</a>
            <a class="icon3" href="shop.php?tag=architechture" ?> ➕</a>
          </div>
        </div> -->
        <?php
        $records = exec_sql_query($db, "SELECT * FROM artworks INNER JOIN auctions on artworks.id = auctions.artwork_id WHERE auctions.availability = TRUE")->fetchAll(PDO::FETCH_ASSOC);
        $image_id = exec_sql_query($db, "SELECT id FROM artworks")->fetchAll(PDO::FETCH_COLUMN);


        if (count($records) > 0) {
          foreach ($records as $record) { ?>
            <div class="image middle">
              <img src="uploads/artwork/<?php echo $record['id']; ?>.jpg" alt="<?php echo $record['file_name']; ?>" />
              <div class="image-content">
                <h1><?php echo $record['title']; ?></h1>
                <a href="" class="icon1">❤️</a>
                <a href="donation.php?<?php echo http_build_query(array('purchase' => strtolower($record['title']))) ?>" class="icon2">💰</a>
                <a href="shop.php?<?php echo http_build_query(array('moreinfo' => strtolower($record['title']))) ?>" class="icon3">➕</a>
              </div>
            </div>
      </div>
  <?php }
        }
  ?>


  <h3> <span class='text-highlight'> Sold</span> artwork:</h3>
  <?php
  $records = exec_sql_query($db, "SELECT * FROM artworks INNER JOIN auctions on artworks.id = auctions.artwork_id WHERE auctions.availability = FALSE")->fetchAll(PDO::FETCH_ASSOC);
  $image_id = exec_sql_query($db, "SELECT id FROM artworks")->fetchAll(PDO::FETCH_COLUMN);

  if (count($records) > 0) {
    foreach ($records as $record) { ?>
      <div class="image middle">
        <img src="uploads/artwork/<?php echo $record['id']; ?>.jpg" alt="<?php echo $record['file_name']; ?>" />
        <div class="image-content">
          <h1><?php echo $record['title']; ?></h1>
          <a href="" class="icon1">❤️</a>
          <a href="shop.php?<?php echo http_build_query(array('moreinfo' => strtolower($record['title']))) ?>" class="icon3">➕</a>
        </div>
      </div>
    </div>
<?php }
  }
?>


</div>
</main>
<?php include("includes/footer.php") ?>

</body>

</html>
