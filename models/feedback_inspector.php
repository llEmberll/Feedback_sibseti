<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/path.php";
require_once BASE_DIR . "/models/database_operator.php";

require_once BASE_DIR . "/models/form/username.php";
require_once BASE_DIR . "/models/form/email.php";
require_once BASE_DIR . "/models/form/date.php";
require_once BASE_DIR . "/models/form/text.php";

/*
 * Обработчик данных с формы обращения
 */

class FeedbackInspector {
    public string $message;
    public string $startCompanyDate = '2004-04-01';
    public string $commonError = "Извините, что-то пошло не так, вернитесь к нам, пожалуйста, позднее";

    private bool $debug;


    public function __construct(bool $debug) {
        $this->debug = $debug;
    }


    public function getForm($name, $email, $date, $text)
    {
        $name = new Username($name);
        $email = new Email($email);
        $date = new Date($date, $this->startCompanyDate);
        $text = new Text($text);
    
        return [
            'name' => $name,
            'email' => $email,
            'date' => $date,
            'text' => $text
        ];
    }
    
    
    public function formValidation($form)
    {
        foreach ($form as $key => $value) {
            if ($value->isValid == false) {
                return $value;
            }
            $form[$key] = $value->getValue();
        }
        return $form;
    }
    
    public function checkFieldsFilling($body, $expectedFields=['full_name', 'email', 'date', 'full_text']): array {
        $missingFields = [];
        foreach ($expectedFields as $field) {
            if (!(isset($body[$field]) && $body[$field] != false && strlen($body[$field]) > 0)) array_push($missingFields, $field);
        }
        return $missingFields;
    }
    
    
    public function inspection(array $data):array {
        try {
            $emptyFields = $this->checkFieldsFilling($data);
            if (count($emptyFields) < 1) {
                $form = $this->getForm($data['full_name'], $data['email'], $data['date'], $data['full_text']);
                $resValidation = $this->formValidation($form);
                if (is_array($resValidation)) {
                    if ($this->debug == false) {
                        $db = new DataBaseOperator();
                        $id = $db->addRecord('feedback', $resValidation);
                        if ($id) {
                            $this->message = "Спасибо за обратную связь!";
                            return ['success' => true, 'message' => $this->message];
                        } else {
                            $this->message = $this->commonError;;
                        }
                    } else {
                        $this->message = "Спасибо за обратную связь!";
                        return ['success' => true, 'message' => $this->message];
                    }

                } else {
                    $this->message = $resValidation->humanView . ": " . $resValidation->trouble;
                }
                return ['success' => false, 'message' => $this->message];
            }
            $this->message = "необходимо заполнить поле";

            return ['success' => false, 'message' => $this->message, 'emptyFields' => $emptyFields];
        } catch (Throwable $e) {
            $this->message = $this->commonError;
            return ['success' => false, 'message' => $this->message];
        }
    }
}