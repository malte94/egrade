<?php

class SchoolTemplateVariables
{
    /**
     * @var array
     */
    private array $school_template_variables = [];

    /**
     * @var SchoolTemplate
     */
    private SchoolTemplate $school_template;

    public function __construct(SchoolTemplate $school_template)
    {
        $this->school_template = $school_template;
    }

    public function loadSchoolTemplateVariablesBySchool(School $school) : void
    {
        $db = new DB();

        $result = $db->query("
                        SELECT 
                        PK_School_Template_Vars, 
                        FK_School_Template,
                        Datatype, 
                        Varname, 
                        Displayname, 
                        Description 
                        FROM school_template_vars stv
                        JOIN school_templates st ON stv.FK_School_Template = st.PK_School_Template AND st.PK_School_Template = ?
                        WHERE stv.FK_School_Template = st.PK_School_Template  AND st.Active = 1
                    
        ",
            [
                $this->school_template->getId()
            ]
        );

        if($result->numRows() > 0)
        {
            $template_variables = $result->fetchAll();

            //Optional. Check if template variable value is present and apply if found
            foreach($template_variables as $template_variable)
            {
                $tmp_school_template_variable = new SchoolTemplateVariable(
                    $template_variable['PK_School_Template_Vars'],
                    $template_variable['FK_School_Template'],
                    $template_variable['Datatype'],
                    $template_variable['Varname'],
                    $template_variable['Displayname']
                );
                $tmp_school_template_variable->setDescription($template_variables['Description']);

                $template_variable_values = $db->query("
                                                        SELECT 
                                                        PK_Template_Settings_Value, 
                                                        FK_School_Template_Var, 
                                                        `Value`, 
                                                        FK_School_Template, 
                                                        FK_School 
                                                        FROM school_template_settings sts
                                                        JOIN template_settings_value stv ON stv.PK_Template_Settings_Value = sts.FK_Template_Settings_Value
                                                        WHERE sts.FK_School = ? AND sts.FK_School_Template = ? AND stv.FK_School_Template_Var = ?
                ",
                    [
                        $school->getSchoolId(),
                        $this->school_template->getId(),
                        $tmp_school_template_variable->getId()
                    ]
                );

                if($template_variable_values->numRows() == 1)
                {
                    $template_variable_values_result = $template_variable_values->fetchArray();

                    //just double check the return result
                    if($template_variable_values_result['FK_School'] == $school->getSchoolId() && $template_variable_values_result['FK_School_Template_Var'] == $tmp_school_template_variable->getId())
                    {
                        $tmp_school_template_variable->setValue($template_variable_values_result['Value']);
                        $tmp_school_template_variable->setPkSchoolTemplateSettingsValue($template_variable_values_result['PK_Template_Settings_Value']);
                    }

                }elseif($template_variable_values->numRows() > 1)
                {
                    alert("Mehr als ein Wert für Template-Variable gefunden" . $template_variable_values->fetchAll());
                }

                $tmp_school_template_variable->setValueType(TemplateVariableType::SCHOOL);
                $this->school_template_variables[] = $tmp_school_template_variable;
            }

        }
    }

    public function loadSchoolTemplateVariablesByClass(SchoolClass $school_class) : void
    {
        $db = new DB();

        $result = $db->query("
                        SELECT 
                        PK_School_Template_Vars, 
                        FK_School_Template,
                        Datatype, 
                        Varname, 
                        Displayname, 
                        Description 
                        FROM school_template_vars stv
                        JOIN school_templates st ON stv.FK_School_Template = st.PK_School_Template AND st.PK_School_Template = ?
                        WHERE stv.FK_School_Template = st.PK_School_Template  AND st.Active = 1
                    
        ",
            [
                $this->school_template->getId()
            ]
        );

        if($result->numRows() > 0)
        {
            $template_variables = $result->fetchAll();

            //Optional. Check if template variable value is present and apply if found
            foreach($template_variables as $template_variable)
            {
                $tmp_school_template_variable = new SchoolTemplateVariable(
                    $template_variable['PK_School_Template_Vars'],
                    $template_variable['FK_School_Template'],
                    $template_variable['Datatype'],
                    $template_variable['Varname'],
                    $template_variable['Displayname']
                );
                $tmp_school_template_variable->setDescription($template_variables['Description']);

                $template_variable_values = $db->query("
                                                        SELECT 
                                                        PK_Template_Settings_Value, 
                                                        FK_School_Template_Var, 
                                                        `Value`, 
                                                        FK_School_Template, 
                                                        FK_Class 
                                                        FROM class_template_settings cts
                                                        JOIN template_settings_value stv ON stv.PK_Template_Settings_Value = cts.FK_Template_Settings_Value
                                                        WHERE cts.FK_Class = ? AND cts.FK_School_Template = ? AND stv.FK_School_Template_Var = ?
                ",
                    [
                        $school_class->getSchoolClassId(),
                        $this->school_template->getId(),
                        $tmp_school_template_variable->getId()
                    ]
                );

                if($template_variable_values->numRows() == 1)
                {
                    $template_variable_values_result = $template_variable_values->fetchArray();

                    //just double check the return result
                    if($template_variable_values_result['FK_Class'] == $school_class->getSchoolClassId() && $template_variable_values_result['FK_School_Template_Var'] == $tmp_school_template_variable->getId())
                    {
                        $tmp_school_template_variable->setValue($template_variable_values_result['Value']);
                        $tmp_school_template_variable->setPkSchoolTemplateSettingsValue($template_variable_values_result['PK_Template_Settings_Value']);
                    }

                }elseif($template_variable_values->numRows() > 1)
                {
                    alert("Mehr als ein Wert für Template-Variable gefunden" . $template_variable_values->fetchAll());
                }

                $tmp_school_template_variable->setValueType(TemplateVariableType::SCHOOL_CLASS);
                $this->school_template_variables[] = $tmp_school_template_variable;
            }

        }
    }

    public function loadSchoolTemplateVariablesByStudent(Student $student) : void
    {
        $db = new DB();

        $result = $db->query("
                        SELECT 
                        PK_School_Template_Vars, 
                        FK_School_Template,
                        Datatype, 
                        Varname, 
                        Displayname, 
                        Description 
                        FROM school_template_vars stv
                        JOIN school_templates st ON stv.FK_School_Template = st.PK_School_Template AND st.PK_School_Template = ?
                        WHERE stv.FK_School_Template = st.PK_School_Template  AND st.Active = 1
                    
        ",
            [
                $this->school_template->getId()
            ]
        );

        if($result->numRows() > 0)
        {
            $template_variables = $result->fetchAll();

            //Optional. Check if template variable value is present and apply if found
            foreach($template_variables as $template_variable)
            {
                $tmp_school_template_variable = new SchoolTemplateVariable(
                    $template_variable['PK_School_Template_Vars'],
                    $template_variable['FK_School_Template'],
                    $template_variable['Datatype'],
                    $template_variable['Varname'],
                    $template_variable['Displayname']
                );
                $tmp_school_template_variable->setDescription($template_variables['Description']);

                $template_variable_values = $db->query("
                                                        SELECT 
                                                        PK_Template_Settings_Value, 
                                                        FK_School_Template_Var, 
                                                        `Value`, 
                                                        FK_School_Template, 
                                                        FK_Student 
                                                        FROM student_template_settings stuts
                                                        JOIN template_settings_value stv ON stv.PK_Template_Settings_Value = stuts.FK_Template_Settings_Value
                                                        WHERE stuts.FK_Student = ? AND stuts.FK_School_Template = ? AND stv.FK_School_Template_Var = ?
                ",
                    [
                        $student->getStudentID(),
                        $this->school_template->getId(),
                        $tmp_school_template_variable->getId()
                    ]
                );

                if($template_variable_values->numRows() == 1)
                {
                    $template_variable_values_result = $template_variable_values->fetchArray();

                    //just double check the return result
                    if($template_variable_values_result['FK_Student'] == $student->getStudentID() && $template_variable_values_result['FK_School_Template_Var'] == $tmp_school_template_variable->getId())
                    {
                        $tmp_school_template_variable->setValue($template_variable_values_result['Value']);
                        $tmp_school_template_variable->setPkSchoolTemplateSettingsValue($template_variable_values_result['PK_Template_Settings_Value']);
                    }

                }elseif($template_variable_values->numRows() > 1)
                {
                    alert("Mehr als ein Wert für Template-Variable gefunden" . $template_variable_values->fetchAll());
                }

                $tmp_school_template_variable->setValueType(TemplateVariableType::STUDENT);
                $this->school_template_variables[] = $tmp_school_template_variable;
            }

        }
    }

    /**
     * @param int $type
     * @return array
     */
    public function getSchoolTemplateVariables() : array
    {
        return $this->school_template_variables;
    }

    public function getSchoolTemplateVariablesFiltered(int $filter = TemplateVariableType::ALL) : array
    {
        if($filter == TemplateVariableType::ALL)
        {
            return $this->school_template_variables;
        }

        $tmp_school_template_variables = [];

        foreach ($this->school_template_variables as $school_template_variable)
        {
            if($school_template_variable->getValueType() == $filter)
            {
                $tmp_school_template_variables[] = $school_template_variable;
            }
        }

        return $tmp_school_template_variables;
    }

    /**
     * Count number of school template variables stored
     * @return int
     */
    public function count() : int
    {
        return count($this->school_template_variables);
    }

    /**
     * @param string $var_name
     * @return SchoolTemplateVariable|null
     */
    public function getTemplateVariableByName(string $var_name) : ?SchoolTemplateVariable
    {
        foreach($this->school_template_variables as $school_template_setting)
        {
            if($school_template_setting->getVarName() == $var_name)
            {
                return $school_template_setting;
            }
        }

        return null;
    }

    /** return the value of a variable (by name) hierarchically (student = strongest, school = lowest item)
     *
     * @param string $var_name
     * @return string
     */
    public function getTemplateVariableValueByName(string $var_name) : string
    {
        $tmp_template_variables = [];
        foreach($this->school_template_variables as $school_template_setting)
        {
            $tmp_template_variables[$school_template_setting->getValueType()][] = $school_template_setting;
        }

        //start and look if a value for student is given, then class and then school
        for($i = TemplateVariableType::STUDENT;$i >= TemplateVariableType::SCHOOL; $i--)
        {
            if(array_key_exists($i, $tmp_template_variables))
            {
                foreach($tmp_template_variables[$i] as $school_template_setting)
                {
                    if($school_template_setting->getVarName() == $var_name && $school_template_setting->getValue() != "")
                    {
                        return $school_template_setting->getValue();
                    }
                }
            }
        }

        return "";
    }

    /**
     * @return array
     */
    public function getRegisteredTemplateVariables() : array
    {
        $db = new DB();

        $result = $db->query("SELECT * FROM school_template_vars WHERE FK_School_Template = ?", [$this->school_template->getId()])->fetchAll();
        $tmp_variables = [];

        foreach($result as $variables)
        {
            $tmp_variables[] = new SchoolTemplateVariable(-1, $variables['Datatype'], $variables['Varname'], $variables['Displayname'], "", $variables['Description'], TemplateVariableType::GLOBAL);
        }

        return $tmp_variables;
    }
}