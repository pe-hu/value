<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
$title = (string)filter_input(INPUT_POST, 'title');
$name = (string)filter_input(INPUT_POST, 'name');
$link = (string)filter_input(INPUT_POST, 'link');
$language = (string)filter_input(INPUT_POST, 'language');
$text = (string)filter_input(INPUT_POST, 'text');
$email = (string)filter_input(INPUT_POST, 'email');

$fp = fopen('value.csv', 'a+b');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    flock($fp, LOCK_EX);
    fputcsv($fp, [$title, $name, $link, $language, $text, $email]);
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
<link rel="stylesheet" type="text/css" href="/value/index.css" />
<link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro:ital,wght@0,300;0,600;0,700;1,600&display=swap" rel="stylesheet">
<title>大切なことを大切にするためのウェブサイト</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<style type="text/css">
#jp_title {
    position: fixed;
    top:0;
    right:0;
}
.essay {
  white-space:pre-wrap;
}
.link {
	margin:2.5vw;
    -ms-writing-mode: horizontal-tb;
    writing-mode: horizontal-tb;
}
.link a {
	font-size:1rem;
	border:0.1rem solid;
	border-radius:50%;
	padding:0.5rem 1rem;
	text-decoration:none;
	color:#000;
}
</style>
</head>
<body>
<h1 class="jp_title">
  <?php
  $mod = filemtime("value.csv");
  date_default_timezone_set('Asia/Tokyo');
  print "".date("Y-m-d H:i:s",$mod);
  ?>
  更新</h1>

<div id="post">
<?php if (!empty($rows)): ?>
<?php foreach ($rows as $row): ?>
<div class="<?=h($row[3])?>">
<div class="app">
<p class="tt"><?=h($row[0])?><br/>
<?=h($row[1])?></p>
<div class="essay">
<p><?=h($row[4])?></p>
</div>
<div class="link">
<p style="display:<?=h($row[2])?>;"><a href="<?=h($row[2])?>">Link</a></p>
</div>
</div>
</div>
<?php endforeach; ?>
<?php else: ?>
<div class="en">
<div class="app">
<p class="tt">Title<br/>
Name</p>
<div class="essay">
<p>Text</p>
</div>
</div>
</div>
<div class="ja">
<div class="app">
<p class="tt">Title<br/>
Name</p>
<div class="essay">
<p>Text</p>
</div>
</div>
</div>
<?php endif; ?>
</div>
</body>
</html>
