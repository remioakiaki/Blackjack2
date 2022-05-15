<?php

namespace Blackjack\tests;

use PHPUnit\Framework\TestCase;
use Blackjack\User;
use Blackjack\Deck;
use Blackjack\Hand;


require_once(__DIR__ . '/../../lib/blackjack/User.php');

final class UserTest extends TestCase
{
    private User $user;
    private Deck $deck;
    protected function setUp(): void
    {
        $this->user = new User('プレイヤー1', 'プレイヤー');
        $this->deck = new Deck();
    }

    public function testGetName(): void
    {
        $this->assertSame('プレイヤー1', $this->user->getName());
    }

    public function testGetRole(): void
    {
        $this->assertSame('プレイヤー', $this->user->getRole());
    }

    public function testGetCard(): void
    {
        $this->user->drawCard($this->deck);
        $this->assertSame('object', gettype($this->user->getCard(0)));
    }

    public function testDrawCard(): void
    {
        $this->assertSame('object', gettype($this->user->drawCard($this->deck)));
    }

    public function testAddCard(): void
    {
        // カードを引いて、手札に追加される。
        // 正しく追加されていて、カードの取得ができればOKとする。
        $this->user->drawCard($this->deck);
        $this->assertSame('object', gettype($this->user->getCard(0)));
    }
}
