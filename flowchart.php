<?php
include 'mod/headerFlowChart.php';
session_start();
extract($_POST);
$dao = new DataAccessObject(INI_FILE_PATH);
$var_lvls = [1,2,3,4];
$d = 0;

if(isset($_GET["student"])) {
  $flw_student  = $_GET["student"];
  $stuObj       = $dao->getStudentByID($flw_student);
  $courses      = $dao->getCourses();
  $_SESSION['preURLForms']    = "http://$_SERVER[HTTP_HOST]/eCoordinator/flowchart.php?student=".$flw_student;
} else {
  echo "<script type='text/javascript'>document.location.href='/eCoordinator/index.php';</script>";
}

function childFm($key, $grade, $pass, $css, $comments, $name, $flw_student, $courseDependencies) {
  if($comments != '') {
    $com_icon = "<i class='fa fa-comment comIcon'></i>";
  } else {
    $com_icon = "";
  }


  //if(course is passed)
  $pass_icon = "<i class='fa fa-check checkIcon'></i>";
  //else
  //$pass_icon = "<i class='fa fa-times timesIcon'></i>";

  $excep_icon = "<i class='fa fa-plus excepIcon'></i>";


  $var_Dependencies = implode(" | ",$courseDependencies);

  echo "<ul>";
    echo "<li class='gridBox' id='$key'>";
      if($grade == ' --- ') {
        echo "<a class='cellcss $css' href='#'><center>$name</br><strong>$key</strong></br>Grade: $grade (PG: $pass)</br><div class='dep_style'>$var_Dependencies</div></center><div>$excep_icon$com_icon</div></a>";
      } else {
        echo "<button type='button' data-toggle='modal' data-target='#view-modal' data-id='$flw_student' data-key='$key' id='btnOpenModal' class='btnFlowChart'><a class='cellcss $css' href='#'><center>$name</br><strong>$key</strong></br>Grade: $grade (PG: $pass)</br><div class='dep_style'>$var_Dependencies</div></center><div>$com_icon$pass_icon</div></a></button>";
      }
    echo "</li>";
  echo "</ul>";
}


function depen_map($deps) {
  $d = 0;
  $count = 0;
  foreach ($deps as $dc) {
      $count += count($dc);
  }
  echo "<input id='totDep' name='totDep' type='text' readonly hidden value='$count'>";

  foreach (array_keys($deps) as $k) {
      $i = 0;
      foreach ($deps[$k] as $v) {
        echo "<input id='a$d-$i' name='a$d-$i' type='text' readonly hidden value='$k'>";
        echo "<input id='b$d-$i' name='b$d-$i' type='text' readonly hidden value='$v'>";
        $i++;
      }
      $d++;
    }

}

?>

<form method="post" id="formFlowChart">


<h3 class='lbl_user'>
  <button data-toggle='modal' data-target='#view-modal-info' id='btnOpenFlowchartInfo' class="info">
    <div class="info">
      <i class="fa fa-info-circle"></i>
    </div>
  </button> Student: <?php echo $stuObj->getName()."(".$stuObj->getStudentId().")"; ?>
  <a href='/eCoordinator/index.php'>
    <div class="flo-close">
      <i class="fa fa-window-close"></i>
    </div>
  </a>
</h3>

<div class="style"></div>

<div class="tree">

<canvas id="myCanvas"></canvas>

	<ul class='lvl_row'>
        <?php
        foreach($var_lvls as $var_lvl) {
          $stu_courses = array();
          $stu_comments = array();
          $depMulti = array();
          echo "<li class='li_Level offset-sm-1'>";
          echo "<a class='lbl_level lvlLi'>Lvl ($var_lvl)</a>";
          foreach($courses as $couObj) {
            $courseName = $couObj->getName();
            $courseKey = $couObj->getKey();
            $courseLvl = $couObj->getLevel();
            $coursePass = $couObj->getPassGrade();
            $courseDependencies = $couObj->getDependencies();

            $t = 0;
            foreach ($courseDependencies as $dep) {
              $course_deps[$courseKey][$t] = $dep;
              $t++;
            }

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
              $sesDepFor = $_SESSION['totDep'];
              childFm($courseKey, $var_Grade, $coursePass, $cssCell, $var_Comments, $courseName, $flw_student, $courseDependencies);
            }
          }
            echo "</li>";
        }
?>
	 </ul>
  </div>

  <?php
    depen_map($course_deps);
  ?>
</form>
  </body>
</html>
