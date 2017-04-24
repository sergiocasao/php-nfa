<?php

require_once('Pila.php');

class Automata
{
    public $initial_state;
    public $states;
    public $symbols;
    public $transitions;
    public $current_road;
    public $results;
    public $debug;

    function __construct($states, $symbols, $debug = false)
    {
        $this->states = $states;
        $this->symbols = $symbols;
        $this->current_road = new Pila;
        $this->results = array();
        $this->debug = $debug;

        array_push($this->symbols, 'E');

        foreach ($this->states as $state) {
            foreach ($this->symbols as $symbol) {
                $state->createEmptyTransition($symbol);
            }
        }
    }

    public function validate($string)
    {
        dump($string);
        $this->recursive($this->initial_state, $string, 0);
        $results = $this->results;
        $this->results = array();
        $this->current_road = new Pila;
        return $results;
    }

    public function recursive(State $current_state, $string, $n)
    {
        $this->current_road->push($current_state);
        if ($this->debug){
            dump("push(".$current_state->id.")");
            dump("Current road:");
            dump($this->current_road->implode());
        }
        if ($n == strlen($string)) {
            if ($this->debug) {
                dump( "$(" . $current_state->id . ") Llegamos al final de la cadena, es final?");
                dump($current_state->isFinal() ? "Si" : "No");
            }
            if ($current_state->isFinal()) {
                array_push($this->results, $this->current_road->implode());
            }else {
                $new_states = $current_state->getStatesWithEpsilon();
                if (count($new_states) > 0) {
                    if ($this->debug) {
                        dump("$(". $current_state->id .", E) => " . $current_state->implodeStatesWithEpsilon());
                    }
                    foreach ($new_states as $key => $state) {
                        $this->recursive($state, $string, $n);
                        $pop = $this->current_road->pop();
                        if ($this->debug){
                            dump("pop(".$pop->id.")");
                        }
                    }
                }
            }
        }else {
            $new_states = $current_state->getStatesWithSymbol($string[$n]);
            if (count($new_states) > 0) {
                if ($this->debug) {
                    dump("$(". $current_state->id .", $string[$n]) => " . $current_state->implodeStatesWithSymbol($string[$n]));
                }
                foreach ($new_states as $key => $state) {
                    $this->recursive($state, $string, $n+1);
                    $pop = $this->current_road->pop();
                    if ($this->debug){
                        dump("pop(".$pop->id.")");
                    }
                }
            }
            $new_states = $current_state->getStatesWithEpsilon();
            if (count($new_states) > 0) {
                if ($this->debug) {
                    dump("$(". $current_state->id .", E) => " . $current_state->implodeStatesWithEpsilon());
                }
                foreach ($new_states as $key => $state) {
                    $this->recursive($state, $string, $n);
                    $pop = $this->current_road->pop();
                    if ($this->debug){
                        dump("pop(".$pop->id.")");
                    }
                }
            }
        }

        return ;
    }

    public function find($id)
    {
        $new_array = array_filter($this->states, function($obj) use ($id){
            if (isset($obj->id)) {
                if ($obj->id == $id) return true;
            }
            return false;
        });

        if (count($new_array) == 1) {
            return array_values($new_array)[0];
        }

        return null;
    }

    public function setInitialState($id)
    {
        $this->initial_state = $this->find($id);
    }

    public function setFinalStates($states)
    {
        foreach ($states as $state) {
            $obj = $this->find($state);
            $obj->setAsFinal();
        }
    }

}
