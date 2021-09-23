<?php

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

$text = (string)filter_input(INPUT_POST, 'text'); // $_POST['text']

$fp = fopen('text.csv', 'a+b');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    flock($fp, LOCK_EX);
    fputcsv($fp, [$text,]);
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
<title>TAKAPOP | by イトウ ヒロキ</title>
<link rel="stylesheet" type="text/css" href="/value/online/value.css" />
</head>
<body>
<span id="value">あなたの大切なものは何ですか？</span>
<div id="image">
<p><img src="image.jpg"></p>
</div>
<div id="what" class="two">
<b>TAKAPOP</b>
</div>
<div id="you">
イトウ ヒロキ
</div>

<div id="about" class="ja">
<div class="app">
<div class="essay">
<?php if (!empty($rows)): ?>
<?php foreach ($rows as $row): ?>
<p><?=h($row[0])?></p>
<?php endforeach; ?>
<?php else: ?>
<?php endif; ?>
</div>
</div>
</div>
</div>
</div>

<p class="link">
<a href="#" onclick="window.history.back(); return false;">↩︎</a>
</p>
</body>
</html>
