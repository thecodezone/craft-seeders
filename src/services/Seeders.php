<?php

namespace CodeZone\seeders\services;

use CodeZone\seeders\exceptions\SeederException;
use CodeZone\seeders\SeederInterface;
use craft\base\Component;
use craft\services\Plugins;
use CodeZone\seeders\Seeders as Plugin;

class Seeders extends Component
{
    public function exists($handle)
    {
        if (!$handle) {
            return null;
        }

        return array_key_exists($handle, Plugin::$plugin->getSettings()->seeders);
    }

    public function find($handle)
    {
        if (!$handle) {
            return null;
        }

        if (!$this->exists($handle)) {
            return null;
        }

        return Plugin::$plugin->getSettings()->seeders[$handle];
    }

    public function factory($handleOrClassName): SeederInterface
    {
        if (!$handleOrClassName) {
            return null;
        }

        if (!$classname = $this->find($handleOrClassName)) {
            $classname = $handleOrClassName;
        }

        if (!class_exists($classname)) {
            throw new SeederException($classname . ' does not exist');
        }

        return new $classname;
    }
}