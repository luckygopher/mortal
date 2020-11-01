<?php
namespace core\lib;

use Medoo\Medoo;

class Model extends Medoo
{
    public function __construct()
    {
        $dataConf = Config::all('database');
        parent::__construct($dataConf);
    }
}