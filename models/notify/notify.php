<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/path.php';


/*
 * Абстрактный класс для уведомлений
 * необходимо реализовать способ создания и удаления
 */


abstract class Notify
{
    public string $text;
    public string $imageSrc;

    abstract public function create();
    abstract protected function delete();

}
