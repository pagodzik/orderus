<?php

class Player extends Controller
{
    private $name;
    private $health;
    private $strength;
    private $defence;
    private $speed;
    private $luck;
    private $skills;
    private $objSkills;

    public function __construct($heroName = 'Monster')
    {
        parent::__construct();
        $this->objSkills = new Skills();

        $this->name = $heroName;
        require 'config/database.php';
        foreach ($$heroName as $k=>$v) {
            $this->$k = $v;
        }
        $this->skills = $this->objSkills->makeSkills($this->skills);
    }

    /**
     * @param mixed $health
     */
    public function setHealth($health): void
    {
        $this->health = $health;
    }

    public function __get($key) {
        return $this->$key;
    }

    function index() {
    }

    public function allParams() {
        return [
            'Name'      => $this->name,
            'Health'    => $this->health,
            'Strength'  => $this->strength,
            'Defence'   => $this->defence,
            'Speed'     => $this->speed,
            'Luck'      => $this->luck,
        ];
    }


    public function showPlayer() {
        $table = '<table><caption>' . $this->name . '</caption>';
        $table.= '<tr><th>Name</th><th>Value</th></tr>';
        foreach ($this->allParams() as $n=>$v) {
            $table.= '<tr><td>'.$n.'</td><td>'.$v.'</td></tr>';
        }
        if (!empty($this->skills)) {
            $table.= '<tr><td>Skills</td><td>';
            foreach ($this->skills as $skill) {
                $table.= $skill['name'].': '.$skill['value'].'<br />';
            }
            $table .= '</td></tr>';
        }
        $table.= '</table>';

        $this->view->showPlayer = $table;
        $this->view->render('player/presentation', true);
        return;
    }

}
