<?php

namespace App;

class HtmlAttributes implements \ArrayAccess
{
    /**
     * @var array
     */
    public $attributes;

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function renderAttribute($attribute): string
    {
        if (is_numeric($attribute)) {
            return ' ' . $this->attributes[$attribute];
        }

        return ' ' . $attribute . '="' . htmlentities($this->attributes[$attribute], ENT_QUOTES, 'UTF-8') . '"';
    }

    public function attributes(): string
    {
        /*
        $htmlAttributes = '';

        foreach ($this->attributes as $name => $value) {
            $htmlAttributes .= $this->renderAttribute($name, $value);
        }

        return $htmlAttributes;
        */

        return array_reduce(array_keys($this->attributes), function ($result, $attribute) {
            //var_dump($result .' '.$attribute);
            return $result . $this->renderAttribute($attribute);
        }, '');

    }

    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    public function offsetGet($offset)
    {
        return $this->attributes[$offset];
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }
}