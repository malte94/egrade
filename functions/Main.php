<?php

class Main_Class extends Page
{
    public $hasAccessToAdmin = true;
    public $school_classes = array();
    public $user_students = array();

    /**
     * Main_Mainmenu_Class constructor.
     * Dies ist die Controller Klasse für das Module "Main_Mainmenu", also dem Hauptmenü.
     * Diese wird automatisch von der index.php erstellt, wenn der Parameter function=main_mainmenu übergeben wird.
     * Hier wird die gesamte Logik ausgespielt, also Rechte aus der Datenbank geladen und entsprechende Properties erstellt.
     * Diese Klasse extended automatisch vom Page Objekt, welches globale Session und Rechte Sachen macht.
     * Anschließend wird aus der index.php heraus die Methode view aufgerufen, welche die View Klasse generiert.
     * In dieser können alle "dreckigen" Frontend sachen gemacht werden. Zb. kann dort auch $hasAccessToAdmin abgefragt werden.
     */

     public function __construct()
    {
        parent::__construct($this);
        $this->school->loadSchoolClassesByUser($this->user);
        $school_classes = $this->school->getSchoolClassesByUser($this->user);
        $this->school_classes = $school_classes;
        $user_students = User::getStudentsByUser($this->user);
        $this->user_students = $user_students;

        // AJAX & FETCH ----------------------------------------------------

        if (Page::getGetVariable("showAdmin") == "1"){
            header("Content-Type: text/html");
            echo $this->showAdmin();
        } else {
            $this->render();
        }

        // UPDATE USER NOTES -----------------------------------------------
        if (Page::getGetVariable("action") == "updateUserNotes"){
            $user_notes = Page::getPostVariable("user_notes");
            if(!$this->updateUserNotes($user_notes)) echo "Fehler";
        }

    }
    
    public function hasAccess(){
        return true;
    }

    private function updateUserNotes(string $user_notes) : bool
    {
        $this->user->setUserNotes($user_notes);
        if ($this->user->update()){
            return true;
        }else{
            return false;
        }
    }

    public function showChat() {
        $loader = new \Twig\Loader\FilesystemLoader(ROOT_PATH.'/template/');
        $this->template = new \Twig\Environment($loader, [
            'cache' => ROOT_PATH.'/template/cache/',
            'cache' => false,
            'debug' => true,
        ]);
        
        $route_url = $this->getRouteUrl("", "");
        return $this->template->load("Blocks.html")->renderBlock('egrade_chat', 
            [

            ]);
    }

    public function showAdmin() {
        $loader = new \Twig\Loader\FilesystemLoader(ROOT_PATH.'/template/');
        $this->template = new \Twig\Environment($loader, [
            'cache' => ROOT_PATH.'/template/cache/',
            'cache' => false,
            'debug' => true,
        ]);

        $route_url = $this->getRouteUrl("main", "");
        return $this->template->load("Blocks.html")->renderBlock('show_admin', 
            [
            'schoolClasses' => $this->school_classes,
            'UrlSchoolClass' => $this->getRouteUrl("Schoolclass_Details", "&school_class_id=")    
            ]);
    }

    public function render()
    {
        $this->view("Main.html")->display([
            'user' => $this->user,
            'userStudents' => $this->user_students,
            'schoolClasses' => $this->school_classes,
            'urlMain' => $this->getRouteUrl("main", ""),
            'urlUserStudents' => $this->getRouteUrl("Student_Details", "&school_class_id="),
            'urlSchoolClass' => $this->getRouteUrl("Schoolclass_Details", "&school_class_id=")
        ]);
    }
}

?>