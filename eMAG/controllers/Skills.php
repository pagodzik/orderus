<?php


class Skills extends Controller
{
    private $skillsSlugs;
    private $skillsNames;
    private $skillsMoments;

    /**
     * Skills constructor.
     */
    public function __construct()
    {
        parent::__construct();
        require 'config/database.php';
        $this->skillsSlugs = $Skills;
        $this->skillsNames = $SkillsNames;
        $this->skillsMoments = $SkillsMoments;
    }

    public function getSkillNameBySlug($slug) {
        $key = array_search($slug,$this->skillsSlugs);
        return $this->skillsNames[$key];
    }

    public function makeSkills($skills)
    {
        $return = [];
        foreach ($skills as $k=>$v) {
            $return[] = [
                'value' => $v,
                'slug'  => $this->skillsSlugs[$k],
                'name'  => $this->skillsNames[$k],
                'moment'  => $this->skillsMoments[$k],
            ];
        }
        return $return;
    }

    public function getMomentSkills($player, $moment) {
        if (empty($player->skills[0])) { return false;}
        $return=[];
        foreach ($player->skills as $skill) {
            if ($skill['moment'] == $moment) {
                $return[$skill['slug']] = $skill['value'];
            }
        }
        return $return;
    }

    public function magicShield($value,&$damage) {
        if (mt_rand(1,100) <= $value ) {
            $damage /= 2;
            return true;
        } else {
            return false;
        }
    }

    public function rapidStrike($value,$battle,$msg) {
        if (mt_rand(1,100) <= $value ) {
            $this->view->afterDamage = $msg[1];
            $this->view->render('battle/afterDamage', true);
            return $battle->attack();
        } else {
            $this->view->afterDamage = $msg[0];
            $this->view->render('battle/afterDamage', true);
            return true;
        }
    }
}
