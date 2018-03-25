<?php
/*---------------------------------------------------------------------------------------------------/
           NAME: dataAccessClass.php
    DESCRIPTION: Library used for all queries and connections.
                 Only requires entityClass.php.
 ----------------------------------------------------------------------------------------------------*/
include_once 'entityClass.php';

class DataAccessObject
{
// ++++++++ MAIN CONSTRUCTOR AND DESTRUCTOR ++++++++
    private $pdo;
    function __construct($iniFile)
    {
        $dbConnection = parse_ini_file($iniFile);
        extract($dbConnection);
        try {
           $this->pdo = new PDO($dsn, $username, $passworddhcp);
        } catch (Exception $ex) {
            try {
                $this->pdo = new PDO($dsn, $username, $password );
                } catch (Exception $ex) {
                    echo "The eCoordinator database is either down or there are connection issues.";
                }
        }
    }

    function __destruct()
    {
        $this->pdo = null;
    }
// .MAIN CONST



// ++++++++ USER FUNCTIONS ++++++++

// -- Gets the username for the current user
public function getUsernames($username)
{
    $sql = "SELECT * FROM USERS WHERE user_username = '".$username."' ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchColumn();
}

// -- Insers new user into the DB
public function addNewUser($fldUsername, $fldFullName, $fldPassword)
{
    $sql = "INSERT INTO USERS VALUES(DEFAULT, :fUsername, :fFullName, :fPassword)";
    $stmt = $this->pdo->prepare($sql);
    $this->pdo->beginTransaction();
    $stmt->execute(['fUsername'=>$fldUsername, 'fFullName'=>$fldFullName, 'fPassword'=>$fldPassword]);
    $this->pdo->commit();
}

// -- Gets all users used in the Admin->users view
public function getUsers()
{
    $users = array();
    $sql = "SELECT * FROM USERS ORDER BY user_id ASC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    foreach ($stmt as $row)
    {
        $user = new User ($row['user_id'], $row['user_username'], $row['user_fullname']);
        $users[] = $user;
    }
    return $users;
}

// -- Deletes a user from the db
public function deleteUser($UserId)
{
    $sql = "DELETE FROM USERS WHERE user_id = :fUserId";
    $stmt = $this->pdo->prepare($sql);
    $this->pdo->beginTransaction();
    $stmt->execute(['fUserId'=>$UserId]);
    $this->pdo->commit();
}

// -- Gets the user based on user/pwd, allows the user to access the tool
public function getUserByUsernameAndPassword($username, $password)
{
    $user = null;
    $sql = "SELECT * FROM USERS WHERE user_username = :username AND user_password = :password";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['username' => $username, 'password'=>$password]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row)
    {
        $user = new User ($row['user_id'], $row['user_username'], $row['user_fullname']);
    }
    return $user;
}
// .USER ENDS


// ++++++++ COURSE FUNCTIONS ++++++++

public function getDependencies($courseKey)
{
    $dependencies = [];
    $sql = "SELECT depends_on FROM dependencies WHERE course_key = :courseKey";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(["courseKey" => $courseKey]);
    foreach ($stmt as $row)
    {
        $dependencies[] = $row['depends_on'];
    }

    return $dependencies;
}

public function getCourses()
{
    $courses = array();
    $sql = "SELECT * FROM course ORDER BY course_key ASC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    foreach ($stmt as $row)
    {
        $dependencies = $this->getDependencies($row['course_key']);
        $course = new Course ($row['course_key'], $row['course_name'], $row['course_pass_grade'], $row['course_level'], $dependencies);
        $courses[] = $course;
    }
    return $courses;
}

public function getCourseByKey($courseKey)
{
    $sql = "SELECT * FROM course WHERE course_key = :courseKey";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(["courseKey" => $courseKey]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row){
        $dependencies = $this->getDependencies($courseKey);
        $course = new Course ($row['course_key'], $row['course_name'], $row['course_pass_grade'], $row['course_level'], $dependencies);
    }
    return $course;
}

public function saveCourse($key, $level){
    $sql = "INSERT INTO course VALUES(:fCourseKey, DEFAULT, :fLevel, NULL)";
    $stmt = $this->pdo->prepare($sql);
    $this->pdo->beginTransaction();
    $stmt->execute(['fCourseKey'=>$key, 'fLevel'=>$level]);
    $this->pdo->commit();
}


public function saveNewCourse($fldCourseName, $fldCourseKey, $fldCourseLevel, $fldPassingGrade, $dependencies){
    $sql = "INSERT INTO course VALUES(:fCourseKey, :fPassingGrade, :fCourseLevel, :fCourseName)";
    $stmt = $this->pdo->prepare($sql);
    $this->pdo->beginTransaction();
    $stmt->execute(['fCourseKey'=>$fldCourseKey,'fPassingGrade'=>$fldPassingGrade, 'fCourseLevel'=>$fldCourseLevel, 'fCourseName'=>$fldCourseName]);
    $this->pdo->commit();

    if(!empty($dependencies)){
        foreach($dependencies as $dependancy){
            $sql = "INSERT INTO dependencies VALUES(:fCourseKey, :fDependancy)";
            $stmt = $this->pdo->prepare($sql);
            $this->pdo->beginTransaction();
            $stmt->execute(['fCourseKey'=>$fldCourseKey,'fDependancy'=>$dependancy]);
            $this->pdo->commit();
        }
    }
}

public function updateCourse($editCourseKey, $fldCourseName, $fldCourseKey, $fldCourseLevel, $fldPassingGrade, $dependencies){
    $sql = "UPDATE course SET course_key = :fCourseKey, course_pass_grade = :fPassingGrade, course_level = :fCourseLevel, course_name = :fCourseName WHERE course_key = :editCourseKey";
    $stmt = $this->pdo->prepare($sql);
    $this->pdo->beginTransaction();
    $stmt->execute(['editCourseKey'=>$editCourseKey, 'fCourseKey'=>$fldCourseKey,'fPassingGrade'=>$fldPassingGrade, 'fCourseLevel'=>$fldCourseLevel, 'fCourseName'=>$fldCourseName]);
    $this->pdo->commit();

    $sql = "DELETE FROM dependencies WHERE course_key = :editCourseKey";
    $stmt = $this->pdo->prepare($sql);
    $this->pdo->beginTransaction();
    $stmt->execute(['editCourseKey'=>$editCourseKey]);
    $this->pdo->commit();

    if(!empty($dependencies)){
        foreach($dependencies as $dependancy){
            $sql = "INSERT INTO dependencies VALUES(:fCourseKey, :fDependancy)";
            $stmt = $this->pdo->prepare($sql);
            $this->pdo->beginTransaction();
            $stmt->execute(['fCourseKey'=>$fldCourseKey,'fDependancy'=>$dependancy]);
            $this->pdo->commit();
        }
    }
}

// ++++++++ STUDENTCOURSE FUNCTIONS ++++++++

public function saveStudentCourse($student_id, $course_key, $grade){
    $sql = "INSERT INTO studentcourse VALUES(:fStudentID, :fCourseKey, :fGrade, NULL)";
    $stmt = $this->pdo->prepare($sql);
    $this->pdo->beginTransaction();
    $stmt->execute(['fStudentID'=>$student_id, 'fCourseKey'=>$course_key, 'fGrade'=>$grade]);
    $this->pdo->commit();
}

// ++++++++ STUDENT FUNCTIONS ++++++++

public function saveStudent($student_id, $name){
    $sql = "INSERT INTO student VALUES(:fStudentID, :fName, DEFAULT, DEFAULT, NULL)";
    $stmt = $this->pdo->prepare($sql);
    $this->pdo->beginTransaction();
    $stmt->execute(['fStudentID'=>$student_id, 'fName'=>$name]);
    $this->pdo->commit();
}

// ++++++++  GET STUDENT FUNCTIONS ++++++++
  public function getStudents ($fldStudentName){
    $sqlStudentName = "%".$fldStudentName ."%";
    $students = array();
    $sql = "SELECT student_id, student_name, student_email FROM student WHERE student_name LIKE :name";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(["name" => $sqlStudentName]);
    foreach ($stmt as $row)
    {
        $student = new Student ($row['student_id'], $row['student_name'], $row['student_email']);
        $students[] = $student;
    }
    return $students;
  }


  public function getStudentByID ($id){
    $student = null;
    $sql = "SELECT * FROM student WHERE student_id = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(["id" => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row)
    {
        $student = new Student ($row['student_id'], $row['student_name'], $row['student_email']);
    }
    return $student;
  }


  public function getStudentCoursesByIDandKey($sId, $cKey){
    $studentCourses = array();
    $sql = "SELECT * FROM studentcourse WHERE student_id = :id AND course_key = :key";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['id' => $sId, 'key' => $cKey]);
    foreach ($stmt as $row)
    {
        $studentCourse = new StudentCourse ($row['student_id'], $row['course_key'], $row['student_grade'], $row['comments']);
        $studentCourses[] = $studentCourse;
    }
    return $studentCourses;
  }

  public function getStudentCourseByIDandKey($sId, $cKey){
    $studentCourse = null;
    $sql = "SELECT * FROM studentcourse WHERE student_id = :id AND course_key = :key";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['id' => $sId, 'key' => $cKey]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row)
    {
        $studentCourse = new StudentCourse ($row['student_id'], $row['course_key'], $row['student_grade'], $row['comments']);
    }
    return $studentCourse;
  }

  public function updateStudentCourse($sc_ID, $sc_key, $sc_grade, $sc_comment)
  {
      $sql = "UPDATE studentcourse SET student_grade = :vGrade, comments = :vComment WHERE student_id = :vId AND course_key = :vKey";
      $stmt = $this->pdo->prepare($sql);
      $this->pdo->beginTransaction();
      $stmt->execute(['vGrade'=>$sc_grade, 'vComment'=>$sc_comment, 'vId'=>$sc_ID, 'vKey'=>$sc_key]);
      $this->pdo->commit();
  }


}
