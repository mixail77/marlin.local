<?php

//Подключение к базе
function dbConnect()
{

    return new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASSWORD);

}

//Ищем пользователя по E-mail
function getUserByEmail($email)
{

    if (!empty($email)) {

        $pdo = dbConnect();

        $stmt = $pdo->prepare('SELECT * FROM `user` WHERE `email` = :email');
        $stmt->execute(
            [
                'email' => $email,
            ]
        );

        $arResult = $stmt->fetch(PDO::FETCH_ASSOC);

        //Проверяем
        if (!empty($arResult)) {

            return $arResult;

        }

    }

    return false;

}

//Авторизуем пользователя
function login($email, $password)
{

    if (!empty($email) && !empty($password)) {

        //Ищем пользователя
        $arUser = getUserByEmail($email);

        if (!empty($arUser)) {

            //Проверяем хеш пароля
            if (password_verify($password, $arUser['PASSWORD'])) {

                //Записываем данные пользователя
                $_SESSION['USER'] = $arUser;

                setFlashMessage('LOGIN_SUCCESS', 'Вы успешно авторизованы');

                //Редирект на страницу пользователей
                redirectTo('/users.php');

            } else {

                setFlashMessage('LOGIN_ERROR', 'Неверный логин или пароль');

            }

        } else {

            setFlashMessage('LOGIN_ERROR', 'Неверный логин или пароль');

        }

    } else {

        setFlashMessage('LOGIN_ERROR', 'Неверный логин или пароль');

    }

    return false;

}

//Добавляем нового пользователя
function userAdd($email, $password)
{

    if (!empty($email) && !empty($password)) {

        $pdo = dbConnect();

        $stmt = $pdo->prepare('INSERT INTO `user` SET `email` = :email, `password` = :password');
        $stmt->execute(
            [
                'email' => $email,
                'password' => $password,
            ]
        );

        $id = $pdo->lastInsertId();

        //Проверяем
        if (!empty($id)) {

            setFlashMessage('REGISTER_SUCCESS', 'Вы успешно зарегистрированы. Пожалуйста, авторизуйтесь');

            //Редирект на страницу авторизации
            redirectTo('/page_login.php');

        } else {

            setFlashMessage('REGISTER_ERROR', 'Произошла ошибка');

        }

    } else {

        setFlashMessage('REGISTER_ERROR', 'Произошла ошибка');

    }

    return false;

}

//Устанавливаем текст уведомления
function setFlashMessage($messageKey, $message)
{

    if (is_array($message)) {

        $_SESSION['MESSAGE'][$messageKey] = implode(', ', $message);

    } else {

        $_SESSION['MESSAGE'][$messageKey] = $message;

    }

}

//Выводим текст уведомления
function displayFlashMessage($messageKey)
{

    if (!empty($_SESSION['MESSAGE'][$messageKey])) {

        echo $_SESSION['MESSAGE'][$messageKey];

    }

}

//Удаляем все уведомления
function displayFlashClear()
{

    $_SESSION['MESSAGE'] = [];

}

//Проверяем авторизацию пользователя
function userAuthorize()
{

    if (empty($_SESSION['USER']['ID'])) {

        redirectTo();

    }

}

//Редирект на страницу
function redirectTo($page = PAGE_LOGIN)
{

    header('Location:' . $page);

}

?>