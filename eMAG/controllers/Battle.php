<?php


class Battle extends Controller
{
    private $hero1;
    private $hero2;
    private $attacker;
    private $defender;
    private $turnNumber;
    private $objSkills;
    /**
     * Battle constructor.
     */
    public function __construct($hero1Name = 'Monster',$hero2Name = 'Monster')
    {
        parent::__construct();
        $this->objSkills = new Skills();

        $this->hero1 = new Player($hero1Name);
        $this->hero2 = new Player($hero2Name);
        $this->turnNumber = 1;
        $this->attackOrder();
    }

    public function __get($key) {
        return $this->$key;
    }

    public function index() {
        $this->view->render('battle/index', true);
    }

    private function attackOrder() {
        $speedCompare = $this->hero1->speed <=> $this->hero2->speed;
        switch ($speedCompare) {
            case 1:
                $this->attacker = $this->hero1;
                $this->defender = $this->hero2;
                break;
            case -1:
                $this->attacker = $this->hero2;
                $this->defender = $this->hero1;
                break;
            case 0:
                $luckCompare = $this->hero1->luck <=> $this->hero2->luck;
                switch ($luckCompare) {
                    case 1:
                        $this->attacker = $this->hero1;
                        $this->defender = $this->hero2;
                        break;
                    case -1:
                        $this->attacker = $this->hero2;
                        $this->defender = $this->hero1;
                        break;
                    case 0:
                        $rand = mt_rand(0,1);
                        $this->attacker = $this->{'hero'.($rand+1)};
                        $this->defender = $this->{'hero'.(2-$rand)};
                        break;
                }
                break;
        }
        return;
    }

    public function getFirstAttacker() {
        echo 'First attacker: '.$this->attacker->name;
    }

    public function turn() {
        $this->showOpponents();

        if ($this->attack()) {
            if ($this->afterDamage('attacker')) {
                $this->afterDamage('defender');
            }
        }
    }

    public function beforeHit()
    {
        $this->checkBeforeHitSkills();
    }

    public function attack(){
        if (!$this->ifLucky())
        {
            $this->beforeHit();
            $this->makeHit();
        }

        if (!$this->ifAlive($this->defender,true)) {
            $this->view->finalResult =
                $this->defender->name . ' is dead! <br /><br />
                <b>'.$this->attacker->name.' IS A WINNER!</b>';
            return false;
        }
        return true;
    }

    public function showOpponents() {
        $this->view->opponents = '<b>' . $this->attacker->name . ' is attacking ' . $this->defender->name . '</b><br />';
        $this->view->render('battle/opponents', true);
    }

    public function makeHit() {
        $damage = $this->attacker->strength - $this->defender->defence;
        $this->view->makeHit = 'Hit value: '.$damage.'<br />';
        $this->afterHit('attacker', $damage);
        $this->afterHit('defender', $damage);
        $this->view->makeHit .= 'Final damage: '.$damage.'<br />';
        $this->defender->setHealth($this->defender->health - $damage);
        $this->view->render('battle/makeHit', true);
    }

    public function afterHit($role, &$damage) {
        if ($role == 'attacker') {
            $moment = 'afterMakeHit';
            $change = 'increase';
        } else {
            $moment = 'afterGetHit';
            $change = 'reduce';
        }

        if ($this->objSkills->getMomentSkills($this->$role,$moment)) {
            foreach ($this->objSkills->getMomentSkills($this->$role,$moment) as $slug=>$value) {
                $skillResult = $this->objSkills->$slug($value, $damage);
                if (!$skillResult) {
                    $this->view->makeHit .= 'Unfortunatelly for '.$this->$role->name.' "'.$this->objSkills->getSkillNameBySlug($slug).'" doesn\'t work this time.<br />';
                } else {
                    $this->view->makeHit .= $this->$role->name . ' use his special skill "'.$this->objSkills->getSkillNameBySlug($slug).'"!<br />';
                }
            }
        } else {
            $this->view->makeHit .= $this->$role->name . ' has no special skills for '.$change.' damage value.<br />';
        }
    }

    public function afterDamage($role) //return false if defender is dead
    {
        $return = true;
        if ($role == 'attacker') {
            $moment = 'afterMakeDamage';
            $do = 'make';
        } else {
            $moment = 'afterGetDamage';
            $do = 'get';
        }

        if ($this->objSkills->getMomentSkills($this->$role,$moment)) {
            foreach ($this->objSkills->getMomentSkills($this->$role,$moment) as $slug=>$value) {
                $msg = [
                    'Unfortunatelly for '.$this->$role->name.' "'.$this->objSkills->getSkillNameBySlug($slug).'" doesn\'t work this time.<br />',
                    $this->$role->name . ' use his special skill "'.$this->objSkills->getSkillNameBySlug($slug).'"!<br />'
                ];
                $return = ($return && $this->objSkills->$slug($value,$this,$msg));
            }
        } else {
            $this->view->afterDamage = $this->$role->name . ' has no special skills after '.$do.' damage.<br />';
            $this->view->render('battle/afterDamage', true);
        }
        return $return;
    }

    public function swapRoles() {
        list( $this->defender, $this->attacker ) = array( $this->attacker, $this->defender );
    }

    private function checkBeforeHitSkills() {

    }

    private function checkBeforeDamageSkills() {

    }



    public function nextTurn() {
        $this->turnNumber++;
    }

    public function turnNumber() {
        $this->view->turnNumber = $this->turnNumber;
        $this->view->render('battle/turnNumber', true);

    }

    private function ifLucky() {
        $result = $this->defender->luck >= mt_rand(1,100);
        if ($result) {
            $this->view->ifLucky = $this->defender->name . ' was lucky, '.$this->attacker->name.' missed.<br />';
        } else {
            $this->view->ifLucky = $this->defender->name . ' wasn\'t lucky, '.$this->attacker->name.' not missed.<br />';
        }
        $this->view->render('battle/ifLucky', true);
        return $result;
    }

    public function ifAlive($player,$show=false) {
        if ($show && $player->health > 0) {
            $this->view->ifAlive = '<b>'.$this->defender->name . ' has '.$this->defender->health.' health yet.</b><br /><br />';
            $this->view->render('battle/ifAlive', true);
        }
        return $player->health > 0;
    }

    private function getSkillsMoments(Player $player) {
        foreach ($this->$player->skills as $k => $v) {
            $skills = '';
        }
    }

}
