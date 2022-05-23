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
<!DOCTYPE html>
<html lang="ja">

<head>
<title>大切にすることを大切にするための場所</title>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="format-detection" content="telephone=no">
<meta name="author" content="∧°┐">
<meta name="description" content="あなたの大切なものは何ですか？">

<meta property="og:title" content="大切にすることを大切にするための場所" />
<meta property="og:description" content="あなたの大切なものは何ですか？" />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://creative-community.space/value/" />
<meta property="og:site_name" content="creative-community.space" />
<meta property="og:image" content="https://creative-community.space/value/icon.png" />
<meta property="og:locale" content="ja_JP" />

<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="@NLC_update" />
<meta name="twitter:image" content="https://creative-community.space/value/icon.png" />

<link rel="icon" href="https://creative-community.space/value/icon.png">
<link rel="apple-touch-icon" href="https://creative-community.space/value/icon.png">
<link rel="stylesheet" type="text/css" href="index.css" />
<link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro:ital,wght@0,300;0,600;0,700;1,600&display=swap" rel="stylesheet">

<style type="text/css">
#submit {
	position: fixed;
  top:0;
  left:0;
  width: 100%;
  background-color: #fff;
}
#submit iframe {
  width: 100%;
  height: 100%;
  border: none;
}
.none {
  z-index: 0;
  opacity: 0;
  pointer-events: none;
  user-select: none;
  height: 0;
  transition: all 5000ms ease;
}
.open {
  z-index: 50;
  opacity: 1;
  pointer-events:all;
  user-select:auto;
  width: 100%;
  height: 100vh;
  transition: all 4500ms ease;
}
#credit {
  width:95%;
  margin:2.5rem 2.5% 0;
  font-size:1.25rem;
  display: flex;
  justify-content: space-between;
  flex-wrap:wrap;
  font-family: 'Source Serif Pro', serif;
}
.pehu {font-family: "MS Mincho", "SimSong", serif;}

@media screen and (max-width: 950px){
  #index {
    position:absolute;
  }
}

@media screen and (max-width: 550px){
.jp_title {display:none;}
  #org {
    margin:20rem auto 2.5rem;
  }
}
</style>
</head>
<body>

<h1 class="jp_title"><a onclick="window.location.reload(true);">
  <?php
  $mod = filemtime("index.csv");
  date_default_timezone_set('Asia/Tokyo');
  print "".date("Y-m-d H:i:s",$mod);
  ?>
  更新</a></h1>

<div id="list">
<div id="index">
  <form id="information">
      <p>Index / <a onclick="window.location.reload(true);">valuing an act of valuing</a></p>
  <ul class="search-box appreciate" id="click">
  <input type="radio" name="appreciate" value="topics" id="topics">
  <label for="topics" class="label">Topics</label>
  <input type="radio" name="appreciate" value="show" id="show">
  <label for="show" class="label">Show</label>
  <input type="radio" name="appreciate" value="gallery" id="gallery">
  <label for="gallery" class="label">Gallery</label><hr/>
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
<ul>
<li class="list_item list_toggle" data-appreciate="topics">
<p class="what">あなたの大切なものは何ですか？</p>
<span class="name">What do you value?</span>
<a href="/value/online/" target="_parent"></a>
</li>
</ul>
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


<div id="credit">
<p>Presented by</p>
<p><a href="/pehu/" class="pehu">∧° ┐</a></p>
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
