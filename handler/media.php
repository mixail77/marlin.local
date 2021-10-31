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

//Редактирование аватара пользователя
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    displayFlashClear();

    $arError = [];

    //Проверяем загружаемый файл
    if (empty($_FILES['photo']) || $_FILES['photo']['error'] != 0) {

        $arError[] = 'Выберите аватар';

    } else {

        //Тип файла
        $arExtension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $arType = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($arExtension, $arType)) {

            $arError[] = 'Неверный тип файла';

        }

    }

    //Если нет ошибок
    if (!empty($arError)) {

        setFlashMessage('MEDIA_ERROR', $arError);

    } else {

        //Добавляем новый файл + в реальной ситуации нужно сделать проверку на корректность добавления файла
        $photo = addPhoto($_FILES);

        //Удаляем старый файл пользователя + в реальной ситуации нужно сделать проверку на корректность удаления файла
        if (!empty($arUserProfileInfo['PHOTO'])) {

            deletePhoto($arUserProfileInfo['PHOTO']);

        }

        $updateProfileFields = [
            'PHOTO' => $photo,
        ];

        //Обновляем профиль пользователя
        userUpdateProfile($arUserInfo['PROFILE'], $updateProfileFields);

        setFlashMessage('CREATE_SUCCESS', 'Пользователь успешно отредактирован');

        //Редирект на страницу списка пользователей
        redirectTo('/page_users.php');

    }

}

?>

