<?php

class Add_Schoolclass_Class extends Page
{
    private $id_new_schoolclass = -1;

    public function __construct()
    {
        parent::__construct($this);

        $enrollment_year = Page::getPostVariable("enrollment_year", FILTER_SANITIZE_NUMBER_INT);
        $schoolclass_name = Page::getPostVariable("schoolclass_name", FILTER_SANITIZE_STRING);
        $class_level = Page::getPostVariable("class_level", FILTER_SANITIZE_NUMBER_INT);
        $is_halfyear = Page::getPostVariable("is_halfyear", FILTER_SANITIZE_NUMBER_INT);

        if(SchoolClass::isValidEnrollmentYear($enrollment_year) && SchoolClass::isValidSchoolClassName($schoolclass_name && SchoolClass::isValidSchoolClassLevel($class_level)))
        {
            $this->addClass($enrollment_year, $schoolclass_name, $class_level, $is_halfyear);
        }

        if($this->is_ajax){
            $this->responseJson();
        }else{
            $this->responsenHtml();
        }
    }

    public function addClass($enrollment_year, $schoolclass_name, $class_level, $is_halfyear)
    {

        //create new SchoolClass
        $school_class = Schoolclass::createSchoolClass($this->school->getSchoolId(), $enrollment_year, $schoolclass_name, $class_level, $is_halfyear);

        if($school_class->getSchoolClassId() >= 0)
        {
            $this->id_new_schoolclass = $school_class->getSchoolClassId();

            //assign current user to this SchoolClass
            $school_class->assignUser($this->user);
            return true;
        }else{
            return false;
        }
    }

    private function responsenHtml()
    {
        if($this->id_new_schoolclass >= 0)
        {
            //return success redirect to details page of this new school class
            header("Location: ". $this->getRouteUrl("Schoolclass_Details", "&school_class_id=" . $this->id_new_schoolclass));
        }else{
            echo "Ein Fehler ist aufgetreten.!";
        }
    }
}

?>