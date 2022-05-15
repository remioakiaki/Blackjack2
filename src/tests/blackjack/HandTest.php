<?php

namespace Blackjack\tests;

use PHPUnit\Framework\TestCase;
use Blackjack\User;
use Blackjack\Deck;
use Blackjack\Card;
use Blackjack\Hand;

require_once(__DIR__ . '/../../lib/blackjack/Hand.php');

final class HandTest extends TestCase
{
    private User $user;
    private Deck $deck;

    protected function setUp(): void
    {
        $this->user = new User('プレイヤー1', 'プレイヤー');
        $this->deck = new Deck();
    }
    public function testAddCard()
    {
        $card = $this->user->drawCard($this->deck);
        $this->assertSame('object', gettype($card));
    }
    public function testAddPoint(): void
    {
        $card1 = new Card('C', '10');
        $card2 = new Card('C', '2');
        $card3 = new Card('C', 'A');
        $hand = new Hand();

        $hand->addCard($card1);
        $hand->addCard($card2);
        $hand->addCard($card3);

        $this->assertSame(13, $hand->getPoint());

        $card1 = new Card('C', '10');
        $card2 = new Card('C', 'A');
        $card3 = new Card('D', 'A');
        $hand = new Hand();

        $hand->addCard($card1);
        $hand->addCard($card2);
        $hand->addCard($card3);
        $this->assertSame(21, $hand->getPoint());
    }

    public function getCard(): void
    {
        $card1 = new Card('C', '10');
        $this->hand->addCard($card1);
        $this->assertSame('object', $this->hand->getCard(1));
    }
}
