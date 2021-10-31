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

//Получаем информацию о профиле пользователя
$arUserProfileInfo = array_shift(getUserProfileById($arUserInfo['PROFILE']));

//Редактирование профиля пользователя
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    displayFlashClear();

    $arError = [];

    $name = trim(strip_tags($_POST['name']));
    $job = trim(strip_tags($_POST['job']));
    $phone = trim(strip_tags($_POST['phone']));
    $address = trim(strip_tags($_POST['address']));

    //Проверяем имя
    if (empty($name)) {

        $arError[] = 'Введите Имя пользователя';

    }

    //Проверяем место работы
    if (empty($job)) {

        $arError[] = 'Введите Место работы пользователя';

    }

    //Проверяем телефон
    if (empty($phone)) {

        $arError[] = 'Введите Телефон пользователя';

    }

    //Проверяем адрес
    if (empty($address)) {

        $arError[] = 'Введите Адрес пользователя';

    }

    //Если нет ошибок
    if (!empty($arError)) {

        setFlashMessage('EDIT_ERROR', $arError);

    } else {

        $updateProfileFields = [
            'NAME' => $name,
            'LAST_NAME' => '',
            'SECOND_NAME' => '',
            'PHONE' => $phone,
            'ADDRESS' => $address,
            'JOB' => $job,
        ];

        //Обновляем профиль пользователя
        userUpdateProfile($arUserInfo['PROFILE'], $updateProfileFields);

        setFlashMessage('CREATE_SUCCESS', 'Пользователь успешно отредактирован');

        //Редирект на страницу списка пользователей
        redirectTo('/page_users.php');

    }

}

?>

