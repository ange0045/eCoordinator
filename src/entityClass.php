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
    private $course_dependent;
    private $course_dependency;
    private $course_level;
    private $course_comments;
    
    public function __construct($course_key, $course_pass_grade, $course_dependent, $course_dependency, $course_level, $course_comments) {
        $this->course_key = $course_key;
        $this->course_pass_grade = $course_pass_grade;
        $this->course_dependent = $course_dependent;
        $this->course_dependency = $course_dependency;
        $this->course_level = $course_level;
        $this->course_comments = $course_comments;
    }
    
    public function __toString(){
        return $this->course_key;
    }
    
    public function getCourseKey(){
        return $this->course_key;
    }
    
    public function getCoursePassGrade(){
        return $this->course_pass_grade;
    }
    
    public function getCourseDependent(){
        return $this->course_dependent;
    }
    
    public function getCourseDependency(){
        return $this->course_dependency;
    }
    
    public function getCourseLevel(){
        return $this->course_level;
    }
    
    public function getCourseComments(){
        return $this->course_comments;
    }
}
