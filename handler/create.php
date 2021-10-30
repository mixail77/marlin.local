<?php

//Проверяем авторизацию пользователя
isAuthorize();

//Список статусов
$arStatusList = getStatusListAll();

//Регистрация пользователя
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    displayFlashClear();

    $arError = [];

    $name = trim(strip_tags($_POST['name']));
    $job = trim(strip_tags($_POST['job']));
    $phone = trim(strip_tags($_POST['phone']));
    $address = trim(strip_tags($_POST['address']));
    $email = trim(strip_tags($_POST['email']));
    $password = trim(strip_tags($_POST['password']));
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $status = trim(strip_tags($_POST['status']));
    $vk = trim(strip_tags($_POST['vk']));
    $telegram = trim(strip_tags($_POST['telegram']));
    $instagram = trim(strip_tags($_POST['instagram']));

    //Проверяем E-mail
    if (empty($email)) {

        $arError[] = 'Введите ваш E-mail';

    } else {

        //Ищем пользователя
        $arUser = getUserByEmail($email);

        if (!empty($arUser)) {

            $arError[] = 'Пользователь с таким E-mail адресом уже зарегистрирован';

        }

    }

    //Проверяем пароль
    if (empty($password)) {

        $arError[] = 'Введите ваш пароль';

    }

    //Проверяем загружаемый файл
    if (empty($_FILES['photo']) || $_FILES['photo']['error'] != 0) {

        $arError[] = 'Выберите аватар1';

    } else {

        //Тип файла
        $arExtension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $arType = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($arExtension, $arType)) {

            $arError[] = 'Недопустимый тип файла';

        }

    }

    //Нет ошибок
    if (!empty($arError)) {

        setFlashMessage('CREATE_ERROR', $arError);

    } else {

        $userId = userAdd($email, $password, $status, 'create');

        if (!empty($userId)) {

            $userFields = getUserByID($userId);

            $updateProfileFields = [
                'NAME' => $name,
                'LAST_NAME' => '',
                'SECOND_NAME' => '',
                'PHONE' => $phone,
                'ADDRESS' => $address,
                'JOB' => $job,
                'PHOTO' => addPhoto($_FILES),
            ];

            $updateSocialFields = [
                'VK' => $vk,
                'INSTAGRAM' => $telegram,
                'TELEGRAM' => $instagram,
            ];

            userUpdateProfile($userFields['PROFILE'], $updateProfileFields);
            userUpdateSocial($userFields['SOCIAL'], $updateSocialFields);

            setFlashMessage('CREATE_SUCCESS', 'Пользователь успешно добавлен');

            //Редирект на страницу авторизации
            redirectTo('/users.php');

        }

    }

}

?>
