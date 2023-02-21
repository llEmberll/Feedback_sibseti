<?php
require_once "form.php";


/*
 * Форма типа "имя"
 */


class Username extends Form {
    public $value;


    public function __construct(string $username) {
        $this->humanView = 'Имя';
        $this->dbView = 'name';
        $this->description = "Кирилица, латиница и пробелы";
        $this->min = 10;
        $this->max = 128;
        $this->setValue($username);
        $this->validate();
    }


    public function getValue()
    {
        return $this->value;
    }


    public function setValue(string $new)
    {
        $this->value = $new;
        $this->validate();
    }


    public function validate():bool
    {
        $len = strlen($this->value);
        if ($len >= $this->min && $this->max >= $len) {
            if (preg_match('/^[a-zA-ZА-Яа-яЁё\s]+/', $this->value)) {
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