<?php

class ModuleLoader
{
    /**
     * @var
     */
    public Module $module;

    /**
     * @var string
     */
    private string $module_name = "";

    /**
     * @var Federal
     */
    private Federal $federal;

    /**
     * @var PrintTemplateModelAbstract
     */
    private ?PrintTemplateModelAbstract $model = null;

    public function __construct(string $module_name, Federal $federal)
    {
        $this->module_name = $module_name;
        $this->federal = $federal;
    }

    /**
     * @param School $school
     * @param SchoolClass $school_class
     * @param Student $student
     * @param SchoolTemplateVariables $school_template_variables
     * @return bool
     */
    public function loadModule(School $school, SchoolClass $school_class, Student $student, SchoolTemplateVariables $school_template_variables) : bool
    {
        if (file_exists(ROOT_PATH . "/Modules/" . $this->federal->getShort() . "/" . $this->module_name)) {
            require_once($this->getModulePath() . "/" . $this->module_name . "_model.php");
            require_once($this->getModulePath()  . "/" . $this->module_name . "_print.php");
            require_once($this->getModulePath()  . "/" . $this->module_name . "_module.php");

            $module_name = $this->module_name . "_module";

            $this->module = new $module_name($school, $school_class, $student, $this->federal, $this->module_name, $school_template_variables);

            return true;

        } else {
            return false;
        }
    }

    public function getModuleName() : string
    {
        return $this->module_name;
    }

    public function getModulePath() : string
    {
        return ROOT_PATH . "/Modules/" . $this->federal->getShort() . "/" . $this->module_name;
    }
}
