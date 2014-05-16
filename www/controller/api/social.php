<?php

$adapterConfigs = array(
    'vk' => array(
        'client_id' => '3784783',
        'client_secret' => 'P2FiEq6KUWVcPRB8JkDZ',
        'redirect_uri' => 'http://www.stepcloud.ru/vkgdt?provider=vk'
    ),
    'yandex' => array(
        'client_id' => 'f0e239a30c624aa1b698590f3c9a65e5',
        'client_secret' => '23097e253b4d4b1b9899c860c5641b06',
        'redirect_uri' => 'http://www.stepcloud.ru/vkgdt?provider=yandex'
    ),
    'facebook' => array(
        'client_id' => '596731827032744',
        'client_secret' => '8d4bc6480880be66d49fb3fc1e4676c5',
        'redirect_uri' => 'http://www.stepcloud.ru/vkgdt?provider=facebook'
    )
);

$provider = $_GET['provider'];
$sett = "SocialAuther\Adapter\\$provider";

// создание адаптера и передача настроек
$Adapter = new $sett($adapterConfigs[$provider]);

// передача адаптера в SocialAuther
$auther = new SocialAuther\SocialAuther($Adapter);

if (!isset($_GET['code'])) {
//    echo '<p><a href="' . $Adapter->getAuthUrl() . '">Аутентификация через ВКонтакте</a></p>';
    header("Location: " . $Adapter->getAuthUrl());
}


if (isset($_GET['code'])) {
    if ($auther->authenticate()) {
        /* if (!is_null($auther->getSocialId()))
          echo "Социальный ID пользователя: " . $auther->getSocialId() . '<br />';

          if (!is_null($auther->getName()))
          echo "Имя пользователя: " . $auther->getName() . '<br />';

          if (!is_null($auther->getEmail()))
          echo "Email пользователя: " . $auther->getEmail() . '<br />';

          if (!is_null($auther->getSocialPage()))
          echo "Ссылка на профиль пользователя: " . $auther->getSocialPage() . '<br />';

          if (!is_null($auther->getSex()))
          echo "Пол пользователя: " . $auther->getSex() . '<br />';

          if (!is_null($auther->getBirthday()))
          echo "День Рождения: " . $auther->getBirthday() . '<br />';

          // аватар пользователя
          if (!is_null($auther->getAvatar()))
          echo '<img src="' . $auther->getAvatar() . '" />'; echo "<br />";
         */

        $social_id = $auther->getSocialId();
        $name = $auther->getName();
        $email = $auther->getEmail();
        $social_page = $auther->getSocialPage();
        $sex = ($auther->getSex() === 'male') ? 1 : 0;
        $birthday = date('Y-m-d', strtotime($auther->getBirthday()));
        $avatar = $auther->getAvatar();

        $qs = Core::getConnect()->prepare("SELECT * FROM sys_users WHERE provider = :provider AND social_id = :social_id");
        $qs->bindValue(':provider', $provider);
        $qs->bindValue(':social_id', $social_id);
        $qs->execute();
        if ($row = $qs->fetch()) { //если получена одна строка
            /*
              echo "пользователь в базе уже существует";
              echo "<pre>";
              print_r($row);
              echo "</pre>";
             */

            $model = new users_Model();
            $model->orm_data = array(
                'id' => $row['id'],
                'provider' => $row['provider'],
                'social_id' => $row['social_id'],
                'name' => $row['name'],
                'email' => $row['email'],
                'social_page' => $row['social_page'],
                'sex' => ($row['sex'] === 'male') ? 1 : 0,
                'birthday' => date('Y-m-d', strtotime($row['birthday'])),
                'avatar' => $row['avatar'],
                'login' => $social_id,
            );
            $model->update();
            $model->save();

            if (!isset($_SESSION['id'])) session_start();
			
            $_SESSION['id'] = $row['id'];
        } else {

            $model = new users_Model();
            $model->orm_data = array(
                'provider' => $provider,
                'social_id' => $social_id,
                'name' => $name,
                'email' => $email,
                'social_page' => $social_page,
                'sex' => ($sex === 'male') ? 1 : 0,
                'birthday' => date('Y-m-d', strtotime($birthday)),
                'avatar' => $avatar,
                'login' => $social_id,
            );
            $model->insert();
            $model->save();



            $qs = Core::getConnect()->prepare("SELECT * FROM sys_users WHERE provider = :provider AND social_id = :social_id");
            $qs->bindValue(':provider', $provider);
            $qs->bindValue(':social_id', $social_id);
            $qs->execute();
            if ($row = $qs->fetch()) { //если получена одна строка
                if (!isset($_SESSION['id'])) session_start();
                $_SESSION['id'] = $row['id'];
            }
        }


//echo $_SESSION['id'];
        $this->header();
    }
}
?>						