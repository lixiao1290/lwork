<?php
namespace minicore\lib;

class ClosuresQueue
{
    public $closuresArray=array();
    public $closursNotes=array();
    public function  addClosure(\Closure $closure,$note='null')
    {
        array_push($this->closuresArray, $closure);
        array_push($this->closursNotes, $note);
    }
    public function addClosures(array $closures,$note='null')
    {
        $this->closuresArray=array_merge($this->closuresArray,$closures);
    }
    public function runByOrder()
    {
        while ($closure=array_shift($this->closuresArray)) {
            call_user_func($closure);
        }
        
    }
}

