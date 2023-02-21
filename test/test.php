<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/path.php";


/*
 * Юнит тест
 */


class Test
{
    public string $trouble = "";


    public function testAddDBRecord():bool {
        try {
            require_once BASE_DIR . "/models/database_operator.php";
            $db = new DataBaseOperator();

            $table = 'feedback';

            $addResponse = $db->addRecord($table,
                [
                    'name' => "Test Name",
                    'email' => "test.k1@mail.ru",
                    'date' => date('Y-m-d H:i:s'),
                    'text' => "Тест Тест 1 тЕст2 теСт 3 тесТ4"]);

            $typeAddResponse = gettype($addResponse);
            if ($typeAddResponse == "integer" || $typeAddResponse == "string") {
                $delResponse = $db->deleteRecords($table, ['id' => $addResponse]);
                if ($delResponse === 1) {
                    return true;
                }
                    $this->trouble = "Не удалось удалить тестовую запись, ожидалось 1, получили $delResponse";
            }
            else {
                $this->trouble = "Не удалось добавить тестовую запись, ожидался id новой записи(integer/string), получили $addResponse($typeAddResponse)";
            }

        } catch (Throwable $e) {
            $this->trouble = "При выполнении теста добавления в базу записи произошла непредвиденная ошибка: \n$e";
        }
        return false;
    }

    public function testSuccessSendFeedback():bool {
        require_once BASE_DIR . "/models/feedback_inspector.php";
        $inspector = new FeedbackInspector(true);
        $testForm = [
            'full_name' => "ТЕСт Test Тестович",
            'email' => "test.t@mail.ru",
            'date' => '2023-02-01',
            'full_text' => "Тестовый текст  1 Текст тестовый2"
        ];

        $resInspection = $inspector->inspection($testForm);
        if ($resInspection['success'] && $resInspection['message'] == "Спасибо за обратную связь!") return true;
        else {
            $this->trouble = $resInspection['message'];
            return false;
        }

    }

    public  function testEmptyFieldsSendFeedback():bool {
        require_once BASE_DIR . "/models/feedback_inspector.php";
        $inspector = new FeedbackInspector(true);
        $testForm = [
            'email' => "test.t@mail.ru",
            'date' => "",
            'full_text' => "Тестовый текст  1 Текст тестовый2"
        ];

        $resInspection = $inspector->inspection($testForm);
        if (!$resInspection['success'] && $resInspection['message'] == "необходимо заполнить поле" && isset($resInspection['emptyFields'])) {
            if ($resInspection['emptyFields'] == ['full_name', 'date']) return true;
        }
        $this->trouble = $resInspection['message'];
        return false;
    }


    public function testErrorServerResponse():bool {
        $_POST = null;
        $oldDBConfigName = BASE_DIR . "/db_config.php";
        $newDBConfigName = BASE_DIR . "/db0_config.php";

        $rn = rename($oldDBConfigName, $newDBConfigName);

        require_once BASE_DIR . "/models/feedback_inspector.php";
        $inspector = new FeedbackInspector(false);

        if ($rn) {
            $expectedError = $inspector->inspection([
                'full_name' => "ТЕСт Test Тестович",
                'email' => "test.t@mail.ru",
                'date' => '2023-02-01',
                'full_text' => "Тестовый текст  1 Текст тестовый2"
            ]);
            $rn = rename($newDBConfigName, $oldDBConfigName);

            if (!$expectedError['success'] && $expectedError['message'] == $inspector->commonError) return true;
            $this->trouble = $inspector->message;
            return false;
        }
        else {
            $this->trouble = "Не удалось переименовать файл $oldDBConfigName";
            return false;
        }
    }


    public function testAllCases():array {
        $commonResult = [
            'Добавление записи в базу данных' => ['success' => false, 'trouble' => ""],
            'Успешный фидбек' => ['success' => false, 'trouble' => ""],
            'Незаполненные поля' => ['success' => false, 'trouble' => ""],
            'Ошибка сервера' => ['success' => false, 'trouble' => ""]
            ];
        $resAddRecordTest = $this->testAddDBRecord();
        $commonResult['Добавление записи в базу данных']['success'] = $resAddRecordTest; $commonResult['Добавление записи в базу данных']['trouble'] = $this->trouble;

        $resSuccessSendFeedback = $this->testSuccessSendFeedback();
        $commonResult['Успешный фидбек']['success'] = $resSuccessSendFeedback; $commonResult['Успешный фидбек']['trouble'] = $this->trouble;

        $resEmptyFieldsSendFeedback = $this->testEmptyFieldsSendFeedback();
        $commonResult['Незаполненные поля']['success'] = $resEmptyFieldsSendFeedback; $commonResult['Незаполненные поля']['trouble'] = $this->trouble;

        $resErrorServerResponse = $this->testErrorServerResponse();
        $commonResult['Ошибка сервера']['success'] = $resErrorServerResponse; $commonResult['Ошибка сервера']['trouble'] = $this->trouble;

        return $commonResult;
    }
}