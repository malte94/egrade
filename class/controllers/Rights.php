<?php

class Rights
{
    public DB $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    /** Check if the given user "owns" the class. atm we only have this single right.
     *
     * @param User $user
     * @param SchoolClass $school_class
     * @return bool
     */
    private function userOwnsClass(User $user, SchoolClass $school_class) : bool
    {
        if($user->getUserId() > -1 && $school_class->getSchoolClassId() > -1)
        {
            $result = $this->db->query("SELECT FK_User, FK_Class FROM user_to_class WHERE FK_User = ? AND FK_Class = ?", $user->getUserId(), $school_class->getSchoolClassId());

            //check if "something" was returned.
            if($result->numRows() > 0)
            {
                $result = $result->fetchArray();
                //Why check again? - To prevent sql-injections.
                if($result['FK_User'] == $user->getUserId() && $result['FK_Class'])
                {
                    return true;
                }
            }
        }

        return false;
    }

    /** May the given user delete the given class
     *
     * @param User $user
     * @param SchoolClass $school_class
     * @return bool
     */
    public function userMayDeleteClass(User $user, SchoolClass $school_class) : bool
    {
        return $this->userOwnsClass($user, $school_class);
    }

    /** Given user is allowed to "see" the given class
     *
     * @param User $user
     * @param SchoolClass $school_class
     * @return bool
     */
    public function userMaySeeClass(User $user, SchoolClass $school_class) : bool
    {
        return $this->userOwnsClass($user, $school_class);
    }
}