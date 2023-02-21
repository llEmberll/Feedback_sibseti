<?php
require_once "form.php";


/*
 * Форма типа "адрес"
 */


class Email extends Form {
    public $value;


    public function __construct(string $email) {
        $this->humanView = 'Почта';
        $this->dbView = 'email';
        $this->description = "адрес электронной почты";
        $this->min = 8;
        $this->max = 64;
        $this->setValue($email);
        $this->validate();
    }


    public function getValue()
    {
        return $this->value;
    }


    public function setValue(string $new)
    {
        $this->value = trim($new);
        $this->validate();
    }


    public function validate():bool
    {
        $len = strlen($this->value);
        if ($len >= $this->min && $this->max >= $len) {
            if (preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/', $this->value)) {
                return $this->isValid = true;
            }
            else {
                $this->trouble = "некорректно указан адрес";
            }
        }
        else {
            $this->trouble = "неверная длина(от $this->min до $this->max символов)";
        }
        return $this->isValid = false;
    }
}