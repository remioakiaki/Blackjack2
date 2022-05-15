<?php

namespace Blackjack;

require_once('Deck.php');
require_once('Hand.php');

class User
{
    private Hand $hand;
    public function __construct(
        private string $name,
        private string $role
    ) {
        $this->hand = new Hand();
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function getRole(): string
    {
        return $this->role;
    }
    public function getCard(int $getNum): Card
    {
        return $this->hand->getCard($getNum);
    }

    public function drawCard(Deck $deck): Card
    {
        $card = $deck->drawCard();
        $this->addCard($card);
        return $card;
    }

    public function addCard(Card $card): void
    {
        $this->hand->addCard($card);
    }

    public function getPoint(): int
    {
        return $this->hand->getPoint();
    }
}
