<?php

/**
 * Class Module
 */
abstract class Module
{
    /**
     * @var Student|null
     */
    public ?Student $student = null;

    /**
     * @var SchoolClass|null
     */
    public ?SchoolClass $school_class = null;

    /**
     * @var School
     */
    public School $school;

    /**
     * @var int
     */
    public int $class_level = 1;

    /**
     * @var null
     */
    public ?PrintTemplateModelAbstract $model = null;

    /**
     * @var IPrintTemplate
     */
    private ?IPrintTemplate $print_template = null;

    /**
     * @var Federal
     */
    private Federal $federal;

    /**
     * @var string
     */
    private string $module_name = "";

    /**
     * @var null | SchoolTemplateVariables
     */
    public ?SchoolTemplateVariables $school_template_variables = null;


    public function __construct(School $school,  SchoolClass $school_class, Student $student, Federal $federal, string $module_name, SchoolTemplateVariables $school_template_variables)
    {
        $this->school = $school;
        $this->school_class = $school_class;
        $this->student = $student;
        $this->federal = $federal;
        $this->module_name = $module_name;
        $this->school_template_variables = $school_template_variables;
    }

    /**
     * @return PrintTemplateModelAbstract
     */
    public function loadModel(): PrintTemplateModelAbstract
    {
//        $model_name = $model_name . "_model";
        $model_name = $this->module_name . "_model";
        $model = new $model_name();

        $db = new DB();
        $result = $db->query("SELECT * FROM templates WHERE FK_Student = ? AND FK_Class = ? AND FK_School = ? AND Class_Level = ? AND Is_Halfyear = ? ORDER BY Date_Changed desc LIMIT 1",
            $this->student->getStudentID(),
            $this->school_class->getSchoolClassId(),
            $this->school->getSchoolId(),
            $this->school_class->getSchoolClassLevel(),
            $this->school_class->getIsHalfYear()
        );

        if ($result->numRows() >= 1) {
            $result = $db->fetchArray();
            //check twice is important in case of manipulation
            if ($this->student->getStudentID() == $result['FK_Student'] && $this->school_class->getSchoolClassId()) {
                $model->deserialize($result['Template_c']);
                $model->setPkTemplate($result['PK_Templates']);
            }
        }

        return $model;
    }

    /**
     * @return bool
     */
    public function saveModel(): bool
    {
        if (empty($this->model)) return false;
        $db = new DB();

        //insert
        if ($this->model->getPkTemplate() == -1) {
            $db->query("INSERT INTO templates (FK_Student, FK_Class, FK_School, Template_c, Date_Changed, Class_Level, Is_Halfyear, FK_School_Template) VALUES (?,?,?,?,NOW(),?,?,?)",
                $this->student->getStudentId(),
                $this->school_class->getSchoolClassId(),
                $this->school->getSchoolId(),
                $this->model->serialize(),
                $this->school_class->getSchoolClassLevel(),
                $this->school_class->getIsHalfYear(),
                $this->model->getSchoolTemplateId()
            );
        } else { //update
            $db->query("UPDATE templates SET Template_c = ?, Date_Changed = NOW() WHERE PK_Templates = ?",
                $this->model->serialize(),
                $this->model->getPkTemplate()
            );
        }

        return true;
    }

    /**
     * @param array $template_vars
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render(array $template_vars): string
    {
        //Parse whole model
        $template_vars['model'] = $this->model;

        $loader = new \Twig\Loader\FilesystemLoader([ROOT_PATH . '/Modules/' . $this->getModulePath(), ROOT_PATH . '/template/']);
        $this->template = new \Twig\Environment($loader, [
            'cache' => ROOT_PATH . '/Modules/' . $this->getModulePath() . "/cache/",
            'cache' => false,
            'debug' => true,
        ]);

        return $this->template->load($this->module_name . "_view.html")->render($template_vars);
    }

    public function generatePrintTemplate() : string
    {
        $template_name = $this->module_name . "_print";
        //TODO: Improve path generation
        $full_template_path_file = ROOT_PATH . "/" . "Modules" . "/" . $this->federal->getShort(). "/" . $this->module_name . "/" . $this->module_name . "_print.php";

        if (file_exists($full_template_path_file)) {
//            require_once($full_template_path_file);

            if ($this->loadModel()) {

//                $this->model->deserialize($this->loadModelData($this->student->getStudentID(), $this->school_class->getSchoolClassId()));

                $this->model->setSchool($this->school);
                $this->model->setSchoolClass($this->school_class);
                $this->model->setStudent($this->student);
                $this->model->setSchoolTemplateVariables($this->school_template_variables);

                $this->print_template = new $template_name($this->model);
                $this->print_template->render();
                return true;

            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getPrintTemplate() : ?IPrintTemplate
    {
        return $this->print_template;
    }

    private function getModulePath() : string
    {
        return $this->federal->getShort() . "/". $this->module_name;
    }

    public function getIsAjax() : bool
    {
        return (Page::getGetVariable("is_ajax", FILTER_SANITIZE_STRING) == "1" ? true : false);
    }

    public function getSchoolTemplateVariables() : ?SchoolTemplateVariables
    {
        return $this->school_template_variables;
    }
}