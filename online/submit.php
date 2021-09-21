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
		$data = "'".$_POST['name']."','".$_POST['q_one']."'\n\n\n";

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
	$auto_reply_subject = 'ichoose | Create 10 Questions';

	// 本文を設定
	$auto_reply_text .= "Thank You for Create 10 Questions\n\n";
	$auto_reply_text .= "This questions was created by\n" . $_POST['name'] . "\n\n\n";

	$auto_reply_text .= "Question 1\n\n" . $_POST['q_one'] . "\n";
	$auto_reply_text .= "Posted on " . date("m-d-y H:i") . "\n\n\n";
	$auto_reply_text .= "ichoose.pe.hu";

	mb_send_mail( $_POST['email'], $auto_reply_subject, $auto_reply_text, $header);


	// 件名を設定
	$admin_reply_subject = 'ichoose | Create 10 Questions';

	// 本文を設定
	$admin_reply_text .= "Thank You for Create 10 Questions\n\n";
	$admin_reply_text .= "This questions was created by\n" . $_POST['name'] . "\n\n";
	$admin_reply_text .= "Email " . $_POST['email'] . "\n\n\n";

	$admin_reply_text .= "Question 1\n\n" . $_POST['q_one'] . "\n";

	$admin_reply_text .= "Posted on " . date("m-d-y H:i") . "\n\n\n";
	$admin_reply_text .= "ichoose.pe.hu";

	mb_send_mail( 'sorryforthedelayinsending@vg.pe.hu', $admin_reply_subject, $admin_reply_text, $header);

	} else {
		$page_flag = 0;
	}
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="/styles.css" />
<link rel="stylesheet" type="text/css" href="/10q/10q.css" />
<link rel="stylesheet" type="text/css" href="/10q/list.css" />
<title>Create 10 Questions | The Answers are always inside of you</title>
<style type="text/css">
.ichoose {font-size: 2vw; margin:10vw 5vw 35vw;}

.ichoose h3 u {font-size: 2.5vw;}
.ichoose p {margin-bottom: 5vw;}
input[type="name"],
input[type="email"],
input[type="text"] {
  width:75%;
  padding:1.25%;
  font-size:2vw;
}

input[type="submit"] {
  padding:2.5% 5%;
  margin:0 2.5%;
  font-size:2.5vw;
  background:transparent;
  border:red 2px solid;
  border-radius:50%;
  cursor:pointer;
}
#next {margin-top:5vw;}

.thankyou {
  position:absolute;
  display:block;
  overflow:auto;
  padding:0; margin:0;
  width:100%; height:100vh;
}
.thankyou h2 {
  position:fixed;
  bottom:0;
  width:100%;
  text-align:center;
  font-size: 2.5vw; font-weight: 500;
  font-family: "Times New Roman", "Times", serif;
}
.thankyou hr {
  border:none;
  padding:2.5vw;
}

#next {zoom:1.25;}

@media screen and (max-width: 500px){
.or {width:75%;}
.left, .right {width:100%;}
input[type="name"],
input[type="email"],
input[type="text"] {
  width:85%;
  font-size:2.5vw;
}
.question h2 {padding-bottom:2.5vw;}
.or {padding-bottom:5vw;}
#answer {margin-top:2.5vw;}
#next {margin-top:7.5vw;}
}
@media print{
.ichoose {zoom:150%; height:70vh;}
}
</style>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
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
<h2><?php echo $_POST['q_one']; ?></h2>
</div>

<div class="question">
<p id="next">
<input type="submit" name="btn_back" value="Back">
<input type="submit" name="btn_submit" value="Post">
</p>

<input type="hidden" name="name" value="<?php echo $_POST['name']; ?>">
<input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">
<input type="hidden" name="q_one" value="<?php echo $_POST['q_one']; ?>">
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

<div class="question">
<div id="answer">
<h2 for="name">Your Name</h2>
<p><input id="name" type="name" name="name" value="<?php if( !empty($_POST['name']) ){ echo $_POST['name']; } ?>" required></p>
<br/>
<h2 for="name">Email</h2>
<p><input id="email" type="email" name="email" value="<?php if( !empty($_POST['email']) ){ echo $_POST['email']; } ?>" required></p>
</div>
</div>

<div class="question">
<h2 for="q_one">Question 1</h2>
<h2><input id="q_one" type="text" name="q_one" value="<?php if( !empty($_POST['q_one']) ){ echo $_POST['q_one']; } ?>" required></h2>
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
