<?php

/*
 * Абстрактный класс для форм
 * необходимо реализовать способ внутренней
 * валидации
 */


abstract class Form
{
    public $isValid = false;

    protected $value;
    public $humanView;
    public $dbView;
    public $description;
    public string $trouble;
    protected int $min;
    protected int $max;


    abstract public function validate();
    abstract protected function setValue(string $new);
    abstract protected function getValue();

    public function getDescription() {
        return $this->description;
    }

    public function getTrouble() {
        return $this->trouble;
    }
}