<?php
require_once "form.php";


/*
 * Форма типа "текст"
 */


class Text extends Form {
    public $value;


    public function __construct(string $text) {
        $this->humanView = 'Текст';
        $this->dbView = 'text';
        $this->description = "Кирилица, цифры, дефиз, тире, подчеркивания, пробельные символы";
        $this->min = 1;
        $this->max = 2000;
        $this->setValue($text);
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
            if (preg_match('/^[-_0-9А-Яа-яЁё\s]+/', $this->value)) {
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