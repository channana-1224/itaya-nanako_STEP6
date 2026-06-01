<?php
// セッションを開始して、contact.phpから保存されたデータを受け取る
session_start();
// 不正アクセスガード
// もしPOST送信（フォームのボタン押し）以外で直接アクセスされたら、入力画面に強制的に戻す
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit;
    }
    
// エラーメッセージかご
$errors = [];

// 各入力データを安全に取得（空なら空文字にする）
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$companyName = isset($_POST['companyName']) ? trim($_POST['companyName']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$age = isset($_POST['age']) ? trim($_POST['age']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// 基本の空欄チェック
if ($name === '') { $errors[] = 'お名前を入力してください。'; }
if ($companyName === '') { $errors[] = '会社名を入力してください。'; }
if ($email === '') { $errors[] = 'メールアドレスを入力してください。'; }
if ($age === '') { $errors[] = '年齢を入力してください。'; }
if ($message === '') { $errors[] = 'お問い合わせ内容を入力してください。'; }


// 各種バリテーション
if ($name !== '') {
if (!preg_match('/^[\x{3040}-\x{309F}\x{30A0}-\x{30FF}\x{4E00}-\x{9FFF}a-zA-Z\s ・、,.\-\']/u', $name)) {
$errors[] = 'お名前にはひらがな・カタカナ・漢字・英字・一部の記号のみ使用できます。';
}
}

if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
$errors[] = 'メールアドレスの形式が正しくありません。';
}

if ($age !== '') {
if (!ctype_digit($age)) {
$errors[] = '年齢は半角数字だけで入力してください。';
} else {
$ageInt = (int)$age;
if ($ageInt < 0 || $ageInt > 150) {
$errors[] = '年齢は 0 から 150 の間で入力してください。';
}
}
}

if ($message !== '') {
$length = mb_strlen($message, 'UTF-8');
if ($length < 10) {
$errors[] = 'お問い合わせ内容は最低でも 10 文字以上入力してください。';
} elseif ($length > 500) {
$errors[] = 'お問い合わせ内容は 500 文字以内で入力してください。';
}

$lines = explode("\n", $message);
if (count($lines) > 10) {
$errors[] = 'お問い合わせ内容は 10 行以内で入力してください。';
}
}


// セッションに保存して進む
$_SESSION['name'] = $name;
$_SESSION['companyName'] = $companyName;
$_SESSION['email'] = $email;
$_SESSION['age'] = $age;
$_SESSION['message'] = $message;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>お問い合わせフォーム</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<header>
<h2>お問い合わせフォーム - 確認画面</h2>
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

<?php if (!empty($errors)): ?>
<div style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
<p style="margin-top: 0; font-weight: bold;">入力内容に不備があります。以下を確認してください：</p>
<ul style="margin: 0; padding-left: 20px;">
<?php foreach ($errors as $error): ?>
<li style="margin-bottom: 5px;"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
<?php endforeach; ?>
</ul>
</div>
<p>恐れ入りますが、一度戻って内容を修正してください。</p>
<input type="button" value="入力画面に戻る" onclick="history.back();">

<?php else: ?>

<p>以下の内容で送信します。よろしければ「送信」ボタンを押してください。</p>

<table border="3" width="100%">
<tr>
<th>お名前</th>
<td><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></td>
</tr>
<tr>
<th>会社名</th>
<td><?php echo htmlspecialchars($companyName, ENT_QUOTES, 'UTF-8'); ?></td>
</tr>
<tr>
<th>メールアドレス</th>
<td><?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></td>
</tr>
<tr>
<th>年齢</th>
<td><?php echo htmlspecialchars($age, ENT_QUOTES, 'UTF-8'); ?></td>
</tr>
<tr>
<th>お問い合わせ内容</th>
<td><?php echo nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8')); ?></td>
</tr>
</table>
<br>

<div style="display: flex; gap: 15px;">
<input type="button" value="戻る" onclick="history.back()">

<form action="send.php" method="POST">
<input type="hidden" name="name" value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>">
<input type="hidden" name="companyName" value="<?php echo htmlspecialchars($companyName, ENT_QUOTES, 'UTF-8'); ?>">
<input type="hidden" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
<input type="hidden" name="age" value="<?php echo htmlspecialchars($age, ENT_QUOTES, 'UTF-8'); ?>">
<input type="hidden" name="message" value="<?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>">

<input type="submit" value="送信">
</form>
</div>

<?php endif; ?>
</main>
</div>

<footer>
<p>&copy; お問い合わせフォーム</p>
</footer>

</body>
</html>

