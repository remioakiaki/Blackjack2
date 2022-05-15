<?php

namespace Blackjack\tests;

use PHPUnit\Framework\TestCase;
use Blackjack\GameMaster;
use Blackjack\User;
use Blackjack\Card;

require_once(__DIR__ . '/../../lib/blackjack/GameMaster.php');

final class GameMasterTest extends TestCase
{
    private User $user;
    private Card $card;
    private GameMaster $gameMaster;
    protected function setUp(): void
    {
        $this->user = new User('プレイヤー1', 'プレイヤー');
        $this->dealer = new User('ディーラー', 'ディーラー');
        $this->card1 = new Card('C', '10');
        $this->card2 = new Card('C', '10');
        $this->card3 = new Card('C', 'A');
        $this->card4 = new Card('C', '5');
        $this->card5 = new Card('C', '7');

        $this->gameMaster = new GameMaster();
    }

    public function testOutputMessage(): void
    {
        $this->assertSame('ブラックジャックを開始します。' . PHP_EOL, $this->gameMaster->outputMessage('start'));
        $this->assertSame('ディーラーの引いた2枚目のカードはわかりません。' . PHP_EOL, $this->gameMaster->outputMessage('unknownSecondDrawCard'));
        $this->assertSame('ブラックジャックを終了します。' . PHP_EOL, $this->gameMaster->outputMessage('end'));
    }

    public function testReadCard(): void
    {
        $this->assertSame(
            'プレイヤー1の引いたカードはクラブの10です。' . PHP_EOL,
            $this->gameMaster->readCard($this->card1, $this->user)
        );
    }

    public function testReadPoint(): void
    {
        $this->assertSame(
            'プレイヤー1の現在の得点は0です。' . PHP_EOL,
            $this->gameMaster->readPoint($this->user)
        );
    }

    public function testCheckPoint(): void
    {
        $user1 = new User('プレイヤー1', 'プレイヤー');
        $user1->addCard($this->card1);
        $user1->addCard($this->card2);
        $user1->addCard($this->card3);

        $this->assertFalse($this->gameMaster->checkPoint($user1));

        $user2 = new User('プレイヤー2', 'プレイヤー');
        $user2->addCard($this->card1);
        $user2->addCard($this->card2);

        $this->assertTrue($this->gameMaster->checkPoint($user2));
    }

    public function testReadDealerSecondCard(): void
    {
        $card = $this->card1;
        $this->assertSame('ディーラーの引いたカードはクラブの10でした。' . PHP_EOL, $this->gameMaster->readDealerSecondCard($card, $this->dealer) . PHP_EOL);
    }

    public function testDecideWinnerPattern1(): void
    {
        //どちらも21点を越えた場合
        $this->user->addCard($this->card1);
        $this->user->addCard($this->card2);
        $this->user->addCard($this->card3);
        $this->user->addCard($this->card3);

        $this->dealer->addCard($this->card1);
        $this->dealer->addCard($this->card2);
        $this->dealer->addCard($this->card3);
        $this->dealer->addCard($this->card3);

        $players[] = $this->user;

        $this->gameMaster->decideWinner($players, $this->dealer);
        $this->expectOutputString('引き分けです。' . PHP_EOL);
    }

    public function testDecideWinnerPattern2(): void
    {
        //いずれかが21点を越えた場合
        $this->user->addCard($this->card1);
        $this->user->addCard($this->card2);
        $this->user->addCard($this->card3);

        $this->dealer->addCard($this->card1);
        $this->dealer->addCard($this->card2);
        $this->dealer->addCard($this->card3);
        $this->dealer->addCard($this->card3);

        $players[] = $this->user;

        $this->gameMaster->decideWinner($players, $this->dealer);
        $this->expectOutputString('プレイヤー1の勝ちです！' . PHP_EOL);
    }

    public function testDecideWinnerPattern3(): void
    {
        //両者21点を越えていない場合
        $this->user->addCard($this->card1);
        $this->user->addCard($this->card4);

        $this->dealer->addCard($this->card1);
        $this->dealer->addCard($this->card5);

        $players[] = $this->user;

        $this->gameMaster->decideWinner($players, $this->dealer);
        $this->expectOutputString('ディーラーの勝ちです！' . PHP_EOL);
    }
}
