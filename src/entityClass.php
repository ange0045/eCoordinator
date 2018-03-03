<?php

class User
{
    private $user_id;
    private $user_username;
    private $user_name;
    private $user_access;
    private $user_approval;

    public function __construct($user_id, $user_username, $user_name, $user_access, $user_approval) {
        $this->user_id = $user_id;
        $this->user_username = $user_username;
        $this->user_name = $user_name;
        $this->user_access = $user_access;
        $this->user_approval = $user_approval;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getUsername() {
        return $this->user_username;
    }

    public function getFullName() {
        return $this->user_name;
    }

    public function getAccessType() {
        return $this->user_access;
    }

    public function getApproval() {
        return $this->user_approval;
    }
}

class Course
{
    private $course_key;
    private $course_pass_grade;
    private $course_level;
    private $course_name;
    
    public function __construct($course_key, $course_name, $course_pass_grade, $course_level, $dependencies) {
        $this->course_key = $course_key;
        $this->course_pass_grade = $course_pass_grade;
        $this->course_level = $course_level;
        $this->course_name = $course_name;
        $this->dependencies = $dependencies;
    }
    
    public function __toString(){
        $s = $this->course_key;
        if(!empty($this->getName())){
            $s = $s . " - " . $this->getName();
        }
        return $s;
    }
    
    public function getKey(){
        return $this->course_key;
    }
    
    public function getPassGrade(){
        return $this->course_pass_grade;
    }
    
    public function getLevel(){
        return $this->course_level;
    }
    
    public function getName(){
        return $this->course_name;
    }
    
    public function getDependencies(){
        return $this->dependencies;
    }
}

class Student
{
    private $student_id;
    private $student_name;
    private $student_email;

    public function __construct($student_id, $student_name, $student_email) {
        $this->student_id = $student_id;
        $this->student_name = $student_name;
        $this->student_last_name = $student_email;
    }

    public function getStudentId() {
        return $this->student_id;
    }

    public function getName() {
        return $this->student_name;
    }

    public function getEmail() {
        return $this->student_email;
    }

}