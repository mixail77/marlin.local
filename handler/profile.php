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

//Получаем информацию о соцсетях пользователя
$arUserSocialInfo = array_shift(getUserSocialById($arUserInfo['SOCIAL']));

?>

