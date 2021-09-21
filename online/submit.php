<?php

mb_language("ja");
mb_internal_encoding("UTF-8");

// メッセージを保存するファイルのパス設定
define( 'FILENAME', 'draft.csv');

// 変数の初期化
$page_flag = 0;

if( !empty($_POST['btn_confirm']) ) {

	$page_flag = 1;
	session_start();
	$_SESSION['page'] = true;

} elseif( !empty($_POST['btn_submit']) ) {

	if( $file_handle = fopen( FILENAME, "a") ) {

		// 書き込むデータを作成
		$data = "'".$_POST['title']."','".$_POST['name']."','".$_POST['link']."','".$_POST['language']."','".$_POST['email']."'\n\n\n";

		// 書き込み
		fwrite( $file_handle, $data);

		// ファイルを閉じる
		fclose( $file_handle);
	}

	session_start();
	if( !empty($_SESSION['page']) && $_SESSION['page'] === true ) {

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
	$header .= "From: ∧° ┐ | creative, community space <we.are.pe.hu@gmail.com>\n";
	$header .= "Reply-To: ∧° ┐ | creative, community space <we.are.pe.hu@gmail.com>\n";

	// 件名を設定
	$auto_reply_subject = '大切にすることを大切にする';

	// 本文を設定
	$admin_reply_text .= "Thank You for Submit\n\n";
	$auto_reply_text .= "Your Name\n" . $_POST['name'] . "\n\n\n";

	$auto_reply_text .= "大切なもの | What do you value?\n" . $_POST['title'] . "\n\n";
	$auto_reply_text .= "" . $_POST['text'] . "";

	$auto_reply_text .= "Posted on " . date("Y-m-d H:i:s") . "\n\n\n";
	$auto_reply_text .= "https://creative-community.space/value/";

	mb_send_mail( $_POST['email'], $auto_reply_subject, $auto_reply_text, $header);


	// 件名を設定
	$auto_reply_subject = '大切にすることを大切にする';

	// 本文を設定
	$auto_reply_text .= "Name\n" . $_POST['name'] . "\n\n\n";

	$auto_reply_text .= "大切なもの | What do you value?\n" . $_POST['title'] . "\n\n";
	$auto_reply_text .= "" . $_POST['text'] . "";

	$auto_reply_text .= "Posted on " . date("Y-m-d H:i:s") . "\n\n\n";
	$auto_reply_text .= "https://creative-community.space/value/";

	mb_send_mail( 'sasajimakazuma@gmail.com', $admin_reply_subject, $admin_reply_text, $header);

	} else {
		$page_flag = 0;
	}
}
?>

<html lang="ja">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="icon" href="../icon.png">
<link rel="stylesheet" type="text/css" href="/value/stylesheet.css" />
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
<p>Title<br/>
<input type="text" name="title" placeholder="あなたの大切なものは何ですか？" required></p>
<p>Your Name<br/>
<input type="name" name="name" placeholder="名前" required></p>
<p style="display:none;">Link<br/>
<input type="text" name="link" value="none"></p>
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
