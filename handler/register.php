<?php

//Проверяем авторизацию пользователя
if (isAuthorize()) {

    redirectTo('/page_users.php');

}

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

        //Добавляем нового пользователя
        $userId = userAdd($email, $hash);

        if (!empty($userId)) {

            //Добавляем профиль и соцсети пользователя
            $profileId = userAddProfile($userId);
            $socialId = userAddSocial($userId);

            setFlashMessage('REGISTER_SUCCESS', 'Вы успешно зарегистрированы. Пожалуйста, авторизуйтесь');

            //Редирект на страницу авторизации
            redirectTo('/page_login.php');

        } else {

            setFlashMessage('REGISTER_ERROR', 'Произошла ошибка');

        }

    }

}

?>

