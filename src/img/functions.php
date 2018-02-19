<?php
/*---------------------------------------------------------------------------------------------------/
           NAME: functions.php
    DESCRIPTION: Stores all the functions needed
 ----------------------------------------------------------------------------------------------------*/

/*--------------------------------------------------------------/
 *              NEW USER FUNCTIONS (NewUser.php)
 *--------------------------------------------------------------*/
// Validate NewUser.php fields
function val_NewUser($f_title, $f_name) {
        $field  = $_POST[$f_name];
        if(empty($field)) {                                                     // Main validation to check if empty
            $errVal = "$f_title cannot be left empty";
            $_SESSION['errCheck'] = "err";
        }
        elseif($f_name == 'fldStudentId') {
            include 'conn.php';                                                 // Connects to DB and sets the query
            $results = mysqli_query($link, $q_CheckID);
            if(mysqli_num_rows($results) > 0) {                                 // If ID matches returns and error
                $errVal = "A student with this ID has already signed up.";
                $_SESSION['errCheck'] = "err";
            }
            mysql_close($link);                                                 // Always close connection!
        }
        elseif($f_name == 'fldPhone') {                                         // RegEx validation for phone number
            $expression= '/[2-9][0-9]{2}-[2-9][0-9]{2}-[0-9]{4}/';
            $validRegEx = (bool)preg_match($expression, $field);
            if(!$validRegEx){
                $errVal = "Phone number is not a recognised format";
                $_SESSION['errCheck'] = "err";
            }
        }
        elseif($f_name == 'fldPassword') {                                      // Password validation
            $upCase = preg_match('@[A-Z]@', $field);
            $loCase = preg_match('@[a-z]@', $field);
            $num    = preg_match('@[0-9]@', $field);

            if(!$upCase || !$loCase || !$num || strlen($field) < 6) {
                $errVal = "Password must contain 1 lower / 1 upper case and 1 number.";
                $_SESSION['errCheck'] = "err";
            }
        }
        elseif($f_name == 'fldPasswordRp') {                                    // Password repeat validation
            if($field != $_POST['fldPassword']) {
                $errVal = "Passwords do not match.";
                $_SESSION['errCheck'] = "err";
            }
        }
        else {
            $errVal = "";                                                       // If no errors found clears err variable
        }
        $_SESSION['ses_'.$f_name] = $field;                                     // Creates a new ses var to store value of field
        return $errVal;
}




/*--------------------------------------------------------------/
 *              LOGIN FUNCTIONS (Login.php)
 *--------------------------------------------------------------*/
// Checks to see if Student Id of Password are empty
function fn_EmptyVal($f_title, $f_name) {
        $field = $_POST[$f_name];
        if(empty($field)) {                                                     // Main validation to check if empty
            $errVal = "$f_title cannot be left empty";
            $_SESSION['ses_errCheck'] = "err";
        }
        $_SESSION['ses_'.$f_name] = $field;
        return $errVal;
}


/*--------------------------------------------------------------/
 *      PAGINATION FUNCTIONS
 *--------------------------------------------------------------*/
function funcPagination($table, $dao, $whereCondition) {       // Calculates total of items and creates a pagination navigation menu
    $total = $dao->countTable($table, $whereCondition);
    $limit = 100;
    $pages = ceil($total / $limit);
    $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
        'options' => array(
            'default'   => 1,
            'min_range' => 1,
        ),
    )));
    $offset = ($page - 1)  * $limit;
    if ($total == 0) {
        $start = 0;
        $end = 0;
    } else {
        $start = $offset + 1;
        $end = min(($offset + $limit), $total);
    }

    $prevlink = ($page > 1) ? '<a href="?page=1" title="First page" class="pageSymbols">&laquo;</a> <a href="?page=' . ($page - 1) . '" title="Previous page" class="pageSymbols">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';
    $nextlink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '" title="Next page" class="pageSymbols">&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page" class="pageSymbols">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';
    $htmlPagination = '<div id="paging" class="pageText"><p>'.$prevlink.' Page '.$page.' of '.$pages.' pages, displaying '.$start.'-'.$end.' of '.$total.' items '.$nextlink.' </p></div>';
    return array ($limit, $offset, $htmlPagination);
}




/*--------------------------------------------------------------/
 *                      HTML BUILDER
 *--------------------------------------------------------------*/

// -- Builds HTML structure to avoid duplicating HTML code.
// -- SYNTAX: htmlBuilder("Field Title", "FieldName", $arg , $FieldValue, "cc_readonly");
function htmlBuilderSmall($title, $fieldName, $args, $value, $cssClass, $fieldType)
{
echo <<<EOD
        <label class="form-control-label formLabel">$title</label>
        <div class="col-sm-2">
            <input id="$fieldName" name="$fieldName" type="$fieldType" class="form-control inputField $cssClass" $args value="$value" >
        </div>
EOD;
}
function htmlBuilder($title, $fieldName, $args, $value, $cssClass, $fieldType)
{
echo <<<EOD
        <label class="form-control-label formLabel">$title</label>
        <div class="col-sm-2">
            <input id="$fieldName" name="$fieldName" type="$fieldType" class="form-control inputField $cssClass" $args value="$value" >
        </div>
EOD;
}

function htmlBuilderMed($title, $fieldName, $args, $value, $cssClass, $fieldType)
{
echo <<<EOD
        <label class="col-sm-1 form-control-label formLabel">$title</label>
        <div class="col-sm-2">
            <input id="$fieldName" name="$fieldName" type="$fieldType" class="form-control inputField $cssClass" $args value="$value" >
        </div>
EOD;
}

function htmlBuilderMedLrg($title, $fieldName, $args, $value, $cssClass, $fieldType) 
{
echo <<<EOD
        <label class="col-sm-1 form-control-label formLabel">$title</label>
        <div class="col-sm-3">
            <input id="$fieldName" name="$fieldName" type="$fieldType" class="form-control inputField $cssClass" $args value="$value" >
        </div>
EOD;
}

function htmlBuilderSmWindow($title, $fieldName, $args, $value, $cssClass, $fieldType)
{
echo <<<EOD
        <label class="col-sm-3 form-control-label formLabel">$title</label>
        <div class="col-sm-7">
            <input id="$fieldName" name="$fieldName" type="$fieldType" class="form-control inputField $cssClass" $args value="$value" >
        </div>
EOD;
}

function htmlBuilderTreatRead($title, $fieldName, $args, $value, $cssClass, $fieldType)
{
echo <<<EOD
        <label class="col-sm-4 col-sm-offset-1 form-control-label formLabel">$title</label>
        <div class="col-sm-3">
            <input id="$fieldName" name="$fieldName" type="$fieldType" class="form-control inputField $cssClass" $args value="$value" >
        </div>
EOD;
}


function htmlBuilderBgField($title, $fieldName, $args, $value, $cssClass, $fieldType)
{
echo <<<EOD
        <label class="col-sm-3 form-control-label formLabel">$title</label>
        <div class="col-sm-4">
            <input id="$fieldName" name="$fieldName" type="$fieldType" class="form-control inputField $cssClass" $args value="$value" >
        </div>
EOD;
}

function htmlBuilderSmModal($title, $fieldName, $args, $value, $cssClass, $fieldType)
{
echo <<<EOD
        <label class="col-sm-2 form-control-label formLabel">$title</label>
        <div class="col-sm-6">
            <input id="$fieldName" name="$fieldName" type="$fieldType" class="form-control inputField $cssClass" $args value="$value" >
        </div>
EOD;
}

function htmlBuilderExtraSmall($title, $fieldName, $args, $value, $cssClass, $fieldType)
{
echo <<<EOD
        <label class="col-sm-2 form-control-label  vcenterFields">$title</label>
        <div class="col-sm-1 appPatientInfo">
            <input id="$fieldName" name="$fieldName" type="$fieldType" class="form-control inputField $cssClass appPatientInfo" $args value="$value" >
        </div>
EOD;
}

function htmlBuilderLogin($title, $fieldName, $args, $value, $cssClass, $fieldType)
{
echo <<<EOD
        <label class="col-sm-4 form-control-label formLabel">$title:</label>
        <div class="col-sm-4">
            <input id="$fieldName" name="$fieldName" type="$fieldType" class="form-control password inputField $cssClass" $args value="$value" >
        </div>
EOD;
}
