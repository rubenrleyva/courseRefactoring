<?php

namespace App;

class HtmlElement
{

    private $name;
    private $content;
    private $attributes;

    public function __construct(string $name, array $attributes = [], $content= null)
    {
        $this->name = $name;
        $this->attributes = new HtmlAttributes($attributes);
        $this->content = $content;
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
        return ! empty($this->getAttributes());
    }

    protected function getAttributes(): array
    {
        return $this->attributes->attributes;
    }

    public function attributes(): string
    {
        return $this->attributes->attributes();
    }
}