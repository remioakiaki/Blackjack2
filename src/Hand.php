<?php

namespace Blackjack;

require_once('User.php');
require_once('Deck.php');

class Hand
{
    /**
     * @var array<int, Card> $cards
     *
     */
    private array $cards;
    private int $point;
    private const ACE_BORDER_POINT = 11;
    private const ACE_BIGGER_POINT = 10;
    private const ACE_SMALLER_POINT = 1;

    public function __construct()
    {
        $this->point = 0;
    }

    public function addCard(Card $card): void
    {
        $this->cards[] =
            $card;

        $this->addPoint($card);
    }

    private function addPoint(Card $card): int
    {
        $point = $card->getPoint();
        $number = $card->getNumber();
        $totalPoint = $this->point;
        $addPoint = $this->decidePoint($totalPoint, $number, $point);

        return $this->point += $addPoint;
    }

    public function getCard(int $getNum): Card
    {
        return $this->cards[$getNum];
    }

    public function getPoint(): int
    {
        return $this->point;
    }

    private function decidePoint(int $totalPoint, string $number, int $point): int
    {
        $borderPoint = self::ACE_BORDER_POINT; //Aを引いた時、1を加えるか10を加えるかの境界線になる数字
        $addPoint = $point;

        if ($number === 'A' && $totalPoint <= $borderPoint) {
            return $addPoint = self::ACE_BIGGER_POINT;
        }
        if ($number === 'A' && $totalPoint > $borderPoint) {
            return $addPoint = self::ACE_SMALLER_POINT;
        }
        return $addPoint;
    }
}
