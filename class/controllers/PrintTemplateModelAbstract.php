<?php
abstract class PrintTemplateModelAbstract
{
    /**
     * @var int
     */
    protected int $pk_template = -1;

    /**
     * @var string
     */
    protected string $module_name = "";
    /**
     * @var School
     */
    protected School $school;
    /**
     * @var SchoolClass
     */
    protected SchoolClass $school_class;
    /**
     * @var Student
     */
    protected Student $student;

    /**
     * @var null
     */
    public ?SchoolTemplateVariables $school_template_variables = null;

    public function __construct($module_name, School $school, SchoolClass $school_class, Student $student)
    {
        $this->module_name = $module_name;
        $this->school = $school;
        $this->school_class = $school_class;
        $this->student = $student;
    }

    public function setPkTemplate(int $id) : void
    {
        $this->pk_template = $id;
    }

    public function getPkTemplate() : int
    {
        return $this->pk_template;
    }

    public function getSchool() : School
    {
        return $this->school;
    }

    public function getSchoolClass() : SchoolClass
    {
        return $this->school_class;
    }

    public function getStudent() : Student
    {
        return $this->student;
    }

    public function setSchool(School $school) : void
    {
        $this->school = $school;
    }

    public function setSchoolClass(SchoolClass $school_class) : void
    {
        $this->school_class = $school_class;
    }

    public function setStudent(Student $student) : void
    {
        $this->student = $student;
    }

    public function setSchoolTemplateVariables(SchoolTemplateVariables $school_template_variables) : void
    {
        $this->school_template_variables = $school_template_variables;
    }

    public function getSchoolTemplateVariables() : ?SchoolTemplateVariables
    {
        return $this->school_template_variables;
    }

    public abstract function serialize() : string;
    public abstract function deserialize(string $content) : bool;
    public abstract function getSchoolTemplateId() : int;
}