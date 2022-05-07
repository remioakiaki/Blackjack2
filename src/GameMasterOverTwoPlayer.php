<?php

namespace Blackjack;

require_once('Game.php');
require_once('User.php');
require_once('Hand.php');

class GameMasterOverTwoPlayer extends GameMaster
{
    private const LIMIT_POINT = 21;

    public function decideWinner(array $players, User $user2): void
    {
        $lists = $this->createLists($players, $user2);

        $winners = [];
        $winners = $this->whichWinner($lists);
        if ($this->isDraw($winners)) {
            echo '引き分けです。' . PHP_EOL;
        } else {
            echo $winners[0]['name'] . 'の勝ちです！' . PHP_EOL;
        }
    }

    /**
     * @param array<int, User> $players
     * @return array<int, array{'name': string,'point': int} > $lists
     */
    private function createLists(array $players, User $user2): array
    {
        $lists = [];
        foreach ($players as $player) {
            $name = $player->getName();
            $point = $player->getPoint();
            $lists[] = [
                'name' => $name,
                'point' => $point
            ];
        }

        $name = $user2->getName();
        $point = $user2->getPoint();

        $lists[] = [
            'name' => $name,
            'point' => $point
        ];
        return $lists;
    }

    /**
     * @param array<int, array{'name': string,'point': int} > $winners
     */
    private function isDraw(array $winners): bool
    {
        return count($winners) > 1;
    }

    /**
     * @param array<int, array{'name': string,'point': int} > $lists
     * @return array<int, array{'name': string,'point': int} > $winners
     */
    private function whichWinner(array $lists): array
    {
        $winners[] = ['name' => '', 'point' => 0];

        foreach ($lists as $list) {
            //$listName = $list['name'];
            //$listPoint = $list['point'];
            if ($this->isValidPoint($list)) {
                $winners = $this->compareListPointAndPoint($list, $winners);

                //$winners[] = $listName;
                //$point = $listPoint;
            };
        }
        return $winners;
    }
    /**
     * @param array{'name': string,'point': int} $list
     */
    private function isValidPoint(array $list): bool
    {
        $listPoint = $list['point'];
        return $listPoint < self::LIMIT_POINT;
    }

    /**
     * @param array{'name': string,'point': int} $list
     * @param array<int, array{'name': string,'point': int}> $winners
     * @return array<int, array{'name': string,'point': int}> $winners
     */
    private function compareListPointAndPoint(array $list, array $winners): array
    {
        $listName = $list['name'];
        $listPoint = $list['point'];
        $winnerPoint = $winners[0]['point'];

        if ($listPoint == $winnerPoint) {
            $winners[] = ['name' => $listName, 'point' => $listPoint];
        } elseif ($listPoint > $winnerPoint) {
            $winners = [];
            $winners[] = ['name' => $listName, 'point' => $listPoint];
        }
        return $winners;
    }
}
