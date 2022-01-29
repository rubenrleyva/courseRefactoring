<?php

namespace Tests;

use App\HtmlElement;

class HtmlElementTest extends TestCase
{

    /** @test */
    function it_asserts_true()
    {
        $this->assertTrue(true);
    }

    /** @test */
    function it_generates_a_paragraph_with_content()
    {
        $element = new HtmlElement('p',
            [],
            'Este es el contenido'
        );

        $this->assertSame(
            '<p>Este es el contenido</p>',
            $element->render()
        );
    }

    /** @test */
    function it_generates_a_paragraph_with_content_and_an_id_attribute()
    {
        $element = new HtmlElement(
            'p', ['id' => 'my_paragraph'],
            'Este es el contenido'
        );

        $this->assertSame(
            '<p id="my_paragraph">Este es el contenido</p>',
            $element->render()
        );
    }

    /** @test */
    function it_generates_a_paragraph_with_multiple_attributes()
    {
        $element = new HtmlElement(
            'p', ['id' => 'my_paragraph', 'class' => 'paragraph'],
            'Este es el contenido'
        );

        $this->assertSame(
            '<p id="my_paragraph" class="paragraph">Este es el contenido</p>',
            $element->render()
        );
    }

    /** @test */
    function it_generates_an_img_tag()
    {
        $element = new HtmlElement(
            'img', ['src' => 'img/test.png']
        );

        $this->assertSame(
            '<img src="img/test.png">',
            $element->render()
        );
    }

    /** @test */
    function it_escapes_the_html_attributes()
    {
        $element = new HtmlElement('img',
            ['src' => 'img/test.png', 'title' => 'Curso de "refactorización"']
        );

        $this->assertSame(
            '<img src="img/test.png" title="Curso de &quot;refactorizaci&oacute;n&quot;">',
            $element->render()
        );
    }

    /** @test */
    function it_generate_an_input_tag()
    {
        $element = new HtmlElement(
            'input',
            ['required']
        );

        $this->assertSame(
            '<input required>',
            $element->render()
        );
    }
}