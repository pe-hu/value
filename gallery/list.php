<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
$title = (string)filter_input(INPUT_POST, 'title');
$name = (string)filter_input(INPUT_POST, 'name');
$link = (string)filter_input(INPUT_POST, 'link');
$language = (string)filter_input(INPUT_POST, 'language');
$text = (string)filter_input(INPUT_POST, 'text');
$image = (string)filter_input(INPUT_POST, 'image');
$url = (string)filter_input(INPUT_POST, 'ulr');
$appreciate = (string)filter_input(INPUT_POST, 'appreciate');

$fp = fopen('list.csv', 'a+b');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    flock($fp, LOCK_EX);
    fputcsv($fp, [$title, $name, $link, $language, $text, $image, $url, $appreciate]);
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
<link rel="icon" href="/value/icon.png">
<link rel="stylesheet" type="text/css" href="../index/index.css" />
<link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro:ital,wght@0,300;0,600;0,700;1,600&display=swap" rel="stylesheet">
<title>大切にすることを大切にするためのギャラリー</title>
<style type="text/css">
@media screen and (max-width: 950px){
  #index {
    position:absolute;
  }
}

@media screen and (max-width: 550px){
  #org {
    margin:20rem auto 2.5rem;
  }
}
</style>
</head>
<body>

<div id="list">
<div id="index">
  <p><a onclick="window.location.reload(true);">大切にすることを大切にするためのギャラリー</a></p>
</div>

<div id="org">
<ul class="random">
<?php if (!empty($rows)): ?>
<?php foreach ($rows as $row): ?>
<li class="list_item list_toggle">
<p class="what"><?=h($row[0])?></p>
<span class="name"><?=h($row[1])?></span>
<a href="<?=h($row[2])?>" target="gallery"></a>
</li>
<?php endforeach; ?>
<?php else: ?>
<li class="list_item list_toggle">
<p class="what">大切なもの</p>
<span class="name">名前</span>
</li>
<?php endif; ?>
</ul>
</div>
</div>


<div id="credit">
<p>Presented by</p>
<p><a href="/pehu/" class="pehu">∧° ┐</a></p>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="../index/org.js"></script>
<script type="text/javascript">
function shuffleContent(container) {
  var content = container.find("> *");
  var total = content.length;
  content.each(function() {
    content.eq(Math.floor(Math.random() * total)).prependTo(container);
  });
}
$(function() {
  shuffleContent($(".random"));
});
</script>
</body>
</html>
