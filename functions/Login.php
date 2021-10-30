<?php
class Login_Class extends Page
{
    public $prefill_school_id = "";
    public ?\Twig\Environment $template;

    public function __construct()
    {
        //parent::__construct();
        $session_id = "";

        if(!empty($_COOKIE['PHPSESSID'])) $session_id = $_COOKIE['PHPSESSID'];

        $session = new Session_Handler($session_id);

        if($session->isValidSession($session_id)){
            header("Location: ".APP_URL."/index.php?function=main&loggedin");
        }else{
            if (Page::getPostVariable("school") && Page::getPostVariable("username") && Page::getPostVariable("password")) {

                //load school id by school shortcut
                $school_id = School::getSchoolIdByShortcut(Page::getPostVariable("school"));

                //load user id by username
                $user_id = User::getUserIdByUsername(Page::getPostVariable("username"), $school_id);

                //create user object using school id and user id
                $user = new User($school_id, $user_id);

                if ($user->exists()) {
                    if ($user->checkPasswordMatch(Page::getPostVariable("password"))) {

                        if($session->create($user->getUserId(), $user->getSchoolId()))
                        {
                            header("Location: ".APP_URL."/index.php?function=main&loggedin");
                        }else{
                            $session->destroy();
                        }

                    } else {
                        echo "missmatch";
                    }
                }
            }
        }

        $this->prefill_school_id = Page::getGetVariable("school");

        $this->render();
    
    }

    public function render() {
        $loader = new \Twig\Loader\FilesystemLoader(ROOT_PATH.'/template/');
        $this->template = new \Twig\Environment($loader,
            [
                'cache' => ROOT_PATH.'/template/cache/',
                'cache' => false,
                'debug' => true
            ]);

        $this->template->display("Login.html",
        [
            'global_App_Url' => APP_URL,
            'global_App_Path' => ROOT_PATH,
            'route' => strtolower($this->getRoute()),
            'prefill_school' => $this->prefill_school_id
        ]
        );
    }
}


