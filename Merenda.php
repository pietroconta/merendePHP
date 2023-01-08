<?php
class Merenda
{
    private $name = "";
    private $cost = 0;
    private $num = 0;

    public function __construct(string $name, int $cost, int $num)
    {
        $this->name = $name;
        $this->cost = $cost;
        $this->num = $num;
    }

    public function getName()
    {
        return $this->name;
    }
    public function getCost()
    {
        return $this->cost;
    }
    public function getNum()
    {
        return $this->num;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }
    public function setCost(int $cost)
    {
        $this->cost = $cost;
    }
    public function setNum(int $num)
    {
        $this->num = $num;
    }
}

?>