<?php

$state_A = new State(0, 'A');
$state_B = new State(1, 'B');
$state_C = new State(2, 'C');
$state_D = new State(3, 'D', 1);

$state_A->createTransition('0', [ $state_A, $state_B ]);
$state_A->createTransition('1', [ $state_A, $state_C ]);

$state_B->createTransition('0', [ $state_D ]);
$state_B->createTransition('1');

$state_C->createTransition('0');
$state_C->createTransition('1', [ $state_D ]);

$state_D->createTransition('0', [ $state_D ]);
$state_D->createTransition('1', [ $state_D ]);

$states = [
    $state_A,
    $state_B,
    $state_C,
    $state_D,
];

$automata = new Automata($states, $state_A, false);

$string = "0000";

$automata->validate($string);

foreach ($automata->results as $result) {
    dump($result->implode());
}

die;
