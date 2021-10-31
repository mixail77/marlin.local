<?php

//Проверяем авторизацию пользователя
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

    //Если нет ошибок
    if (!empty($arError)) {

        setFlashMessage('LOGIN_ERROR', $arError);

    } else {

        if (login($email, $password)) {

            setFlashMessage('LOGIN_SUCCESS', 'Вы успешно авторизованы');

            //Редирект на страницу пользователей
            redirectTo('/page_users.php');

        } else {

            setFlashMessage('LOGIN_ERROR', 'Неверный логин или пароль');

        }

    }

}

?>

