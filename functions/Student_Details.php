<?php
class Student_Details_Class extends Page{

    protected ?SchoolClass $selected_schoolclass = null;

    protected ?Student $selected_student = null;

    protected $error = array();

    public function __construct()
    {
        parent::__construct($this);

        $school_class_id = Page::getGetVariable("school_class_id");
        $student_id = Page::getGetVariable("student_id");

        if(empty($school_class_id)){
            echo ("no class id provided - school_class_id - in GET Variable");
        }

        if(empty($student_id)){
            echo ("no student id provided - student_id - in GET Variable");
        }
        $this->school->loadSchoolClasses();

        foreach($this->school->getSchoolClasses() as $value){

            if($value->getSchoolClassId() == $school_class_id){
                $this->selected_schoolclass = $value;
            }
        }

        if($this->selected_schoolclass->getSchoolClassId() >= 1){
            if(!$this->loadStudent($student_id)){
                echo ("Error while loading student with id $student_id from class $this->selected_schoolclass->getSchoolClassId()");
            }
        }

        // UPDATE STUDENT NOTES
        if($this->selected_schoolclass->getSchoolClassId() >= 1){
            if(!empty($student_id)) {
                $student_notes = Page::getPostVariable("student_notes");
                $PK_Student = $student_id;   
                $this->updateStudentNotes($student_notes, $PK_Student);
            }
        }

        $this->render();
    }

    public function loadStudent(int $student_id) : bool
    {
        $found = false;
        if(!empty($this->selected_schoolclass)){
            $students = Student::getStudentsBySchoolClass($this->selected_schoolclass);
            foreach($students as $student){
                if ($student->getStudentID() == $student_id){
                    $this->selected_student = $student;
                    $found = true;
                }
            }
        }

        return $found;
    }

    private function updateStudentNotes(string $student_notes, int $PK_Student)
    {
        Student::updateStudentNotes($student_notes, $PK_Student);
    }

    public function render() {
        $this->view("Student_Details.html")->display([
            'selected_schoolclass' => $this->selected_schoolclass,
            'selected_student' => $this->selected_student,
            "urlStudentProfile" => $this->getRouteUrl("Student_Details", "&school_class_id=".$this->selected_schoolclass->getSchoolClassId()."&student_id="),
            "urlCreateReports" => $this->getRouteUrl("Create_Reports", "&school_class_id=".$this->selected_schoolclass->getSchoolClassId()."&student_id=")
        ]);
    }
}