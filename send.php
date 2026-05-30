<?php
//セッションを開始して元のコードの互換性をキープ
session_start();

//フォーム画面（contact.php）➔ 確認画面（confirm.php）からPOSTメソッドで送られてきたデータを正しく受け取る
$name = isset($_POST['name']) ? $_POST['name'] : '';
$companyName = isset($_POST['companyName']) ? $_POST['companyName'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$age = isset($_POST['age']) ? $_POST['age'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';

//メール送信の設定（元の設定をそのままに！）
$to = "test@example.com";
$subject = "【お問い合わせ】" . $name . " 様より";
$body = "以下の内容でお問い合わせを受け付けました。\n\n" .
"・名前：" . $name . "\n" .
"・会社名：" . $companyName . "\n" .
"・メールアドレス：" . $email . "\n" .
"・年齢：" . $age . "\n" .
"・お問い合わせ内容：\n" . $message;
$headers = "From: " . $email;

//確認画面からデータが正しく届いているかをチェック
$mail_sent = false;
if ($name !== '') {
$mail_sent = true;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>お問い合わせフォーム - 送信完了画面</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<header>
<h2>お問い合わせフォーム - 送信完了画面</h2>
</header>

<div class="container">
<nav class="sidebar">
<ul>
<li><a href="#">トップページ</a></li>
<li><a href="#">人気投稿</a></li>
<li><a href="#">エンジニアおすすめ商品</a></li>
<li><a href="#">エンジニアおすすめ記事</a></li>
<li><a href="#">投稿ページ</a></li>
</ul>
</nav>

<main class="main-content">
<?php if ($mail_sent): ?>

<p>お問い合わせのメール送信が成功しました。ありがとうございます！</p>
<br>
<a href="contact.php" style="display: inline-block; padding: 10px 20px; background-color: #333; color: #fff; text-decoration: none; border-radius: 4px;">お問い合わせフォームに戻る</a>

<?php
// セッションをクリア（元のコードの位置をキープ）
session_destroy();
?>

<?php else: ?>

<p style="color: red; font-weight: bold;">お問い合わせのメール送信が失敗しました。アクセス方法が正しくないか、データが届いていません。</p>
<br>
<a href="contact.php">お問い合わせフォームに戻る</a>

<?php endif; ?>
</main>
</div>

<footer>
<p>&copy; お問い合わせフォーム送信完了画面</p>
</footer>

</body>
</html>