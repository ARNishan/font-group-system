<?php
namespace App\Models;

class FontGroup
{
    public $group_name;
    public $fonts;
    public $font_count;

    public function __construct($group_name, $fonts)
    {
        $this->group_name = $group_name;
        $this->fonts = $fonts;
        $this->font_count = count($fonts); 
    }
}
