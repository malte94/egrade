<?php
class Session_Handler
{
    /**
     * @var string
     */
    private string $sessionID = "";

    /**
     * @var bool
     */
    private bool $isValidSession = false;

    /**
     * @var int
     */
    public int $userId = -1;

    /**
     * @var int
     */
    public int $schoolId = -1;

    public function __construct(string $sessionID)
    {
        $this->sessionID = $sessionID;
//        if(!empty($sessionID) && $this->isValidSession($sessionID)){
//            $this->sessionID = $sessionID;
//            $this->isValidSession = true;
//        }else{
//            $this->sessionID = "";
//            $this->isValidSession = false;
//        }
    }

    /** Check whether the session is valid and found in database or not
     *
     * @param string $sessionID
     * @return bool
     */
    public function isValidSession(string $sessionID) : bool
    {
//        if($this->sessionID != $sessionID){
            $db = new DB();
            $result = $db->query("SELECT * FROM session WHERE sessionID = ? AND TIMESTAMPDIFF(HOUR, created, NOW()) < 12 ", $sessionID);

            if($result->numRows() >= 1){

                $tmp_session = $result->fetchArray();
                $this->userId = $tmp_session["FK_User"];
                $this->schoolId = $tmp_session["FK_School"];
                $this->isValidSession = true;
            }
//        }else{
//            $this->isValidSession = false;
//        }

        return $this->isValidSession;
    }

    /** destroy session and remove Cookie
     *
     */
    public function destroy() : void
    {
        $this->isValidSession = false;
        $db = new DB();
        $db->query("DELETE FROM session WHERE sessionID = ?", $this->sessionID);
        session_destroy();
        setcookie("PHPSESSID", "", time() + 3600); // 30 Tage
    }

    /** Create new session and save to database
     *
     * @param $userid
     * @param $schoolid
     * @return bool
     */
    public function create($userid, $schoolid) : bool
    {
        session_regenerate_id(true);
        $this->sessionID = session_id();

        $db = new DB();
        $stm = $db->query("INSERT INTO `session` (FK_User, FK_School, sessionID, created) VALUES (?, ?, ?, ?) ",
            $userid,
            $schoolid,
            $this->sessionID,
            date("Y-m-d H:i:s", time())
        );

        if(!$stm->error && $stm->getLastInsertId() >= 0){

            $this->userId = $userid;
            $this->schoolId = $schoolid;

            return true;
        }else{
            return false;
        }
    }

    /** Get actual session id. If -1 then not valid.
     * @return int
     */
    public function getSessionID() : string
    {
        return $this->sessionID;
    }

    /** Return actual user id from session.
     * TODO: necessary
     * @return int
     */
    public function getSessionUserID() : int
    {
        return $this->userID;
    }
}