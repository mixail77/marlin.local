<?php

//Проверяем авторизацию пользователя
if (!isAuthorize()) {

    redirectTo('/page_login.php');

}

//Список пользователей
$arUserList = getUserListAll();

//Получаем список статусов
$arStatusList = getStatusListAll();

//Получаем список ролей
$arRoleList = getRoleListAll();

//Профили пользователей
$arUserProfileList = getUserProfileById(array_column($arUserList, 'PROFILE'));

//Соцсети пользователей
$arUserSocialList = getUserSocialById(array_column($arUserList, 'SOCIAL'));

?>

