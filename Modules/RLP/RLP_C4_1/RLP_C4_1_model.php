<?php

/**
 * Class RLP_C4_1_model
 */
class RLP_C4_1_model extends PrintTemplateModelAbstract
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
    public array $competences =
        [
            "deutsch_rechtschreibung_regeln" => -1,
            "deutsch_rechtschreibung_hilfsmittel" => -1,
            "deutsch_rechtschreibung_formklar" => -1,
            "deutsch_rechtschreibung_tafel" => -1,
            "deutsch_sprachgebrauch_formulieren" => -1,
            "deutsch_sprachgebrauch_gespraeche" => -1,
            "deutsch_sprachgebrauch_situationsgerecht" => -1,
            "deutsch_lesen_vortragen" => -1,
            "deutsch_lesen_informationen" => -1,
            "deutsch_lesen_anweisungen" => -1,

            "mathe_analytisch_strategien" => -1,
            "mathe_analytisch_sachverhalte" => -1,
            "mathe_analytisch_fachwoerter" => -1,
            "mathe_zahlen_millionen" => -1,
            "mathe_zahlen_berechnungen" => -1,
            "mathe_zahlen_einheiten" => -1,
            "mathe_zahlen_kopfrechnen" => -1,
            "mathe_geometrie_benennen" => -1,
            "mathe_geometrie_flaechen" => -1,
            "mathe_geometrie_raumvorstellung" => -1,

            "sachunterricht_informationen_beziehen" => -1,
            "sachunterricht_themengebiete" => -1,
            "sachunterricht_arbeitsmappe" => -1,

            "ethik_offen_respektvoll" => -1,
            "ethik_faehigkeiten_einschaetzen" => -1,
            "ethik_meinung_anderer" => -1,
            "ethik_unterricht_gestalten" => -1,
            "ethik_andere_einfuehlen" => -1,

            "kunst_aufgaben_umsetzen" => -1,
            "kunst_ideen_umsetzen" => -1,
            "kunst_begeistern" => -1,

            "musik_rhythmus" => -1,
            "musik_musikrichtungen" => -1,
            "musik_kuenstler_instrumente" => -1,
            "musik_darstellen" => -1,

            "sport_regeln" => -1,
            "sport_anstrengungsbereitschaft" => -1,
            "sport_kondition" => -1,
            "sport_bewegungsrepertoire" => -1

        ];

          /**
     * @var
     */
    public array $grades = [
            "grade_deutsch" => -1,
            "grade_mathe" => -1,
            "grade_sachunterricht" => -1,
            "grade_ethik" => -1,
            "grade_kunst" => -1,
            "grade_musik" => -1,
            "grade_sport" => -1
        ];

    /**
     * RLP_C1_4_model constructor.
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
            $this->competences,
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
            $this->competences,
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

    public function getCompetences() : array
    {
        return $this->competences;
    }

    public function setCompetences(array $competences) : void
    {
        $this->competences = $competences;
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