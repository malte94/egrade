<?php

class RLP_C1_1_module extends Module {

    public function __construct(School $school, SchoolClass $school_class, Student $student, Federal $federal, string $module_name, SchoolTemplateVariables $school_template_variables)
    {
        parent::__construct($school, $school_class, $student, $federal, $module_name, $school_template_variables);

        $this->model = $this->loadModel();

        //passthru schooltemplate variables

//        $this->model->setSchoolTemplateVariables($this->getSchoolTemplateVariables());

        if(!empty($_POST['lern_arbeits_und_sozialverhalten'])){
            $this->model->setLernArbeitsUndSozialVerhalten($_POST['lern_arbeits_und_sozialverhalten']);
        }
        if(!empty($_POST['deutsch_sachunterricht'])){
            $this->model->setDeutschSachunterricht($_POST['deutsch_sachunterricht']);
        }
        if(!empty($_POST['mathematik'])){
            $this->model->setMathematik($_POST['mathematik']);
        }
        if(!empty($_POST['religion'])){
            $this->model->setReligion($_POST['religion']);
        }
        if(!empty($_POST['musik_sport'])){
            $this->model->setMusikSport($_POST['musik_sport']);
        }
        if(!empty($_POST['bemerkungen'])){
            $this->model->setBemerkungen($_POST['bemerkungen']);
        }
        if(!empty($_POST['leistungsentwicklung'])){
            $this->model->setLeistungsentwicklung($_POST['leistungsentwicklung']);
        }
        if(!empty($_POST['fehlzeiten_entschuldigt'])){
            $this->model->setFehlzeitenEntschuldigt($_POST['fehlzeiten_entschuldigt']);
        }
        if(!empty($_POST['fehlzeiten_unentschuldigt'])){
            $this->model->setFehlzeitenUnentschuldigt($_POST['fehlzeiten_unentschuldigt']);
        }
        if(!$this->saveModel()){
            echo "Beim Speichern gab es ein Problem";exit;
        }
    }

}