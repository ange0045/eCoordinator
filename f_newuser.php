<?php
include 'mod/header.php';
session_start();
extract($_POST);
$dao = new DataAccessObject(INI_FILE_PATH); // Data Access Object - Creates conx with DB
if(isset($btnLogin)){
    unset($_SESSION['errCheck']); // errCheck should be empty if no errors are found
    $alertVar = ""; // alerVar is used to display confirmation message after submitting
    $sVal_Username      = val_NewUser('Username', 'fldUsername'); // Validate fields values and returns error message
    $sVal_FullName      = val_NewUser('Full Name', 'fldFullName');
    $sVal_Password      = val_NewUser('Password', 'fldPassword');
    $sVal_ConfPassword  = val_NewUser('Confirm Password', 'fldConfPassword');

    if(empty($_SESSION['errCheck'])){ // No errors found, adds user to db
        $_SESSION['ses_fldUsername'] = ""; // Clears form values
        $_SESSION['ses_fldFullName'] = "";
        $_SESSION['ses_fldPassword'] = "";
        $_SESSION['ses_fldConfPassword'] = "";
        $dao->addNewUser($fldUsername, $fldFullName, md5($fldPassword)); // Adds new user to database
        $alertVar = "User: <strong>$fldUsername</strong> added succesfully, please log in to continue. Redirecting you to login page.";
        echo "<script type='text/javascript'>setTimeout(function() {document.location.href='/eCoordinator/f_login.php'}, 5000);</script>"; // Redirects user to login after 5 secs
    }
}

?>
    <form id="form_new_user" method="post">
        <div class="login-cont offset-sm-3 col-sm-6">
            <h3><center><strong>eCoordinator</strong> Access Request</h3></center>
            <p class="centerLabel" style="color: black">Your access needs to be approved by the administrator</p>
             <p class="centerLabel" style="color: darkred">All fields are required</p>

            <?php
              func_alertBuilder($alertVar, 'Success');
              // SYNTAX: fieldBuilder([TYPE], [LABEL], [NAME & ID], [ARGUMENTS], [VALUE], [CSS], [VALUE TYPE], [LBL COLUMNS], [FLD COLUMNS], [LBL COLS OFFSET], [FLD COL OFFSET], [FLD OPTIONS], [ERROR MSG])
              func_fieldBuilder("TEXTFIELD", "Username", "fldUsername", "" , $fldUsername, "", "text", "col-sm-4", "col-sm-5", "", "", "", $sVal_Username);
              func_fieldBuilder("TEXTFIELD", "Full Name", "fldFullName", "" , $fldFullName, "", "text", "col-sm-4", "col-sm-5", "", "", "", $sVal_FullName);
              func_fieldBuilder("TEXTFIELD", "Password", "fldPassword", "" , $fldPassword, "", "password", "col-sm-4", "col-sm-5", "", "", "", $sVal_Password);
              func_fieldBuilder("TEXTFIELD", "Confirm Password", "fldConfPassword", "" , $fldConfPassword, "", "password", "col-sm-4", "col-sm-5", "", "", "", $sVal_ConfPassword);
              echo "<p class='centerLabel' style='color: darkblue'><a href='f_login.php'><u>Already have access? Login here</></a></p>";
              func_btnBuilder("Submit", "btnLogin", "btnGrey", "col-sm-2", "offset-sm-5");
            ?>

        </div>
    </form>

<?php include_once 'mod/footer.php' ?>
