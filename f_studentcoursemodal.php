<?php
/*---------------------------------------------------------------------------------------------------/
           NAME: f_studentcoursemodal.php
    DESCRIPTION: Used to display student/course modal
 ----------------------------------------------------------------------------------------------------*/

include 'mod/headerModal.php';
session_start();
extract($_POST);
$dao = new DataAccessObject(INI_FILE_PATH);

if(isset($id) && isset($coursekey)) {
    $stuCou       = $dao->getStudentCourseByIDandKey($id, $coursekey);
    $sc_stuId     = $id;
    $sc_couKey    = $coursekey;
    $sc_stuGrade  = $stuCou->getStudentGrade();
    $sc_comment   = $stuCou->getComments();
}
else {
    echo "Nothing to see here";
}

// if(isset($btnSubmit)){
//   $dao->updateStudentCourse($sc_stuId, $sc_couKey, $fld_Grade, $fld_Comments);
// }
?>

        <div class="contentMainModal">
            <form method="post" id="formStuCou" action="a_saveStudentCourse.php">
                <fieldset>
                    <div class="ContentModal">
                      <?php
                        // -- ROW 1
                          func_fieldBuilder('TEXTFIELD', 'Student ID', 'fld_ID', 'readonly', $sc_stuId, '', 'text', 'col-sm-3', 'col-sm-6', 'offset-sm-1', '', '', '');
                        // -- ROW 2
                          func_fieldBuilder('TEXTFIELD', 'Course Key', 'fld_Key', 'readonly', $sc_couKey, '', 'text', 'col-sm-3', 'col-sm-6', 'offset-sm-1', '', '', '');
                        // -- ROW 3
                          func_fieldBuilder('TEXTFIELD', 'Grade', 'fld_Grade', '', $sc_stuGrade, '', 'text', 'col-sm-3', 'col-sm-3', 'offset-sm-1', '', '', '');
                      ?>
                    </div><!-- /.mainModal -->

                  <div class="commentDiv">
                      <label class="col-sm-12 form-control-label">Comments:</label>
                      <div class="col-sm-12">
                      <?php
                          echo '<textarea rows="4" id="fld_Comments" name="fld_Comments" class="form-control inputField cc_Comments">'.$sc_comment.'</textarea>';
                      ?>
                    </div>
                  </div>  <!-- /.Comments -->

                    <div class="col-xs-12 modal-footer">
                      <button id="btnSubmit" value="btnSubmit" name="btnSubmit" class="btn btn-primary">Update Info</button>
                    </div>

                </fieldset>
            </form>
        </div>

    </body>
</html>
