<?php

/**
 * Class RLP_C3_1_model
 */
class RLP_C3_1_model extends PrintTemplateModelAbstract
{
    /**
     * @var int
     */
    private int $fk_school_template = -1;
    /**
     * @var string
     */
    public string $lern_arbeits_und_sozialverhalten = "";
    /**
     * @var string
     */
    public string $bemerkungen = "";
    /**
     * @var string
     */
    public string $leistungsentwicklung = "";
    /**
     * @var int
     */
    public int $fehlzeiten_entschuldigt = 0;
    /**
     * @var int
     */
    public int $fehlzeiten_unentschuldigt = 0;

    /**
     * @var
     */
    public array $grades = [
            "grade_mathe" => "-1",
            "grade_deutsch" => "-1",
            "grade_englisch" => "-1",
            "grade_ethik" => "-1",
            "grade_sachunterricht" => "-1",
            "grade_musik" => "-1",
            "grade_sport" => "-1",
            "grade_kunst" => "-1",
            "grade_schrift" => "-1",
        ];

    /**
     * RLP_C3_1_model constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function serialize() : string
    {
        return serialize([
            $this->pk_template,
            $this->lern_arbeits_und_sozialverhalten,
            $this->leistungsentwicklung,
            $this->fehlzeiten_entschuldigt,
            $this->fehlzeiten_unentschuldigt,
            $this->grades
        ]);
    }

    /**
     * @param string $content
     * @return bool
     */
    public function deserialize(string $content) : bool
    {
        list(
            $this->pk_template,
            $this->lern_arbeits_und_sozialverhalten,
            $this->leistungsentwicklung,
            $this->fehlzeiten_entschuldigt,
            $this->fehlzeiten_unentschuldigt,
            $this->grades
            ) = unserialize($content);

        return true;
    }

    /**
     * Primary Key from school_templates entry  (school_templates.PK_School_Templates)
     * @return int
     */
    public function getSchoolTemplateId(): int
    {
        return 4;
    }

    public function getGrades() : array
    {
        return $this->grades;
    }

    public function setGrades(array $grades) : void
    {
        $this->grades = $grades;
    }

    public function getLernArbeitsUndSozialVerhalten(){
        return $this->lern_arbeits_und_sozialverhalten;
    }

    public function setLernArbeitsUndSozialVerhalten(string $value)
    {
        $this->lern_arbeits_und_sozialverhalten = $value;
    }

    public function getLeistungsentwicklung(){
        return $this->leistungsentwicklung;
    }

    public function setLeistungsentwicklung(string $value){
        $this->leistungsentwicklung = $value;
    }

        /**
     * @return int
     */
     public function getFehlzeitenEntschuldigt(){
        return $this->fehlzeiten_entschuldigt;
    }

    /**
     * @param int $value
     */
    public function setFehlzeitenEntschuldigt(int $value){
        $this->fehlzeiten_entschuldigt = $value;
    }

    /**
     * @return int
     */
    public function getFehlzeitenUnentschuldigt(){
        return $this->fehlzeiten_unentschuldigt;
    }

    /**
     * @param int $value
     */
    public function setFehlzeitenUnentschuldigt(int $value){
        $this->fehlzeiten_unentschuldigt = $value;
    }

}