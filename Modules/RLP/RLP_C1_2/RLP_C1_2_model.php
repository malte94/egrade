<?php

/**
 * Class RLP_C1_2_model
 */
class RLP_C1_2_model extends PrintTemplateModelAbstract
{
    /**
     * @var int
     */
    private int $fk_school_template = -1;
    /**
     * @var string
     */
    private string $school_name = "";
    /**
     * @var string
     */
    private string $school_logo = "";
    /**
     * @var string
     */
    private string $student_firstname = "";
    /**
     * @var string
     */
    private string $student_lastname = "";
    /**
     * @var string
     */
    private string $school_half_year = "";
    /**
     * @var string
     */
    private string $school_class_name = "";
    /**
     * @var string
     */
    private string $lern_arbeits_und_sozialverhalten = "";
    /**
     * @var string
     */
    private string $deutsch_sachunterricht = "";
    /**
     * @var string
     */
    private string $mathematik = "";
    /**
     * @var string
     */
    private string $religion = "";
    /**
     * @var string
     */
    private string $musik_sport = "";
    /**
     * @var string
     */
    private string $bemerkungen = "";
    /**
     * @var string
     */
    private string $leistungsentwicklung = "";
    /**
     * @var int
     */
    private int $fehlzeiten_entschuldigt = 0;
    /**
     * @var int
     */
    private int $fehlzeiten_unentschuldigt = 0;

    /**
     * RLP_C1_1_V1_model constructor.
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
            $this->school_name,
            $this->school_logo,
            $this->student_firstname,
            $this->student_lastname,
            $this->school_half_year,
            $this->school_class_name,
            $this->lern_arbeits_und_sozialverhalten,
            $this->deutsch_sachunterricht,
            $this->mathematik,
            $this->religion,
            $this->musik_sport,
            $this->bemerkungen,
            $this->leistungsentwicklung,
            $this->fehlzeiten_entschuldigt,
            $this->fehlzeiten_unentschuldigt
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
            $this->school_name,
            $this->school_logo,
            $this->student_firstname,
            $this->student_lastname,
            $this->school_half_year,
            $this->school_class_name,
            $this->lern_arbeits_und_sozialverhalten,
            $this->deutsch_sachunterricht,
            $this->mathematik,
            $this->religion,
            $this->musik_sport,
            $this->bemerkungen,
            $this->leistungsentwicklung,
            $this->fehlzeiten_entschuldigt,
            $this->fehlzeiten_unentschuldigt
            ) = unserialize($content);

        return true;
    }

    public function getSchoolTemplateId(): int
    {
        return 2;
    }

    /**
     * @param string $student_firstname
     */
    public function setStudentFirstname(string $student_firstname)
    {
        $this->student_firstname = $student_firstname;
    }

    /**
     * @return string
     */
    public function getStudentFirstname()
    {
        return $this->student_firstname;
    }

    /**
     * @param string $student_lastname
     */
    public function setStudentLastname(string $student_lastname){
        $this->student_lastname = $student_lastname;
    }

    /**
     * @return string
     */
    public function getStudentLastname()
    {
        return $this->student_lastname;
    }

    /**
     * @return string
     */
    public function getLernArbeitsUndSozialVerhalten(){
        return $this->lern_arbeits_und_sozialverhalten;
    }

    /**
     * @param string $value
     */
    public function setLernArbeitsUndSozialVerhalten(string $value){
        $this->lern_arbeits_und_sozialverhalten = $value;
    }

    /**
     * @return string
     */
    public function getDeutschSachunterricht(){
        return $this->deutsch_sachunterricht;
    }

    /**
     * @param string $value
     */
    public function setDeutschSachunterricht(string $value){
        $this->deutsch_sachunterricht = $value;
    }

    /**
     * @return string
     */
    public function getMathematik(){
        return $this->mathematik;
    }

    /**
     * @param string $value
     */
    public function setMathematik(string $value){
        $this->mathematik = $value;
    }

    /**
     * @return string
     */
    public function getReligion(){
        return $this->religion;
    }

    /**
     * @param string $value
     */
    public function setReligion(string $value){
        $this->religion = $value;
    }

    /**
     * @return string
     */
    public function getMusikSport(){
        return $this->musik_sport;
    }

    /**
     * @param string $value
     */
    public function setMusikSport(string $value){
        $this->musik_sport = $value;
    }

    /**
     * @return string
     */
    public function getBemerkungen(){
        return $this->bemerkungen;
    }

    /**
     * @param string $value
     */
    public function setBemerkungen(string $value){
        $this->bemerkungen = $value;
    }

    /**
     * @return string
     */
    public function getLeistungsentwicklung(){
        return $this->leistungsentwicklung;
    }

    /**
     * @param string $value
     */
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