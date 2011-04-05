<?php
class User_model extends CI_Model {
    // Class constants
    const TYPE_CHILD = "child";
    const TYPE_TEEN = "teen";
    const TYPE_ADULT = "adult";
    const TYPE_TRUSTED = "trusted";

    function __construct()
    {
        parent::__construct();

        $this->load->database();
        
    }

    
    /**
    * Adds a new user to the database.
    * 
    */
    function add_new_user($first_name, $last_name, $password, $birthdate,
        $account_type, $active, $picture)
    {
        $sql = "INSERT INTO `users` (
                    first_name, last_name, password, birthdate, type, active, picture
                ) VALUES (?, ?, ?, ?, ?, )";


        return $this->db->query($sql, array($first_name, $last_name, 
            $password, $birthdate, $account_type,
            $active, $picture));
    }
    
    /**
     * Updates a user entry
     */
    function modify_user($userid, $first_name, $last_name, $password, $birthdate,
        $account_type, $active, $picture)
    {
        // TODO: put update query here
    }

    /*
     * Returns an array with the users account information so that it can be
     * used to populate the account modification page, for example.
     *
     */
    function get_user_data($userid){
        $sql = "SELECT * FROM users WHERE userID = ? LIMIT 1";

        $query = $this->db->query($sql, array($userid));
        if($query->num_rows == 1)
            return $query->row_array();
        else
            return null;
    }

    /**
     * Protect passwords from devious little children and their SQL injection
     * attacks.
     */
    function salt_password($password){
        return sha1($password.$this->config->item('encryption_key'));
    }

    /**
     * Returns true if the user's account type is Trusted User.
     **/
    function is_trusted_helper($userid){
        $sql = "SELECT type FROM users WHERE userID = ?";
        $query = $this->db->query($sql, array($userid));

        if($query->num_rows == 1)
            return ($query->row()->type == self::TYPE_TRUSTED);
        else 
            return false;
    }

    /**
     * Returns true if the user's account type is Trusted User.
     **/
    function is_adult_helper($userid){
        $sql = "SELECT type FROM users WHERE userID = ?";
        $query = $this->db->query($sql, array($userid));

        if($query->num_rows == 1)
            return ($query->row()->type == self::TYPE_ADULT);
        else 
            return false;
    }

    /**
     * Returns true if the user's account type is a child's.
     **/
    function is_child($userid){
        $sql = "SELECT type FROM users WHERE userID = ?";
        $query = $this->db->query($sql, array($userid));

        if($query->num_rows == 1)
            return ($query->row()->type == self::TYPE_CHILD);
        else 
            return false;
    }

    /**
     * Used for authenticating the user. Returns null if the username/password
     * pair DO NOT match an existing user in the database, otherwise return the
     * userid of the matching user.
     **/
    function password_match($username, $password){
        $sql = "SELECT userID FROM users WHERE first_name = ? AND password = ? LIMIT 1";

        $query = $this->db->query($sql, array($username, $password));
        
        if($query->num_rows == 1)
            return $query->row()->userID;
        
        return null;
    }

}
?>
