<?php

namespace Blackjack;

require_once('Game.php');
require_once('User.php');
require_once('Hand.php');

class GameMaster
{
    private const ANSWER_YES = 'Y';
    private const ANSWER_NO = 'N';
    private const LIMIT_POINT = 21;

    public function outputMessage(string $parameter): string
    {
        switch ($parameter) {
            case 'start':
                return 'ブラックジャックを開始します。' . PHP_EOL;
            case 'unknownSecondDrawCard':
                return 'ディーラーの引いた2枚目のカードはわかりません。' . PHP_EOL;
            case 'end':
                return 'ブラックジャックを終了します。' . PHP_EOL;
        }
        return '条件に一致しないパラメーターが設定されている。';
    }

    public function readCard(Card $card, User $user): string
    {
        $name = $user->getName();
        $suitName = $card->getSuitName();
        $number = $card->getNumber();

        return $name . 'の引いたカードは' . $suitName . 'の' . $number . 'です。' . PHP_EOL;
    }

    public function readPoint(User $user): string
    {
        $name = $user->getName();
        $point = $user->getPoint();
        return $name . 'の現在の得点は' . $point . 'です。' . PHP_EOL;
    }

    public function confirmDrawCard(): string
    {
        echo 'カードを引きますか。(Y/N)';
        $answer = $this->inputAnswer();
        if ($this->isCorrectAnswer($answer)) {
            return $answer;
        }
        echo '入力された値が不正です。再入力してください。';
        return $this->confirmDrawCard();
    }
    private function inputAnswer(): string
    {
        return strtoupper(trim(fgets(STDIN)));
    }
    private function isCorrectAnswer(string $answer): bool
    {
        return
            $answer === self::ANSWER_YES ||
            $answer === self::ANSWER_NO;
    }

    public function checkPoint(User $user): bool
    {
        return $user->getPoint() < self::LIMIT_POINT;
    }

    public function restrictDrawCard(): string
    {
        echo '現在の得点が' . self::LIMIT_POINT . 'より大きくなりました。' . PHP_EOL;
        echo 'これ以上カードは引けません。ディーラーのターンに移行します。' . PHP_EOL;
        return self::ANSWER_NO;
    }

    public function readDealerSecondCard(Card $card, User $user): string
    {
        $user->getName();
        $suitName = $card->getSuitName();
        $number = $card->getNumber();

        return $user->getName() . 'の引いたカードは' . $suitName . 'の' . $number . 'でした。';
    }
    /**
     * @param array<int, User> $players
     */
    public function decideWinner(array $players, User $user2): void
    {
        $user1 = $players[0];

        $user1Point = $user1->getPoint();
        $user2Point = $user2->getPoint();

        $user1Name = $user1->getName();
        $user2Name = $user2->getName();

        $winner = '';
        if ($this->isDraw($user1Point, $user2Point)) {
            echo '引き分けです。' . PHP_EOL;
        } else {
            $winner = $this->whichWinner($user1Point, $user2Point, $user1Name, $user2Name);
            echo $winner . 'の勝ちです！' . PHP_EOL;
        }
    }

    private function isDraw(int $point1, int $point2): bool
    {
        return ($point1 === $point2) ||
            ($point1 > self::LIMIT_POINT && $point2 > self::LIMIT_POINT);
    }

    private function whichWinner(int $point1, int $point2, string $user1Name, string $user2Name): string
    {
        $winner = $user1Name;
        if ($point1 > self::LIMIT_POINT) {
            return $winner = $user2Name;
        }
        if ($point2 > self::LIMIT_POINT) {
            return $winner;
        }
        if ($point1 < $point2) {
            return $user2Name;
        }
        return $winner;
    }
}
