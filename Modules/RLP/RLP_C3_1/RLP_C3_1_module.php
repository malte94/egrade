<?php

class RLP_C3_1_module extends Module
{

    /**
     * @var array
     */
    private array $grades;

    public function __construct(School $school,  SchoolClass $school_class, Student $student, Federal $federal, string $module_name, SchoolTemplateVariables $school_template_variables)
    {
        parent::__construct($school, $school_class, $student, $federal, $module_name, $school_template_variables);

        $this->model = $this->loadModel();
        $this->grades = $this->model->getGrades();

        //TODO: Sanitize the $_POST input arrays
        if(!empty($_POST['lern_arbeits_und_sozialverhalten']))
        {
            $this->model->setLernArbeitsUndSozialVerhalten($_POST['lern_arbeits_und_sozialverhalten']);
        }

        if(!empty($_POST['leistungsentwicklung']))
        {
            $this->model->setLeistungsentwicklung($_POST['leistungsentwicklung']);
        }

        if(!empty($_POST['fehlzeiten_entschuldigt']))
        {
            $this->model->setFehlzeitenEntschuldigt($_POST['fehlzeiten_entschuldigt']);
        }

        if(!empty($_POST['fehlzeiten_unentschuldigt']))
        {
            $this->model->setFehlzeitenUnentschuldigt($_POST['fehlzeiten_unentschuldigt']);
        }

        if ($this->getIsAjax())
        {
            switch (Page::getGetVariable("action", FILTER_SANITIZE_STRING))
            {
                case "printModel":
                    $this->printModel();
                    break;
            }
        } else {

            foreach ($this->grades as $key => $grade)
            {
                if (!empty($_POST[$key]))
                {
                    $this->grades[$key] = $_POST[$key];
                }
            }

            $this->model->setGrades($this->grades);

            if (!$this->saveModel())
            {
                echo "Beim Speichern gab es ein Problem";
                exit;
            }
        }
    }

    public function printModel(): void
    {
        ob_clean();
        header("Content-Type: application/json");
        $response = [
            "status" => "success",
            "text" => "",
            "data" => $this->model
        ];
        echo json_encode($response);
        ob_flush();
        exit;
    }
}