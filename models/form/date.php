<?php
require_once "form.php";


/*
 * Форма типа "дата"
 */


class Date extends Form {
    public $value;
    public $to;
    public $from;


    public function __construct(string $date, $from, $to=null) {
        if ($to == null) $to = date('Y-m-d H:i:s');
        $this->to = $to;
        $this->from = $from;

        $this->humanView = 'Дата';
        $this->dbView = 'date';
        $this->description = "дата формата 2023-02-20";

        $this->min = 9;
        $this->max = 11;

        $this->setValue($date);
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
            if (preg_match('/^2[0-9]{3}-[01]{1}[0-9]{1}-[0-3]{1}[0-9]{1}/', $this->value)) {
                return $this->isValid = true;
            }
            else {
                $this->trouble = "недопустимые символы";
            }
        }
        else {
            $this->trouble = "неверный формат даты";
        }
        return $this->isValid = false;
    }
}