<?php
/*---------------------------------------------------------------------------------------------------/
           NAME: funcs.php
    DESCRIPTION: Stores all the functions needed
 ----------------------------------------------------------------------------------------------------*/

/*--------------------------------------------------------------/
 *              NEW USER FUNCTIONS (NewUser.php)
 *--------------------------------------------------------------*/
// Validates newUser.php fields
function val_NewUser($f_title, $f_name) {
        $field  = $_POST[$f_name];
        if(empty($field)) { // Main validation to check if empty
            $errVal = "$f_title cannot be left empty";
            $_SESSION['errCheck'] = "err";
        }
        elseif($f_name == 'fldPassword') {  // Password validation
            $upCase = preg_match('@[A-Z]@', $field);
            $loCase = preg_match('@[a-z]@', $field);
            $num    = preg_match('@[0-9]@', $field);

            if(!$upCase || !$loCase || !$num || strlen($field) < 6) {
                $errVal = "Password must contain 1 lower / 1 upper case and 1 number.";
                $_SESSION['errCheck'] = "err";
            }
        }
        elseif($f_name == 'fldConfPassword') {  // Password repeat validation
            if($field != $_POST['fldPassword']) {
                $errVal = "Passwords do not match.";
                $_SESSION['errCheck'] = "err";
            }
        }
        else {
            $errVal = ""; // If no errors found clears err variable
        }
        $_SESSION['ses_'.$f_name] = $field; // Creates a new ses var to store value of field
        return $errVal;
}



/*--------------------------------------------------------------/
 *              LOGIN FUNCTIONS (login.php)
 *--------------------------------------------------------------*/
// Checks to see if Student Id of Password are empty
function fn_EmptyVal($f_title, $f_name) {
        $field = $_POST[$f_name];
        if(empty($field)) { // Main validation to check if empty
            $errVal = "$f_title cannot be left empty";
            $_SESSION['ses_errCheck'] = "err";
        }
        $_SESSION['ses_'.$f_name] = $field;
        return $errVal;
}


/*--------------------------------------------------------------/
 *                      HTML BUILDERS
 *--------------------------------------------------------------*/
// -- Builds HTML structure to avoid duplicating HTML code.


// SYNTAX: fieldBuilder([TYPE], [LABEL], [NAME & ID], [ARGUMENTS], [VALUE], [CSS], [VALUE TYPE], [LBL COLUMNS], [FLD COLUMNS], [LBL COLS OFFSET], [FLD COL OFFSET], [FLD OPTIONS], [ERROR MSG])
function func_fieldBuilder($fld_type, $fld_title, $fld_name, $fld_arg, $fld_value, $fld_css, $fld_valtype, $fld_lblcols, $fld_cols, $fld_lbloffset, $fld_offset, $fld_options, $fld_err)
{
if ($fld_type == 'TEXTFIELD') {
echo <<<EOD
    <div class="row vcenter">
      <label class="form-control-label formLabel $fld_lblcols $fld_lbloffset">$fld_title:</label>
      <div class="$fld_cols $fld_offset">
          <input id="$fld_name" name="$fld_name" type="$fld_valtype" class="form-control inputField $fld_css" $fld_arg value="$fld_value" >
          <span class='cc_error_msg'>$fld_err</span>
      </div>
    </div>
EOD;
  } //.TEXTFIELD END

elseif ($fld_type == 'SELECTFIELD'){
echo <<<EOD
    <div class="row vcenter">
      <label class="form-control-label formLabel $fld_lblcols $fld_lbloffset">$fld_title:</label>
      <div class="$fld_cols $fld_offset">
        <select id="$fld_name" name="$fld_name" class="form-control inputField $fld_css" $fld_arg>
            <option value='0'></option>
EOD;
            foreach($fld_options as $sel_option) {
              if ($fld_value == $sel_option) {
                echo "<option selected value='$sel_option'>$sel_option</option>";
              } else {
                echo "<option value='$sel_option'>$sel_option</option>";
              }
            }
echo <<<EOD
        </select>
        <span class='cc_error_msg'>$fld_err</span>
      </div>
    </div>
EOD;
  }//.SELECTFIELD END    
}//.func_fieldBuilder END



function func_btnBuilder($btn_title, $btn_name, $btn_css, $btn_cols, $btn_offset)
{
echo <<<EOD
  <div class="$btn_cols $btn_offset">
      <button id="$btn_name" value="$btn_name" name="$btn_name" class="btn btn-primary $btn_css">$btn_title</button>
  </div>
EOD;
}//.func_btnBuilder END



function func_alertBuilder($alertVar, $alertType)
{
if($alertVar == "") {
  $var_alertHide = "hidden";
} else {
  $var_alertHide = "";
}

if($alertType == "Success") {
  echo "<div class='alert alert-success fade show' role='alert' $var_alertHide>$alertVar</div>";
}
elseif ($alertType == "Danger") {
  echo "<div class='alert alert-danger fade show' role='alert' $var_alertHide>$alertVar</div>";
}

}//.func_alertBuilder END



function func_fieldErrBuilder($sVal)
{
echo "<div class='col-sm-4 vcenter'>";
    echo "<span class='cc_error_msg'>$sVal</span>";
echo "</div>";
}//.func_fieldErrBuilder END


/*--------------------------------------------------------------/
 *              VALIDATION NEW COURSE FUNCTION
 *--------------------------------------------------------------*/
// Checks if any of your fields are empty and generates error messages

function val_newCourse($f_title, $f_name) {
        $field  = $_POST[$f_name];
        if(empty($field)) { // Main validation to check if empty
            $errVal = "$f_title cannot be left empty";
            $_SESSION['errCheck'] = "err";
        }
        elseif($f_name == 'fldCourseKey') {  // Course Code Validation (3 letters, 4 numbers)
            $code = preg_match('/^\w{3}\d{4}/', $field);

            if(!$code) {
                $errVal = "Course code must contain 3 letters followed by 4 numbers.";
                $_SESSION['errCheck'] = "err";
            }
        }
        elseif ($f_name == 'fldCourseLevel') {
            $level = preg_match('/^[1-4]$/', $field);
            
            if(!$level) {
                $errVal = "Course level must be between 1 and 4.";
                $_SESSION['errCheck'] = "err";
            }  
        }
        else {
            $errVal = ""; // If no errors found clears err variable
        }
        $_SESSION['ses_'.$f_name] = $field; // Creates a new ses var to store value of field
        return $errVal;
}

/*--------------------------------------------------------------/
 *              VALIDATION SEARCH FUNCTION
 *--------------------------------------------------------------*/
// Checks if any of your fields are empty and generates error messages

function val_Search($f_title, $f_name) {
        $field  = $_POST[$f_name];
        if(empty($field)) { // Main validation to check if empty
            $errVal = "$f_title cannot be left empty";
            $_SESSION['errCheck'] = "err";
        }
        else {
            $errVal = ""; // If no errors found clears err variable
        }
    $_SESSION['ses_'.$f_name] = $field; // Creates a new ses var to store value of field
        return $errVal;
}
