<?php
/*---------------------------------------------------------------------------------------------------/
           NAME: a_delete.php
    DESCRIPTION: Deletes records based on what type of record it is
 ----------------------------------------------------------------------------------------------------*/
 include_once 'src/funcs.php';
 include_once 'src/constants.php';
 include_once 'src/dataAccessClass.php';
 include_once 'src/entityClass.php';
session_start();
extract($_POST);    // Used to get value of all fields (all shown as $fld...)
$dao = new DataAccessObject(INI_FILE_PATH);     // Creates connection to the database

$deleteURL = $_GET['delete'];   // -- Gets it from the URL

if (isset($deleteURL))
{
    // -- DELETE: USER RECORDS
    if ($deleteURL == 'user') {
        if(isset($btndelYes) & isset($chk_UsrSel)){
            if (is_array($chk_UsrSel)) {
                foreach($chk_UsrSel as $user) {
                    $dao->deleteUser($user);
                }
            }
        }
        header("Location: v_users.php");
    }// . users
}
