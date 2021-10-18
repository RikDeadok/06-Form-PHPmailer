<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/Exception.php';

    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->setLanguage('ru', 'phpmailer/language/');
    $mail->IsHTML(true);

    //от кого письмо
    $mail->setFrom('rikdeadok@gmail.com', 'Sergey Kovalenko');
    //Кому отправить
    $mail->addAddress('test@gmail.com');
    //Тема письма
    $mail->Subject = 'Приветствие';

    //пол
    $male = "мужчина";
    if ($_POST['male'] == "женщина")
        $male = "женщина";

    //Тело письма
    $body = '<h1>Встречайте супер письмо!</h1>';

    if (trim(!empty($_POST['name']))) {
        $body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
    }
    if (trim(!empty($_POST['email']))) {
        $body.='<p><strong>E-mail:</strong> '.$_POST['email'].'</p>';
    }
    if (trim(!empty($_POST['male']))) {
        $body.='<p><strong>Пол:</strong> '.$male.'</p>';
    }
    if (trim(!empty($_POST['age']))) {
        $body.='<p><strong>Возраст:</strong> '.$_POST['age'].'</p>';
    }
    if (trim(!empty($_POST['message']))) {
        $body.='<p><strong>Сообщение:</strong> '.$_POST['message'].'</p>';
    }

    //Прикрепить файл
    if (!empty($_FILES['image']['tmp_name'])) {
        //Путь загрузки файла
        $filePath = __DIR__ . "/files/" . $_FILES['image']['name'];
        //Грузим файл
        if (copy($_FILES['image']['tmp_name'], $filePath)) {
            $fileAttach = $filePath;
            $body.='<p><strong>Фото в приложении</strong></p>';
            $mail->addAttachment($fileAttach);
        }
    }

    $mail->Body = $body;

    //Отправляем
    if(!$mail->send()) {
        $message = "Ошибка";
    } else {
        $message = "Данные отправлены!";
    }

    $response = ['message' => $message];

    header('Content-type: application/json');
    echo json_encode($response);
?>