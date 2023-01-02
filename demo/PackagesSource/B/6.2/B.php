<?php
namespace B;
use address\A;

class B{
    public function __construct()
    {
        echo 'B v6.2';
        new A();
    }
}