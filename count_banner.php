<?php

/**
Некий аналог контроллера 
Прочитаем значения счетчика в БД
это и будет количество вызовов
banner.php взятое из БД 
SELECT count FROM banner_table WHERE id=2
*/
//подгрузим конфиг где указаны параметры 
//соединения с БД и параметры баннера
$setting = (require_once ('config.php'))["db"];
// Распакуем массив в переменные
extract($setting);
require_once ('db.php');
//Создаем обект БД с доступом ТОЛЬКО к счетчику
// Доступны 2 метода - получить количество счетчика
// и записать +1 к количеству
$obj_pdo=new DataBasePDO();
print_r($obj_pdo);
//$count = $obj_pdo->getCounter($bannerID);
// Выведу вьюху (шаблон стрницы)
require_once('view.php');