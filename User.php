<?php
class User
{
    private $username = "";
    private $password = "";
    private $credit = 0;
    private $arrSessionsId = [];

    public function __construct(string $username, string $password, int $credit)
    {
        $this->username = $username;
        $this->password = $password;
        $this->credit = $credit;
    }

    public function getUsername()
    {
        return $this->username;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getCredit()
    {
        return $this->credit;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
    }
    public function setPassword(string $password)
    {
        $this->password = $password;
    }
    public function setCredit(int $credit)
    {
        $this->credit = $credit;
    }

    public function addSessionId(string $sessionID)
    {
        $lastPosition = count($this->arrSessionsId);
        $this->arrSessionsId[$lastPosition] = $sessionID;
        return $this->arrSessionsId[$lastPosition];
    }

    public function getSessionIdArray()
    {
        return $this->arrSessionsId;
    }
}
?>