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

$fp = fopen('index.csv', 'a+b');
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
<link rel="stylesheet" type="text/css" href="org.css" />
<link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro:ital,wght@0,300;0,600;0,700;1,600&display=swap" rel="stylesheet">
<title>大切にすることを大切にする場所</title>
<style type="text/css">
</style>
</head>
<body>

<h1 class="jp_title"><a href="/value/">大切にすることを大切にする場所</a></h1>

<div id="list">
<div id="index">
  <form id="information">
      <p>Index / valuing an act of valuing</p>
  <ul class="search-box appreciate" id="click">
  <input type="radio" name="appreciate" value="topics" id="topics">
  <label for="topics" class="label">Topics</label><hr/>
  <li>
  <input type="radio" name="appreciate" value="things" id="things">
  <label for="things" class="label">Things</label></li>
  <li>
  <input type="radio" name="appreciate" value="objects" id="objects">
  <label for="objects" class="label">Objects</label></li>
  <li>
  <input type="radio" name="appreciate" value="peoples" id="peoples">
  <label for="peoples" class="label">Peoples</label></li>
  <li>
  <input type="radio" name="appreciate" value="valuing" id="valuing">
  <label for="valuing" class="label">Valuing</label></li>
  </ul>
  <input type="reset" name="reset" value="View All" class="reset-button">
  </form>
</div>

<div id="org">
<ul class="random">
<?php if (!empty($rows)): ?>
<?php foreach ($rows as $row): ?>
<li class="list_item list_toggle" data-appreciate="<?=h($row[7])?>">
<p class="what"><?=h($row[0])?></p>
<span class="name"><?=h($row[1])?></span>
<a href="<?=h($row[2])?>" target="_parent"></a>
</li>
<?php endforeach; ?>
<?php else: ?>
<li class="list_item list_toggle" data-appreciate="<?=h($row[0])?>">
<p class="what">大切なもの</p>
<span class="name">名前</span>
</li>
<?php endif; ?>
</ul>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="org.js"></script>
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
