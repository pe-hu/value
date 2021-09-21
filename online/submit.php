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
		$data = "'".$_POST['title']."'".$_POST['name']."','".$_POST['text']."'\n";

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
	$auto_reply_text .= "大切なもの | What do you value?\n\n";
	$auto_reply_text .= "\n". $_POST['title'] . "\n";
	$auto_reply_text .= "by" . $_POST['name'] . "\n\n";

	$auto_reply_text .= "\n" . $_POST['text'] . "\n\n\n";

	$auto_reply_text .= "Posted on " . date("m-d-y H:i") . "\n\n";
	$auto_reply_text .= "https://creative-community.space/value/";

	mb_send_mail( $_POST['email'], $auto_reply_subject, $auto_reply_text, $header);


	// 件名を設定
	$admin_reply_subject = '大切にすることを大切にする';

	// 本文を設定
	$admin_reply_text .= "大切なもの | What do you value?\n\n";
	$auto_reply_text .= "\n". $_POST['title'] . "\n";
	$auto_reply_text .= "by" . $_POST['name'] . "\n";
	$admin_reply_text .= "Email " . $_POST['email'] . "\n\n";

	$admin_reply_text .= "\n" . $_POST['text'] . "\n\n\n";

	$admin_reply_text .= "Posted on " . date("m-d-y H:i") . "\n\n";
	$admin_reply_text .= "https://creative-community.space/value/";

	mb_send_mail( 'sorryforthedelayinsending@vg.pe.hu', $admin_reply_subject, $admin_reply_text, $header);

	} else {
		$page_flag = 0;
	}
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="icon" href="../icon.png">
<link rel="stylesheet" type="text/css" href="/value/stylesheet.css" />
<link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro:ital,wght@0,300;0,600;0,700;1,600&display=swap" rel="stylesheet">
<title>大切にすることを大切にする場所</title>
<style type="text/css">
</style>
</head>
<body>
<?php if( $page_flag === 1 ): ?>
<section id="main" class="form">

<div id="post">
<div class="en">
<div class="app">
<p class="tt"><?php echo $_POST['title']; ?><br/>
<?php echo $_POST['name']; ?></p>
<div class="essay">
<p><?php echo $_POST['text']; ?></p>
</div>
<div class="link">
<p><a><?php echo $_POST['email']; ?></a></p>
</div>
</div>
</div>
</div>

<div class="question">
<p id="next">
<input type="submit" name="btn_back" value="Back">
<input type="submit" name="btn_submit" value="Post">
</p>

<input type="hidden" name="title" value="<?php echo $_POST['title']; ?>">
<input type="hidden" name="name" value="<?php echo $_POST['name']; ?>">
<input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">
<input type="hidden" name="text" value="<?php echo $_POST['text']; ?>">
</div>
</form>
</section>

<?php elseif( $page_flag === 2 ): ?>

<div class="thankyou">
<h1>Thank You for Submit</h1>
<p>投稿フォームに入力いただいたメールアドレスに、あなたの大切なものを自動返信します。</p>
<p><u>※ 投稿後、返信メールが届かなかった場合は、お手数ですが we.are.pe.hu@gmail.com までお問合わせください。</u></p>
<br/>
<p>あなたの大切なものを、このウェブサイトに公開する準備が整いましたら、改めてご連絡いたします。</p>
<hr/>
</div>

<?php else: ?>
<section id="main" class="form">
<form action="" id="10q" method="post">

<div class="question">
<div id="answer">
<p><input id="title" type="text" name="title" value="<?php if( !empty($_POST['title']) ){ echo $_POST['title']; } ?>" required></p>
<p><input id="name" type="name" name="name" value="<?php if( !empty($_POST['name']) ){ echo $_POST['name']; } ?>" required></p>
<br/>
<h2 for="name">Email</h2>
<p><input id="email" type="email" name="email" value="<?php if( !empty($_POST['email']) ){ echo $_POST['email']; } ?>" required></p>
</div>
</div>

<div class="question">
<h2><input id="text" type="text" name="q_one" value="<?php if( !empty($_POST['text']) ){ echo $_POST['text']; } ?>" required></h2>
</div>

<div class="question">
<p id="next">
<input type="submit" name="btn_confirm" value="Submit">
</p>
</div>
</form>
</section>
<?php endif; ?>
</body>
</html>
