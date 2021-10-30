<?php

/**
 * Class NRW_C2_1_model
 */
class NRW_C2_1_model extends PrintTemplateModelAbstract
{
    /**
     * @var int
     */
    private int $fk_school_template = -1;

    /**
     * @var string
     */
    private string $aussagen_arbeits_sozialverhalten_lernentwicklung = "";

    /**
     * @var array
     */
    public array $grades = [
        "grade_religion" => "-1",
        "grade_sachunterricht" => "-1",
        "grade_deutsch" => "-1",
        "grade_mathematik" => "-1",
        "grade_deutsch_sprachgebrauch" => "-1",
        "grade_sport" => "-1",
        "grade_deutsch_lesen" => "-1",
        "grade_musik" => "-1",
        "grade_deutsch_rechtschreiben" => "-1",
        "grade_kundsttextil" => "-1",
    ];

    /**
     * @var string
     */
    private string $bemerkungen = "";
    /**
     * @var int
     */
    private int $fehlzeiten_entschuldigt = 0;
    /**
     * @var int
     */
    private int $fehlzeiten_unentschuldigt = 0;

    /**
     * NRW_C2_1_model constructor.
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
            $this->aussagen_arbeits_sozialverhalten_lernentwicklung,
            $this->grades,
            $this->fehlzeiten_entschuldigt,
            $this->fehlzeiten_unentschuldigt,
            $this->bemerkungen
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
            $this->aussagen_arbeits_sozialverhalten_lernentwicklung,
            $this->grades,
            $this->fehlzeiten_entschuldigt,
            $this->fehlzeiten_entschuldigt,
            $this->bemerkungen
            ) = unserialize($content);

        return true;
    }

    /**
     * Primary Key from school_templates entry  (school_templates.PK_School_Templates)
     * @return int
     */
    public function getSchoolTemplateId(): int
    {
        return 6;
    }

    public function getAussagenArbeitsSozialverhaltenLernentwicklung() : string
    {
        return $this->aussagen_arbeits_sozialverhalten_lernentwicklung;
    }

    public function setAussagenArbeitsSozialverhaltenLernentwicklung(string $value) : void
    {
        $this->aussagen_arbeits_sozialverhalten_lernentwicklung = $value;
    }

    public function getGrades() : array
    {
        return $this->grades;
    }

    public function setGrades(array $grades) : void
    {
        $this->grades = $grades;
    }

    public function getBemerkungen() : string
    {
        return $this->bemerkungen;
    }

    public function setBemerkungen(string $value) : void
    {
        $this->bemerkungen = $value;
    }

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