<?php
include("includes/init.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>ArtForChange - Donation</title>

    <link rel="stylesheet" type="text/css" href="styles/site.css" media="all" />
</head>

<body>
    <?php include("includes/header.php");


    const MAX_FILE_SIZE = 1000000;

    $auctionName = '';
    $artworkNameBuy = '';
    $donationAmount = 0;

    $artistName = '';
    $artworkNameDonate = '';
    $expectedAmount = 0;

    $auctionNameError = '';
    $artworkNameBuyError = '';
    $donationAmountError = '';
    $artistNameError = '';
    $artworkNameDonateError = '';
    $expectedAmountError = '';


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $is_application_valid = TRUE;
        $auctionName = trim($_POST['name']);
        $artistName = trim($_POST['artisname']);
        $artworkNameBuy = trim($_POST['artwork-name']);
        $donationAmount = $_POST['donation_amout'];
        $artworkNameDonate = $_POST['artname'];
        $expectedAmount = $_POST['expected_amount'];

        $auctionName = filter_var($auctionName, FILTER_SANITIZE_STRING);
        $artistName = filter_var($artistName, FILTER_SANITIZE_STRING);
        $artworkNameBuy = filter_var($artworkNameBuy, FILTER_SANITIZE_STRING);
        $donationAmount = filter_var($donationAmount, FILTER_VALIDATE_INT);
        $artworkNameDonate = filter_var($artworkNameDonate, FILTER_SANITIZE_STRING);
        $expectedAmount = filter_var($expectedAmount, FILTER_VALIDATE_INT);
        $sticky_purchase = $_GET['purchase'];

    }

    $sticky_purchase = $_GET['purchase'];

    if (!empty($sticky_purchase)) {
        $artworkNameBuy = filter_var($sticky_purchase, FILTER_SANITIZE_STRING);
    }

    if(!empty($auctionName)){
        $params = array(
            ':artworkNameBuy' => $artworkNameBuy,
        );
        $sql = "DELETE FROM artworks where title = :artworkNameBuy";
        exec_sql_query($db, $sql, $params);

    }

    if (isset($_POST["submit"])) {

        if (!empty($auctionName)) {
            // $records = exec_sql_query($db, "SELECT * FROM artworks INNER JOIN auctions on artworks.id = auctions.artwork_id WHERE auctions.availability = FALSE")->fetchAll(PDO::FETCH_ASSOC);
            $artwork = exec_sql_query($db, "SELECT artworks.id FROM artworks where artworks.title = $artworkNameBuy")->fetchAll(PDO::FETCH_ASSOC);
            $artwork_id = $artwork['id'];
            $sql = "UPDATE auctions SET availability = FALSE WHERE auctions.artwork_id = $artwork_id; ";
            exec_sql_query($db, $sql);
        }
        if ($_FILES['loadfile']['error'] == UPLOAD_ERR_OK) {
            $upload_info = $_FILES["loadfile"]; //accessing uploaded files
            $targetDir = "uploads/artwork/";
            $fileName = basename($upload_info['name']);
            $upload_ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));


            $artworkNameDonate = filter_var($artworkNameDonate, FILTER_SANITIZE_STRING);

            // if uploaded successfully

            $sql = "INSERT INTO artworks (file_name, file_ext, title) VALUES (:name,:type, :title) ";
            $params = array(
                ":name" => $fileName,
                ":type" => $upload_ext,
                ":title" => $artworkNameDonate,
            );
            exec_sql_query($db, $sql, $params);

            $id = $db->lastInsertId("id");
            $file_ext = $db->lastINSERTID("file_ext");
            $new_path = $targetDir . $id . "." . $upload_ext;
            move_uploaded_file($_FILES["loadfile"]["tmp_name"], $new_path);
        }
    }


    ?>

    <main>
        <h2>Donate <span class="text-highlight">Art works </span> or <span class="text-highlight"> Money</span></h2>
        <div id="showcase_donation"></div>

        <div class="container">
            <section id="donation-form">

                <?php if (!$is_application_valid) { ?>
                    <div class="form-info">

                        <form id="moneyDonation" method='post' action="donation.php">
                            <h3>Pealse fill out this form to make <span class="text-highlight">money </span> donation!</h3>

                            <label for="name">Your Name</label>
                            <input type="text" name="name" id="name" value='<?php echo $auctionName ?>' ; />


                            <label for="artwork-name">Artwork name you wish to purchase</label>
                            <input type="text" name="artwork-name" id="artwork-name" value='<?php echo $artworkNameBuy ?>' ; />


                            <label for="donation_amout">Please enter or select your donation amount:</label>
                            <input type="number" id="donation_amount" name="donation_amount" min="1" max="1000" value='<?php echo $donationAmount ?>' ; />


                            <p>Click "purchase" to enter the auction!:)</p>
                            <div class="input">
                                <input type="submit" value="purchase" name="purchase" />

                            </div>
                    </div>
                    </form>

                    <div class="artwork-info">
                        <form id="artwork-donation" enctype="multipart/form-data" method='post' action="donation.php">

                            <h3>Pealse fill out this form to make an <span class="text-highlight"> artwork </span> donation!</h3>
                            <label for="artistname">Artist Name</label>
                            <input type="text" name="artistname" id="name" value='<?php echo $artistName ?>' ; />

                            <label for="artname">Artwork's name</label>
                            <input type="text" name="artname" id="name" value='<?php echo $artworkNameDonate ?>' ; />

                            <label for="expected_amount">Please enter or select your expecting price :</label>
                            <input type="number" id="expected_amount" name="expected_amount" min="1" max="1000" value='<?php echo $expectedAmount ?>' ; />


                            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />
                            <label for="loadfile">Upload File:</label>
                            <input id="loadfile" type="file" name="loadfile">
                            <p>Click "submit" to donate artwork!:)</p>
                            <div class="input">
                                <input type="submit" value="submit" name="submit" />

                            </div>

                    </div>
        </div>


        </div>
        </section>
        </div>

    <?php } else { ?>
        <h3>Confirmation</h3>
        <p> Thanks for your donation!:)
        </p>

        <h2>Current Artworks</h2>
        <ul>
            <?php
                    $records = exec_sql_query($db, "SELECT * FROM artworks")->fetchAll(PDO::FETCH_ASSOC);
                    $image_id = exec_sql_query($db, "SELECT artwork_id FROM auctions INNER JOIN artworks on artwork_id=artworks.id WHERE availability = TRUE")->fetchAll(PDO::FETCH_COLUMN);

                    if (count($records) > 0) {
                        foreach ($records as $record) {
                            echo "<li><a href=\"uploads/artwork/" . $record["id"] . "." . $record["file_ext"] . "\">" . htmlspecialchars($record["file_name"]) . "</a> - " .  "</li>";
            ?>
                    <div class=art_gallary>
                        <a href="donation.php?<?php echo http_build_query(array('search' => $image_id)); ?>">
                            <figure>
                                <div class="image middle">

                                    <img src="uploads/artwork/<?php echo $record['id']; ?>.jpg" alt="<?php echo $record['file_name']; ?>" />
                                    <?php echo ucfirst("#" . $record['title']); ?>

                                </div>
                                <figcaption>
                                </figcaption>
                            </figure>
                    </div><?php
                        }
                    } ?>
            <?php $records = exec_sql_query($db, "SELECT * FROM artworks")->fetchAll(PDO::FETCH_ASSOC);
                    function gallery_element($record)
                    { ?>
                <a href="donation.php?<?php

                                        echo http_build_query(array('search' => strtolower($record['file_name']))); ?>">
                    <figure>
                        <img src="uploads/<?php echo $record['id']; ?>.jpg" alt="<?php echo $record['file_name']; ?>" />
                        <figcaption><?php echo ucfirst($record['title']); ?></figcaption>
                    </figure>
                </a>
            <?php
                    }
            ?>
        </ul>


    <?php } ?>
    </main>


    <?php include("includes/footer.php") ?>

</body>

</html>
