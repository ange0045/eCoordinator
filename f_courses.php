<?php
include 'mod/header.php';
session_start();
extract($_POST);
$dao = new DataAccessObject(INI_FILE_PATH); // Data Access Object - Creates conx with DB

$courses = $dao->getCourses();


if(isset($btnSubmit)){
    unset($_SESSION['errors']); // errCheck should be empty if no errors are found

    if(empty($_SESSION['errors'])){ // No errors found, adds course to db
        $_SESSION['ses_CourseName'] = ""; // Clears form values
        
        // Adds course to database
    }
}

?>
    <form id="form_new_user" method="post">
        <div class="login-cont offset-sm-3 col-sm-6">
            <h3><center><strong>E-Coordinator</strong> Course Edit</h3></center>
            <select id="course" name="course">                      
                <option value="0">--Select Course--</option>
                <?php 
                    foreach($courses as $course){
                        echo "<option value='{$course->getCourseKey()}'>{$course->getCourseKey()}</option>";
                    }
                ?>
            </select>
            <a href="f_newcourse.php">Add New Course</a>

            <?php
              func_btnBuilder("Submit", "btnSubmit", "btnGrey", "col-sm-2", "offset-sm-5");
            ?>

        </div>
    </form>

<?php include_once 'mod/footer.php' ?>
