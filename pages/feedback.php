<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/path.php" ?>


<!-- Страница с обратной связью -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" http-equiv="Cache-Control" content="no-cache">
    <link rel="stylesheet" href="<?php echo BASE_STYLES ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Commissioner:wght@100;200;400&display=swap" rel="stylesheet">
    <title>Обратная связь</title>
</head>

<body>

<div class="header">

    <div class="container">

        <div class="header-line">
            <div class="header-text">

                <h4>
                    Заполните форму
                </h4>

            </div>


        </div>

        <form action="<?php echo FEEDBACK_REDIR ?>" method="POST">

            <input class="feedback-input" type="text" name="full_name" placeholder="ФИО" pattern="^[a-zA-ZА-Яа-яЁё\s]+$" maxlength="200">

            <input class="feedback-input" type="text" name="email" placeholder="E-mail для отправки ответа">

            <label for="call-date">Дата получения услуги:</label><br>
            <input class="feedback-input" id="call-date" type="date" min="2004-04-01" name="date">

            <input class="feedback-input" type="text" name="full_text" placeholder="Ваше обращение" pattern="^[0-9А-Яа-яЁё\s]+$" maxlength="2000">

            <button type="submit" class="submit-button">Отправить</button>

        </form>

        <!-- Подсветка полей, которые остались незаполненными -->

        <script>
            let formInputs = document.querySelectorAll('.feedback-input');
            let sendForm = document.querySelector('.submit-button');

            formInputs.forEach((s) => {
                sendForm.addEventListener('click', function() {
                    if(s.value == '') {
                        s.classList.add('req')
                    }
                })
            })
        </script>

    </div>

</div>

</body>
</html>