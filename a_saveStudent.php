<?php
/*---------------------------------------------------------------------------------------------------/
           NAME: a_saveStudent.php
    DESCRIPTION: Saves the student modal information
 ----------------------------------------------------------------------------------------------------*/
 include_once 'src/funcs.php';
 include_once 'src/constants.php';
 include_once 'src/entityClass.php';
 include_once 'src/dataAccessClass.php';
extract($_POST);
$dao = new DataAccessObject(INI_FILE_PATH);
session_start();

$dao->updateStudent($fld_ID, $fld_Name, $fld_Type, $fld_Email);
header('Location: '.$_SESSION['preURLForms'].'#saveConfirmation');
