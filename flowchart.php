<?php
include 'mod/headerFlowChart.php';
session_start();
extract($_POST);
$dao = new DataAccessObject(INI_FILE_PATH);
$var_lvls = [1,2,3,4];

if(isset($_GET["student"])) {
  $flw_student  = $_GET["student"];
  $stuObj       = $dao->getStudentByID($flw_student);
  $courses      = $dao->getCourses();
  $_SESSION['preURLForms']    = "http://$_SERVER[HTTP_HOST]/eCoordinator/flowchart.php?student=".$flw_student;
} else {
  echo "<script type='text/javascript'>document.location.href='/eCoordinator/index.php';</script>";
}

function childFm($key, $grade, $pass, $css, $comments, $name, $flw_student) {
  if($comments != '') {
    $com_icon = "<i class='fa fa-comment comIcon'></i>";
  } else {
    $com_icon = "";
  }

  echo "<ul>";
    echo "<li>";
      if($grade == ' --- ') {
        echo "<a class='cellcss $css' href='#'><center>$name</br><strong>$key</strong></br>Grade: $grade (PG: $pass)</br></center>$com_icon</a>";
      } else {
        echo "<button type='button' data-toggle='modal' data-target='#view-modal' data-id='$flw_student' data-key='$key' id='btnOpenModal' class='btnFlowChart'><a class='cellcss $css' href='#'><center>$name</br><strong>$key</strong></br>Grade: $grade (PG: $pass)</br></center>$com_icon</a></button>";
      }
    echo "</li>";
  echo "</ul>";
}

?>

<h3 class='lbl_user'>Student: <?php echo $stuObj->getName()." (".$stuObj->getStudentId().")"; ?><a href='/eCoordinator/index.php'><i class="fa fa-window-close"></i></a></h3>

<div class="tree col-sm-10 offset-sm-1">
	<ul>
		<li>
        <?php
        foreach($var_lvls as $var_lvl) {
          $stu_courses = array();
          $stu_comments = array();
          echo "<li class='li_Level'>";
          echo "<a href='#' class='lbl_level'>Lvl ($var_lvl)</a>";
          foreach($courses as $couObj) {
            $courseName = $couObj->getName();
            $courseKey = $couObj->getKey();
            $courseLvl = $couObj->getLevel();
            $coursePass = $couObj->getPassGrade();

            $stuCourses = $dao->getStudentCoursesByIDandKey($flw_student, $courseKey);
            foreach ($stuCourses as $stuCouObj) {
              $courseStKey = $stuCouObj->getCourseKey();
              $stuGrade = $stuCouObj->getStudentGrade();
              $stuCouComment = $stuCouObj->getComments();
              $stu_courses[$courseStKey] = $stuGrade;
              $stu_comments[$courseStKey] = $stuCouComment;
            }

            if($courseLvl == $var_lvl) {
              if (in_array($courseKey, array_keys($stu_courses))) {
                $var_Grade = $stu_courses[$courseKey];
                $var_Comments = $stu_comments[$courseKey];
                $cssCell = "cellDone";
              } else {
                $var_Grade = " --- ";
                $var_Comments = "";
                $cssCell = "cellPending";
              }
              childFm($courseKey, $var_Grade, $coursePass, $cssCell, $var_Comments, $courseName, $flw_student);
            }
          }
            echo "</li>";
        }
        ?>
		</li>
	</ul>
</div>
  </body>
</html>
