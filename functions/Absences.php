<?php

class Absences_Class extends Page
{
    public function __construct()
    {
        parent::__construct($this);

        switch (strtolower(Page::getGetVariable("action"))) {

            case "addabsence":
                $user_id = $this->user->getUserId();
                $school_id = $this->user->getSchoolId();
                $reason = Page::getPostVariable("reason");
                $date_from = Page::getPostVariable("date_from");
                $date_to = Page::getPostVariable("date_to");

                if (!empty($user_id) && !empty($school_id) && !empty($reason) && !empty($date_from) && !empty($date_to)) {
                    $this->addAbsence($user_id, $school_id, $reason, $date_from, $date_to);
                    mail("malte@uni-koblenz.de", "Ein Kollege hat sich krank gemeldet.", "Todo");
                }
                break;
        }

        $this->user->getAbsencesByUser($this->user);

        $this->render();

    }

    private function addAbsence(int $user_id, int $school_id, string $reason, $date_from, $date_to)
    {
        $this->user->addAbsence($user_id, $school_id, $reason, $date_from, $date_to);
    }

    public function render()
    {
        $this->view("Absences.html")->display(
            [
                'absences' => $this->user->getAbsences()
            ]);
    }
}