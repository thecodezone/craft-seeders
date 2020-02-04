<?php

namespace CodeZone\seeders\models;

use craft\base\Model;

class Settings extends Model
{
    public $seeders = [];
    public $default = null;

    public function rules()
    {
        return [
            [['seeders'], 'array']
        ];
    }
}