<?php

namespace Blackjack;

class Card
{
    private const CARD_POINT = [
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,
        '10' => 10,
        'J' => 10,
        'Q' => 10,
        'K' => 10,
        'A' => 1,
    ];

    private const CARD_SUIT_NAME = [
        'S' => 'スペード',
        'H' => 'ハート',
        'C' => 'クラブ',
        'D' => 'ダイヤ',

    ];
    private int $point;
    private string $suitName;
    public function __construct(private string $suitLetter, private string $number)
    {
        $this->point = $this->convertNumberToPoint($number);
        $this->suitName = $this->convertSuitLetterToSuitName($suitLetter);
    }

    private function convertNumberToPoint(string $number): int
    {
        return self::CARD_POINT[$number];
    }

    private function convertSuitLetterToSuitName(string $suitLetter): string
    {
        return self::CARD_SUIT_NAME[$suitLetter];
    }

    public function getNumber(): string
    {
        return $this->number;
    }
    public function getSuitName(): string
    {
        return $this->suitName;
    }

    public function getPoint(): int
    {
        return $this->point;
    }

    public function getSuitLetter(): string
    {
        return $this->suitLetter;
    }
}
