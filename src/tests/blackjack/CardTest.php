<?php

namespace Blackjack\tests;

use PHPUnit\Framework\TestCase;
use Blackjack\Card;

require_once(__DIR__ . '/../../lib/blackjack/Card.php');

final class CardTest extends TestCase
{
    public function testGetNumber(): void
    {
        $card1 = new Card('C', '5');
        $card2 = new Card('C', '10');
        $card3 = new Card('C', 'J');
        $card4 = new Card('C', 'Q');
        $card5 = new Card('C', 'K');
        $card6 = new Card('C', 'A');

        $this->assertSame('5', $card1->getNumber());
        $this->assertSame('10', $card2->getNumber());
        $this->assertSame('J', $card3->getNumber());
        $this->assertSame('Q', $card4->getNumber());
        $this->assertSame('K', $card5->getNumber());
        $this->assertSame('A', $card6->getNumber());
    }
    public function testGetSuitName(): void
    {
        $card1 = new Card('C', 5);
        $card2 = new Card('H', 5);
        $card3 = new Card('S', 5);
        $card4 = new Card('D', 5);

        $this->assertSame('クラブ', $card1->getSuitName('C'));
        $this->assertSame('ハート', $card2->getSuitName('H'));
        $this->assertSame('スペード', $card3->getSuitName('S'));
        $this->assertSame('ダイヤ', $card4->getSuitName('D'));
    }

    public function testGetPoint(): void
    {
        $card1 = new Card('C', '5');
        $card2 = new Card('C', '10');
        $card3 = new Card('C', 'J');
        $card4 = new Card('C', 'Q');
        $card5 = new Card('C', 'K');
        $card6 = new Card('C', 'A');

        $this->assertSame(5, $card1->getPoint());
        $this->assertSame(10, $card2->getPoint());
        $this->assertSame(10, $card3->getPoint());
        $this->assertSame(10, $card4->getPoint());
        $this->assertSame(10, $card5->getPoint());
        $this->assertSame(1, $card6->getPoint());
    }

    public function testGetSuitLetter(): void
    {
        $card1 = new Card('C', 5);
        $card2 = new Card('H', 5);
        $card3 = new Card('S', 5);
        $card4 = new Card('D', 5);

        $this->assertSame('C', $card1->getSuitLetter());
        $this->assertSame('H', $card2->getSuitLetter());
        $this->assertSame('S', $card3->getSuitLetter());
        $this->assertSame('D', $card4->getSuitLetter());
    }
}
