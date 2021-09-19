<?php

mb_language("ja");
mb_internal_encoding("UTF-8");

//var_dump($_POST);

// 変数の初期化
$page_flag = 0;

if( !empty($_POST['btn_confirm']) ) {
	$page_flag = 1;
	// セッションの書き込み
	session_start();
	$_SESSION['page'] = true;

} elseif( !empty($_POST['btn_submit']) ) {
	session_start();
	if( !empty($_SESSION['page']) && $_SESSION['page'] === true ) {

	// セッションの削除
	unset($_SESSION['page']);

	$page_flag = 2;

	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	$admin_reply_subject = null;
	$admin_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	// ヘッダー情報を設定
	$header = "MIME-Version: 1.0\n";
	$header .= "From: creative, community space ∧°┐ <we.are.pe.hu@gmail.com>\n";
	$header .= "Reply-To: creative, community space ∧°┐ <we.are.pe.hu@gmail.com>\n";

	// 件名を設定
	$auto_reply_subject = '大切にすることを大切にする';

	// 本文を設定
	$admin_reply_text .= "" . $_POST['name'] . "の大切なもの\n";
	$admin_reply_text .= "title" . $_POST['title'] . "\n\n";
	$admin_reply_text .= "" . nl2br($_POST['text']) . "\n\n\n";
	$admin_reply_text .= "Posted on " . date("m-d-Y H:i") . "\n";
	$admin_reply_text .= "creative-community.space/value/";

	// メール送信
	mb_send_mail( $_POST['email'], $auto_reply_subject, $auto_reply_text, $header);

	// 運営側へ送るメールの件名
	$admin_reply_subject = "大切にすることを大切にする";

	// 本文を設定
	$admin_reply_text .= "" . $_POST['name'] . "の大切なもの\n";
	$admin_reply_text .= "title" . $_POST['title'] . "\n\n";
	$admin_reply_text .= "" . nl2br($_POST['text']) . "\n\n\n";
	$admin_reply_text .= "Posted on " . date("m-d-Y H:i") . "\n";
	$admin_reply_text .= "creative-community.space/value/";

	// 運営側へメール送信
	mb_send_mail( 'admin@vg.pe.hu', $admin_reply_subject, $admin_reply_text, $header);

	} else {
		$page_flag = 0;
	}
}

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
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="icon" href="../icon.png">
<link rel="stylesheet" type="text/css" href="../value.css" />
<link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro:ital,wght@0,300;0,600;0,700;1,600&display=swap" rel="stylesheet">
<title>大切なことを大切にする場所</title>
<style type="text/css">
#submit h1,
#submit p,
#submit button {
	font-family: 'Source Serif Pro', serif;
	font-weight:500;
}
#submit {
	position:relative;
	top:0; left:0;
	font-size:0.75rem;
	padding:5% 0;
}
#submit section {
	width:90%;
	max-width:35rem;
    margin:auto;
}
#submit input[type="text"],
#submit input[type="name"],
#submit input[type="url"],
#submit input[type="email"],
#submit textarea {
	padding:1.5%;
	margin:0.01vw 0;
	border:0.1rem solid;
	border-radius:0.5rem;
	font-size:0.75rem;
	width:97%;
}
#submit button {
	font-size: 1rem;
	cursor:pointer;
	width:100%;
	margin-bottom:2.5rem;
	padding:0.25rem 0;
	background: #fff;
	color: #000;
	border-radius:2.5rem;
}
</style>
</head>
<body>
<div id="submit">
<section>
<form action="/value/online/complete.php" method="post">
<h1>Q. What do you value?</h1>
<p class="jp_title">あなたの大切なものは何ですか？</p>
<p>Title<br/>
<input type="text" name="title" placeholder="題名" required></p>
<p>Your Name<br/>
<input type="name" name="name" placeholder="名前" required></p>
<p>Your Email<br/>
<input type="email" name="email" placeholder="メールアドレス" required></p>
<p>Text by
<input type="radio" name="language" value="ja" required> 日本語
<input type="radio" name="language" value="en" required> English<br/>
<textarea name="text" rows="7.5" placeholder="あなたの大切なものは何ですか？" required></textarea></p>
<button type="submit">Submit</button>
</form>
</section>
</div>
</body>
</html>
