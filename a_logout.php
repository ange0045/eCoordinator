<?php
/*---------------------------------------------------------------------------------------------------/
           NAME: logout.php
    DESCRIPTION: Logs the user out slim
 ----------------------------------------------------------------------------------------------------*/
session_start();
session_destroy();
session_unset();
header("Location:f_login.php");
