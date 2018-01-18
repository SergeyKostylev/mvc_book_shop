<?php

namespace Framework;


class Conteiner
{

    private $services = [];

    public function set($key,$object)
    {
        $this->services[$key] = $object;
        return $this;
    }

    public function get($key)
    {
        if (!isset($this->services[$key])){

            throw new \Exception("Services not found");
        }
        return $this->services[$key];

    }
}