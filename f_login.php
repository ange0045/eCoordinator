<?php
include 'mod/header.php';
session_start();
extract($_POST);
$_SESSION['ses_Username'] = '';
$_SESSION['ses_Password'] = '';
$msgLogin = ""; // Used to display login error message to user

if(isset($btnLogin)){
    $_SESSION['ses_User'] = array();                                            // ses_User object stores user specific info (access, name), starts as an empty array
    $fnVar_Username = fn_EmptyVal('Username', 'fldUsername');                   // fn_EmptyVal checks if fields are empty, if they are sends back err value
    $fnVar_Password = fn_EmptyVal('Password', 'fldPassword');

    if(empty($fnVar_Username) && empty($fnVar_Password))                       // If no error is found
    {
      $dao = new DataAccessObject(INI_FILE_PATH); // Data Access Object - Creates conx with DB
      $_SESSION['ses_Username'] = $fldUsername;
      $fnVar_User = $dao->getUserByUsernameAndPassword($fldUsername, md5($fldPassword));  // Function also checks if user has been approved
      $_SESSION['ses_User'] = $fnVar_User;
      $_SESSION['LAST_ACTIVITY'] = $curtime;
    }

    if(isset($fnVar_User)){
        if ($_SESSION['ses_User'] != '') {
            $_SESSION['ses_Name'] = $fnVar_User->getFullName();
            $_SESSION['ses_Access'] = $fnVar_User->getAccessType();
            echo "<script type='text/javascript'>document.location.href='/eCoordinator/index.php';</script>"; // Redirects user to index
        }
    } else {
        $msgLogin = "Incorrect Username/Password or access not yet approved";
    }
}

?>
    <form id="form_login" method="post">
        <div class="login-cont offset-sm-3 col-sm-6">
            <h3><center><strong>eCoordinator</strong> Access Request</h3></center>
            <p class="centerLabel" style="color: black">- Please <a href="/eCoordinator/f_newuser.php"><u>sign up</u></a> if you are a first time user -</p>
             <div class="alert alert-success fade show" role="alert"  <?php if($alertVar == ""){echo "hidden";} ?>>
              <?php echo $alertVar;?>
            </div>

            <?php
              func_alertBuilder($msgLogin, 'Danger');
              // SYNTAX: fieldBuilder([TYPE], [LABEL], [NAME & ID], [ARGUMENTS], [VALUE], [CSS], [VALUE TYPE], [LBL COLUMNS], [FLD COLUMNS], [LBL COLS OFFSET], [FLD COL OFFSET], [FLD OPTIONS], [ERROR MSG])
              func_fieldBuilder("TEXTFIELD", "Username", "fldUsername", "" , $fldUsername, "", "text", "col-sm-4", "col-sm-5", "", "", "", $fnVar_Username);
              func_fieldBuilder("TEXTFIELD", "Password", "fldPassword", "" , $fldPassword, "", "password", "col-sm-4", "col-sm-5", "", "", "", $fnVar_Password);

              func_btnBuilder("Submit", "btnLogin", "btnGrey", "col-sm-2", "offset-sm-5");
            ?>

        </div>
    </form>

<?php include_once 'mod/footer.php' ?>
