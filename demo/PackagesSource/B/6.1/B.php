<?php
namespace B;
use address\A;

class B{
    public function __construct()
    {
        echo 'B v6.1';
        new A();
    }
}