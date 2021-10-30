<?php

class Admin_School_Class extends Page
{
    /**
     * @var null|array
     */
    protected ?array $class = array(array());
    /**
     * @var null|array
     */
    protected ?array $class_variables = array(array());
    /**
     * @var null|array
     */
    protected ?array $installed_school_templates = null;

    public function __construct()
    {
        parent::__construct($this);

        $this->class[1][0] = $this->school_template_map->getTemplateByClassLevel(1,0);
        $this->class[1][1] = $this->school_template_map->getTemplateByClassLevel(1,1);
        $this->class[2][0] = $this->school_template_map->getTemplateByClassLevel(2,0);
        $this->class[2][1] = $this->school_template_map->getTemplateByClassLevel(2,1);
        $this->class[3][0] = $this->school_template_map->getTemplateByClassLevel(3,0);
        $this->class[3][1] = $this->school_template_map->getTemplateByClassLevel(3,1);
        $this->class[4][0] = $this->school_template_map->getTemplateByClassLevel(4,0);
        $this->class[4][1] = $this->school_template_map->getTemplateByClassLevel(4,1);

        for($i = 1;$i < 5;$i++)
        {
            //init empty vars
            $this->class_variables[$i][1] = [];
            $this->class_variables[$i][0] = [];

            if($this->class[$i][0])
            {
                $school_template_settings = new SchoolTemplateVariables($this->class[$i][0]);
                $school_template_settings->loadSchoolTemplateVariablesBySchool($this->school);

                foreach($school_template_settings->getSchoolTemplateVariables() as $registeredTemplateVariable)
                {
                    $this->class_variables[$i][0][] = $registeredTemplateVariable->getHtml();
                }
            }

            if($this->class[$i][1])
            {
                $school_template_settings = new SchoolTemplateVariables($this->class[$i][1]);
                $school_template_settings->loadSchoolTemplateVariablesBySchool($this->school);

                foreach($school_template_settings->getSchoolTemplateVariables() as $registeredTemplateVariable)
                {
                    $this->class_variables[$i][1][] = $registeredTemplateVariable->getHtml();
                }
            }
        }

        foreach(SchoolTemplate::getAllInstalledTemplates($this->school->getFederalState()) as $school_template)
        {
            $this->installed_school_templates[] = $school_template;
        }

        if($this->getIsAjax())
        {
            switch(Page::getGetVariable("action"))
            {
                case "updateSchoolTemplate":
                    $this->updateSchoolTemplates();
                    break;

                case "updateSchoolName":
                    $school_name = Page::getPostVariable("school_name");
                    $this->updateSchoolName($school_name);
                    break;

                case "updateTemplateVariables":
                    $this->updateTemplateVariables();
                    break;
            }
        }
        else
        {
            $this->render();
        }

    }

    private function updateSchoolName(string $school_name) : void
    {
        $this->school->setSchoolName(filter_var($school_name, FILTER_SANITIZE_STRING));
        $this->school->update();
    }

    private function updateSchoolTemplates()
    {
        $configured_templates = $_POST["admin_change_template"];

        $class_number = 1;
        $halfyear=0;
        $i=1;
        foreach($configured_templates as $school_template_id)
        {
            $halfyear = (int)!(bool)($i % 2);

            foreach($this->installed_school_templates as $school_template)
            {
                //Wenn ausgewähltes Template auch verfügbar ist
                if($school_template->getId() == $school_template_id && $school_template_id != -1)
                {
                    $this->school_template_map->setTemplateByClassLevel($school_template, $class_number, $halfyear);
                }
            }

            if($halfyear == 1) $class_number +=1;
            $i+=1;
        }

        $this->school_template_map->persist();
    }

    public function updateTemplateVariables() : void
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
                        $template_variable->setValueType(TemplateVariableType::SCHOOL);
                        if($template_variable->saveValueBySchool($this->school, $template_variable_data["value"])) $success = true;
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

    private function render() : void
    {
        $this->view("Admin_School.html")->display(
            [
                "installed_school_templates" => $this->installed_school_templates,
                "class_1_0" => $this->class[1][0],
                "class_1_1" => $this->class[1][1],
                "class_2_0" => $this->class[2][0],
                "class_2_1" => $this->class[2][1],
                "class_3_0" => $this->class[3][0],
                "class_3_1" => $this->class[3][1],
                "class_4_0" => $this->class[4][0],
                "class_4_1" => $this->class[4][1],
                "class_1_0_vars" => $this->class_variables[1][0],
                "class_1_1_vars" => $this->class_variables[1][1],
                "class_2_0_vars" => $this->class_variables[2][0],
                "class_2_1_vars" => $this->class_variables[2][1],
                "class_3_0_vars" => $this->class_variables[3][0],
                "class_3_1_vars" => $this->class_variables[3][1],
                "class_4_0_vars" => $this->class_variables[4][0],
                "class_4_1_vars" => $this->class_variables[4][1],
            ]);
    }
}