<?php

namespace Blackjack\tests;

use PHPUnit\Framework\TestCase;
use Blackjack\GameMasterOverTwoPlayer;
use Blackjack\Card;
use Blackjack\User;
use Blackjack\GameMaster;

require_once(__DIR__ . '/../../lib/blackjack/GameMasterOverTwoPlayer.php');

final class GameMasterOverTwoPlayerTest extends TestCase
{
    protected function setUp(): void
    {
        $this->player1 = new User('プレイヤー1', 'プレイヤー');
        $this->player2 = new User('プレイヤー2', 'プレイヤー');
        $this->dealer = new User('ディーラー', 'ディーラー');
        $this->players = [$this->player1, $this->player2];
        $this->gameMaster = $this->decideGameMaster($this->players);

        $this->card1 = new Card('C', '10');
        $this->card2 = new Card('D', '10');
        $this->card3 = new Card('S', 'A');
        $this->card4 = new Card('S', '5');
        $this->card5 = new Card('S', '7');
    }
    public function testDecideWinnerPattern1(): void
    {
        // 全員の点数を21点にする
        $this->player1->addCard($this->card1);
        $this->player1->addCard($this->card2);
        $this->player1->addCard($this->card3);
        $this->player2->addCard($this->card1);
        $this->player2->addCard($this->card2);
        $this->player2->addCard($this->card3);
        $this->dealer->addCard($this->card1);
        $this->dealer->addCard($this->card2);
        $this->dealer->addCard($this->card3);


        $this->gameMaster->decideWinner($this->players, $this->dealer);
        $this->expectOutputString('引き分けです。' . PHP_EOL);
    }
    public function testDecideWinnerPattern2(): void
    {
        // 全員の点数を21点を越えないが同じ点数
        $this->player1->addCard($this->card1);
        $this->player1->addCard($this->card2);

        $this->player2->addCard($this->card1);
        $this->player2->addCard($this->card2);

        $this->dealer->addCard($this->card1);
        $this->dealer->addCard($this->card2);

        $this->gameMaster->decideWinner($this->players, $this->dealer);
        $this->expectOutputString('引き分けです。' . PHP_EOL);
    }
    public function testDecideWinnerPattern3(): void
    {
        // ひとり勝ちパターン
        $this->player1->addCard($this->card1);
        $this->player1->addCard($this->card2);
        $this->player1->addCard($this->card4);

        $this->player2->addCard($this->card1);
        $this->player2->addCard($this->card2);
        $this->player2->addCard($this->card4);

        $this->dealer->addCard($this->card1);
        $this->dealer->addCard($this->card2);

        $this->gameMaster->decideWinner($this->players, $this->dealer);
        $this->expectOutputString('ディーラーの勝ちです！' . PHP_EOL);
    }
    public function testDecideWinnerPattern4(): void
    {
        // 21点以下が複数名いるパターン
        $this->player1->addCard($this->card1);
        $this->player1->addCard($this->card5);

        $this->player2->addCard($this->card1);
        $this->player2->addCard($this->card4);

        $this->dealer->addCard($this->card1);
        $this->dealer->addCard($this->card2);
        $this->dealer->addCard($this->card4);

        $this->gameMaster->decideWinner($this->players, $this->dealer);
        $this->expectOutputString('プレイヤー1の勝ちです！' . PHP_EOL);
    }
    public function testDecideWinnerPattern5(): void
    {
        // 21点以下が複数名いて、点数が同じパターン
        $this->player1->addCard($this->card1);
        $this->player1->addCard($this->card5);

        $this->player2->addCard($this->card1);
        $this->player2->addCard($this->card5);

        $this->dealer->addCard($this->card1);
        $this->dealer->addCard($this->card2);
        $this->dealer->addCard($this->card4);

        $this->gameMaster->decideWinner($this->players, $this->dealer);
        $this->expectOutputString('引き分けです。' . PHP_EOL);
    }
    private function decideGameMaster(array $players): GameMaster
    {
        if (count($players) > 1) {
            return new GameMasterOverTwoPlayer();
        } else {
            return new GameMaster();
        }
    }
}
