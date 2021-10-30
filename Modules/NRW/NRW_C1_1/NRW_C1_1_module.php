<?php

class NRW_C1_1_module extends Module {

    public function __construct(School $school, SchoolClass $school_class, Student $student, Federal $federal, string $module_name, SchoolTemplateVariables $school_template_variables)
    {
        parent::__construct($school, $school_class, $student, $federal, $module_name, $school_template_variables);

        $this->model = $this->loadModel();

        if(!empty($_POST['hinweise_lern_arbeits_und_sozialverhalten']))
        {
            $this->model->setHinweiseLernArbeitsSozialverhalten($_POST['hinweise_lern_arbeits_und_sozialverhalten']);
        }

        if(!empty($_POST['hinwesie_lernbereiche']))
        {
            $this->model->setHinweiseLernbereiche($_POST['hinwesie_lernbereiche']);
        }

        if(!empty($_POST['bemerkungen']))
        {
            $this->model->setBemerkungen($_POST['bemerkungen']);
        }

        if(!empty($_POST['fehlzeiten_entschuldigt']))
        {
            $this->model->setFehlzeitenEntschuldigt($_POST['fehlzeiten_entschuldigt']);
        }

        if(!empty($_POST['fehlzeiten_unentschuldigt']))
        {
            $this->model->setFehlzeitenUnentschuldigt($_POST['fehlzeiten_unentschuldigt']);
        }

        if(!$this->saveModel()){
            echo "Beim Speichern gab es ein Problem";exit;
        }
    }
}