<?php

class Pinboard_Class extends Page
{
    private $substitution = "";
    private $announcements = "";
    private $information = "";
    private $board_id = "";
    private $school_id = "";

    public function __construct()
    {

        if(Page::getGetVariable("action", FILTER_SANITIZE_STRING) == "renderExtern")
        {
            $board_id = Page::getGetVariable("board", FILTER_SANITIZE_STRING);

            $db = new DB();
            $result = $db->query("SELECT * FROM pinboard WHERE board_id = ? AND board_id is not null", $board_id);

            if($result->numRows() >0 )
            {
                $data = $result->fetchArray();

                $this->school_id = $data["FK_School"];
                $this->substitution = $data["vertretungsplan"];
                $this->announcements = $data["ankuendigung"];
                $this->information = $data["infos"];
                $this->board_id = $data['board_id'];

                $this->school = new School($this->school_id);
            }
            
            $this->renderExtern();

        }else{
            parent::__construct($this);

            if($this->getIsAjax() && Page::getGetVariable("action") == "save")
            {
                $success = $this->save();
                $this->loadData();

                ob_clean();
                header("Content-Type: application/json");
                $json_response = [
                    "success" => $success,
                    "message" => ($success ? "Pinboard erfolgreich gespeichert." : "Pinboard konnte nicht gespeichert werden!"),
                    "data" => [
                        "substitution" => $this->substitution,
                        "announcements" => $this->announcements,
                        "information" => $this->information,
                        "board_id" => $this->board_id
                    ]
                ];
                echo json_encode($json_response);
                ob_flush();

            }else{
                $this->loadData();
                $this->render();
            }

        }
    }

    public function render()
    {
        if(empty($this->board_id)) $this->board_id = rand(100, 9999999);

        $this->view("Pinboard.html")->display([
            'substitution' => $this->substitution,
            "announcements" => $this->announcements,
            "information" => $this->information,
            "board_id" => $this->board_id,
            'UrlSchoolClass' => $this->getRouteUrl("Schoolclass_Details", "&school_class_id=")
        ]);
    }

    private function save() : bool
    {
        try{
            $db = new DB();

            $this->substitution = $_POST["substitution"];
            $this->announcements = $_POST["announcements"];
            $this->information = $_POST["information"];
            $this->board_id = $_POST["board_id"];

            $result = $db->query("SELECT PK_Pinboard FROM pinboard WHERE FK_School = ?", $this->school->getSchoolId());

            if($result->numRows() > 0)
            {
                $pk_pinboard = $result->fetchArray()['PK_Pinboard'];

                $update = $db->query("UPDATE pinboard SET vertretungsplan = ?, ankuendigung = ?, infos = ? WHERE PK_Pinboard = ?",
                    $this->substitution,
                    $this->announcements,
                    $this->information,
                    $pk_pinboard
                );
            }else{
                $db->query("INSERT INTO pinboard (FK_School, vertretungsplan, ankuendigung, infos, board_id) VALUES (?,?,?,?,?)",
                    $this->school->getSchoolId(),
                    $this->substitution,
                    $this->announcements,
                    $this->information,
                    $this->board_id
                );
            }

        }catch (Exception $e){
            return false;
        }

        return true;
    }

    public function loadData()
    {
        $db = new DB();

        $result = $db->query("SELECT * FROM pinboard WHERE FK_School = ? LIMIT 1", $this->school->getSchoolId());

        if($result->numRows() >0 )
        {
            $data = $result->fetchArray();

            $this->substitution = $data["vertretungsplan"];
            $this->announcements = $data["ankuendigung"];
            $this->information = $data["infos"];
            $this->board_id = $data['board_id'];
        }
    }

    public function renderExtern()
    {
        ob_clean();

        $loader = new \Twig\Loader\FilesystemLoader(ROOT_PATH . '/template/');
        $this->template = new \Twig\Environment($loader, [
            'cache' => ROOT_PATH . '/template/cache/',
            'cache' => false,
            'debug' => true,
        ]);

        $this->template->load("Pinboard_Extern.html")->display([
            'substitution' => $this->substitution,
            "announcements" => $this->announcements,
            "information" => $this->information,
            'UrlSchoolClass' => $this->getRouteUrl("Schoolclass_Details", "&school_class_id="),
            'school_name' => $this->school->getSchoolName()
        ]);

    }
}

?>