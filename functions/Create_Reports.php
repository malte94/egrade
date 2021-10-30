<?php

class Create_Reports_Class extends Page
{

    /**
     * @var SchoolClass|null
     */
    protected ?SchoolClass $selected_schoolclass = null;

    /**
     * @var Student|null
     */
    protected ?Student $selected_student = null;

    /**
     * @var
     */
    protected Array $students;

    /**
     * @var array
     */
    public $school_classes = array();

    /**
     * @var array
     */
    protected $error = array();

    /**
     * @var int
     */
    private int $selected_template = -1;

    /**
     * @var null | SchoolTemplateVariables
     */
    private ?SchoolTemplateVariables $school_template_variables = null;

    public function __construct()
    {
        parent::__construct($this);

        $school_class_id = Page::getGetVariable("school_class_id");
        $selected_student_id = Page::getGetVariable("student_id");
//        $school_classes = $this->school->getSchoolClasses();
//        $this->school_classes = $school_classes;
    
        // ################### KLASSEN EINLESEN ###################

        //1. lade alle Klassen ins Schulobjekt, unabhägig davon, welche wir sehen wollen

        $this->school->loadSchoolClassesByUser($this->user);

        if($this->school->getSchoolClasses())
        {
            //2. keine Klassen ID angegeben, nimm erste Klasse aus dem Schulklassen Array im Schulobjekt
            if (empty($school_class_id)) {

                //2.1 Wenn die erste gefundene Klasse vorhanden...
                if ($this->school->getSchoolClasses()[0])
                {
                    //2.2 ... dann wähle sie aus
                    $this->selected_schoolclass = $this->school->getSchoolClasses()[0];

                    if ($this->selected_schoolclass->getSchoolClassId() >= 1) {
                        $this->loadStudents();
                    } else {
                        //Fehlermeldung
                    }

                } else {

                    // 2.2 ... oder tue etwas anderes (Fehlermeldung)
                }
            } else {

                if ($this->school->getSchoolClasses())
                {
                    foreach ($this->school->getSchoolClasses() as $school_class)
                    {
                        if ($school_class->getSchoolClassId() == $school_class_id)
                        {
                            if ($this->rights->userMaySeeClass($this->user, $school_class))
                            {
                                $this->selected_schoolclass = $school_class;
                                $this->loadStudents();
                            }
                        }
                    }

                } else {
                    //Fehler Keine Schulklassen
                }
            }

            // ################### STUDENTEN EINLESEN ###################

            if (!empty($selected_student_id)) {

                // ... dann Student per URL ausgewählt

                foreach ($this->students as $student) {
                    if ($student->getStudentID() == $selected_student_id) {
                        $this->selected_student = $student;
                        break;
                    }
                }

            } elseif (empty($selected_student_id)) {

                // ... dann schaue, ob es zu einer ersten Klasse Studenten gibt

                if ($this->selected_schoolclass->getSchoolClassId() >= 1) {
                    $this->loadStudents();
                    foreach ($this->students as $student) {
                        $this->selected_student = $student;
                        break;
                    }
                }

            }
        }

        //load all templates/grades from this student
        //TODO: Seperate this in own class

        if (!empty($selected_student)) {

            $db = new DB();
            $result = $db->query("SELECT * FROM templates WHERE FK_Student = ? AND FK_Class = ? ORDER BY Date_Changed", $this->selected_student->getStudentID(), $this->selected_schoolclass->getSchoolClassId());

            if ($result->numRows() > 0) {
                $this->selected_template = $result->fetchArray()['PK_Templates'];
            }
        }

        // AJAX & FETCH ----------------------------------------------------

        if (Page::getGetVariable("printGrade", FILTER_SANITIZE_STRING) == "1") {
            $this->renderGrade();

        } elseif ($this->getIsAjax() && Page::getGetVariable("showClassesDialogue") == "1") {
            header("Content-Type: text/html");
            echo $this->showClasses();
        } elseif ($this->getIsAjax() && Page::getGetVariable("showClassesVariables") == "1") {
            header("Content-Type: text/html");
            echo $this->showClassesVariables();
        } elseif ($this->getIsAjax() && Page::getGetVariable("showStudentVariables") == "1") {
            header("Content-Type: text/html");
            echo $this->showStudentVariables();
        } elseif ($this->getIsAjax() && Page::getGetVariable("printReport") == "1") {
            header("Content-Type: text/html");
            echo $this->showPrintReport();
        } elseif ($this->getIsAjax() && Page::getGetVariable("deleteReport") == "1") {
            header("Content-Type: text/html");
            echo $this->showDeleteReport();
        } elseif($this->getIsAjax() && Page::getGetVariable("action", FILTER_SANITIZE_STRING) == "updateClasssTemplateVariables"){
            $this->updateClassTemplateVariables();
        }elseif($this->getIsAjax() && Page::getGetVariable("action", FILTER_SANITIZE_STRING) == "updateStudentTemplateVariables") {
            $this->updateStudentTemplateVariables();
        }elseif(Page::getGetVariable("action", FILTER_SANITIZE_STRING) == "createReportsBatch") {
            $this->createReportsBatch();
        }else {
            $this->render();
        }

    }

    public function loadStudents()
    {
        if (!empty($this->selected_schoolclass)) {
            $this->students = Student::getStudentsBySchoolClass($this->selected_schoolclass);
        }
    }

    public function showClasses()
    {
        $route_url = $this->getRouteUrl("create_reports", "");

        $loader = new \Twig\Loader\FilesystemLoader(ROOT_PATH . '/template/');
        $this->template = new \Twig\Environment($loader, [
            'cache' => ROOT_PATH . '/template/cache/',
            'cache' => false,
            'debug' => true,
        ]);

        return $this->template->load("Blocks.html")->renderBlock('create_reports_classes',
            [
                "schoolClasses" => $this->school->getSchoolClasses(),
                "routeUrl" => $route_url
            ]);
    }

    public function showPrintReport()
    {
        $route_url = $this->getRouteUrl("create_reports", "");

        $loader = new \Twig\Loader\FilesystemLoader(ROOT_PATH . '/template/');
        $this->template = new \Twig\Environment($loader, [
            'cache' => ROOT_PATH . '/template/cache/',
            'cache' => false,
            'debug' => true,
        ]);

        return $this->template->load("Blocks.html")->renderBlock('create_reports_print_report',
            [
                "schoolClasses" => $this->school->getSchoolClasses(),
                "routeUrl" => $route_url,
                "selectedStudent" => $this->selected_student,
                "urlClasses" => $this->getRouteUrl("My_classes", ""),
                "urlReport" => $this->getRouteUrl("create_reports", "&school_class_id=" . $this->selected_schoolclass->getSchoolClassId() . "&student_id=")
            ]);
    }

    public function showDeleteReport()
    {
        $route_url = $this->getRouteUrl("create_reports", "");

        $loader = new \Twig\Loader\FilesystemLoader(ROOT_PATH . '/template/');
        $this->template = new \Twig\Environment($loader, [
            'cache' => ROOT_PATH . '/template/cache/',
            'cache' => false,
            'debug' => true,
        ]);

        return $this->template->load("Blocks.html")->renderBlock('create_reports_delete_report',
            [
                "schoolClasses" => $this->school->getSchoolClasses(),
                "routeUrl" => $route_url,
                "selectedStudent" => $this->selected_student,
                "urlClasses" => $this->getRouteUrl("My_classes", ""),
                "urlReport" => $this->getRouteUrl("create_reports", "&school_class_id=" . $this->selected_schoolclass->getSchoolClassId() . "&student_id=")
            ]);
    }

    public function showClassesVariables()
    {

        $school_class_template = null;

        // Lade school class template
        if($this->selected_schoolclass)
        {
            $school_class_template = $this->school_template_map->getTemplateByClassLevel($this->selected_schoolclass->getSchoolClassLevel(), $this->selected_schoolclass->getIsHalfYear());
        }

        if ($school_class_template) {
            if ($this->selected_student) {
                $school_class_template = $this->school_template_map->getTemplateByClassLevel($this->selected_schoolclass->getSchoolClassLevel(), $this->selected_schoolclass->getIsHalfYear());

                $template_variables = new SchoolTemplateVariables($school_class_template);
                $template_variables->loadSchoolTemplateVariablesBySchool($this->school);
                $template_variables->loadSchoolTemplateVariablesByClass($this->selected_schoolclass);

                $tmp_template_vars_html = [];
                foreach($template_variables->getSchoolTemplateVariablesFiltered(TemplateVariableType::SCHOOL_CLASS) as $template_variable)
                {
                    $tmp_template_vars_html[] = $template_variable->getHtml();
                }
            }
        }

        $route_url = $this->getRouteUrl("create_reports", "");

        $loader = new \Twig\Loader\FilesystemLoader(ROOT_PATH . '/template/');
        $this->template = new \Twig\Environment($loader, [
            'cache' => ROOT_PATH . '/template/cache/',
            'cache' => false,
            'debug' => true,
        ]);

        return $this->template->load("Blocks.html")->renderBlock('create_reports_template_variables_class',
            [
                "schoolClasses" => $this->school->getSchoolClasses(),
                "routeUrl" => $route_url,
                "template_vars" => $tmp_template_vars_html
            ]);
    }

    public function showStudentVariables()
    {
        $school_class_template = null;

        // Lade school class template
        if($this->selected_schoolclass)
        {
            $school_class_template = $this->school_template_map->getTemplateByClassLevel($this->selected_schoolclass->getSchoolClassLevel(), $this->selected_schoolclass->getIsHalfYear());
        }

        if ($school_class_template) {
            if ($this->selected_student) {
                $school_class_template = $this->school_template_map->getTemplateByClassLevel($this->selected_schoolclass->getSchoolClassLevel(), $this->selected_schoolclass->getIsHalfYear());

                $template_variables = new SchoolTemplateVariables($school_class_template);
                $template_variables->loadSchoolTemplateVariablesBySchool($this->school);
                $template_variables->loadSchoolTemplateVariablesByClass($this->selected_schoolclass);
                $template_variables->loadSchoolTemplateVariablesByStudent($this->selected_student);

                $tmp_template_vars_html = [];

                foreach($template_variables->getSchoolTemplateVariablesFiltered(TemplateVariableType::STUDENT ) as $template_variable)
                {
                    $tmp_template_vars_html[] = $template_variable->getHtml();
                }
            }
        }

        $route_url = $this->getRouteUrl("create_reports", "");

        $loader = new \Twig\Loader\FilesystemLoader(ROOT_PATH . '/template/');
        $this->template = new \Twig\Environment($loader, [
            'cache' => ROOT_PATH . '/template/cache/',
            'cache' => false,
            'debug' => true,
        ]);

        return $this->template->load("Blocks.html")->renderBlock('create_reports_template_variables_student',
            [
                "schoolClasses" => $this->school->getSchoolClasses(),
                "routeUrl" => $route_url,
                "template_vars" => $tmp_template_vars_html
            ]);
    }

    private function renderGrade()
    {
        $school_class_template = $this->school_template_map->getTemplateByClassLevel($this->selected_schoolclass->getSchoolClassLevel(), $this->selected_schoolclass->getIsHalfYear());

        $module_loader = new ModuleLoader($school_class_template->getTemplateModuleName(), $this->school->getFederalState());

        $template_variables = new SchoolTemplateVariables($school_class_template);
        $template_variables->loadSchoolTemplateVariablesBySchool($this->school);
        $template_variables->loadSchoolTemplateVariablesByClass($this->selected_schoolclass);

        $module_loader->loadModule($this->school, $this->selected_schoolclass, $this->selected_student, $template_variables);

        if ($module_loader->module->generatePrintTemplate())
        {

            ob_clean();
            header("Content-Type: application/pdf;charset=utf-8");
            header('Content-disposition: filename="Zeugnis.pdf"');


            echo $module_loader->module->getPrintTemplate()->output();
            ob_flush();
            exit;
        }
    }

    public function render()
    {
        $school_class_template = null;

        // Lade school class template
        if($this->selected_schoolclass)
        {
            $school_class_template = $this->school_template_map->getTemplateByClassLevel($this->selected_schoolclass->getSchoolClassLevel(), $this->selected_schoolclass->getIsHalfYear());
        }

        if ($school_class_template) {
            if ($this->selected_student) {

                $template_variables = new SchoolTemplateVariables($school_class_template);
                $template_variables->loadSchoolTemplateVariablesByClass($this->selected_schoolclass);

                $module_loader = new ModuleLoader($school_class_template->getTemplateModuleName(), $this->school->getFederalState());
                $module_loader->loadModule($this->school, $this->selected_schoolclass, $this->selected_student, $template_variables);


                $tmp_template_vars_html = [];
                foreach($template_variables->getSchoolTemplateVariables() as $template_variable)
                {
                    $tmp_template_vars_html[] = $template_variable->getHtml();
                }

                if(!$this->getIsAjax())
                {
                    $module_content = $module_loader->module->render([]);

                    echo $this->view("Create_Reports.html")->display(
                        [
                            "module_content" => $module_content,
                            "school_class_template" => $school_class_template,
                            "schoolClasses" => $this->school->getSchoolClasses(),
                            "selectedSchoolClass" => $this->selected_schoolclass,
                            "students" => $this->students,
                            "selectedStudent" => $this->selected_student,
                            "urlClasses" => $this->getRouteUrl("My_classes", ""),
                            "urlReport" => $this->getRouteUrl("create_reports", "&school_class_id=" . $this->selected_schoolclass->getSchoolClassId() . "&student_id="),
                            "urlStudent" => $this->getRouteUrl("Schoolclass_Details", "&school_class_id=" . $this->selected_schoolclass->getSchoolClassId() . "&student_id="),
                            "urlSchoolClassDetails" => $this->getRouteUrl("Schoolclass_Details", "&school_class_id=" . $this->selected_schoolclass->getSchoolClassId()),
                            "urlStudentProfile" => $this->getRouteUrl("Student_Details", "&school_class_id=" . $this->selected_schoolclass->getSchoolClassId() . "&student_id="),
                            "schoolTemplateDefined" => 1,
                            "template_vars" => $tmp_template_vars_html
                        ]
                    );
                }

            } else {
                $this->view("Create_Reports.html")->display([
                    "schoolClasses" => $this->school->getSchoolClasses(),
                    "selectedSchoolClass" => $this->selected_schoolclass,
                    "students" => $this->students,
                    "selectedStudent" => $this->selected_student,
                    "urlClasses" => $this->getRouteUrl("My_classes", ""),
                    "urlReport" => $this->getRouteUrl("create_reports", "&school_class_id=" . $this->selected_schoolclass->getSchoolClassId() . "&student_id="),
                    "urlStudent" => $this->getRouteUrl("Schoolclass_Details", "&school_class_id=" . $this->selected_schoolclass->getSchoolClassId() . "&student_id="),
                    "urlStudentProfile" => $this->getRouteUrl("Student_Details", "&school_class_id=" . $this->selected_schoolclass->getSchoolClassId() . "&student_id="),
                    "schoolTemplateDefined" => "1"
                ]);
            }

        } elseif($this->selected_student) {
            //TODO: Für diese Klassenstufe wurde noch kein Template ausgewählt. sauber abfangen und anzeigen, dies kann durchaus vorkommen und ist eine "gewollte Fehldermeldung"
            //Hier sollte per %Block% dann eine Fehlermeldung erscheinen, dass kein Zeugnis-Template für diese Klassen-Stufe konfiguert wurde. Derzeit einfach nur den Twig Block kopiert damit irgendwas angezeigt wird
            $this->view("Create_Reports.html")->display([
                "schoolClasses" => $this->school->getSchoolClasses(),
                "selectedSchoolClass" => $this->selected_schoolclass,
                "students" => $this->students,
                "selectedStudent" => $this->selected_student,
                "urlClasses" => $this->getRouteUrl("My_classes", ""),
                "urlReport" => $this->getRouteUrl("create_reports", "&school_class_id=" . $this->selected_schoolclass->getSchoolClassId() . "&student_id="),
                "urlStudent" => $this->getRouteUrl("Schoolclass_Details", "&school_class_id=" . $this->selected_schoolclass->getSchoolClassId() . "&student_id="),
                "urlStudentProfile" => $this->getRouteUrl("Student_Details", "&school_class_id=" . $this->selected_schoolclass->getSchoolClassId() . "&student_id="),
                "schoolTemplateDefined" => "0"
            ]);
        }else{ // no tempplate, class and student available
            //Hier sollte per %Block% dann eine Fehlermeldung erscheinen, dass kein Zeugnis-Template für diese Klassen-Stufe konfiguert wurde. Derzeit einfach nur den Twig Block kopiert damit irgendwas angezeigt wird
            $this->view("Create_Reports.html")->display([
                "schoolTemplateDefined" => "0",
                "urlClasses" => $this->getRouteUrl("My_classes", "")
            ]);
        }

    }

    public function updateClassTemplateVariables() : void
    {
        $success = false;

        //TODO: Input validation!
        $template_variable_data = $_POST['data'];

        $school_templates = SchoolTemplate::getTemplatesBySchool($this->school);

        foreach($school_templates as $school_template)
        {
            //when submitted template id is registered for this school
            if($school_template->getId() == (int)$template_variable_data["idtemplate"])
            {
                $template_variable = SchoolTemplateVariable::loadById((int)$template_variable_data["templatevarid"]);

                //variable match
                if($template_variable->getId() == (int)$template_variable_data["templatevarid"])
                {
                    if($template_variable_data["value"])
                    {
                        //save value for this variable/school tupel
                        $template_variable->setValueType(TemplateVariableType::SCHOOL_CLASS);
                        if($template_variable->saveValueBySchoolClass($this->selected_schoolclass, $template_variable_data["value"])) $success = true;
                    }

                    break;
                }
            }
        }

        ob_clean();
        header("Content-Type: application/json");
        echo json_encode(["success" => $success]);
        ob_flush();
    }

    public function updateStudentTemplateVariables() : void
    {
        $success = false;

        //TODO: Input validation!
        $template_variable_data = $_POST['data'];

        $school_templates = SchoolTemplate::getTemplatesBySchool($this->school);

        foreach($school_templates as $school_template)
        {
            //when submitted template id is registered for this school
            if($school_template->getId() == (int)$template_variable_data["idtemplate"])
            {
                $template_variable = SchoolTemplateVariable::loadById((int)$template_variable_data["templatevarid"]);

                //variable match
                if($template_variable->getId() == (int)$template_variable_data["templatevarid"])
                {
                    if($template_variable_data["value"])
                    {
                        //save value for this variable/school tupel
                        $template_variable->setValueType(TemplateVariableType::STUDENT);
                        if($template_variable->saveValueByStudent($this->selected_student, $template_variable_data["value"])) $success = true;
                    }

                    break;
                }
            }
        }

        ob_clean();
        header("Content-Type: application/json");
        echo json_encode(["success" => $success]);
        ob_flush();
    }

    public function createReportsBatch() : void
    {
        $school_class_template = $this->school_template_map->getTemplateByClassLevel($this->selected_schoolclass->getSchoolClassLevel(), $this->selected_schoolclass->getIsHalfYear());

        $module_loader = new ModuleLoader($school_class_template->getTemplateModuleName(), $this->school->getFederalState());

        $template_variables = new SchoolTemplateVariables($school_class_template);
        $template_variables->loadSchoolTemplateVariablesBySchool($this->school);
        $template_variables->loadSchoolTemplateVariablesByClass($this->selected_schoolclass);

        $students = Student::getStudentsBySchoolClass($this->selected_schoolclass);

        $zip = new ZipArchive();

        $tmp_dir = sys_get_temp_dir();
        $tmp_file = $tmp_dir."/egradeBatchTmpFile" . md5($this->user-$this->getSession()->getSessionID()) ."_".time().".tmp";

        unlink($tmp_file);

        if ($zip->open($tmp_file, ZipArchive::CREATE) === true) {

            foreach ($students as $student) {
                $module_loader->loadModule($this->school, $this->selected_schoolclass, $student, $template_variables);

                if ($module_loader->module->generatePrintTemplate()) {
                    $zip->addFromString
                    (
                        $student->getFirstname() . "_" . $student->getLastname() . ".pdf",
                        $module_loader->module->getPrintTemplate()->output()
                    );
                }
            }

            $zip->close();

            $download_filename = "Zeugnisse_" . $this->selected_schoolclass->getSchoolClassName() . "_" . ($this->selected_schoolclass->getIsHalfYear() == 0 ? "Halbjahr" : "Ganzjahr") . "_" . date("Y-m-d") .".zip";

            ob_clean();
            header("Content-Type: application/zip, application/octet-stream");
            header('Content-disposition: filename="'.$download_filename.'"');
            echo file_get_contents($tmp_file);
            ob_flush();
            exit;
        }else{
            echo "Cant create tmp file";
        }

    }
}

?>