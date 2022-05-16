# PHPでオブジェクト指向を利用した作成したブラックジャック
## ルール

ブラックジャックはカジノで行われるカードゲームの一種です。
1〜13までの数が書かれたカード52枚を使ってゲームが行われます。
ルールは次の通りです。

- 実行開始時、ディーラーとプレイヤー全員に２枚ずつカードが配られる。
- 参加できるプレイヤーは3名（ディーラー含めて合計4名までとする）。
- 自分のカードの合計値が21に近づくよう、カードを追加するか、追加しないかを決める
- プレイヤーはカードの合計値が21を超えない限り、好きなだけカードを追加できる
- ディーラーはカードの合計値が17を超えるまでカードを追加する

各カードの点数は次のように決まっています。
- 2から9までは、書かれている数の通りの点数
- 10,J,Q,Kは10点
- Aは1点あるいは11点として、手の点数が最大となる方で数える

## あわせて行った学習内容
- PHPUnit
- PHP_CodeSniffer
- PHPMD
- PHPStan
