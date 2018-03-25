<?php
/*---------------------------------------------------------------------------------------------------/
           NAME: a_saveStudentCourse.php
    DESCRIPTION: Saves the student course modal information
 ----------------------------------------------------------------------------------------------------*/
 include_once 'src/funcs.php';
 include_once 'src/constants.php';
 include_once 'src/entityClass.php';
 include_once 'src/dataAccessClass.php';
extract($_POST);
$dao = new DataAccessObject(INI_FILE_PATH);
session_start();

$dao->updateStudentCourse($fld_ID, $fld_Key, $fld_Grade, $fld_Comments);
header('Location: '.$_SESSION['preURLForms'].'#saveConfirmation');
