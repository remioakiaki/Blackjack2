<?php

namespace Blackjack;

require_once('User.php');
require_once('Deck.php');
require_once('Hand.php');
require_once('GameMaster.php');
require_once('GameMasterOverTwoPlayer.php');

define('MODE', 'TEST');
class Game
{
    private const ANSWER_YES = 'Y';
    private const DEALER_LIMIT_POINT = 17;
    private const INITIALIZE_READ_CARD_OFFSET_NUMBER = 2; // 最初に2枚読み上げた後の配列の要素数を指定
    private const PLAYER_LIMIT = 3;

    public function start(): void
    {
        $deck = new Deck();
        $card = [];
        $playerNames = [];
        $dealer = new User('ディーラー', 'ディーラー');

        $readCardOffsetNumber = 0;
        $dealerSecondDrawCard = '';
        $dealerPoint = 0;

        $playerNames = $this->inputPlayerNames();
        $players = $this->createPlayers($playerNames);

        $gameMaster = $this->decideGameMaster($playerNames);

        echo $gameMaster->outputMessage('start');

        $this->waitNextLine();
        foreach ($players as $player) {
            $player->drawCard($deck);
            $player->drawCard($deck);
        }

        $dealer->drawCard($deck);
        $dealer->drawCard($deck);

        foreach ($players as $player) {
            $card = $player->getCard($readCardOffsetNumber);
            echo $gameMaster->readCard($card, $player);

            $card = $player->getCard($readCardOffsetNumber + 1);
            echo $gameMaster->readCard($card, $player);
            echo $gameMaster->readPoint($player);
        }

        $card = $dealer->getCard($readCardOffsetNumber);
        echo $gameMaster->readCard($card, $dealer);

        $dealerSecondDrawCard = $dealer->getCard($readCardOffsetNumber + 1);
        echo $gameMaster->outputMessage('unknownSecondDrawCard') . PHP_EOL;

        foreach ($players as $player) {
            echo $gameMaster->readPoint($player);
            $answer = $gameMaster->confirmDrawCard();
            echo $answer . PHP_EOL;

            $readCardOffsetNumber = $this->initializeReadCardOffsetNumber();
            while ($this->isContinue($answer)) {
                $player->drawCard($deck);

                $card = $player->getCard($readCardOffsetNumber);
                $readCardOffsetNumber++;

                echo $gameMaster->readCard($card, $player);
                echo $gameMaster->readPoint($player);

                if ($gameMaster->checkPoint($player)) {
                    $answer = $gameMaster->confirmDrawCard();
                    echo $answer . PHP_EOL;
                } else {
                    $answer = $gameMaster->restrictDrawCard();
                }
            }
        }

        echo $gameMaster->readDealerSecondCard($dealerSecondDrawCard, $dealer) . PHP_EOL;
        echo $gameMaster->readPoint($dealer) . PHP_EOL;

        $readCardOffsetNumber = $this->initializeReadCardOffsetNumber();
        $dealerPoint = $dealer->getPoint();

        while ($this->isOver($dealerPoint)) {
            $dealer->drawCard($deck);

            $card = $dealer->getCard($readCardOffsetNumber);
            $readCardOffsetNumber++;

            echo $gameMaster->readCard($card, $dealer) . PHP_EOL;
            echo $gameMaster->readPoint($dealer) . PHP_EOL;

            $dealerPoint = $dealer->getPoint();
            $this->waitNextLine();
        }
        $gameMaster->decideWinner($players, $dealer);
        echo $gameMaster->outputMessage('end');
    }

    private function initializeReadCardOffsetNumber(): int
    {
        return self::INITIALIZE_READ_CARD_OFFSET_NUMBER;
    }

    private function waitNextLine(): void
    {
        fgets(STDIN);
    }

    private function isContinue(string $answer): bool
    {
        return $answer === self::ANSWER_YES;
    }

    private function isOver(int $dealerPoint): bool
    {
        return $dealerPoint < self::DEALER_LIMIT_POINT;
    }
    /**
     * @param array<string> $playerNames
     * @return array<int, User> $playerNames
     */
    private function createPlayers(array $playerNames): array
    {
        return array_map(fn ($playerName) => new User($playerName, 'プレイヤー'), $playerNames);
    }

    /**
     * @return array<string> $playerNames
     */
    public function inputPlayerNames(): array
    {
        $playerNames = [];
        echo 'プレイヤー名をスペース区切りで入力してください。' . PHP_EOL;
        echo '最大3人まで入力可能です。' . PHP_EOL;
        return  $playerNames[] = $this->checkPlayerNames();
    }

    /**
     * @return array<string> $playerNames
     */
    private function checkPlayerNames(): array
    {
        $input = '';
        $input = trim(fgets(STDIN));
        $input = str_replace('　', ' ', $input);
        $input = explode(' ', $input);
        $playerNames = $this->sliceInput($input);

        return $playerNames;
    }

    /**
     * @param array<string> $input
     * @return array<string> $playerNames
     */
    private function sliceInput(array $input): array
    {
        $inputNumber = count($input);
        if ($inputNumber > self::PLAYER_LIMIT) {
            echo '入力されたプレイヤーが最大数を越えています。' . PHP_EOL;
            echo self::PLAYER_LIMIT . '人目までしか登録されません。' . PHP_EOL;
            return array_slice($input, 0, self::PLAYER_LIMIT);
        }
        return $input;
    }

    /**
     * @param array<string> $playerNames
     */
    private function decideGameMaster(array $playerNames): GameMaster
    {
        $gameMaster = new GameMaster();
        if (count($playerNames) > 1) {
            return $gameMaster = new GameMasterOverTwoPlayer();
        }
        return $gameMaster;
    }
}
