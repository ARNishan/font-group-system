<?php
namespace App\Models;

class Font
{
    private $name;
    private $tmp_name;

    public function __construct($name, $tmp_name)
    {
        $this->name = $name;
        $this->tmp_name = $tmp_name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTmpName()
    {
        return $this->tmp_name;
    }
}
