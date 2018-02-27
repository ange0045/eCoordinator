<?php
    include 'mod/header.php';
    session_start();
    extract($_POST);
    $dao = new DataAccessObject(INI_FILE_PATH); // Data Access Object - Creates conx with DB
    
    $courses = $dao->getCourses();
?>


    <form id="new_course" method="post">
        <div class="offset-sm-2 col-sm-7">
        <h3><center>Add New Course</h3></center>
        <br>
            <?php
                func_fieldBuilder("TEXTFIELD", "Course Name", "fldUsername", "" , $fldUsername, "", "text", "col-sm-4", "col-sm-8", "", "", "", $sVal_Username);
                func_fieldBuilder("TEXTFIELD", "Course ID", "fldCourseId", "" , $fldCourseId, "", "text", "col-sm-4", "col-sm-4", "", "", "", $sVal_Username);
                func_fieldBuilder("TEXTFIELD", "Course Level", "fldCourseLevel", "" , $fldCourseLevel, "", "text", "col-sm-4", "col-sm-4", "", "", "", $sVal_Username);
                
                
            ?>
        </div>
        
        <div class="offset-sm-2">
            <label class="form-control-label formLabel">Dependencies?</label>
            <div class="offset-sm-3">
              <select name="dependencies[]" size="5" multiple="multiple" tabindex="1" style="width:350px;">
                  <?php 
                    foreach($courses as $course){
                        echo "<option value='{$course->getKey()}'>{$course->getKey()}  -  {$course->getName()}</option>";
                    }
                  ?>
              </select>
            </div>
        </div>
        
        <div class="offset-sm-2 col-sm-7">
            <?php
                func_fieldBuilder("TEXTFIELD", "Passing Grade", "fldPassingGrade", "" , $fldUsername, "", "text", "col-sm-4", "col-sm-4", "", "", "", $sVal_Username);
                echo '<br>';
                func_btnBuilder("Submit", "btnLogin", "btnGrey", "col-sm-2", "offset-sm-5");
            ?>
        </div>
    </form>


<?php
    include 'mod/footer.php';
?>

