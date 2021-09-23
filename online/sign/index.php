<?php

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

$text = (string)filter_input(INPUT_POST, 'text'); // $_POST['text']

$fp = fopen('ja.csv', 'a+b');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    flock($fp, LOCK_EX);
    fputcsv($fp, [$ja,]);
    rewind($fp);
}

flock($fp, LOCK_SH);
while ($row = fgetcsv($fp)) {
    $rows[] = $row;
}
flock($fp, LOCK_UN);
fclose($fp);

?>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="/value/online/post.css" />
<title>Sign by ∧° ┐ | creative, community space</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
</head>
<body>
<span id="value">あなたの大切なものは何ですか？</span>

<div id="what" class="one">
<b>Sign</b>
</div>
<div id="you">
∧° ┐ | creative, community space
</div>

<div id="about" class="ja">
<div class="app">
<div class="essay">
<p>何もないところから<br />
始まって続いてる<br />
知らぬ間に足音が<br />
重なって一つになる<br />
<br />
名前を書く 白いテープ<br />
力強く 結び直す<br />
白い壁 絵を飾る<br />
食事の香りと音楽と<br />
<br />
赤い屋根が見える通り<br />
軽やかに手を振りあゆみ<br />
れんげの花が咲くまでに<br />
恥ずかしがらなくなれるように<br />
<br />
丸い机がある部屋に<br />
大きな木 鮮やかな水<br />
手を滑るのは滑らかで<br />
光ル輪の先 pal up with you</p>
</div>
</div>
</div>

<p class="link">
<a href="#" onclick="window.history.back(); return false;">↩︎</a>
</p>
</body>
</html>
