<?php

class NRW_C2_1_module extends Module {

    private array $grades;

    public function __construct(School $school, SchoolClass $school_class, Student $student, Federal $federal, string $module_name, SchoolTemplateVariables $school_template_variables)
    {
        parent::__construct($school, $school_class, $student, $federal, $module_name, $school_template_variables);

        $this->model = $this->loadModel();
        $this->grades = $this->model->getGrades();

        if($this->getIsAjax())
        {
            switch (Page::getGetVariable("action", FILTER_SANITIZE_STRING))
            {
                case "printModel":
                    $this->printModel();
                    break;
            }
        }

        if(!empty($_POST['aussagen_arbeits_sozialverhalten_lernentwicklung']))
        {
            $this->model->setAussagenArbeitsSozialverhaltenLernentwicklung($_POST['aussagen_arbeits_sozialverhalten_lernentwicklung']);
        }

        foreach ($this->grades as $key => $grade)
        {
            if (!empty($_POST[$key]))
            {
                $this->grades[$key] = $_POST[$key];
            }
        }

        $this->model->setGrades($this->grades);

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

    /**
     * flush the model class as json object to output buffer
     */
    public function printModel(): void
    {
        ob_clean();
        header("Content-Type: application/json");
        $jon_response = [
            "status" => "success",
            "text" => "",
            "data_model" => $this->model
        ];
        echo json_encode($jon_response);
        ob_flush();
        exit;
    }

}