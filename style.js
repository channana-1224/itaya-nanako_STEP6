//ページが完全に読み込まれてから処理を実行する
window.addEventListener('DOMContentLoaded', function() {

//フォーム送信時に未入力項目をチェックする処理
var formElement = document.querySelector('form');

if (formElement) {
formElement.addEventListener('submit', function(event) {

var nameValue = document.querySelector('input[name="name"]').value.trim();
var companyValue = document.querySelector('input[name="companyName"]').value.trim();
var emailValue = document.querySelector('input[name="email"]').value.trim();
var ageValue = document.querySelector('input[name="age"]').value.trim();
var messageValue = document.querySelector('textarea[name="message"]').value.trim();

if (nameValue === "" || companyValue === "" || emailValue === "" || ageValue === "" || messageValue === "") {
event.preventDefault();
alert('必須項目が未入力です。入力内容をご確認ください。');
} else {
var confirmMessage = '下記の内容を本当に送信しますか？\n\n' +
'お名前 ➔ ' + nameValue + '\n' +
'会社名 ➔ ' + companyValue + '\n' +
'メールアドレス ➔ ' + emailValue + '\n' +
'年齢 ➔ ' + ageValue + '\n' +
'お問い合わせ内容 ➔ ' + messageValue;

var isOk = confirm(confirmMessage);
if (!isOk) {
event.preventDefault();
}
}
});
}

// a)「押してみてね！」のボタンを取得すること。
// b) ボタンの種類を特定するには「document.querySelector」を使用すること。
var footerButton = document.querySelector('footer button');

// c) 背景色を変更する要素「footer」を取得してください。
var footerElement = document.querySelector('footer');

// d) 以下の4色を配列に保存してください（青、赤、黄色、灰色）
var colors = ['blue', 'red', 'yellow', 'gray'];

// 現在の色が配列の何番目か（0＝青、1＝赤、2＝黄色、3＝灰色）を記憶する変数
var currentColorIndex = 0;

// e) ボタンがクリックされるたびに、背景色が次の色に変更されるようにすること。
footerButton.addEventListener('click', function() {

// 現在のインデックス（番号）の色をフッターの背景色に設定する
footerElement.style.backgroundColor = colors[currentColorIndex];

// f) 色は配列の順番で変更され、最後の色（灰色）の次は再び最初の色（青）に戻るようにすること。
// 次の色の番号に進める（0 -> 1 -> 2 -> 3 と増える）
currentColorIndex = currentColorIndex + 1;

// もし番号が4（配列の限界）になったら、0（最初の青）に戻す
if (currentColorIndex >= colors.length) {
currentColorIndex = 0;
}

// （確認用）ログを出して、次のクリックに備える
console.log("フッターのボタンがクリックされました。");
console.log("次の色番号（インデックス）:", currentColorIndex);
});
});