<?php

class State
{
    public $id;
    public $is_final;
    public $transitions = array();

    function __construct($id, $is_final = 0)
    {
        $this->id = (int)$id;
        $this->is_final = $is_final;
    }

    public function setTransitions($transitions)
    {
        $this->transitions = $transitions;
    }

    public function createEmptyTransition(string $symbol)
    {
        $this->transitions[trim($symbol)] = array();
    }

    public function createTransition(string $symbol, State $state)
    {
        $this->transitions[trim($symbol)][] = $state;
    }

    public function setAsFinal(){
        $this->is_final = true;
    }

    public function isFinal()
    {
        return $this->is_final;
    }

    public function getStatesWithSymbol(string $symbol)
    {
        return $this->transitions[trim($symbol)];
    }

    public function getStatesWithEpsilon()
    {
        return $this->transitions['E'];
    }

    public function implodeStatesWithEpsilon()
    {
        $i = 0;
        $text = "";
        $states = $this->getStatesWithEpsilon();

        $text .= "[";

        foreach ($states as $state) {
            $text .=  $state->id;
            if ($i != (count($states)-1)) {
                $text .= ", ";
            }
            $i++;
        }

        $text .= "]";

        $text .= ": " . count($states);

        return $text;
    }

    public function implodeStatesWithSymbol(string $symbol)
    {
        $i = 0;
        $text = "";
        $states = $this->getStatesWithSymbol($symbol);

        $text .= "[";

        foreach ($states as $state) {
            $text .=  $state->id;
            if ($i != (count($states)-1)) {
                $text .= ", ";
            }
            $i++;
        }

        $text .= "]";

        $text .= ": " . count($states);

        return $text;
    }
}
