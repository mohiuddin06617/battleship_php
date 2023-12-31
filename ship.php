<?php
class Ship {
    public $name;
    public $size;
    public $hits;

    public function __construct($name, $size) {
        $this->name = $name;
        $this->size = $size;
        $this->hits = 0;
    }

    public function isSunk() {
        return $this->hits === $this->size;
    }
}