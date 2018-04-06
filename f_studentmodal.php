<?php
/*---------------------------------------------------------------------------------------------------/
           NAME: f_studentmodal.php
    DESCRIPTION: Used to display student modal
 ----------------------------------------------------------------------------------------------------*/

include 'mod/headerModal.php';
session_start();
extract($_POST);
$dao = new DataAccessObject(INI_FILE_PATH);

if(isset($id)) {
    $stu      = $dao->getStudentByID($id);
    $s_id     = $id;
    $s_name   = $stu->getName();
    $s_type   = $stu->getType();
    $s_email  = $stu->getEmail();
}
else {
    echo "Nothing to see here";
}
?>

        <div class="contentMainModal">
            <form method="post" id="formStu" action="a_saveStudent.php">
                <fieldset>
                    <div class="ContentModal">
                      <?php
                        // -- ROW 1
                          func_fieldBuilder('TEXTFIELD', 'Student ID', 'fld_ID', 'readonly', $s_id, '', 'text', 'col-sm-4', 'col-sm-6', 'offset-sm-1', '', '', '');
                        // -- ROW 2
                          func_fieldBuilder('TEXTFIELD', 'Student Name', 'fld_Name', '', $s_name, '', 'text', 'col-sm-4', 'col-sm-6', 'offset-sm-1', '', '', '');
                        // -- ROW 3

                          $arr_types = array('PT', 'FT');
                          func_fieldBuilder('SELECTFIELD', 'Student Type', 'fld_Type', '', $s_type, '', 'text', 'col-sm-4', 'col-sm-2', 'offset-sm-1', '', $arr_types, '');
                        // -- ROW 4
                          func_fieldBuilder('TEXTFIELD', 'Student Email', 'fld_Email', '', $s_email, '', 'text', 'col-sm-4', 'col-sm-6', 'offset-sm-1', '', '', '');
                      ?>
                    </div><!-- /.mainModal -->


                    <div class="col-xs-12 modal-footer">
                      <button id="btnSubmit" value="btnSubmit" name="btnSubmit" class="btn btn-success">Update Info</button>
                    </div>

                </fieldset>
            </form>
        </div>

    </body>
</html>
