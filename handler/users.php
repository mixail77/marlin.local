<?php

//Проверяем авторизацию пользователя
if (!isAuthorize()) {

    redirectTo('/page_login.php');

}

//Список пользователей
$arUserList = getUserListAll();

//Список статусов
$arStatusList = getStatusListAll();

//Список ролей
$arRoleList = getRoleListAll();

//Профили пользователей
$arUserProfileList = getUserProfileById(array_column($arUserList, 'PROFILE'));

//Соцсети пользователей
$arUserSocialList = getUserSocialById(array_column($arUserList, 'SOCIAL'));

?>

