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
     * \param $first_name The first name of the new user
     * \param $last_name The last name of the new user
     * \param $password The cleartext password the new user plans to use
     * \param $birthdate The new user's birthdate in YYYMMDD format??
     * \param $account_type The account type of the new user.  May be one of 
     *        the following:  "child", "teen", "adult", "trusted".
     * \param $active A boolean indicating whether we are inserting an active 
     *        user (TRUE) or an inactive user (FALSE).
     * \param $picture The filename of a picture of the new user.  If the name 
     *        is unknown, do not include it in the function call or specify 
     *        "defaultuser.jpg".
     * \return TRUE on success, FALSE on failure
     */
    function add_new_user($first_name, $last_name, $password, $birthdate, 
        $account_type, $active, $picture='defaultuser.jpg')
    {
        $passwd = $this->salt_password($password);

        $sql = "INSERT INTO `users` (`first_name`, `last_name`, `password`, 
            `birthdate`, `type`, `active`, `picture`) VALUES (?, ?, ?, ?, ?, ?, 
            ?)";

        return $this->db->query($sql, array($first_name, $last_name, $passwd, 
            $birthdate, $account_type, $active, $picture));
    }

    /**
     * Updates a user entry.  All fields other than userID may be changed.  For 
     * all fields you intend to change, provide the new value.  For all fields 
     * that are to remain the same, provide the old value.  Read the 
     * documentation for each parameter, not all of the fields have the same 
     * handling mechanisms.
     *
     * \param $userID The ID number of the user being modified
     * \param $first_name New or retained first name
     * \param $last_name New or retained last name
     * \param $password A new cleartext password is assumed when $changepasswd 
     *        is set to TRUE.  Retention of the old password is assumed if 
     *        $changepasswd is set to FALSE.  When retaining a password, the 
     *        actual value passed in this parameter is ignored.
     * \param $birthdate New or retained birthdate
     * \param $account_type New or retained account type.  May be one of the 
     *        following: "child", "teen", "adult", "trusted".
     * \param $active New or retained activity status
     * \param $picture New or retained picture filename.  NULL will set this
     *        value to its default: "defaultuser.jpg"
     * \param $changepasswd Set to TRUE to indicate that the value in $password 
     *        is a new password to add to the database.  Omit or set to FALSE
     *        to indicate that the old password is to be retained.
     *
     * \return TRUE on success, FALSE on failure 
     */
    function modify_user($userid, $first_name, $last_name, $password, 
        $birthdate, $account_type, $active, $picture, $changepasswd=0)
    {
        if($changepassword){
            $passwd = $this->salt_password($password);
        
            $sql = "UPDATE `users` SET `first_name` = ?, `last_name` = ?, 
                `password` = ?, `birthdate` = ?, `type` = ?, `active` = ?, 
                `picture` = ? WHERE `userID` = ?";
            return $this->db->query($sql, array($first_name, $last_name, 
                $passwd, $birthdate, $account_type, $active, $picture, 
                $userid));
        } else {
            $sql = "UPDATE `users` SET `first_name` = ?, `last_name` = ?, 
                `birthdate` = ?, `type` = ?, `active` = ?, `picture` = ? WHERE 
                `userID` = ?";
            return $this->db->query($sql, array($first_name, $last_name, 
                $birthdate, $account_type, $active, $picture, $userid));
        }
    }

    /**
     * Returns an array with the users account information so that it can be
     * used to populate the account modification page, for example.
     *
     * \param $userid The (unique) id number used to refer to the user for 
     *        which data is desired.
     * \return The row as an array on success, FALSE on failure.
     */
    function get_user_data($userid)
    {
        $sql = "SELECT * FROM `users` WHERE userID = ? LIMIT 1";

        $query = $this->db->query($sql, array($userid));

        if($query->num_rows == 1)
            return $query->row_array();
        else
            return null;
    }

    /**
     * Protect passwords from devious little children and their SQL injection
     * attacks.  The password is first concatenated with the applications
     * encryption key and the result is run through SHA1.
     *
     * \param $password The cleartext password to salt and hash
     *
     * \return The salted and hashed password.
     */
    function salt_password($password)
    {
        return sha1($password.$this->config->item('encryption_key'));
    }

    /**
     * Returns true if the user's account type is Trusted Helper.
     *
     * \param The id number of the user to test.
     *
     * \return TRUE if the user is a trusted helper, FALSE if they are not, 
     *         FALSE on failure.
     */
    function is_trusted_helper($userid)
    {
        $sql = "SELECT `type` FROM `users` WHERE `userID` = ?";
        $query = $this->db->query($sql, array($userid));

        if($query->num_rows == 1)
            return ($query->row()->type == self::TYPE_TRUSTED);
        else 
            return false;
    }

    /**
     * Returns true if the user's account type is Adult Helper.
     *
     * \param The id number of the user to test.
     *
     * \return TRUE if the user is an adult helper, FALSE if they are not, 
     *         FALSE on failure.
     */
    function is_adult_helper($userid)
    {
        $sql = "SELECT `type` FROM `users` WHERE `userID` = ?";
        $query = $this->db->query($sql, array($userid));

        if($query->num_rows == 1)
            return ($query->row()->type == self::TYPE_ADULT);
        else 
            return false;
    }
    
    /**
     * Returns true if the user's account type is teen Helper.
     *
     * \param The id number of the user to test.
     *
     * \return TRUE if the user is an teen helper, FALSE if they are not, 
     *         FALSE on failure.
     */
    function is_teen_helper($userid)
    {
        $sql = "SELECT `type` FROM `users` WHERE `userID` = ?";
        $query = $this->db->query($sql, array($userid));

        if($query->num_rows == 1)
            return ($query->row()->type == self::TYPE_TEEN);
        else 
            return false;
    }

    /**
     * Returns true if the user's account type is Child.
     *
     * \param The id number of the user to test.
     *
     * \return TRUE if the user is a child, FALSE if they are not, 
     *         FALSE on failure.
     */
    function is_child($userid)
    {
        $sql = "SELECT `type` FROM `users` WHERE `userID` = ?";
        $query = $this->db->query($sql, array($userid));

        if($query->num_rows == 1)
            return ($query->row()->type == self::TYPE_CHILD);
        else 
            return false;
    }

    /**
     * Used for authenticating a user at login.  Will always fail if the user
     * is inactive.
     *
     * \param $username The user's first name
     * \param $password The user's cleartext password.
     *
     * \return NULL if the username/password pair DO NOT match an existing user 
     *         in the database, otherwise return the userid of the matching 
     *         user.
     */
    function password_match($username, $password)
    {
        $passwd = $this->salt_password($password);
        $sql = "SELECT `userID` FROM `users` WHERE `first_name` = ? AND 
            `password` = ? AND `active` = 1 LIMIT 1";

        $query = $this->db->query($sql, array($username, $passwd));

        if($query->num_rows == 1)
            return $query->row()->userID;

        return null;
    }
    
    /**
     * Return a count of all users in the database.
     *
     * \param $inactive Boolean, should inactive users be included. If omitted,
     *        FALSE is assumed.
     *
     * \return See above.
     */
    function get_user_count($inactive=0)
    {
        if($inactive){
            $sql = "SELECT COUNT(*) FROM `users`";
        } else {
            $sql = "SELECT COUNT(*) FROM `users` WHERE `active` = 1";
        }
        
        $query = $this->db->query($sql);
        
        return $query->row_array();
    }
    
    /**
     * Returns information for a specified count of users, sorted by userID, 
     * with a specified offset from the top of the list.
     *
     * \param $start The offset from the start of the list from which the 
     *        returned users are taken.
     * \param $count The number of items to return
     * \param $inactive Boolean, should inactive user be included. If omitted,
     *        FALSE is assumed.
     *
     * \return The sorted range of users as an array, null on failure.
     */    
    function get_user_range($start, $count, $inactive=0)
    {
        if($inactive){
            $sql = "SELECT * FROM `users` ORDER BY `userID` LIMIT ?,  ?";
        } else {
            $sql = "SELECT * FROM `users` WHERE `active` = 1 ORDER BY `userID`
            LIMIT ?, ?";
        }
        
        $query = $this->db->query($sql, array($start, $count));

        if($query->num_rows > 0)
        return $query->result_array();

        return null;
    }
    
    /**
     * Return information on all users of a particular type.
     *
     * \param $type The type of user to search for.  Current values are listed 
     *        as constants at the top of the file.  Check the database for new 
     *        additions.
     * \param $inactive Boolean, do we return any inactive users. If omitted,
     *        FALSE is assumed.
     *
     * \return All found users in an array or null on failure.
     */    
    function get_user_by_type($type, $inactive=0)
    {
        if($inactive){
            $sql = "SELECT * from `users` WHERE `type` = ? ORDER BY `userID`";
        } else {
            $sql = "SELECT * from `users` WHERE `type` = ? AND `active` = 1 
                ORDER BY `userID`";
        }
    
        $query = $this->db->query($sql, array($type));
        
        if($query->num_rows > 0)
            return $query->result_array();

        return null;
    }
}
?>
