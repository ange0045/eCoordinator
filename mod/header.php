<?php
/*---------------------------------------------------------------------------------------------------/
           NAME: header.php
    DESCRIPTION: Main header for most of the application, head info, modals and messages
 ----------------------------------------------------------------------------------------------------*/
include_once 'src/funcs.php';
include_once 'src/constants.php';
include_once 'src/dataAccessClass.php';
include_once 'src/entityClass.php';
session_start();

// Checks to see if user is logged. If not forces user to go to login page.
if(!isset($_SESSION['ses_Name']) && ($_SERVER['PHP_SELF'] != '/eCoordinator/f_login.php' && $_SERVER['PHP_SELF'] != '/eCoordinator/f_newuser.php')) {
    echo "<script type='text/javascript'>document.location.href='/eCoordinator/f_login.php';</script>";
}
?>
<html>
    <head>
        <title>Algonquin College eCoordinator</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link href='src/img/tortkinglogo.ico' type='image/x-icon' rel='icon'/>
        <link href='src/css/style.css' rel='stylesheet'/>
        <link href='src/css/bootstrap.min.css' rel='stylesheet'/>
        <link href='src/css/main.css' rel='stylesheet'/>
        <link href='src/css/font-awesome.min.css' rel='stylesheet' >
        <script src='src/js/jquery.min.js'></script>
        <script src='src/js/bootstrap.min.js'></script>
        <script src='src/js/main.js'></script>
     </head>

     <header>
       <a href='http://www.algonquincollege.com'><img src='src/img/aclogoheader.png' style='height:4rem;' alt='Algonquin College' id='logo'/></a>
       <nav>
         <div class="menu-local-nav-container">
            <ul id="menu-local-nav" class="menu">
              <li id="menu-item-3393" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3393"><a href="index.php">Student Search</a></li>
              <li id="menu-item-3479" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3479"><a href="f_import.php">Import CSV</a></li>
              <li id="menu-item-3479" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3479"><a href="v_users.php">Users</a></li>
              <li id="menu-item-3479" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3479"><a href="f_courses.php">Courses</a></li>
            </ul>
          </div>
        </nav>


          <?php // Shows user info and logout option if user is logged in
          if (isset($_SESSION['ses_Name'])) {
            echo '<div class="col-sm-3 infoHeader" id="titleScan">';
                echo '<strong>Hi</strong> ' . $_SESSION['ses_Name'] . ' | ';
                echo '<button id="btnLogout" type="button" data-toggle="modal" data-target="#modalLogout" title="LOG OUT from eCoordinator">LOG OUT <i class="fa fa-sign-out fa-1x" aria-hidden="true"></i></button>';
            echo '</div>';
          }
          ?>

    </header>


    <body>
        <div id="wrapper">
       <div id="main" role="main">


<?php // ************************** MESSAGE CONFIRMATION ************************** ?>
          <div id="message">
              <div style="padding: 5px;">
                  <div class="alert alert-success" id="success-alert" hidden>
                      <button type="button" class="close" data-dismiss="alert">x</button>
                      <strong>Success! </strong> Item has been saved.
                  </div>
              </div>

              <div style="padding: 5px;">
                  <div class="alert alert-warning" id="delete-alert" hidden>
                      <button type="button" class="close" data-dismiss="alert">x</button>
                      <strong>Success! </strong> Item has been deleted.
                  </div>
              </div>
          </div><!-- /.message -->


<?php // ************************** DYNAMIC MODAL ************************** ?>
          <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
               <div class="modal-dialog">
                    <div class="modal-content">
                         <div class="modal-header">
                              <button type="button" class="modalClose" data-dismiss="modal" aria-hidden="true">X</button>
                              <div class="modal-title">
                                  <!--Logo here if needed-->
                              </div>
                         </div><!-- /.modal-header -->
                         <div class="modal-body">
                             <div id="modal-loader" style="display: none; text-align: center;">
                                  <img src="src/img/loader.gif">
                             </div>
                             <div id="dynamic-content"></div><!-- Form loads here -->
                          </div>
                   </div>
                </div>
          </div><!-- /.dynamic modal -->


<?php // ************************** LOGOUT CONFIRMATION MODAL ************************** ?>
          <div id="modalLogout" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header-conf">
                          <a href="#" data-dismiss="modal" class="close" aria-hidden="true"><i class="fa fa-times-circle"></i></a>
                      </div>
                      <div class="row modal-body-conf">
                          <div class="col-sm-2">
                              <i id="warningIcon" class="fa fa-exclamation-triangle fa-3x"></i>
                          </div>
                          <div class="logoutText col-sm-9">
                              <p>You are about to logout.<br>
                                  Do you want to proceed?</p>
                          </div>
                      </div>
                      <div class="modal-footer-conf">
                          <button type="button" class="btn btn-default btnLogoutConf" data-dismiss="modal">Cancel</button>
                          <button id="btnLogoutConf" type="button" class="btn btn-danger btnLogoutConf" onclick="logOutUser();">Logout</button>
                      </div>
                  </div>
              </div>
          </div><!-- /.logout modal -->
