<?php
include("includes/init.php");

// const MAX_FILE_SIZE = 1000000;

//default values
//$show_application = TRUE;
$applicantFirstName = '';
$applicantLastName = '';
$applicantEmail = '';
$applicantReason = '';
$applicantYear = 0;
$applicantTime = 0;
$show_first_name_feedback = FALSE;
$show_last_name_feedback = FALSE;

$show_email_feedback = FALSE;
$show_reaason_feedback = FALSE;
$show_year_feedback = FALSE;
$show_time_feedback = FALSE;

//errorMessage default
$firstNameError = '';
$lastNameError = '';
$emailError = '';
$reasonError = '';
$yearError = '';
$timeError = '';
$peopleError = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $is_application_valid = TRUE;
    $applicantFirstName = trim($_POST['first_name']);
    $applicantLastName = trim($_POST['last_name']);
    $applicantEmail = trim($_POST['email']);
    $applicantReason = trim($_POST['reason']);
    $applicantYear = $_POST['year'];
    $applicantTime = $_POST['commitment'];


    $applicantFirstName = filter_var($applicantFirstName, FILTER_SANITIZE_STRING);
    $applicantLastName = filter_var($applicantLastName, FILTER_SANITIZE_STRING);
    $applicantEmail = filter_var($applicantEmail, FILTER_VALIDATE_EMAIL);
    $applicantYear = filter_var($applicantYear, FILTER_VALIDATE_INT);
    $applicantTime = filter_var($applicantTime, FILTER_VALIDATE_INT);
    $applicantReason = filter_var($applicantReason, FILTER_SANITIZE_STRING);

    //applicant name cannot be empty
    if (empty($applicantFirstName)) {
        $is_application_valid = FALSE;
        $show_first_name_feedback = TRUE;
        $firstNameError = 'Please enter your first name. First name cannot be empty';
    }

    if (empty($applicantLastName)) {
        $is_application_valid = FALSE;
        $show_last_name_feedback = TRUE;
        $lastNameError = 'Please enter your last name. Last name cannot be empty';
    }

    //email is in right form
    if (filter_var($applicantEmail, FILTER_VALIDATE_EMAIL)) {
        $is_application_valid = TRUE;
    } else {
        $is_application_valid = FALSE;
        $show_email_feedback = TRUE;
        $nameError = 'Please enter a correct form of email.';
    }

    //reason cannot be empty
    if (empty($applicantReason)) {
        $is_application_valid = FALSE;
        $show_reason_feedback = TRUE;
        $reasonError = 'Please enter your reason to join ArtForChange.';
    }

    if ($applicantYear == 0) {
        $is_application_valid = FALSE;
        $show_year_feedback = TRUE;
        $yearError = "Please select a class year from 1876 to 2024.";
    }

    if ($applicantTime == 0) {
        $is_application_valid = FALSE;
        $show_time_feedback = TRUE;
        $timeError = "Please select the number of hours you plan to commit each week on average. The time estimate cannot be 0.";
    }

    if (!isset($_POST['people'])) {
        $peopleError = "no radio buttons were checked.";
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>ArtForChange - Join</title>

    <link rel="stylesheet" type="text/css" href="styles/site.css" media="all" />
</head>
<?php include("includes/header.php") ?>


<body>
    <main>
        <section id="application-form">
            <div class="container">
                <h1>Becoming A <span class='text-highlight'>member:</span> </h1>
                <?php if (!$is_application_valid) { ?>

                    <p>Fill out this form to be a volunteer! We will reach you through email!</p>
                    <form id="joinAFC" method="post" action="join.php" enctype="multipart/form-data" >

                        <div class="form-info">
                            <label for="first_name_field">First Name</label>
                            <input type="text" name="first_name" id="first_name" value='<?php echo $applicantFirstName ?>'>
                        </div>
                        <?php print $firstNameError ?>

                        <div class="form-info">
                            <label for="last_name_field">Last Name</label>
                            <input type="text" name="last_name" id="last_name" value='<?php echo $applicantLastName ?>'>
                        </div>
                        <?php print $lastNameError ?>

                        <div class="form-info">
                            <label for="email_field">Email </label>
                            <input type="text" name="email" id="email" value="<?php echo $applicantEmail ?>">
                        </div>
                        <?php print $emailError; ?>


                        <div class="form-info">
                            <label for="year_input">Class Year:</label>
                            <input type="number" id="year_input" name="year" min="2020" max="2024" value="<?php echo $applicantYear; ?>" />
                        </div>
                        <?php print $yearError; ?>


                        <div class="form-info">
                            <label for="commitment_input">Weekly commitment expected in hours:</label>
                            <input type="number" id="commitment_input" name="commitment" min="1" max="5" value="<?php echo $applicantTime; ?>" />
                        </div>
                        <?php print $timeError; ?>


                        <div class="form-button">
                            <input type="radio" id="people1" name="people" value="donor">
                            <label for="people1">Donor</label>
                            <input type="radio" id="people2" name="people" value="artist">
                            <label for="people2">Artist</label>
                            <input type="radio" id="people3" name="people" value="volunteer">
                            <label for="people3">Volunteers</label>
                        </div>
                        <?php print $peopleError; ?>

                        <div class="form-info">
                            <label for="reason_field">Why do you want to join?</label>
                            <textarea type="text" name="reason" id="reason" value="<?php echo $applicantReason; ?>"></textarea>
                        </div>
                        <?php print $reasonError; ?>

                        <!-- <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />
                        <div class="form-info">
                            <label for="box_file">A Picture of Yourself</label>
                            <input id="box_file" type="file" name="box_file">
                        </div> -->

                        <div class="label_input">
                            <input type="submit" value="join" name="submit" />
                        </div>

            </div>
            </form>

        <?php } else { ?>
            <?php
                    $applicantFirstName = htmlspecialchars($applicantFirstName);
                    $applicantLastName = htmlspecialchars($applicantLastName);
                    $applicantEmail = htmlspecialchars($applicantEmail);
                    $applicantReason = htmlspecialchars($applicantReason);
                    $applicantYear = htmlspecialchars($applicantYear);
                    $applicantTime = htmlspecialchars($applicantTime);

            ?>
            <h3>Application Confirmation for <?php print $applicantFristName. " " . $applicantLastName ?></h3>

            <p> Your email is <?php print $applicantEmail ?>. Your class year is <?php print $applicantYear ?>. You are expecting commitment <?php print $applicantTime ?> hour(s) per week. Your reason to join is <?php print $applicantReason?>. Your Application is been processed now. We hope to see you soon:)
            </p>
            <p><a href="join.php">New Application</a></p>
        <?php } ?>
    </main>
    <?php include("includes/footer.php") ?>
</body>

</html>
