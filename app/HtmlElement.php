<?php

namespace App;

use phpDocumentor\Reflection\Types\This;

class HtmlElement
{

    private $name;
    private $content;
    private $attributes;

    public function __construct(string $name, array $attributes = [], $content= null)
    {
        $this->name = $name;
        $this->content = $content;
        $this->attributes = $attributes;
    }

    public function render(): string
    {
        if ($this->isVoidElement()){
            return $this->openTag();
        }

        return $this->openTag(). $this->renderContent() . $this->closeTag();
    }

    public function openTag(): string
    {
        return $this->isAttributes();
    }

    public function isVoidElement(): bool
    {
        return in_array($this->name, ['br', 'hr', 'img', 'input', 'meta']);
    }

    public function renderContent(): string
    {
        return htmlentities($this->content, ENT_QUOTES, 'UTF-8');
    }

    public function closeTag(): string
    {
        return '</' . $this->name . '>';
    }

    public function openTagWithAttributes(string $htmlAttributes): string
    {
        return '<' . $this->name . $htmlAttributes . '>';
    }

    public function openTagWithoutAttributes(): string
    {
        return '<' . $this->name . '>';
    }

    public function isAttributes(): string
    {
        if ($this->hasAttributes()) {
            return $this->openTagWithAttributes($this->attributes());
        } else {
            return $this->openTagWithoutAttributes();
        }
    }

    public function hasAttributes(): bool
    {
        return ! empty($this->attributes);
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

    protected function renderAttribute($attribute): string
    {
        if (is_numeric($attribute)) {
            return ' ' . $this->attributes[$attribute];
        }

        return ' ' . $attribute . '="' . htmlentities($this->attributes[$attribute], ENT_QUOTES, 'UTF-8') . '"';
    }

}