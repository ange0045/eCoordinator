<?php
include 'mod/header.php';
session_start();
extract($_POST);
$dao = new DataAccessObject(INI_FILE_PATH); // Data Access Object - Creates conx with DB

$courses = $dao->getCourses();
$editingCourse = isset($courseKey) && !empty($courseKey);

if ($editingCourse) {
    $course = $dao->getCourseByKey($courseKey);
    $fldCourseName = $course->getName();
    $fldCourseKey = $course->getKey();
    $fldCourseLevel = $course->getLevel();
    $fldPassingGrade = $course->getPassGrade();
}

if (isset($btnSubmit)) {
    unset($_SESSION['errCheck']); // errCheck should be empty if no errors are found
    $alertVar = ""; // alerVar is used to display confirmation message after submitting
    $sfldCourseKey = val_newCourse('Course Code', 'fldCourseKey');
    $sfldCourseLevel = val_newCourse('Course Level', 'fldCourseLevel');
    $sfldPassingGrade = val_newCourse('Passing Grade', 'fldPassingGrade');

    $courseKey = $editCourseKey;

    if (empty($_SESSION['errCheck'])) { // No errors found, adds user to db
        $dao->updateCourse($editCourseKey, $fldCourseName, $fldCourseKey, $fldCourseLevel, $fldPassingGrade, $dependencies);
        $fldCourseName = ""; // Clears form values
        $fldCourseKey = "";
        $fldCourseLevel = "";
        $fldPassingGrade = "";
        $alertVar = "Course <strong>$fldCourseKey</strong> updated succesfully.";
        unset($courseKey);
    }
    else {
        $editingCourse = true;
    }
}
?>
<div class="row">
    <div class="offset-sm-2 col-sm-7">
        <form id="formSelectCourse" method="post">
            <h3><center><strong>E-Coordinator</strong> Course Edit</center></h3>
            <select id="course" name="courseKey" onchange="this.form.submit()" class="form-control">                      
                <option value="0">--Select Course--</option>
                <?php
                foreach ($courses as $c) {
                    $selected = "";
                    if ($c->getKey() == $courseKey) {
                        $selected = "selected";
                    }
                    echo "<option value='{$c->getKey()}' $selected>$c</option>";
                }
                ?>
            </select>
            <label class="form-control-label formLabel form-inline pull-right"><a href="f_newcourse.php"><icon class="fa fa-plus"></icon>Add New Course</a></label>
        </form>
    </div>
</div>
<?php
if (isset($alertVar)) {
    func_alertBuilder($alertVar, 'Success');
}
?>
<?php if ($editingCourse) : ?>
<div class="row">
    <div class="offset-sm-2 col-sm-7">
        <form id="formEditCourse" method="post">
            <input type="hidden" name="editCourseKey" value="<?php echo $courseKey ?>">
            <h3><center>Edit Course</center></h3>
            <br>
            <?php
            func_fieldBuilder("TEXTFIELD", "Course Name", "fldCourseName", "", $fldCourseName, "", "text", "col-sm-4", "col-sm-8", "", "", "", "");
            func_fieldBuilder("TEXTFIELD", "Course Code", "fldCourseKey", "readonly", $fldCourseKey, "", "text", "col-sm-4", "col-sm-8", "", "", "", $sfldCourseKey);
            func_fieldBuilder("TEXTFIELD", "Course Level", "fldCourseLevel", "", $fldCourseLevel, "", "text", "col-sm-4", "col-sm-8", "", "", "", $sfldCourseLevel);
            func_fieldBuilder("TEXTFIELD", "Passing Grade", "fldPassingGrade", "", $fldPassingGrade, "", "text", "col-sm-4", "col-sm-8", "", "", "", $sfldPassingGrade);
            ?>

            <div class="row vcenter">
                <label class="form-control-label formLabel col-sm-4">Dependencies?</label>
                <div class="col-sm-8">
                    <select name="dependencies[]" size="5" multiple="multiple" tabindex="1" class="form-control">
                        <?php
                        foreach ($courses as $c) {
                            if ($c->getKey() != $courseKey) {
                                $selected = "";
                                if (in_array($c->getKey(), $course->getDependencies())) {
                                    $selected = "selected";
                                }
                                echo "<option value='{$c->getKey()}' $selected>$c</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row vcenter">
                <div class="offset-sm-2 col-sm-7">
                    <?php
                    echo '<br>';
                    func_btnBuilder("Submit", "btnSubmit", "btnGrey", "col-sm-2", "offset-sm-5");
                    ?>
                </div>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>
<?php include_once 'mod/footer.php' ?>
