<?php
namespace Tests\Helpers;

use \PHPUnit\Framework\TestCase;
use \App\Helpers\Text;

class TextTest extends TestCase
{
    private $text = "Esse nostrud sunt id tempor amet eiusmod anim. ";

    public function testExcerptDefault()
    {
        $text = $this->text . $this->text . $this->text ;
        $this->assertEquals(
            'Esse nostrud sunt id tempor amet eiusmod anim. Esse nostrud'.
            ' sunt id tempor amet eiusmod anim. Esse nostrud...',
            Text::excerpt($text)
        );
    }

    public function testExcerptDefaultEndWhiteSpace()
    {
        $text = $this->text .$this->text."Essen ostrud sunt id tempor amet eiusmod anim.";
        $this->assertEquals(
            'Esse nostrud sunt id tempor amet eiusmod anim. Esse nostrud sunt id tempor amet eiusmod anim. Essen...',
            Text::excerpt($text)
        );
    }

    public function testExcerpt50()
    {
        $text = $this->text. $this->text. $this->text;
        $this->assertEquals(
            'Esse nostrud sunt id tempor amet eiusmod anim. Esse...',
            Text::excerpt($text, 50)
        );
    }

    public function testExcerptShortTextLimit50()
    {
        $text = "Esse nostrud sunt id tempor amet eiusmod";
        $this->assertEquals(
            'Esse nostrud sunt id tempor amet eiusmod',
            Text::excerpt($text, 50)
        );
    }

    public function testExcerptTextLimit50NoSpace()
    {
        $text = "EssenostrudsuntidtemporameteiusmodEssenostrudsuntidtemporameEssenostrudsunt";
        $this->assertEquals(
            'EssenostrudsuntidtemporameteiusmodEssenostrudsunti...',
            Text::excerpt($text, 50)
        );
    }

    public function testExcerptDefaultWithHTML()
    {
        $text = "<h1>Esse nostrud sunt</h1> <p>id tempor amet eiusmod anim.</p>".
        " <section>Esse nostrud sunt id tempor amet eiusmod anim. Esse nostrud ".
        "sunt id tempor amet eiusmod anim.</section>";
        $this->assertEquals(
            "Esse nostrud sunt id tempor amet eiusmod anim.".
            " Esse nostrud sunt id tempor amet eiusmod anim. Esse nostrud...",
            Text::excerpt($text)
        );
    }
}
