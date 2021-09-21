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
		$data = "'".$_POST['name']."','".$_POST['essay']."'\n\n\n";

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
	$header .= "From: ichoose <we.are.pe.hu@gmail.com>\n";
	$header .= "Reply-To: ichoose <we.are.pe.hu@gmail.com>\n";

	// 件名を設定
	$auto_reply_subject = '大切にすることを大切にする場所';

	// 本文を設定
	$auto_reply_text .= "Thank You for Submit\n\n";
	$auto_reply_text .= "大切なもの | What do you value?\n" . $_POST['name'] . "\n";

	$auto_reply_text .= "\n" . $_POST['essay'] . "\n\n";
	$auto_reply_text .= "\n" . $_POST['name'] . "\n\n";
	$auto_reply_text .= "Posted on " . date("m-d-y H:i") . "\n\n";
	$auto_reply_text .= "creative-community.space/value/";

	mb_send_mail( $_POST['email'], $auto_reply_subject, $auto_reply_text, $header);


	// 件名を設定
	$admin_reply_subject = '大切にすることを大切にする場所';

	// 本文を設定
	$admin_reply_text .= "大切なもの | What do you value?\n" . $_POST['name'] . "\n";

	$admin_reply_text .= "\n" . $_POST['essay'] . "\n\n";
	$admin_reply_text .= "Name " . $_POST['name'] . "\n";
	$admin_reply_text .= "Email " . $_POST['email'] . "\n\n\n";

	$admin_reply_text .= "Posted on " . date("m-d-y H:i") . "\n\n";
	$admin_reply_text .= "creative-community.space/value/";

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
<?php if( $page_flag === 1 ): ?>
<section id="main" class="form">

<div class="ichoose">
<h3><u>This question was created by</u></h3>
これは、 <b><?php echo $_POST['name']; ?></b>
<p>が考えた 10の質問 です。</p>
</div>

<form action="" id="10q" method="post">
<div class="question">
<h2><?php echo $_POST['essay']; ?></h2>
</div>

<div class="question">
<p id="next">
<input type="submit" name="btn_back" value="Back">
<input type="submit" name="btn_submit" value="Post">
</p>

<input type="hidden" name="name" value="<?php echo $_POST['name']; ?>">
<input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">
<input type="hidden" name="essay" value="<?php echo $_POST['essay']; ?>">
</div>
</form>
</section>

<?php elseif( $page_flag === 2 ): ?>

<div class="thankyou">
<h3><u>Thank You </u></h3>
<b><?php echo $_POST['name']; ?></b>
<p>10の質問をご制作いただき、ありがとうございます。</p>
<br/>
<p>10の質問投稿フォームに入力いただいたメールアドレスに、あなたが制作した10の質問を自動返信します。</p>
<p><u>※ 質問投稿後、返信メールが届かなかった場合は、お手数ですが we.are.pe.hu@gmail.com までお問合わせください。</u></p>
<br/>
<p>投稿いただいた10の質問を、このウェブサイトに公開する準備が整いましたら、同じく投稿フォームに入力いただいたメールアドレスまで、ウェブページ公開のお知らせをお送りいたします。</p>
<hr/>
</div>

<?php else: ?>
<section id="main" class="form">
<form action="" id="10q" method="post">

<h1>Q. What do you value?</h1>
<p>Title<br/>
<input type="text" name="title" value="<?php if( !empty($_POST['title']) ){ echo $_POST['title']; } ?>" placeholder="あなたの大切なものは何ですか？" required></p>
<p>Your Name<br/>
<input type="name" name="name" value="<?php if( !empty($_POST['name']) ){ echo $_POST['name']; } ?>" placeholder="名前" required></p>
<p style="display:none;">Link<br/>
<input type="text" name="link" value="none"></p>
<p>Your Email<br/>
<input type="email" name="email" value="<?php if( !empty($_POST['email']) ){ echo $_POST['email']; } ?>" placeholder="メールアドレス" required></p>
<p>Text by
<input type="radio" name="language" value="ja" required> 日本語
<input type="radio" name="language" value="en" required> English<br/>
<textarea name="text" rows="7.5" value="<?php if( !empty($_POST['text']) ){ echo $_POST['text']; } ?>" placeholder="あなたの大切なものは何ですか？" required></textarea></p>


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
