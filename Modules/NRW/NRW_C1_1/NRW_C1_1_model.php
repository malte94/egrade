<?php

/**
 * Class NRW_C1_1_model
 */
class NRW_C1_1_model extends PrintTemplateModelAbstract
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
    private string $hinweise_lern_arbeits_und_sozialverhalten = "";
    /**
     * @var string
     */
    private string $hinwesie_lernbereiche = "";
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
     * NRW_C1_1_model constructor.
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
            $this->hinweise_lern_arbeits_und_sozialverhalten,
            $this->hinwesie_lernbereiche,
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
            $this->school_name,
            $this->school_logo,
            $this->hinweise_lern_arbeits_und_sozialverhalten,
            $this->hinwesie_lernbereiche,
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
        return 1;
    }

    public function getHinweiseLernArbeitsSozialverhalten() : string
    {
        return $this->hinweise_lern_arbeits_und_sozialverhalten;
    }

    public function setHinweiseLernArbeitsSozialverhalten(string $value) : void
    {
        $this->hinweise_lern_arbeits_und_sozialverhalten = $value;
    }
    public function getHinweiseLernbereiche() : string
    {
        return $this->hinwesie_lernbereiche;
    }
    public function setHinweiseLernbereiche(string $value) : void
    {
        $this->hinwesie_lernbereiche = $value;
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