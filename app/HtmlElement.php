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
        if (!empty($this->attributes)) {

            $htmlAttributes = '';

            foreach ($this->attributes as $name => $value) {

                if (is_numeric($name)) {
                    $htmlAttributes .= ' '.$value;
                }else{
                    $htmlAttributes .= ' '.$name.'="'.htmlentities($value, ENT_QUOTES, 'UTF-8').'"'; // name="value"
                }
            }

            $result = $this->openTagWithAttributes($htmlAttributes);

        }else{
            $result = $this->openTagWithoutAttributes();
        }

        return $result;
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

}