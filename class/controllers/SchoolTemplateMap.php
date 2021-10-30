<?php

/**
 * Class SchoolTemplateMap
 */
class SchoolTemplateMap
{
    /**
     * @var SchoolTemplate
     */
    public ?array $school_templates = null;

    /**
     * @var School
     *
     */
    private School $school;

    /**
     * SchoolTemplateMap constructor.
     * @param School $school
     */
    public function __construct(School $school)
    {
        $this->school_templates[1] = [0 => null, 1 => null];
        $this->school_templates[2] = [0 => null, 1 => null];
        $this->school_templates[3] = [0 => null, 1 => null];
        $this->school_templates[4] = [0 => null, 1 => null];


        $this->school = $school;
        if ($school->getSchoolId() >= 0)
        {

            $db = new DB();

            $result = $db->query("SELECT 
                                         stts.Class_Level, 
                                         stts.Is_Halfyear, 
                                         stts.FK_School, 
                                         st.Module_Name, 
                                         st.ID_Federal, 
                                         st.Display_Name, 
                                         st.PK_School_Template 
                                         FROM school_template_to_school stts
                                         LEFT JOIN school_templates st ON stts.FK_School_Template = st.PK_School_Template
                                         WHERE FK_School = ? ORDER BY stts.Class_Level, stts.Is_Halfyear ", $school->getSchoolId());

            if ($result->numRows() > 0)
            {
                foreach ($result->fetchAll() as $row)
                {
                    $this->school_templates[$row['Class_Level']][$row['Is_Halfyear']] = new SchoolTemplate($row['PK_School_Template'], $row['Module_Name'], Federal::createFederal($row['ID_Federal']), $row['Class_Level'], $row['Is_Halfyear'], $row['Display_Name']);
                }
            }
        }

    }

    /**
     * @param int $class_level
     * @param int $half_year
     * @return SchoolTemplate|null
     */
    public function getTemplateByClassLevel(int $class_level, int $half_year): ?SchoolTemplate
    {
        if($this->school_templates)
        {
            if (array_key_exists($class_level, $this->school_templates))
            {
                if (array_key_exists($half_year, $this->school_templates[$class_level]))
                {

                    if ($this->school_templates[$class_level][$half_year])
                    {
                        return $this->school_templates[$class_level][$half_year];
                    }
                }
            }
        }

        return null;
    }

    /**
     * @param SchoolTemplate $school_template
     * @param int $class_level
     * @param int $halfyear
     */
    public function setTemplateByClassLevel(SchoolTemplate $school_template, int $class_level, int $halfyear): void
    {
        if ($class_level >= 1 && $class_level <= 4)
        {
            $this->school_templates[$class_level][$halfyear] = $school_template;
        }
    }

    /**
     * @return array
     */
    public function getAllTemplates(): array
    {
        return $this->school_templates;
    }

    /**
     * @return bool
     */
    public function persist() : bool
    {
        $db = new DB();

        $class_number = 1;
        $halfyear = 0;

        for($i = 1; $i <= 8; $i++)
        {
            $halfyear = (int)!(bool)($i % 2);

            $school_template_tmp = $this->getTemplateByClassLevel($class_number, $halfyear);

            if($school_template_tmp)
            {
                $db->startTransaction();

                $result = $db->query("SELECT PK_School_Template_To_School FROM school_template_to_school WHERE FK_School = ? AND Class_Level = ? AND Is_Halfyear = ?",
                    $this->school->getSchoolId(),
                    $class_number,
                    $halfyear);

                if ($result->numRows() > 0)
                {
                    $pk_school_template_to_school = $result->fetchArray()['PK_School_Template_To_School'];

                    $query = $db->query("UPDATE  school_template_to_school SET 
                                                        FK_School = ?, 
                                                        FK_School_Template = ?, 
                                                        Class_Level = ?, 
                                                        Is_Halfyear = ? 
                                                        WHERE PK_School_Template_To_School = ?",
                        $this->school->getSchoolId(),
                        $school_template_tmp->getId(),
                        $class_number,
                        $halfyear,
                        $pk_school_template_to_school);
                } else {
                    $query = $db->query("INSERT INTO school_template_to_school (FK_School, FK_School_Template, Class_Level, Is_Halfyear) VALUES (?,?,?,?)",
                        $this->school->getSchoolId(),
                        $school_template_tmp->getId(),
                        $class_number,
                        $halfyear
                    );

                }

                $db->commitTransaction();
            }

            if($halfyear == 1) $class_number +=1;
        }

        return true;
    }
}