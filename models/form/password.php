<?php
require_once "form.php";


/*
 * Форма типа "пароль"
 */


class Password extends Form {
    public $value;
    public $hashed;


    public function __construct(string $password) {
        $this->humanView = 'Пароль';
        $this->dbView = 'password';
        $this->description = "буквы, цифры и нижнее подчеркивание";
        $this->min = 8;
        $this->max = 40;
        $this->setValue($password);
        $this->validate();
    }


    public function getValue()
    {
        return $this->hashed;
    }


    public function setValue(string $new)
    {
        $this->value = trim($new);
        $this->hashed = password_hash(trim($new), PASSWORD_DEFAULT);
        $this->validate();
    }


    public function validate():bool
    {
        $len = strlen($this->value);
        if ($len >= $this->min && $this->max >= $len) {
            if (preg_match('/^[a-zA-Z0-9_]+$/', $this->value)) {
                return $this->isValid = true;
            }
            else {
                $this->trouble = "недопустимые символы";
            }
        }
        else {
            $this->trouble = "неверная длина(от $this->min до $this->max символов)";
        }
        return $this->isValid = false;
    }
}