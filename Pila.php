<?php

class Pila
{
    public $elements;
    public $top;

    public function __construct(){
        $this->top = 0;
        $this->elements = [];
    }

    function pop()
    {
        $element = null;
        if($this->top > 0){
            $element = $this->elements[$this->top];
            unset($this->elements[$this->top]);
            $this->top--;
        }else {
            echo "PILA VACIA";
        }
        return $element;
    }

    function push($element)
    {
        $this->top++;
        $this->elements[$this->top] = $element;
    }

    function implode()
    {
        $text = "";
        $i = 0;

        $text .= "[";

        foreach ($this->elements as $element) {
            $text .= $element->id;
            if ($i != (count($this->elements)-1)) {
                $text .= ", ";
            }
            $i++;
        }

        $text .= "]";

        $text .= ": " . count($this->elements);

        return $text;
    }
}
