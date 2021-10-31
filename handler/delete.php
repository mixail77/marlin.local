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

//Получаем данные удаляемого пользователя
$arUserInfo = getUserByID($userId);

//Пользователь не существует
if (empty($arUserInfo)) {

    redirectTo('/page_users.php');

}

//Получаем информацию о профиле пользователя
$arUserProfileInfo = array_shift(getUserProfileById($arUserInfo['PROFILE']));

//Удаляем пользователя
userDeleteProfile($arUserInfo['PROFILE']);
userDeleteSocial($arUserInfo['SOCIAL']);
deletePhoto($arUserProfileInfo['PHOTO']);
deleteUser($userId);

//Если удалил себя самого
if (isMyProfile($userId)) {

    redirectTo('/page_logout.php');

} else {

    setFlashMessage('CREATE_SUCCESS', 'Пользователь успешно удален');

    //Редирект на страницу списка пользователей
    redirectTo('/page_users.php');

}

?>

