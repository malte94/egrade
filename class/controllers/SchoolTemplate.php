<?php

/**
 * Class SchoolTemplate
 */
class SchoolTemplate
{
    /**
     * @var int
     */
    private int $id_template = -1;

    /**
     * @var string
     */
    private string $template_name = "";
        /**
     * @var string
     */
     private string $template_display_name = "";
    /**
     * @var Federal
     */
    private Federal $federal_state;
    /**
     * @var int
     */
    private int $class_level = 0;
    /**
     * @var int
     */
    private int $get_half_year = 0;

    /**
     * SchoolTemplate constructor.
     * @param string $template_name
     * @param Federal $federal_state
     * @param int $class_level
     * @param int $get_half_year
     */
    public function __construct(int $id_template, string $template_name, Federal $federal_state, int $class_level, int $get_half_year, string $template_display_name)
    {
        $this->id_template = $id_template;
        $this->template_name = $template_name;
        $this->federal_state = $federal_state;
        $this->class_level = $class_level;
        $this->get_half_year = $get_half_year;
        $this->template_display_name = $template_display_name;
    }

    /**
     * @param School $school
     * @return array
     */
    public static function getTemplatesBySchool(School $school): array
    {
        $templates = [];

        $db = new DB();

        $result = $db->query("SELECT * FROM school_template_to_school stts
                                    JOIN school_templates st ON st.PK_School_Template = stts.FK_School_Template WHERE FK_School = ? AND Active = 1",
            $school->getSchoolId());

        if ($result->numRows() > 0) {
            foreach ($result->fetchAll() as $value) {
                $templates[] = new SchoolTemplate(
                    $value['PK_School_Template'],
                    $value['Module_Name'],
                    Federal::createFederal($value['ID_Federal']),
                    $value['Class_Level'], 
                    $value['Half_Year'],
                    $value['Display_Name']
                );
            }
        }

        return $templates;
    }

    /** return all available template from database by federal state
     *
     * @return array
     */
    public static function getAllInstalledTemplates(Federal $federal) : array
    {
        $templates = [];

        $db = new DB();

        $result = $db->query("SELECT * FROM school_templates WHERE Active = 1 AND ID_Federal = ?",
            $federal->getId());

        if ($result->numRows() > 0) {
            foreach ($result->fetchAll() as $value) {
                $templates[] = new SchoolTemplate(
                    $value['PK_School_Template'],
                    $value['Module_Name'],
                    Federal::createFederal($value['ID_Federal']),
                    $value['Class_Level'], 
                    $value['Half_Year'],
                    $value['Display_Name']
                );
            }
        }

        return $templates;
    }

    /**
     * @return array
     */
    public function getTemplateModuleName(): string
    {
        return $this->template_name;
    }
    
    /**
     * @return array
     */
     public function getTemplateDisplayName(): string
     {
         return $this->template_display_name;
     }

    /**
     * @return int
     */
    public function getClassLevel(): int
    {
        return $this->class_level;
    }

    /**
     * @return int
     */
    public function getHalfYear(): int
    {
        return $this->get_half_year;
    }

    /**
     * @return Federal
     */
    public function getFederal(): Federal
    {
        return $this->federal_state;
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id_template;
    }
}
