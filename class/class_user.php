<?php
class User
{
    private $dbHost = 'localhost';
    private $dbUsername = 'test';
    private $dbPassword = 'test';
    private $dbName = 'test';
    private $userTbl = 'users';
    
    public function __construct()
    {
        if (!isset($this->db)) {
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if ($conn->connect_error) {
                die('Failed to connect with MySQL: '.$conn->connect_error);
            } else {
                $this->db = $conn;
            }
        }
    }
    
    public function checkUser($userData = array())
    {
        if (!empty($userData)) {
            // Check whether user data already exists in database
            $prevQuery = "SELECT * FROM ".$this->userTbl." WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";
            $prevResult = $this->db->query($prevQuery);
            if ($prevResult->num_rows > 0) {
                // Update user data if already exists
                $query = "UPDATE ".$this->userTbl." SET first_name = '".$userData['first_name']."', last_name = '".$userData['last_name']."', email = '".$userData['email']."', gender = '".$userData['gender']."', locale = '".$userData['locale']."', picture = '".$userData['picture']."', link = '".$userData['link']."', modified = NOW() WHERE oauth_provider = '".$userData['oauth_provider']."' AND oauth_uid = '".$userData['oauth_uid']."'";
                $update = $this->db->query($query);
            } else {
                // Insert user data
                $query = "INSERT INTO ".$this->userTbl." SET oauth_provider = '".$userData['oauth_provider']."', oauth_uid = '".$userData['oauth_uid']."', first_name = '".$userData['first_name']."', last_name = '".$userData['last_name']."', email = '".$userData['email']."', gender = '".$userData['gender']."', locale = '".$userData['locale']."', picture = '".$userData['picture']."', link = '".$userData['link']."', created = NOW(), modified = NOW()";
                $insert = $this->db->query($query);
            }
            // Get the user data from the database
            $result = $this->db->query($prevQuery);
            $userData = $result->fetch_assoc();
        }
        // Return the user data
        return $userData;
    }
}
