<?php
class School
{
    /**
     * @var int
     */
    private int $school_id = -1;

    /**
     * @var string
     */
    private string $school_name = "";

    /**
     * @var string
     */
    private string $school_shortcut = "";

    /**
     * @var Array
     */
    private array $school_classes = array();

    /**
     * @var Federal
     */
    private Federal $federal_state;

    public function __construct($school_id)
    {
        $db = new DB();
        $result = $db->query("SELECT * FROM school WHERE PK_School = ?", $school_id);

        if($result->numRows() >= 1)
        {
            $tmp_school = $result->fetchArray();
            $this->school_id = $tmp_school["PK_School"];
            $this->school_shortcut = $tmp_school["id"];
            $this->school_name = $tmp_school["Name"];
            $this->federal_state = Federal::createFederal($tmp_school['Federal']);
        }
    }

    public static function getSchoolIdByShortcut($shortcut) : int
    {
        $db = new DB();
        $result = $db->query("SELECT PK_School FROM school WHERE id = ? ", $shortcut);

        if ($result->numRows() >= 0)
        {
            return $result->fetchArray()['PK_School'];
        }else{
            return -1;
        }
    }

    /**
     * Be aware that this function loads ALL classes for actual school
     * @return bool
     */
    public function loadSchoolClasses() : bool
    {
        $db = new DB();

        if ($this->school_id <= 0) return false;

        $result = $db->query("SELECT PK_Class FROM class WHERE FK_School = ?", $this->school_id);

        $this->school_classes = array();

        if($result->numRows() >= 0)
        {
            $values = $result->fetchAll();

            foreach($values as $value)
            {
                $tmp_class = new SchoolClass();
                $tmp_class->loadClass($value['PK_Class']);

                //class successfully loaded -> append to global classes array in school object
                if($tmp_class->getSchoolClassId() > 0 )
                {
                    $this->school_classes[] = $tmp_class;
                }
            }

            return true;

        }else{
            return false;
        }
    }

    /**
     * @param User $user
     * @return bool
     */
    public function loadSchoolClassesByUser(User $user) : bool
    {
        $db = new DB();

        if ($user->getUserId() < 0) return false;
        if ($this->school_id <= 0) return false;

        $result = $db->query("SELECT PK_Class FROM 
                                    class AS c, 
                                    user_to_class as utc, 
                                    user AS u
                                    WHERE 
                                    c.PK_Class = utc.FK_Class AND
                                    u.PK_User = utc.FK_User AND 
                                    utc.FK_User = ? AND
                                    u.FK_School = ?",
            $user->getUserId(),
            $this->school_id
            );

        $this->school_classes = array();

        if($result->numRows() >= 0)
        {
            $values = $result->fetchAll();

            foreach($values as $value)
            {
                $tmp_class = new SchoolClass();
                $tmp_class->loadClass($value['PK_Class']);

                //class successfully loaded -> append to global classes array in school object
                if($tmp_class->getSchoolClassId() > 0 )
                {
                    $this->school_classes[] = $tmp_class;
                }
            }

            return true;

        }else{
            return false;
        }
    }

    /** Update whole school class object in db
     *
     * @return bool
     */
    public function update() : bool
    {
        if($this->getSchoolId() > 0)
        {
            $db = new DB();

            $db->startTransaction();

            $result = $db->query("UPDATE school SET
                                            `id` = ?,
                                            `Name` = ?,
                                            `Federal` = ?
                                        WHERE PK_School = ?",
                $this->getSchoolShortcut(),
                $this->getSchoolName(),
                $this->getFederalState()->getId(),
                $this->getSchoolId());

            $db->commitTransaction();

            if($result->affectedRows() > 0 )
            {
                return true;
            }
        }

        return false;
    }

    /**
     * @param SchoolClass $class
     */
    public function addSchoolClass(SchoolClass $class) : void
    {
        $this->school_classes[] = $class;
    }

    /**
     * @return int
     */
    public function getSchoolId() : int
    {
        return $this->school_id;
    }

    /**
     * @return string
     */
    public function getSchoolName() : string
    {
        return $this->school_name;
    }

    /**
     * @return array
     */
    public function getSchoolClasses() : array
    {
        return $this->school_classes;
    }

    /**
     * @return array
     */
    public function getSchoolClassesByUser(User $user) : array
    {
        if(empty($this->school_classes))
        {
            $this->loadSchoolClassesByUser($user);
        }

        return $this->school_classes;
    }

    /**
     * @return Federal
     */
    public function getFederalState() : Federal
    {
        return $this->federal_state;
    }

    /**
     * @param string $name
     */
    public function setSchoolName(string $name) : void
    {
        if($this->getSchoolId() > 0)
        {
            $this->school_name = $name;
        }
    }

    /**
     * @return string
     */
    public function getSchoolShortcut() : string
    {
        return $this->school_shortcut;
    }
}