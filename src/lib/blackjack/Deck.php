<?php

namespace Blackjack;

require_once('Card.php');

class Deck
{
    /**
     * @var array<int, Card> $cards
     *
     */
    private array $cards;
    private const SUIT_LETTER = ['C', 'H', 'S', 'D'];
    private const NUMBER = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];

    public function __construct()
    {
        foreach (self::SUIT_LETTER as $suitLetter) {
            foreach (self::NUMBER as $number) {
                $this->cards[] = new Card($suitLetter, $number);
            }
        }
    }

    public function shuffleDeck(): void
    {
        shuffle($this->cards);
    }

    public function drawCard(): Card
    {
        $card = array_shift($this->cards);
        return $card;
    }
}
