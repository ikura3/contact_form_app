<?php

class validator
{
    public function validate(ContactForm $form)
    {
        $errors = [];

        $name = $form->getName();
        $email = $form->getEmail();
        $body = $form->getBody();

        if(empty($name)){
            $errors["name"] = "名前は必須です。";
        }elseif(strlen($name) > 20){
            $errors["name"] = "名前は20文字以内で入力してください";
        }

        if(empty($email)){
            $errors["email"] = "メールアドレスは必須です。";
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors["email"] = "正しいメールアドレス形式で入力してください";
        }

        if(empty($body)){
            $errors["body"] = "お問い合わせは必須です。";
        }

        return $errors;
    }
}