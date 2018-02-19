<?php
/*---------------------------------------------------------------------------------------------------/
           NAME: dataAccessClass.php
    DESCRIPTION: Library used for all queries and connections.
                 Only requires EntityClass_Lib.
 ----------------------------------------------------------------------------------------------------*/
include_once 'EntityClass_Lib.php';

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
public function addNewUser($fldUsername, $fldFullName, $fldAccessType, $fldPassword) 
{
    $sql = "INSERT INTO USERS VALUES(DEFAULT, :fUsername, :fFullName, :fAccessType, :fPassword, 'N')";
    $stmt = $this->pdo->prepare($sql);
    $this->pdo->beginTransaction();
    $stmt->execute(['fUsername'=>$fldUsername, 'fFullName'=>$fldFullName, 'fAccessType'=>$fldAccessType, 'fPassword'=>$fldPassword]);
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
        $user = new User ($row['user_id'], $row['user_username'], $row['user_fullname'], $row['user_type'], $row['user_approval']);
        $users[] = $user;
    }
    return $users;
}

// -- Updates the user record to approved
public function approveUser($UserId)
{
    $sql = "UPDATE USERS SET user_approval = 'Y' WHERE user_id = :fUserId";
    $stmt = $this->pdo->prepare($sql);
    $this->pdo->beginTransaction();
    $stmt->execute(['fUserId'=>$UserId]);
    $this->pdo->commit();
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
    $sql = "SELECT * FROM USERS WHERE user_username = :username AND user_password = :password AND user_approval = 'Y'";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['username' => $username, 'password'=>$password]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row)
    {
        $user = new User ($row['user_id'], $row['user_username'], $row['user_fullname'], $row['user_type'], $row['user_approval']);
    }
    return $user;
}
// .USER ENDS

}
