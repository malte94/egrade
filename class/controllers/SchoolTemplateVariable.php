<?php

final class TemplateVariableDataTypes{
    const NONE = 0;
    const DATE = 1;
    const DATETIME = 2;
    const VARCHAR = 3;
    const TEXT = 4;
    const BLOB = 5;
}

final class TemplateVariableType{
    const ALL = 0;
    const GLOBAL = 1;
    const SCHOOL = 2;
    const SCHOOL_CLASS = 3;
    const STUDENT = 4;
}

class SchoolTemplateVariable
{

    /** template_settings_value key
     * @var int
     */
    public int $pk_school_template_var = -1;

    /**
     * @var int
     */
    public int $pk_template_settings_value = -1;

    /**
     * @var int
     */
    public int $fk_school_template = -1;

    /**
     * @var int
     */
    public int $data_type = 0;

    /**
     * @var int
     */
    public int $value_type = 0;

    /**
     * @var stringl $d
     */
    public string $varname = "";

    /**
     * @var string
     */
    public string $display_name = "";

    /**
     * @var string
     */
    public string $value = "";

    /**
     * @var string
     */
    public ?string $description = "";

    public function __construct(int $pk_school_template_var, int $fk_school_template, int $data_type, string $varname, string $display_name)
    {
        $this->pk_school_template_var = $pk_school_template_var;
        $this->fk_school_template = $fk_school_template;
        $this->varname = $varname;
        $this->display_name = $display_name;
        $this->data_type = $data_type;
    }

    /**
     * @return int
     */
    public function getDataType() : int
    {
        return $this->data_type;
    }

    /**
     * @return string
     */
    public function getValue() : string
    {
        return $this->value;
    }

    public function getId() : int
    {
        return $this->pk_school_template_var;
    }

    public function setValue(string $value) : void
    {
        $this->value = $value;
    }

    public function setPkSchoolTemplateSettingsValue(int $pk) : void
    {
        $this->pk_template_settings_value = $pk;
    }

    public function saveValueBySchool(School $school, string $value) : bool
    {
        $success = false;
        $db = new DB();
        $this->setValue($value);

        $db->startTransaction();

        //if already a value entry exist and associate with current school
        if($this->pk_template_settings_value >= 0)
        {
            $db->query("UPDATE template_settings_value SET `Value` = ? WHERE PK_Template_Settings_Value = ?",
                [
                    $this->value,
                    $this->pk_template_settings_value
                ]);
            $success = true;
        }else{

            //Wenn Value gefunden und geladen, wurden die entsprehcenden Daten hier im Objekt ergänzt
            if($this->loadValueBySchool($school))
            {
                return $this->saveValueBySchool($school, $value);

            }else{

                $insert_id_value = $db->query("INSERT INTO template_settings_value (`FK_School_Template_Var`, `Value`) VALUES (?,?)",
                    [
                        $this->pk_school_template_var,
                        $this->getValue()
                    ])->getLastInsertId();

                if($insert_id_value > 0)
                {
                    $insert_id_sts = $db->query("INSERT INTO school_template_settings (FK_School, FK_Template_Settings_Value, FK_School_Template) VALUES (?,?,?);",
                        [
                            $school->getSchoolId(),
                            $insert_id_value,
                            $this->fk_school_template
                        ])->getLastInsertId();
                    //TODO: Rollback
                    if($insert_id_sts > 0 ) $success = true;
                }

                debug([
                    "value_insert_id " =>$insert_id_value,
                    "sts_insert_id " => $insert_id_sts
                ]);
            }

        }

        $db->commitTransaction();

        $db->close();
        return $success;
    }

    public function saveValueBySchoolClass(SchoolClass $school_class, string $value) : bool
    {
        $success = false;
        $db = new DB();
        $this->setValue($value);

        $db->startTransaction();

        //if already a value entry exist and associate with current school
        if($this->pk_template_settings_value >= 0)
        {
            $db->query("UPDATE template_settings_value SET `Value` = ? WHERE PK_Template_Settings_Value = ?",
                [
                    (!$this->value ? "" : $this->value),
                    $this->pk_template_settings_value
                ]);
            $success = true;
        }else{

            //Wenn Value gefunden und geladen, wurden die entsprehcenden Daten hier im Objekt ergänzt
            if($this->loadValueBySchoolClass($school_class))
            {
                return $this->saveValueBySchoolClass($school_class, $value);

            }else{

                $insert_id_value = $db->query("INSERT INTO template_settings_value (`FK_School_Template_Var`, `Value`) VALUES (?,?)",
                    [
                        $this->pk_school_template_var,
                        $this->getValue()
                    ])->getLastInsertId();

                if($insert_id_value > 0)
                {
                    $insert_id_sts = $db->query("INSERT INTO class_template_settings (FK_Class, FK_Template_Settings_Value, FK_School_Template) VALUES (?,?,?);",
                        [
                            $school_class->getSchoolClassId(),
                            $insert_id_value,
                            $this->fk_school_template
                        ])->getLastInsertId();
                    //TODO: Rollback
                    if($insert_id_sts > 0 ) $success = true;
                }

                debug([
                    "value_insert_id " =>$insert_id_value,
                    "sts_insert_id " => $insert_id_sts
                ]);
            }

        }

        $db->commitTransaction();

        $db->close();
        return $success;
    }

    public function saveValueByStudent(Student $student, string $value) : bool
    {
        $success = false;
        $db = new DB();
        $this->setValue($value);

        $db->startTransaction();

        //if already a value entry exist and associate with current school
        if($this->pk_template_settings_value >= 0)
        {
            $db->query("UPDATE template_settings_value SET `Value` = ? WHERE PK_Template_Settings_Value = ?",
                [
                    (!$this->value ? "" : $this->value),
                    $this->pk_template_settings_value
                ]);
            $success = true;
        }else{

            //Wenn Value gefunden und geladen, wurden die entsprehcenden Daten hier im Objekt ergänzt
            if($this->loadValueByStudent($student))
            {
                return $this->saveValueByStudent($student, $value);

            }else{

                $insert_id_value = $db->query("INSERT INTO template_settings_value (`FK_School_Template_Var`, `Value`) VALUES (?,?)",
                    [
                        $this->pk_school_template_var,
                        $this->getValue()
                    ])->getLastInsertId();

                if($insert_id_value > 0)
                {
                    $insert_id_stuts = $db->query("INSERT INTO student_template_settings (FK_Student, FK_Template_Settings_Value, FK_School_Template) VALUES (?,?,?);",
                        [
                            $student->getStudentID(),
                            $insert_id_value,
                            $this->fk_school_template
                        ])->getLastInsertId();
                    //TODO: Rollback
                    if($insert_id_stuts > 0 ) $success = true;
                }

                debug([
                    "value_insert_id " =>$insert_id_value,
                    "stuts_insert_id " => $insert_id_stuts
                ]);
            }

        }

        $db->commitTransaction();

        $db->close();
        return $success;
    }

    /**
     * @return string
     */
    public function getVarName() : string
    {
        return $this->varname;
    }

    /**
     * @return string
     */
    public function getDisplayName() : string
    {
        return $this->display_name;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description) : void
    {
        $this->description = $description;
    }

    public static function loadById(int $id) : ?SchoolTemplateVariable
    {
        $db = new DB();

        if($id > 0)
        {
            $result = $db->query("SELECT * FROM school_template_vars WHERE PK_School_Template_Vars = ? " , [$id]);

            if($result->numRows() > 0)
            {
                $data = $result->fetchArray();
                return new SchoolTemplateVariable($data["PK_School_Template_Vars"], $data["FK_School_Template"], $data["Datatype"], $data["Varname"], $data["Displayname"]);
            }

        }

        return null;
    }

    /**
     * @return string
     */
    public function getHtml() : string
    {
        switch ($this->data_type)
        {
            case TemplateVariableDataTypes::TEXT:
            case TemplateVariableDataTypes::VARCHAR:
                return "
                <div>
                <direct-label class=\"w-50\">".$this->display_name."</direct-label>
                <input class=\"input-egrade w-50 template-variables\" id=\"template_var_$this->pk_school_template_var\" name=\"templatevar[$this->pk_school_template_var]\" type=\"text\" value=\"$this->value\" title=\"$this->description\"\" data-varname=\"$this->varname\" data-valuetype=\"$this->value_type\" data-templatevarid=\"$this->pk_school_template_var\" data-idtemplate=\"$this->fk_school_template\" /> 
                </div>
                ";
                break;

            case TemplateVariableDataTypes::DATE:
                return "
                <div>
                <direct-label class=\"w-50\">".$this->display_name."</direct-label>
                <input class=\"input-egrade w-50 template-variables\" name=\"templatevar[$this->pk_school_template_var]\" id=\"template_var_$this->pk_school_template_var\" type=\"date\" value=".date('Y-m-d', strtotime($this->value))." data-varname=\"$this->varname\" data-valuetype=\"$this->value_type\" data-templatevarid=\"$this->pk_school_template_var\" data-idtemplate=\"$this->fk_school_template\"/> 
                </div>
                ";
                break;

            case TemplateVariableDataTypes::DATETIME:
                return "
                <div>
                <direct-label class=\"w-50\">".$this->display_name."</direct-label>
                <input class=\"input-egrade w-50 template-variables\" name=\"templatevar[$this->pk_school_template_var]\" id=\"template_var_$this->pk_school_template_var\" type=\"date\" value=".date('Y-m-d H:i:s', strtotime($this->value))." data-varname=\"$this->varname\" data-valuetype=\"$this->value_type\" data-templatevarid=\"$this->pk_school_template_var\ data-idtemplate=\"$this->fk_school_template\" /> 
                </div>
                ";
                break;

            default: return "";
        }
    }

    public function getValueType() : int
    {
        return $this->value_type;
    }

    public function setValueType(int $value_type) : void
    {
        $this->value_type = $value_type;
    }

    /**
     * @param School $school
     * @return bool
     */
    public function saveForSchool(School $school) : bool
    {
        if($school->getSchoolId() >= 0)
        {
            if($this->pk_school_template_var <= 0)
            {
                $db = new DB();

                $db->query("INSERT INTO ");
            }
        }
    }

    /*** return false if no value was found/loaded
     *
     * @param School $school
     * @return bool
     */
    public function loadValueBySchool(School $school) : bool
    {
        $db = new DB();

        $result = $db->query("SELECT * FROM 
                                    school_template_vars stv,
                                    template_settings_value tsv,
                                    school_template_settings sts 
                                    WHERE 
                                    stv.FK_School_Template = ? AND 
                                    sts.FK_School_Template = stv.FK_School_Template AND
                                    tsv.FK_School_Template_Var = stv.PK_School_Template_Vars AND
                                    sts.FK_School = ? AND 
                                    tsv.PK_Template_Settings_Value = sts.FK_Template_Settings_Value AND 
                                    stv.PK_School_Template_Vars = ?",
            [
                $this->fk_school_template,
                $school->getSchoolId(),
                $this->pk_school_template_var
            ]
        );

        if($result->numRows() > 0)
        {
            $data = $result->fetchArray();

            $this->setValue($data['Value']);
            $this->pk_template_settings_value = $data['PK_Template_Settings_Value'];
            return true;
        }

        return false;
    }

    public function loadValueBySchoolClass(SchoolClass $school_class) : bool
    {
        $db = new DB();

        $result = $db->query("SELECT * FROM 
                                    school_template_vars stv,
                                    template_settings_value tsv,
                                    class_template_settings cts 
                                    WHERE 
                                    stv.FK_School_Template = ? AND 
                                    cts.FK_School_Template = stv.FK_School_Template AND 
                                    tsv.FK_School_Template_Var = stv.PK_School_Template_Vars  AND 
                                    cts.FK_Class = ? AND 
                                    tsv.PK_Template_Settings_Value = cts.FK_Template_Settings_Value AND 
                                    stv.PK_School_Template_Vars = ?",
            [
                $this->fk_school_template,
                $school_class->getSchoolClassId(),
                $this->pk_school_template_var
            ]
        );

        if($result->numRows() > 0)
        {
            $data = $result->fetchArray();

            $this->setValue($data['Value']);
            $this->pk_template_settings_value = $data['PK_Template_Settings_Value'];
            return true;
        }

        return false;
    }

    public function loadValueByStudent(Student $student) : bool
    {
        $db = new DB();

        $result = $db->query("SELECT * FROM 
                                    school_template_vars stv,
                                    template_settings_value tsv,
                                    student_template_settings cts 
                                    WHERE 
                                    stv.FK_School_Template = ? AND 
                                    cts.FK_School_Template = stv.FK_School_Template AND 
                                    tsv.FK_School_Template_Var = stv.PK_School_Template_Vars  AND 
                                    cts.FK_Student = ? AND 
                                    tsv.PK_Template_Settings_Value = cts.FK_Template_Settings_Value AND 
                                    stv.PK_School_Template_Vars = ?",
            [
                $this->fk_school_template,
                $student->getStudentID(),
                $this->pk_school_template_var
            ]
        );

        if($result->numRows() > 0)
        {
            $data = $result->fetchArray();

            $this->setValue($data['Value']);
            $this->pk_template_settings_value = $data['PK_Template_Settings_Value'];
            return true;
        }

        return false;
    }

}