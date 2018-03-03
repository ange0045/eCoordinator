<?php
include 'mod/header.php';
session_start();
extract($_POST);
$dao = new DataAccessObject(INI_FILE_PATH); // Data Access Object - Creates conx with DB

if(isset($btnSearch)){
    unset($_SESSION['errCheck']);// errCheck should be empty if no errors are found
    $alertVar = ""; // alerVar is used to display confirmation message after submitting
    $sVal_StudentName   = val_Search('Student Name', 'fldStudentName'); // Validate fields values and returns error message
}

?>
<div>
    <form id="form_index" method="post">
        <div class="offset-sm-1 col-sm-10 pb-3">
            <h3><center>Welcome to the IAWD E-Coordinator Application</center></h3>
            <div class="offset-sm-2 col-sm-8">
                 <?php
                // SYNTAX: fieldBuilder([TYPE], [LABEL], [NAME & ID], [ARGUMENTS], [VALUE], [CSS], [VALUE TYPE], [LBL COLUMNS], [FLD COLUMNS], [LBL COLS OFFSET], [FLD COL OFFSET], [FLD OPTIONS], [ERROR MSG])
                func_fieldBuilder("TEXTFIELD", "Student Name", "fldStudentName", "" , $fldStudentName, "", "text", "col-sm-4", "col-sm-8", "", "", "", $sVal_StudentName);
                func_btnBuilder("Submit", "btnSearch", "btnGrey", "col-sm-2", "offset-sm-5");
                ?>
            </div>
        </div>
    </form>
    <table class='table table-striped table-hover'>
    <?php 
                if(empty($_SESSION['errCheck'])){ // No errors found, search student in db
                    $_SESSION['ses_fldStudentName'] = ""; // Clears form values
                    if(isset($fldStudentName)){ //Clears table when form is empty
                        echo "<table class='table table-striped table-hover'>"; // Creates table for Students
                        echo "<thead class='thead'>";
                        echo "<tr>";
                        echo "<th class='centerLabel lgCell'>ID</th>";
                        echo "<th class='centerLabel lgCell'>Name</th>";
                        echo "<th class='centerLabel lgCell'>Email</th>";
                        echo "<th class='centerLabel smCell'></th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        $students = $dao->getStudents($fldStudentName);
                        if (isset($students)){
                            foreach ($students as $item){
                                echo "<tr>";
                                echo "<td align='middle' class='lgCell' >".$item->getStudentId()."</td>";
                                echo "<td align='middle' class='lgCell' >".$item->getName()."</td>";
                                echo "<td align='middle' class='lgCell' >".$item->getEmail()."</td>";
                                echo "<th class='centerLabel smCell'><button type='button' class='btn btn-success'><a href='f_studentedit.php'>Edit</a></button></th>";
                                echo "</tr>";
                                echo "</tbody>";
                                
                            }   
                        }
                    }
                }
            ?>
            </table>
</div>


<?php include 'mod/footer.php' ?>