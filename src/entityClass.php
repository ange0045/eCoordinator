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
