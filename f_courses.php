<?php
include 'mod/header.php';
session_start();
extract($_POST);
$dao = new DataAccessObject(INI_FILE_PATH); // Data Access Object - Creates conx with DB

$courses = $dao->getCourses();


if(isset($courseKey))
{
    $course = $dao->getCourseByKey($courseKey);
    $fldCourseName = $course->getName();
    $fldCourseKey = $course->getKey();
    $fldCourseLevel = $course->getLevel();
    $fldPassingGrade = $course->getPassGrade();
}

if(isset($btnSubmit)){
    unset($_SESSION['errCheck']); // errCheck should be empty if no errors are found
    $alertVar = ""; // alerVar is used to display confirmation message after submitting
    $sfldCourseName         = val_newCourse('Course Name', 'fldCourseName'); // Validate fields values and returns error message
    $sfldCourseKey          = val_newCourse('Course Code', 'fldCourseKey');
    $sfldCourseLevel        = val_newCourse('Course Level', 'fldCourseLevel');
    $sfldPassingGrade       = val_newCourse('Passing Grade', 'fldPassingGrade');
    
    $courseKey = $editCourseKey;

    if(empty($_SESSION['errCheck'])){ // No errors found, adds user to db
        print_r($dependencies);
        $dao->updateCourse($editCourseKey, $fldCourseName, $fldCourseKey, $fldCourseLevel, $fldPassingGrade, $dependencies);
        $fldCourseName = ""; // Clears form values
        $fldCourseKey = "";
        $fldCourseLevel = "";
        $fldPassingGrade = "";
        $alertVar = "Course <strong>$fldCourseKey</strong> updated succesfully.";
        unset($courseKey);
    }
}

?>
<form id="formSelectCourse" method="post">
    <div class="offset-sm-3 col-sm-6">
        <h3><center><strong>E-Coordinator</strong> Course Edit</center></h3>
        <select id="course" name="courseKey" onchange="this.form.submit()">                      
            <option value="0">--Select Course--</option>
            <?php 
                foreach($courses as $c){
                    $selected = "";
                    if ($c->getKey() == $courseKey)
                    {
                        $selected = "selected";
                    }
                    echo "<option value='{$c->getKey()}' $selected>$c</option>";
                }
            ?>
        </select>
        <a href="f_newcourse.php">Add New Course</a>
    </div>
</form>
<?php if(isset($alertVar)){ 
    func_alertBuilder($alertVar, 'Success');
}
?>
<?php if(isset($courseKey)) : ?>
<form id="formEditCourse" method="post">
    <input type="hidden" name="editCourseKey" value="<?php echo $courseKey ?>">
        <div class="offset-sm-2 col-sm-7">
        <h3><center>Edit Course</center></h3>
        <br>
            <?php
                
                func_fieldBuilder("TEXTFIELD", "Course Name", "fldCourseName", "" , $fldCourseName, "", "text", "col-sm-4", "col-sm-8", "", "", "", $sfldCourseName);
                func_fieldBuilder("TEXTFIELD", "Course Code", "fldCourseKey", "" , $fldCourseKey, "", "text", "col-sm-4", "col-sm-4", "", "", "", $sfldCourseKey);
                func_fieldBuilder("TEXTFIELD", "Course Level", "fldCourseLevel", "" , $fldCourseLevel, "", "text", "col-sm-4", "col-sm-4", "", "", "", $sfldCourseLevel);
                func_fieldBuilder("TEXTFIELD", "Passing Grade", "fldPassingGrade", "" , $fldPassingGrade, "", "text", "col-sm-4", "col-sm-4", "", "", "", $sfldPassingGrade);
            ?>
        </div>
        <div class="offset-sm-2">
            <label class="form-control-label formLabel">Dependencies?</label>
            <div class="offset-sm-3">
              <select name="dependencies[]" size="5" multiple="multiple" tabindex="1" style="width:350px;">
                  <?php 
                    foreach($courses as $c){
                        if($c->getKey() != $courseKey)
                        {
                            $selected = "";
                            if (in_array($c->getKey(), $course->getDependencies()))
                            {
                                $selected = "selected";
                            }
                            echo "<option value='{$c->getKey()}' $selected>$c</option>";
                        }
                    }
                  ?>
              </select>
            </div>
        </div>
        <div class="offset-sm-2 col-sm-7">
        <?php
            echo '<br>';
            func_btnBuilder("Update", "btnSubmit", "btnGrey", "col-sm-2", "offset-sm-5");
        ?>
        </div>
</form>
<?php endif; ?>
<?php include_once 'mod/footer.php' ?>
