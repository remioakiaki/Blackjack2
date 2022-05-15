<?php

namespace Blackjack\tests;

use PHPUnit\Framework\TestCase;
use Blackjack\Deck;

require_once(__DIR__ . '/../../lib/blackjack/Deck.php');

final class DeckTest extends TestCase
{
    public function testDrawCard(): void
    {
        $deck = new Deck();
        $card = $deck->drawCard();
        // シャッフルしていない場合、最初は必ずC2が最初になる
        $this->assertSame('C', $card->getSuitLetter());
        $this->assertSame('2', $card->getNumber());
    }
}
