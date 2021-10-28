<?php

//Регистрация пользователя
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    displayFlashClear();

    $arError = [];

    $email = trim(strip_tags($_POST['email']));
    $password = trim(strip_tags($_POST['password']));
    $hash = password_hash($password, PASSWORD_BCRYPT);

    //Проверяем E-mail
    if (empty($email)) {

        $arError[] = 'Введите ваш E-mail';

    } else {

        //Ищем пользователя
        $arUser = getUserByEmail($email);

        if (!empty($arUser)) {

            $arError[] = 'Пользователь с таким E-mail адресом уже зарегистрирован';

        }

    }

    //Проверяем пароль
    if (empty($password)) {

        $arError[] = 'Введите ваш пароль';

    }

    //Нет ошибок
    if (!empty($arError)) {

        setFlashMessage('REGISTER_ERROR', $arError);

    } else {

        userAdd($email, $hash);

    }

}

?>

