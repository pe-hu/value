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
<link rel="stylesheet" type="text/css" href="index.css" />
<link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro:ital,wght@0,300;0,600;0,700;1,600&display=swap" rel="stylesheet">
<title>大切にすることを大切にする場所</title>
<style type="text/css">
#credit {
  width:95%;
  margin:2.5rem 2.5% 0;
  font-size:1.25rem;
  display: flex;
  justify-content: space-between;
  flex-wrap:wrap;
}
.pehu {font-family: "MS Mincho", "SimSong", serif;}

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

<h1 class="jp_title"><a href="/value/">大切にすることを大切にする場所</a></h1>

<div id="list">
<div id="index">
  <form id="information">
      <p>Index / <a href="/value/">valuing an act of valuing</a></p>
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

<!-- Begin Mailchimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
<style type="text/css">
	#mc_embed_signup {
    background:#fff;
    clear:left;
    font-size:1rem;
    font-family: 'Source Serif Pro', serif;
  }
  #mc_embed_signup_scroll h2{
    margin: 0;
    font-size:1.5rem;
    font-weight: 500;
  }
	/* Add your own Mailchimp form style overrides in your site stylesheet or in this style block.
	   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
</style>
<div id="mc_embed_signup">
<form action="https://gmail.us20.list-manage.com/subscribe/post?u=3b5bd5ca5fc54e4c3847e9603&amp;id=103583076f" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
    <div id="mc_embed_signup_scroll">
	<h2>News Letter</h2>
<div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
<div class="mc-field-group">
	<label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
</label>
	<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
</div>
	<div id="mce-responses" class="clear">
		<div class="response" id="mce-error-response" style="display:none"></div>
		<div class="response" id="mce-success-response" style="display:none"></div>
	</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_3b5bd5ca5fc54e4c3847e9603_103583076f" tabindex="-1" value=""></div>
    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
    </div>
</form>
</div>
<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
<!--End mc_embed_signup-->

<div id="credit">
<p>Presented by</p>
<p><a href="/pehu/" class="pehu">∧° ┐ | creative, community space</a></p>
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
