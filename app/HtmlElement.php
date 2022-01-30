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
        $result = $this->openTag();

        if ($this->isVoidElement()){
            return $result;
        }

        $result .= $this->renderContent();

        $result .= $this->closeTag();

        return $result;
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
        if (!empty($this->attributes)) {

            $htmlAttributes = $this->attributes();

            $result = $this->openTagWithAttributes($htmlAttributes);

        } else {
            $result = $this->openTagWithoutAttributes();
        }

        return $result;
    }

    public function attributes(): string
    {
        $htmlAttributes = '';

        foreach ($this->attributes as $name => $value) {
            $htmlAttributes .= $this->renderAttribute($name, $value);
        }

        return $htmlAttributes;
    }

    protected function renderAttribute($attribute, $value): string
    {
        if (is_numeric($attribute)) {
            $htmlAttributes = ' ' . $value;
        } else {
            $htmlAttributes = ' ' . $attribute . '="' . htmlentities($value, ENT_QUOTES, 'UTF-8') . '"'; // name="value"
        }

        return $htmlAttributes;
    }

}