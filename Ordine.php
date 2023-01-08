<?php
include_once("Merenda.php");
include_once("User.php");
class Ordine
{
    private $user;
    private $merende = [];
    private $cost = 0;
    private $date = "";

    public function __construct(User $user, $merende, int $cost, $date)
    {
        $this->user = $user;
        $this->merende = $merende;
        $this->cost = $cost;
        $this->date = $date;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getMerende()
    {
        return $this->merende;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function getTot(){
        $tot = 0;
        foreach ($this->merende as $key => $merenda) {
            $tot += $merenda->getCost();
        }
        return $tot;
    }
}


?>