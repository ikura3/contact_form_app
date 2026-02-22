<?php
session_start();

require_once "contactForm.php";
require_once "validator.php";

$form = new ContactForm("", "", "");
$errors = [];

// CSRFトークン
if (!isset($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION["csrf_token"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // CSRFトークン確認
    if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
        die("不正なアクセスです。");
    }

    $name = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $body = $_POST["body"] ?? "";

    $form = new ContactForm($name, $email, $body);

    $validator = new Validator();
    $errors = $validator->validate($form);
    if (empty($errors)) {
        // CSRFトークンを削除
        unset($_SESSION["csrf_token"]);
        header("Location: thanks.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせフォーム</title>
</head>

<body>
    <div class="wrap">
        <h1>お問い合わせフォーム</h1>
        <div class="contact_list">
            <form action="" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, "UTF-8") ?>">
                <div class="contact_item">
                    <label for="">
                        お名前<input type="text" name="name" value="<?= htmlspecialchars($form->getName(), ENT_QUOTES, "UTF-8"); ?>">
                    </label>
                    <p class="error_msg"><?= htmlspecialchars($errors["name"] ?? "", ENT_QUOTES, "UTF-8"); ?></p>
                </div>
                <div class="contact_item">
                    <label for="">メールアドレス
                        <input type="text" name="email" value="<?= htmlspecialchars($form->getEmail(), ENT_QUOTES, "UTF-8"); ?>">
                    </label>
                    <p class="error_msg"><?= htmlspecialchars($errors["email"] ?? "", ENT_QUOTES, "UTF-8"); ?></p>
                </div>
                <div class="contact_item">
                    <p class="title">お問い合わせ内容</p>
                    <textarea name="body" cols="40" rows="10"><?= htmlspecialchars($form->getBody(), ENT_QUOTES, "UTF-8"); ?></textarea>
                    <p class="error_msg"><?= htmlspecialchars($errors["body"] ?? "", ENT_QUOTES, "UTF-8"); ?></p>

                </div>

                <div class="submit_btn">
                    <button type="submit">送信する</button>
                </div>
            </form>
        </div>
    </div>
</body>

<style>
    .wrap {
        width: 60%;
        margin: 0 auto;
    }

    .contact_list {
        background-color: #d6f0f7;
        padding: 20px;
        width: 400px;
        margin: 0 auto;
    }

    .contact_item {
        margin-bottom: 15px;
    }
    
    .contact_item input[type="text"],
    .contact_item input[type="email"],
    .contact_item textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 8px 10px;
        font-size: 16px;
    }

    .contact_item textarea {
        height: 150px;
        resize: vertical;
    }

    h1 {
        margin-bottom: 1em;
        text-align: center;
    }

    .submit_btn {
        width: 150px;
        margin: 0 auto;
    }

    button[type="submit"] {
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
    }

    /* label {
        display: block;
        text-align: left;
    } */

    .title {
        margin-bottom: 3px;
    }

    .error_msg {
        color: #f61b1b;
        margin-top: 0;
    }
</style>

</html>