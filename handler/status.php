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

//Получаем список статусов
$arStatusList = getStatusListAll();

//Редактирование статуса пользователя
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    displayFlashClear();

    $arError = [];

    $status = trim(strip_tags($_POST['status']));

    //Проверяем статус
    if (empty($status)) {

        $arError[] = 'Выберите статус пользователя';

    }

    //Если нет ошибок
    if (!empty($arError)) {

        setFlashMessage('STATUS_ERROR', $arError);

    } else {

        $updateFields = [
            'STATUS' => $status,
        ];

        //Обновляем пользователя
        userUpdate($userId, $updateFields);

        setFlashMessage('CREATE_SUCCESS', 'Пользователь успешно отредактирован');

        //Редирект на страницу списка пользователей
        redirectTo('/page_users.php');

    }

}

?>

