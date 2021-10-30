<?php

/**
 * Class User
 */
class User
{
    /**
     * @var string
     */
    private string $username;

    /**
     * @var int
     */
    private int $user_id = -1;

    /**
     * @var int
     */
    private int $school_id = -1;

    /**
     * @var
     */
    private string $email;

    /**
     * @var bool
     */
    private bool $user_exists = false;

    /**
     * @var string
     */
    private string $password = "";

    /**
     * @var string
     */
     private string $user_notes = "";

    /**
     * @var array
     */
     private array $absences = array();


    public function __construct($school_id, $user_id)
    {
        $db = new DB();

        $result = $db->query("SELECT username, PK_User, PK_School, notes, password FROM user u, school s WHERE u.FK_School = s.PK_School AND s.PK_School = ? AND u.PK_User = ? LIMIT 1", $school_id, $user_id);

        if($result->numRows() >= 1){
            $tmp_user = $result->fetchArray();
            $this->username = $tmp_user["username"];
            $this->user_id = $tmp_user["PK_User"];
            $this->school_id = $tmp_user["PK_School"];
            $this->password = $tmp_user["password"];
            $this->user_notes = ($tmp_user['notes'] ? $tmp_user['notes'] : "");
            $this->user_exists = true;
        }
        $this->update();
    }

    /** Create password hash value
     * @param $password
     * @return string
     */
    public static function hashPassword($password) : string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /** Check if the password matches a hash value
     * @param $password
     * @param string $hash
     * @return bool
     */
    public function checkPasswordMatch($password, $hash = "") : bool
    {
        if ($hash == "" && $this->password != "") $hash = $this->password;
        if (password_verify($password, $hash)){
            return true;
        }else{
            return false;
        }
    }

    /** Static. Get UserId from database by given username and school id
     * @param $username
     * @param $school_id
     * @return bool
     */
    public static function getUserIdByUsername($username, $school_id)
    {
        $db = new DB();
        $result = $db->query("SELECT PK_User FROM user WHERE username = ? AND FK_School = ?", $username, $school_id);

        if ($result->numRows() >= 0){
            return $result->fetchArray()['PK_User'];
        }else{
            return false;
        }
    }

    /** return all students which are assigned to the given user directly and indirectly. (e.g. through a schoolclass)
     *
     *  TODO: High cohesion. This method could be moved into something called Tools
     *
     * @param User $user
     * @return bool
     */
    public static function getStudentsByUser(User $user) : array
    {
        $db = new DB();

        if ($user->getUserId() < 0) return false;

        $result = $db->query("SELECT *
                                FROM student
                                INNER JOIN user_to_class
                                ON student.FK_Class = user_to_class.FK_Class
                                WHERE FK_User = ?", $user->getUserId()
        );

        $students = array();

        if($result->numRows() >= 0){
            $values = $result->fetchAll();
            foreach($values as $value) {
                $tmp_student = new Student();
                $tmp_student->loadStudent($value['PK_Student']);
                //class successfully loaded -> append to global classes array in school object
                if($tmp_student->getStudentId() > 0 ) {
                    $students[] = $tmp_student;
                }
            }
        }

        return $students;
    }

    /** Update current user in database
     *
     * @return bool
     */
    public function update() : bool
    {
        if($this->user_id > -1 ){

            $db = new DB();

            $result = $db->query("UPDATE user SET 
                                            username = ?, 
                                            notes = ? 
                                            WHERE PK_User = ?",
                $this->getUsername(),
                $this->getUserNotes(),
                $this->getUserId()
            );

            if($result->numRows() == 1){
                return true;
            }else{
                return false;
            }

        }else{
            return false;
        }
    }

    public function addAbsence(int $user_id, int $school_id, string $reason, $date_from, $date_to)
    {
        $db = new DB();

        $db->query("INSERT INTO absences (`FK_User`, `FK_School`, `Reason`, `Date_From`, `Date_To`) 
                                VALUES (?,?,?,?,?)", 
                                $user_id, $school_id, $reason, $date_from, $date_to);
        return true;
    }

    public function getAbsencesByUser(User $user)
    {
        $db = new DB();

        if ($user->getUserId() < 0) return false;

        $result = $db->query("SELECT *
                                FROM absences
                                WHERE FK_User = ?", $user->getUserId()
        );

        if($result->numRows() >= 0) {
            $values = $result->fetchAll();
            foreach($values as $value) {
                $this->absences[] = array('Reason' => $value['Reason'], 'Date_From' => $value['Date_From'], 'Date_To' => $value['Date_To']);
                }
            }
    }


    /**
     * @return bool
     */
    public function exists() : bool
    {
        return $this->user_exists;
    }

    /**
     * @return int
     */
    public function getUserId() : int
    {
        return $this->user_id;
    }

    /**
     * @return int
     */
    public function getSchoolId() : int
    {
        return $this->school_id;
    }

    /**
     * @return mixed
     */
    public function getUsername() : string
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
     public function getUserNotes() : string
     {
         return $this->user_notes;
     }

     public function setUserNotes(string $user_notes) : void
     {
         $this->user_notes = $user_notes;
     }

     /**
     * @return array
     */
    public function getAbsences() : array
    {
        return $this->absences;
    }
}