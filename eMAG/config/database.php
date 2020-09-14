<?php
$Orderus = [
    'health'    => mt_rand(70, 100),
    'strength'  => mt_rand(70, 80),
    'defence'   => mt_rand(45, 55),
    'speed'     => mt_rand(40, 50),
    'luck'      => mt_rand(10, 30),
    'skills'    => [
        1   => 10,
        4   => 20,
    ],
];
$Monster = [
    'health'    => mt_rand(60, 90),
    'strength'  => mt_rand(60, 90),
    'defence'   => mt_rand(40, 60),
    'speed'     => mt_rand(40, 60),
    'luck'      => mt_rand(25, 40),
    'skills'    => [],
];
$Skills = [
    'secretSkill',
    'rapidStrike',
    'anotherSkill',
    'ultraSkill',
    'magicShield',
];
$SkillsNames = [
    'Secret skill',
    'Rapid strike',
    'Another skill',
    'Ultra Skill',
    'Magic shield',
];
$SkillsMoments = [
    'beforeMakeHit',
    'afterMakeDamage',
    'beforeGetHit',
    'afterGetDamage',
    'afterGetHit',
];
