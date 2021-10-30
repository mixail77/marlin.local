<?php

//Если пользователь авторизован
if (isAuthorize()) {

    redirectTo('/page_users.php');

}

//Авторизация пользователя
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    displayFlashClear();

    $arError = [];

    $email = trim(strip_tags($_POST['email']));
    $password = trim(strip_tags($_POST['password']));

    //Проверяем E-mail
    if (empty($email)) {

        $arError[] = 'Введите ваш E-mail';

    }

    //Проверяем пароль
    if (empty($password)) {

        $arError[] = 'Введите ваш пароль';

    }

    //Нет ошибок
    if (!empty($arError)) {

        setFlashMessage('LOGIN_ERROR', $arError);

    } else {

        login($email, $password);

    }

}

?>

