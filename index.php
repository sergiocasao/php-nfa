<?php

require_once('functions.php');
require_once('config.php');

require_once('State.php');
require_once('Automata.php');

$handle = fopen("5.txt", "r");

if ($handle) {

    // Leemos la primera linea del archivo que contiene los estados
    $text_states  = explode(',', fgets($handle));

    $states = array();

    // Creamos los estados por cada estado que exista
    foreach ($text_states as $key => $state) {
        $states[] = new State($state);
    }

    // Leemos la segunda linea que contiene los simbolos del automata.
    $text_symbols = explode(',', fgets($handle));

    // Creamos un objeto automata
    $automata = new Automata($states, $text_symbols, false);

    // Leemos la tercera linea en la que obtenemos el id del estado inicial
    $text_initial_state = explode(',', fgets($handle));

    // Asignamos el estado inicial al automata
    $automata->setInitialState($text_initial_state[0]);

    // Leemos la cuarta linea que contiene los estados finales.
    $text_final_state = explode(',', fgets($handle));

    // Asignamos los estados finales al automata
    $automata->setFinalStates($text_final_state);

    // Seguimos leyendo el archivo que contiene las transiciones.
    while (($transition = fgets($handle)) !== false) {
        $transition = explode(',', $transition);
        if (count($transition) == 3) {
            $state = $automata->find($transition[0]);
            $to_state = $automata->find($transition[2]);
            $state->createTransition($transition[1], $to_state);
        }else {
            dd('The transition doesn´t have the correct format.');
        }
    }

    $string = "bccacc";

    $results = $automata->validate($string);

    if (count($results) > 0) {
        dump('Valid string');
        foreach ($results as $result) {
            dump($result);
        }
    }else {
        dump('Invalid string');
    }


} else {
    dd('Could not open the file.');
}
