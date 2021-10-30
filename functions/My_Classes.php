<?php

class My_classes_Class extends Page
{
    public $school_classes = array();

    public function __construct()
    {
        parent::__construct($this);

        $this->school->loadSchoolClassesByUser($this->user);
        $school_classes = $this->school->getSchoolClassesByUser($this->user);
        $this->school_classes = $school_classes;

        $this->render();
    }

    public function render()
    {
        $this->view("My_Classes.html")->display([
            'schoolClasses' => $this->school_classes,
            'UrlSchoolClass' => $this->getRouteUrl("Schoolclass_Details", "&school_class_id=")
        ]);
    }
}

?>