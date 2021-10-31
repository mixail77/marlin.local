<?php

$userId = (int)$_GET['id'];

//Проверяем авторизацию пользователя
if (!isAuthorize()) {

    redirectTo('/page_login.php');

}

//Если не администратор и не владелец профиля
if (!isAdmin() && !isMyProfile($userId)) {

    redirectTo('/page_users.php');

}

//Получаем данные редактируемого пользователя
$arUserInfo = getUserByID($userId);

//Пользователь не существует
if (empty($arUserInfo)) {

    redirectTo('/page_users.php');

}

//Редактирование пользователя
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    displayFlashClear();

    $arError = [];

    $email = trim(strip_tags($_POST['email']));
    $password = trim(strip_tags($_POST['password']));
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $passwordConfirm = trim(strip_tags($_POST['password_confirm']));

    //Проверяем E-mail
    if (empty($email)) {

        $arError[] = 'Введите ваш E-mail';

    } else {

        //Ищем пользователя
        $arUser = getUserByEmail($email);

        if (!empty($arUser)) {

            //Проверяем ID редактируемого и найденного по E-mail пользователя
            if ($arUser['ID'] != $arUserInfo['ID']) {

                $arError[] = 'Пользователь с таким E-mail адресом уже зарегистрирован';

            }

        }

    }

    //Проверяем пароль
    if (!empty($password) || !empty($passwordConfirm)) {

        if ($password !== $passwordConfirm) {

            $arError[] = 'Пароли не совпадают';

        } else {

            //Будем обновлять пароль пользователю
            $updateFields['PASSWORD'] = $hash;

        }

    }

    //Если нет ошибок
    if (!empty($arError)) {

        setFlashMessage('SECURITY_ERROR', $arError);

    } else {

        $updateFields['EMAIL'] = $email;

        //Обновляем пользователя
        userUpdate($userId, $updateFields);

        setFlashMessage('CREATE_SUCCESS', 'Пользователь успешно отредактирован');

        //Редирект на страницу списка пользователей
        redirectTo('/page_users.php');

    }

}

?>

