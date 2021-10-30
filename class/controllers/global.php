<?php

/**
 * Class Page
 */
class Page
{

    /**
     * @var bool
     */
    private bool $isLoggedIn = false;

    /**
     * @var Session_Handler|null
     */
    private Session_Handler $session;

    /**
     * @var string
     */
    public string $controller_name = "";

    /**
     * (User) Objekt
     * @var User|null
     */
    public ?User $user = null;

    /**
     * @var School|null
     */
    public ?School $school = null;

    /**
     * @var SchoolTemplate|null
     */
    public ?array $school_templates = null;

    /**
     * @var Rights
     */
    public Rights $rights;

    /**
     * @var DB
     */
    public DB $db;

    /**
     * @var bool
     */
    public bool $isAjax = false;

    /**
     * @var \Twig\Enviroment
     */
    public ?\Twig\Environment $template;

    /**
     * @var SchoolTemplateMap
     */
    public SchoolTemplateMap $school_template_map;

    /**
     * Page constructor.
     * @param $controller
     */
    public function __construct($controller)
    {
        $tmp_session_id = "";
        if (!empty($_COOKIE["PHPSESSID"])) $tmp_session_id = $_COOKIE['PHPSESSID'];

        $this->session = new Session_Handler($tmp_session_id);
        if (Page::getGetVariable("logout") == "true")
        {
            $this->destroySession();
        }

        $this->db = new DB();
        $this->rights = new Rights($this->db);

        if (!empty($_COOKIE["PHPSESSID"]))
        {

            if ($this->session->isValidSession($_COOKIE["PHPSESSID"]))
            {
                $this->isLoggedIn = true;

                //Load user object to Page object
                if ($this->session->userId != -1 && $this->session->schoolId != -1)
                {
                    $this->user = new User($this->session->schoolId, $this->session->userId);
                }

                //check again if user exists
                if (!$this->user->exists()) $this->destroySession();

                //load school object to page object
                if ($this->session->schoolId != -1)
                {
                    $this->school = new School($this->session->schoolId);

                    $this->school_template_map = new SchoolTemplateMap($this->school);
                }

            } else {
                $this->destroySession();
            }

        } else {
            $this->destroySession();
        }

        $this->controller_name = get_class($controller);
        if (Page::getGetVariable("is_ajax") == "1") $this->isAjax = true;
    }

    /**
     * @return bool
     */
    public function isLoggedIn() : bool
    {
        return $this->isLoggedIn;
    }

    /**
     *
     */
    public function destroySession() : void
    {
        $this->isLoggedIn = false;
        $this->session->destroy();
        header("Location: " . $this->getRouteUrl("Login", ""));
    }

    /**
     * @param $template_name
     * @return \Twig\TemplateWrapper
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function view($template_name) : \Twig\TemplateWrapper
    {
        $loader = new \Twig\Loader\FilesystemLoader(ROOT_PATH . '/template/');
        $this->template = new \Twig\Environment($loader, [
            'cache' => ROOT_PATH . '/template/cache/',
            'cache' => false,
            'debug' => true,
        ]);

        $this->template->addGlobal('global_App_Url', APP_URL);
        $this->template->addGlobal('global_App_Path', ROOT_PATH);
        $this->template->addGlobal('global_School_Name', $this->school->getSchoolName());
        $this->template->addGlobal('global_User_Name', $this->user->getUsername());
        $this->template->addGlobal('global_federal_state', $this->school->getFederalState());

        return $this->template->load($template_name);
    }

    /**
     * @return string
     */
    public function getControllerName() : string
    {
        return get_class($this);
    }

    /**
     * @param string $controller_name
     * @return string
     */
    public function getRoute($controller_name = "") : string
    {
        if ($controller_name == "")
        {
            $controller_name = $this->getControllerName();
        }

        if (strpos($controller_name, "Class") !== false)
        {
            $controller_name = substr($controller_name, 0, strpos($controller_name, "Class") - 1);
            return $controller_name;
        }

        return $controller_name;
    }

    /**
     * @param string $controller_name
     * @param $appendix
     * @return string
     */
    public function getRouteUrl($controller_name = "", $appendix) : string
    {
        return APP_URL . "/index.php?function=" . $this->getRoute($controller_name) . $appendix;
    }

    /**
     * @param $key
     * @param int $filter
     * @return string
     */
    public static function getPostVariable($key, $filter = FILTER_SANITIZE_SPECIAL_CHARS) : string
    {
        if (isset($_POST[$key]))
        {
            return filter_var($_POST[$key], $filter);
        } else {
            return "";
        }
    }

    /**
     * @param $key
     * @param int $filter
     * @return string
     */
    public static function getGetVariable($key, $filter = FILTER_SANITIZE_SPECIAL_CHARS) : string
    {
        if (isset($_GET[$key]))
        {
            return filter_var($_GET[$key], $filter);
        } else {
            return "";
        }
    }

    /**
     * @return string
     */
    public function getSession() : Session_Handler
    {
        return $this->session;
    }

    /**
     * @return bool
     */
    public function getIsAjax() : bool
    {
        return $this->isAjax;
    }
}
