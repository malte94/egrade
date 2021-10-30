<?php
class Schoolclass_Details_Class extends Page {

    /**
     * @var SchoolClass|null
     */
    protected ?SchoolClass $selected_schoolclass = null;

    protected Array $students;

    protected $error = array();

    public function __construct()
    {
        parent::__construct($this);

        $school_class_id = Page::getGetVariable("school_class_id");

        if (empty($school_class_id)) {
            echo("no class id provided - school_class_id - in GET Variable");
        }

        $this->school->loadSchoolClasses();

        foreach ($this->school->getSchoolClasses() as $value) {

            if ($value->getSchoolClassId() == $school_class_id) {

                //if has has rights
                if($this->rights->userMaySeeClass($this->user, $value))
                {
                    $this->selected_schoolclass = $value;
                }
                break;
            }
        }

        // INITIALIZE
        
        if (!empty($this->selected_schoolclass)) {
            
            if ($this->selected_schoolclass->getSchoolClassId() >= 0) {
                            
                // ADD STUDENT: CHECK

                switch(strtolower(Page::getGetVariable("action"))) {

                case "addstudent":
                    $student_firstname = Page::getPostVariable("student_firstname");
                    $student_lastname = Page::getPostVariable("student_lastname");
                    $student_date_of_birth = Page::getPostVariable("student_date_of_birth");
                
                    if (!empty($student_firstname) && !empty($student_lastname) && !empty($student_date_of_birth)) {
                        $this->addStudent($this->school->getSchoolId(), $school_class_id, $student_firstname, $student_lastname, $student_date_of_birth);
                    }
                    break;

                // DELETE STUDENT: CHECK

                case "deletestudent":
                    $delete_student = Page::getPostVariable("delete_student");
                    if (!empty($delete_student)) {
                        $this->deleteStudent($delete_student);
                    }
                    // Todo: Prüfen, ob aktueller User auch berechtig ist diese Studenten-ID zu löschen
                    break;

                // UPDATE SCHOOL CLASS: CHECK

                case "updateschoolclass":

                    $school_class_name = Page::getPostVariable("class_name");
                    $enrollment_year = Page::getPostVariable("class_enrollment_year");
                    $class_level = Page::getPostVariable("class_level");
                    $is_halfyear = Page::getPostVariable("is_halfyear");
                    $PK_Class = $this->selected_schoolclass->getSchoolClassId();

                    if (!empty($school_class_name) && !empty($class_level) && !empty($enrollment_year) && ($is_halfyear == 0 || $is_halfyear == 1)  && !empty($PK_Class)) {
                        $this->selected_schoolclass->setSchoolClassName($school_class_name);
                        $this->selected_schoolclass->setSchoolClassLevel($class_level);
                        $this->selected_schoolclass->setEnrollmentYear($enrollment_year);
                        $this->selected_schoolclass->setIsHalfYear($is_halfyear);
                        $this->updateSchoolClass();
                    }
                    break;

            
                // DELETE SCHOOL CLASS: CHECK

                case "deleteschoolclass":

                    if ($this->rights->userMayDeleteClass($this->user, $this->selected_schoolclass)) {
                        $this->deleteSchoolClass();
                    } else {
                        //TODO: abfangen und ordentliche Meldung ausgeben
                        echo "Keine Rechte";
                    }
                    break;

                }

                $this->loadStudents();

            }


            // RENDERING ----------------------------------------------------

            if (Page::getGetVariable("asyncDeleteClass") == "1") {
                echo $this->AsyncDeleteClass();
            } else if (Page::getGetVariable("asyncDeleteStudent") == "1") {
                echo $this->AsyncDeleteStudent();
            } else {
                $this->render();
            }

        } else {
            echo ("Die Klasse konnte nicht geladen werden, eventuell besitzen Sie keine Rechte oder diese Klasse existiert nicht!");
            //catch with error page and access violation error
            alert("No class loadable/access violation");
            debug($this);
        }
    }
    
        // -----------------------------------------------------------------

    public function asyncDeleteClass() {
        $loader = new \Twig\Loader\FilesystemLoader(ROOT_PATH.'/template/');
        $this->template = new \Twig\Environment($loader, [
            'cache' => ROOT_PATH.'/template/cache/',
            'cache' => false,
            'debug' => true,
        ]);

        return $this->template->load("Blocks.html")->renderBlock('schoolclass_details_class_remove',
            [
            'students' => $this->students,
            'selected_schoolclass' => $this->selected_schoolclass,
            ]);
    }

    public function asyncDeleteStudent() {
        $loader = new \Twig\Loader\FilesystemLoader(ROOT_PATH.'/template/');
        $this->template = new \Twig\Environment($loader, [
            'cache' => ROOT_PATH.'/template/cache/',
            'cache' => false,
            'debug' => true,
        ]);

        return $this->template->load("Blocks.html")->renderBlock('schoolclass_details_student_remove',
            [
            'students' => $this->students,
            'selected_schoolclass' => $this->selected_schoolclass,
            ]);
    }

    private function addStudent(int $school_id, int $school_class_id, string $student_firstname, string $student_lastname, string $student_date_of_birth)
    {
        Student::createStudent($school_id, $school_class_id, $student_firstname, $student_lastname, $student_date_of_birth); // Direktzugriff da static function in "Students"
    }

    private function deleteStudent(int $PK_Student)
    {
        Student::deleteStudent($PK_Student);
    }

    private function updateSchoolClass() : void
    {
        $this->selected_schoolclass->update();
    }

    /** Delete selected class and redirect to classes overview
     *
     */
    private function deleteSchoolClass() : void
    {
        $this->selected_schoolclass->delete();
        header('Location: index.php?function=my_classes');
    }

    public function loadStudents()
    {
        if(!empty($this->selected_schoolclass)){
           $this->students = Student::getStudentsBySchoolClass($this->selected_schoolclass);
        }
    }

    public function render(){

        $this->view("Schoolclass_Details.html")->display(
            [
                'students' => $this->students,
                'selected_schoolclass' => $this->selected_schoolclass,
                'urlCreateReports' => $this->getRouteUrl("Create_Reports", "&school_class_id=")
            ]);
    }
}