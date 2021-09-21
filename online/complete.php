<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
$title = (string)filter_input(INPUT_POST, 'title');
$name = (string)filter_input(INPUT_POST, 'name');
$id = (string)filter_input(INPUT_POST, 'id');
$language = (string)filter_input(INPUT_POST, 'language');
$text = (string)filter_input(INPUT_POST, 'text');

$fp = fopen('draft.csv', 'a+b');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    flock($fp, LOCK_EX);
    fputcsv($fp, [$title, $name, $id, $language, $text]);
    rewind($fp);
}

flock($fp, LOCK_SH);
while ($row = fgetcsv($fp)) {
    $rows[] = $row;
}
flock($fp, LOCK_UN);
fclose($fp);

?>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width">
<meta http-equiv="refresh" content="3;URL=/value/">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>大切にすることを大切にする場所</title>
<style type="text/css">
.inside h1 {
  width:50vw;
  position:absolute;
  top:47.5%; left:50%;
  padding:0; margin:0;
  transform: translate(-50%, -50%);
  font-size: 10vw; font-weight:500;
  font-family: 'Source Serif Pro', serif;
}
.inside p {
  font-size:1.5vw;
  width:100%;
  text-align:center;
  position:absolute;
  top:85%; left:50%;
  transform: translate(-50%, -50%);
  font-family: YuGothic, Yu Gothic",Hiragino Kaku Gothic ProN", "Hiragino Sans", sans-serif;
}
.inside b {
  border:0.25vw solid #000;
  background:#fff;
  padding:0.5vw 2.5vw;
  border-radius:2rem;
  font-weight:500;
}
</style>
</head>
<body>
<div class="inside">
<h1><span id="rename"></span></h1>
<p class="notice"><b>ご投稿ありがとうございました</b></p>
</div>
</div>
<script>
var text = ["Thank You","for","Submit" ];
var counter = 0;
var elem = document.getElementById("rename");
var inst = setInterval(change, 550);

elem.innerHTML = text[counter];

function change() {
  elem.innerHTML = text[counter];
  counter++;
  if (counter >= text.length) {
    counter = 0;
  }
};
</script>
</body>
</html>