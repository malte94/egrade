<?php

class Student
{
    /**
     * @var int
     */
    private int $student_id = -1;

    /**
     * @var int
     */
    private int $school_class_id = -1;

    /**
     * @var string
     */
    private string $firstname = "";

    /**
     * @var string
     */
    private string $lastname = "";

    /**
     * @var string
     */
    private ?string $date_of_birth = "";

    /**
     * @var string
     */
    private string $student_notes = "";

    /** 1 = male, 2 = female, 0 = diverse
     * @var int
     */
    private int $gender = 0;

    public function __construct()
    {
    }

    /** Load student from database in this instance
     *
     * @param int $student_id
     * @return bool
     */
    public function loadStudent(int $student_id) : bool
    {
        $db = new DB();
        $result = $db->query("SELECT * FROM student WHERE PK_Student = ? ORDER BY Lastname ASC", $student_id);

        if($result->numRows() >= 1){
            $tmp_student = $result->fetchArray();
            $this->student_id = $tmp_student["PK_Student"];
            $this->school_class_id = $tmp_student["FK_Class"];
            $this->firstname = $tmp_student["Firstname"];
            $this->lastname = $tmp_student["Lastname"];
            $this->date_of_birth = $tmp_student['Birthday'];
            $this->student_notes = $tmp_student['Notes'];
            return true;
        } else
        {
            return false;
        }
    }

    /** Static get all students from class by SchoolClass object
     * TODO: could be moved to SchoolClass because it depends to it.
     *
     * @param SchoolClass $school_class
     * @return array
     */
    public static function getStudentsBySchoolClass(SchoolClass $school_class) : Array
    {
        $school_class_id = $school_class->getSchoolClassId();

        if($school_class_id >= 0){

            $db = new DB();
            $result = $db->query("SELECT * FROM student WHERE FK_Class = ? ORDER BY Lastname ASC", $school_class_id);

            if($result->numRows() >= 1){
                $tmp_students = array();

                foreach($result->fetchAll() as $student_result){
                    $tmp_student = new Student();
                    $tmp_student->loadStudent($student_result['PK_Student']);
                    $tmp_students[] = $tmp_student;
                }

                return $tmp_students;
            }
        }

        return array();
    }

    /**
     * @param int $school_id
     * @param int $class_id
     * @param string $firstname
     * @param string $lastname
     * @param string $date_of_birth
     * @return Student
     */
    public static function createStudent(int $school_id, int $class_id, string $firstname, string $lastname, string $date_of_birth) : Student
    {
        $db = new DB();
        $result = $db->query("INSERT INTO student (FK_School, FK_Class, Firstname, Lastname, Birthday) VALUES (?,?,?,?,?)", $school_id, $class_id, $firstname, $lastname, $date_of_birth);
        $student = new Student();
        $student->loadStudent($result->getLastInsertId());

        return $student;
    }

        /**
     * @param int $PK_Student
     * @return Student
     */
     public static function deleteStudent(int $PK_Student) : Student
     {
         $db = new DB(); 

         $result = $db->query("DELETE FROM templates WHERE FK_Student = ?", $PK_Student);
         $result .= $db->query("DELETE FROM student WHERE PK_Student = ?", $PK_Student);

         if($result->numRows() >= 1){
            return true;
        } else{
            return false;
        }
     }

    /** @deprecated use update/reload to save/reload the whole object instead of single methods for each operation like this one
     * @param string $student_notes
     * @param int $PK_Student
     * @return Student
     */
     public static function updateStudentNotes(string $student_notes, int $PK_Student) : Student
     {
         $db = new DB();
         $result = $db->query("UPDATE student SET `Notes` = ? WHERE PK_Student = ?", $student_notes, $PK_Student);
         $student = new Student();
         return $student;
     }

    /** save the current state of Student to database
     * @return bool
     */
     public function update() : bool
     {
      //Not Implemented
     }

    /** reload the current state of student from database
     *
     * @return bool
     */
     public function reload() : bool
     {
         //Not Implemented
     }

    /**
     * @return string
     */
    public function getFirstname() : string
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getLastname() : string
    {
        return $this->lastname;
    }

    /**
     * @return int
     */
    public function getStudentID() : int
    {
        return $this->student_id;
    }

    /**
     * @return int
     */
     public function getSchoolClassId() : int
     {
         return $this->school_class_id;
     }

    /**
     * @return string
     */
    public function getDateOfBirth() : string
    {
        return $this->date_of_birth;
    }

    /**
     * @return string
     */
    public function getStudentNotes() : string
    {
        return $this->student_notes;
    }

    /**
     * @return int
     */
    public function getGender() : int
    {
        return $this->gender;
    }
}