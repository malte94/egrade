<?php

class SchoolClass
{
    /**
     * @var int
     */
    private int $school_class_id = -1;

    /**
     * @var string
     */
    private string $school_class_name = "";

    /**
     * @var int
     */
    private int $school_class_level = -1;

    /**
     * @var int
     */
    private int $is_halfyear = 0;

    /**
     * @var int
     */
    private int $school_id = -1;

    /**
     * @var int
     */
    private int $enrollment_year = -1;

    /**
     * @var int
     */
    private int $student_count = -1;

    public function __construct()
    {

    }

    /** Load class with given id from database in this instance.
     *
     * @param $school_class_id
     */
    public function loadClass($school_class_id): void
    {
        $db = new DB();
        $result = $db->query("SELECT * FROM class WHERE Pk_Class = ?", $school_class_id);

        if ($result->numRows() >= 1) {
            $tmp_class = $result->fetchArray();
            $this->school_class_id = $tmp_class["PK_Class"];
            $this->school_id = $tmp_class["FK_School"];
            $this->school_class_name = $tmp_class["Name"];
            $this->enrollment_year = $tmp_class["Enrollment"];
            $this->school_class_level = $tmp_class["Level"];
            $this->is_halfyear = (int)$tmp_class["Is_Halfyear"];

            $student_count = $db->query("SELECT PK_Student FROM student WHERE Fk_Class = ?", $school_class_id);
            $this->student_count = $student_count->numRows();
        }
    }

    /** Create SchoolClass object, persist in database and return.
     *
     * @param $school_id
     * @param $enrollment_year
     * @param $schoolclass_name
     * @param $class_level
     * @return SchoolClass
     */
    public static function createSchoolClass(int $school_id, int $enrollment_year, string $schoolclass_name, int $class_level, int $is_halfyear): SchoolClass
    {
        $db = new DB();

        $result = $db->query("INSERT INTO class (`FK_School`, `Name`, `Enrollment`, `Level`, `Is_Halfyear`) VALUES (?,?,?,?,?)", $school_id, $schoolclass_name, $enrollment_year, $class_level, $is_halfyear);

        $school_class = new SchoolClass();
        $school_class->loadClass($result->getLastInsertId());

        return $school_class;
    }

    /** Persist current state of SchoolClass instance to database
     *
     * @return bool
     */
    public function update(): bool
    {
        if ($this->school_class_id >= 0) {

            $db = new DB();

            $result = $db->query("UPDATE class SET 
                                    `Name` = ?,
                                    `Enrollment` = ?, 
                                    `Level` = ?,
                                    `Is_Halfyear` = ? 
                                    WHERE PK_Class = ?",
                $this->school_class_name,
                $this->enrollment_year,
                $this->school_class_level,
                ($this->is_halfyear === 0 ? 0 : 1),
                $this->school_class_id
            );

            if ($result->numRows() == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * delete this school class if existent (id > 0)
     */
    public function delete(): void
    {
        if ($this->getSchoolClassId() >= 0) {
            $db = new DB();

            $db->startTransaction();

                $db->query("DELETE FROM templates WHERE FK_Class = ?", $this->getSchoolClassId());
                $db->query("DELETE FROM `student` WHERE `student`.`FK_Class` = ?", $this->getSchoolClassId());
                $db->query("DELETE FROM `templates` WHERE `templates`.`FK_Class` = ?", $this->getSchoolClassId());
                $db->query("DELETE FROM `class` WHERE `class`.`PK_Class` = ?", $this->getSchoolClassId());

            $db->commitTransaction();
        }
    }

    /** assign a user to this class
     *
     * @param User $user
     * @return bool
     */
    public function assignUser(User $user): bool
    {
        if ($user->getUserId() >= 0) {
            $db = new DB();
            $db->query("INSERT IGNORE INTO user_to_class (FK_User, FK_Class) VALUES (?,?)", $user->getUserId(), $this->getSchoolClassId());
        } else {
            return false;
        }

        return true;
    }

    /**
     * @param int $enrollment_year
     * @return bool
     */
    public static function isValidEnrollmentYear(int $enrollment_year): bool
    {
        if ($enrollment_year >= 1990 && $enrollment_year <= intval(date('Y')) + 4) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $schoolclass_name
     * @return bool
     */
    public static function isValidSchoolClassName(string $schoolclass_name): bool
    {
        return true;
    }

    /**
     * @param int $school_class_level
     * @return bool
     */
    public static function isValidSchoolClassLevel(int $school_class_level): bool
    {
        if ($school_class_level < 5 && $school_class_level >= 1) {
            return true;
        } else {
            return false;
        }
    }

    /** creates school class from Student object
     *
     * @param Student $student
     * @return SchoolClass|null
     */
    public static function getSchoolClassByStudent(Student $student): ?SchoolClass
    {
        if ($student->getSchoolClassId() >= 0)
        {
            $school_class = new SchoolClass();
            $school_class->loadClass($student->getSchoolClassId());

            return $school_class;
        }

        return null;
    }

    /**
     * @return int
     */
    public function getSchoolClassId(): int
    {
        return $this->school_class_id;
    }

    /**
     * @return string
     */
    public function getSchoolClassName(): string
    {
        return $this->school_class_name;
    }

    /**
     * @param string $school_class_name
     */
    public function setSchoolClassName(string $school_class_name): void
    {
        $this->school_class_name = $school_class_name;
    }

    /**
     * @return string
     */
    public function getSchoolClassLevel(): int
    {
        return $this->school_class_level;
    }

    /**
     * @return int
     */
    public function getIsHalfYear(): int
    {
        return $this->is_halfyear;
    }

    /**
     * @param int $is_halfyear
     */
    public function setIsHalfYear(int $is_halfyear): void
    {
        $this->is_halfyear = $is_halfyear;
    }

    /**
     * @param int $school_class_level
     */
    public function setSchoolClassLevel(int $school_class_level): void
    {
        $this->school_class_level = $school_class_level;
    }

    /**
     * @return int
     */
    public function getEnrollmentYear(): int
    {
        return $this->enrollment_year;
    }

    /**
     * @param int $enrollment_year
     */
    public function setEnrollmentYear(int $enrollment_year): void
    {
        $this->enrollment_year = $enrollment_year;
    }

    /**
     * @return int
     */
    public function getStudentCount(): int
    {
        return $this->student_count;
    }
}