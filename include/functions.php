<?php

//Подключение к базе
function dbConnect()
{

    return new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASSWORD);

}

//Ищем пользователя по ID
function getUserByID($userId)
{

    if (!empty($userId)) {

        $pdo = dbConnect();

        $stmt = $pdo->prepare('SELECT * FROM `user` WHERE `ID` = :ID');
        $stmt->execute(
            [
                'ID' => $userId,
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

                //Данные авторизованного пользователя
                $_SESSION['USER']['ID'] = $arUser['ID'];
                $_SESSION['USER']['EMAIL'] = $arUser['EMAIL'];
                $_SESSION['USER']['PROFILE'] = array_shift(getUserProfileById($arUser['PROFILE']));
                $_SESSION['USER']['SOCIAL'] = array_shift(getUserSocialById($arUser['SOCIAL']));
                $_SESSION['USER']['STATUS'] = array_shift(getUserStatusById($arUser['STATUS']));
                $_SESSION['USER']['ROLE'] = array_shift(getUserRoleById($arUser['ROLE']));

                setFlashMessage('LOGIN_SUCCESS', 'Вы успешно авторизованы');

                //Редирект на страницу пользователей
                redirectTo('/page_users.php');

                return true;

            }

        }

    }

    setFlashMessage('LOGIN_ERROR', 'Неверный логин или пароль');

    return false;

}

//Добавляем пользователя
function userAdd($email, $password, $status = USER_STATUS)
{

    if (!empty($email) && !empty($password)) {

        $pdo = dbConnect();

        $stmt = $pdo->prepare('INSERT INTO `user` SET `EMAIL` = :EMAIL, `PASSWORD` = :PASSWORD, `STATUS` = :STATUS, `ROLE` = :ROLE');
        $stmt->execute(
            [
                'EMAIL' => $email,
                'PASSWORD' => $password,
                'STATUS' => $status,
                'ROLE' => USER_ROLE, //Роль по умолчанию
            ]
        );

        $userId = $pdo->lastInsertId();

        //Проверяем
        if (!empty($userId)) {

            return $userId;

        }

    }

    return false;

}

//Добавляем пользователю чистый профиль при регистрации
function userAddProfile($userId)
{

    if (!empty($userId)) {

        $pdo = dbConnect();

        $stmt = $pdo->prepare('INSERT INTO `user_profile` SET `USER_ID` = :USER_ID, `NAME` = :NAME, `LAST_NAME` = :LAST_NAME, `SECOND_NAME` = :SECOND_NAME, `PHONE` = :PHONE, `ADDRESS` = :ADDRESS, `JOB` = :JOB, `PHOTO` = :PHOTO');
        $stmt->execute(
            [
                'USER_ID' => $userId,
                'NAME' => USER_NAME,
                'LAST_NAME' => USER_LAST_NAME,
                'SECOND_NAME' => USER_SECOND_NAME,
                'PHONE' => USER_PHONE,
                'ADDRESS' => USER_ADDRESS,
                'JOB' => USER_JOB,
                'PHOTO' => USER_PHOTO,
            ]
        );

        $profileId = $pdo->lastInsertId();

        if (!empty($profileId)) {

            if (userUpdate($userId, ['PROFILE' => $profileId])) {

                return $profileId;

            }

        }

    }

    return false;

}

//Добавляем пользователю чистые соцсети при регистрации
function userAddSocial($userId)
{

    if (!empty($userId)) {

        $pdo = dbConnect();

        $stmt = $pdo->prepare('INSERT INTO `user_social` SET `USER_ID` = :USER_ID, `VK` = :VK, `INSTAGRAM` = :INSTAGRAM, `TELEGRAM` = :TELEGRAM');
        $stmt->execute(
            [
                'USER_ID' => $userId,
                'VK' => USER_VK,
                'INSTAGRAM' => USER_INSTAGRAM,
                'TELEGRAM' => USER_TELEGRAM,
            ]
        );

        $socialId = $pdo->lastInsertId();

        if (!empty($socialId)) {

            if (userUpdate($userId, ['SOCIAL' => $socialId])) {

                return $socialId;

            }

        }

    }

    return false;

}

//Обновляем пользователя
function userUpdate($userId, $updateFields)
{

    if (!empty($userId) && !empty($updateFields)) {

        $arExecute = array_merge($updateFields, ['ID' => $userId]);

        //Подготавливаем строку запроса
        $sqlSet = '';

        foreach ($updateFields as $key => $field) {

            $sqlSet .= '`' . $key . '` = :' . $key . ',';

        }

        $sqlSet = trim($sqlSet, ',');

        if (!empty($sqlSet)) {

            $pdo = dbConnect();

            $stmt = $pdo->prepare('UPDATE `user` SET ' . $sqlSet . ' WHERE `ID` = :ID');
            $stmt->execute($arExecute);

            if ($stmt->rowCount()) {

                return true;

            }

        }

    }

    return false;

}

//Обновляем профиль пользователя
function userUpdateProfile($profileId, $updateFields)
{

    if (!empty($profileId) && !empty($updateFields)) {

        $arExecute = array_merge($updateFields, ['ID' => $profileId]);

        //Подготавливаем строку запроса
        $sqlSet = '';

        foreach ($updateFields as $key => $field) {

            $sqlSet .= '`' . $key . '` = :' . $key . ',';

        }

        $sqlSet = trim($sqlSet, ',');

        if (!empty($sqlSet)) {

            $pdo = dbConnect();

            $stmt = $pdo->prepare('UPDATE `user_profile` SET ' . $sqlSet . ' WHERE `ID` = :ID');
            $stmt->execute($arExecute);

            if ($stmt->rowCount()) {

                return true;

            }

        }

    }

    return false;

}

//Обновляем соцсети пользователя
function userUpdateSocial($socialId, $updateFields)
{

    if (!empty($socialId) && !empty($updateFields)) {

        $arExecute = array_merge($updateFields, ['ID' => $socialId]);

        //Подготавливаем строку запроса
        $sqlSet = '';

        foreach ($updateFields as $key => $field) {

            $sqlSet .= '`' . $key . '` = :' . $key . ',';

        }

        $sqlSet = trim($sqlSet, ',');

        if (!empty($sqlSet)) {

            $pdo = dbConnect();

            $stmt = $pdo->prepare('UPDATE `user_social` SET ' . $sqlSet . ' WHERE `ID` = :ID');
            $stmt->execute($arExecute);

            if ($stmt->rowCount()) {

                return true;

            }

        }

    }

    return false;

}

//Получаем профили пользователя по ID
function getUserProfileById($profileId)
{

    if (is_array($profileId)) {

        $arId = $profileId;

    } else {

        $arId[] = $profileId;

    }

    $inList = str_repeat('?,', count($arId) - 1) . '?';

    $pdo = dbConnect();

    $stmt = $pdo->prepare('SELECT * FROM `user_profile` WHERE `ID` IN (' . $inList . ')');
    $stmt->execute($arId);

    $arRes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($arRes as $value) {

        $arResult[$value['ID']] = $value;

    }

    //Проверяем
    if (!empty($arResult)) {

        return $arResult;

    }

    return false;

}

//Получаем соцсети пользователя по ID
function getUserSocialById($socialId)
{

    if (is_array($socialId)) {

        $arId = $socialId;

    } else {

        $arId[] = $socialId;

    }

    $inList = str_repeat('?,', count($arId) - 1) . '?';

    $pdo = dbConnect();

    $stmt = $pdo->prepare('SELECT * FROM `user_social` WHERE `ID` IN (' . $inList . ')');
    $stmt->execute($arId);

    $arRes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($arRes as $value) {

        $arResult[$value['ID']] = $value;

    }

    //Проверяем
    if (!empty($arResult)) {

        return $arResult;

    }

    return false;

}

//Получаем статус пользователя по ID
function getUserStatusById($statusId)
{

    if (is_array($statusId)) {

        $arId = $statusId;

    } else {

        $arId[] = $statusId;

    }

    $inList = str_repeat('?,', count($arId) - 1) . '?';

    $pdo = dbConnect();

    $stmt = $pdo->prepare('SELECT * FROM `status` WHERE `ID` IN (' . $inList . ')');
    $stmt->execute($arId);

    $arRes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($arRes as $value) {

        $arResult[$value['ID']] = $value;

    }

    //Проверяем
    if (!empty($arResult)) {

        return $arResult;

    }

    return false;

}

//Получаем роль пользователя по ID
function getUserRoleById($roleId)
{

    if (is_array($roleId)) {

        $arId = $roleId;

    } else {

        $arId[] = $roleId;

    }

    $inList = str_repeat('?,', count($arId) - 1) . '?';

    $pdo = dbConnect();

    $stmt = $pdo->prepare('SELECT * FROM `role` WHERE `ID` IN (' . $inList . ')');
    $stmt->execute($arId);

    $arRes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($arRes as $value) {

        $arResult[$value['ID']] = $value;

    }

    //Проверяем
    if (!empty($arResult)) {

        return $arResult;

    }

    return false;

}


//Получаем список пользователей
function getUserListAll()
{

    $pdo = dbConnect();

    $stmt = $pdo->prepare('SELECT * FROM `user` ORDER BY `ID` DESC');
    $stmt->execute();

    $arRes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($arRes as $value) {

        $arResult[$value['ID']] = $value;

    }

    //Проверяем
    if (!empty($arResult)) {

        return $arResult;

    }

    return false;

}


//Получаем список статусов
function getStatusListAll()
{

    $pdo = dbConnect();

    $stmt = $pdo->prepare('SELECT * FROM `status` ORDER BY `ID` DESC');
    $stmt->execute();

    $arRes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($arRes as $value) {

        $arResult[$value['ID']] = $value;

    }

    //Проверяем
    if (!empty($arResult)) {

        return $arResult;

    }

    return false;

}

//Получаем список ролей
function getRoleListAll()
{

    $pdo = dbConnect();

    $stmt = $pdo->prepare('SELECT * FROM `role` ORDER BY `ID` DESC');
    $stmt->execute();

    $arRes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($arRes as $value) {

        $arResult[$value['ID']] = $value;

    }

    //Проверяем
    if (!empty($arResult)) {

        return $arResult;

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

    unset($_SESSION['MESSAGE']);

}

//Проверяем авторизацию пользователя
function isAuthorize()
{

    if (!empty($_SESSION['USER']['ID'])) {

        return true;

    }

    return false;

}

//Проверяем администратора
function isAdmin()
{

    if ($_SESSION['USER']['ROLE']['CODE'] == 'admin') {

        return true;

    }

    return false;

}

//Проверяем текущего пользователя и редактируемый профиль
function isMyProfile($userId)
{

    if ($_SESSION['USER']['ID'] == $userId) {

        return true;

    }

    return false;

}

//Выход пользователя
function logout()
{

    unset($_SESSION['USER']);
    redirectTo();

}

//Загружает фотографию пользователя
function addPhoto($arFiles)
{

    if (!empty($arFiles)) {

        $name = mb_strtolower(mt_rand(0, 10000) . $arFiles['photo']['name']);
        $path = 'upload/photo/' . $name;
        copy($arFiles['photo']['tmp_name'], $path);

        return $path;

    }

    return false;

}

//Редирект на страницу
function redirectTo($page = PAGE_LOGIN)
{

    header('Location:' . $page);

}

?>