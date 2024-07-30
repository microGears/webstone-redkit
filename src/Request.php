<?php

declare(strict_types=1);
/**
 * This file is part of WebStone\Redkit.
 *
 * (C) 2009-2024 Maxim Kirichenko <kirichenko.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WebStone\Redkit;

use WebStone\Stdlib\Classes\AutoInitialized;

class Request extends AutoInitialized
{
    protected $attributes = [];

    public function __get($name)
    {
        return $this->getAttribute($name);
    }

    public function __set($name, $value)
    {
        $this->setAttribute($name, $value);
    }

    public function deleteAttribute($key)
    {
        if ($this->hasAttribute($key)) {
            unset($this->attributes[$key]);
        }
    }

    public function getAttribute($key, $default = null)
    {
        if ($this->hasAttribute($key)) {
            return $this->attributes[$key];
        }

        return $default;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function hasAttribute($key)
    {
        return array_key_exists($key, $this->attributes);
    }

    public function setAttribute($key, $value = null)
    {
        return $this->attributes[$key] = $value;
    }

    public function setAttributes(array $value)
    {
        $this->attributes = $value;
    }
}

/* End of file Predicable.php */