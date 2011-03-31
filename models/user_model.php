<?php
class User_model extends CI_Model {
    
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
        $sql = "SELECT * FROM users WHERE userid = ? LIMIT 1";

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
        // TODO: check if userid belongs to a trusted helper
        return false;
    }

    /**
     * Used for authenticating the user. Returns null if the username/password
     * pair DO NOT match an existing user in the database, otherwise return the
     * userid of the matching user.
     **/
    function password_match($username, $password){
        $sql = "SELECT userid FROM users WHERE first_name = ? AND password = ? LIMIT 1";

        $query = $this->db->query($sql, array($username, $password));
        
        if($query->num_rows <= 0)
            return null;
        else
            return $query->row()->userid;
    }

}
?>
