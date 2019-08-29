<?php
//подгрузим конфиг где указаны параметры 
//соединения с БД и параметры баннера
$setting = (require_once ('config.php'))["bannerSetting"];
// Распакуем массив в переменные
extract($setting);


// Пока ошибок нет
$error=0;

// Корректный ли путь к файлу
if( !file_exists($imagePath) )
{
    $error=404;
}

/// Картинка ли?
if( ! exif_imagetype($imagePath) || $error==404)
{
    $error=404;
}

if($error!=404) {
    //Если картинка то Читаем ее mime тип
    $imageInfoArray = getimagesize($imagePath);

    // Надо ли ее выводить вообще?
    if(in_array( $imageInfoArray['mime'], $mimeImageArrayAllowed ))
    {

//        // Определим ее размер и прочие параметры
//        $sizeImage = filesize($imagePath);
//        /// Получим дату последней модификации файла
//        $dateModefine = filemtime($imagePath);
//
//
//        // Отдадим все хедеры и картинку
//		/*
//		 * Подсмотрим хедеры отдаваемые браузером
//		 * для изображения
//		HTTP/1.1 200 OK
//		Server: nginx
//		Date: Wed, 28 Aug 2019 18:03:46 GMT
//		Content-Type: image/png
//		Content-Length: 2371
//		Last-Modified: Sun, 16 Jul 2017 20:30:51 GMT
//		Connection: keep-alive
//		ETag: "596bccfb-943"
//		Expires: Sat, 28 Sep 2019 18:03:46 GMT
//		Cache-Control: max-age=2678400
//		Accept-Ranges: bytes
//		 */
//        /// Генерим размер байт картинки
//        header("Content-Length: ".$sizeImage."" );
//
//        /// Генерируем в хедере в зависимости от картинки ее mime type
//        header ("Content-Type:".$imageInfoArray['mime']."");
//
//        /// Дату сформирует правильно настроенный сервер
//        //header("Date: ".gmdate("D, j M Y H:i:s T", time()));
//
//        //  Кешировать и срок кеширвоания картинки статические ОБЯЗАТЕЛЬНО!!!
//        // хотябы на месяц
//        // Средний месяц  30*24*60*60 = 2592000 сек
//        header("Cache-Control: max-age=2592000");
//        //  Дата последней модификации файла , а не скрипта
//        header("Last-Modified: ".gmdate("D, j M Y H:i:s T", $dateModefine ));
//        //  Уникальный тег для проверки кеша сервера на актуальность
//        //  Оказывается ETags в заголовке HTTP не является обязательным
//        //    как правильно генерить не указано , зато сказано только не
//        //  CRC32 и CRC64, поэтому сформировал из 2х частей md5 от Даты модификации,
//        // и ширина+высота изображения  выбирая только числа
//        header("ETag: ".sprintf("\"%d-%d\"", md5($dateModefine), ($imageInfoArray[0]+$imageInfoArray[1]) ));
//
//        /// Выведем само тело изображения
//        readfile($imagePath);



        require_once("db.php");

        //Запишем +1 вызов баннера в БД
        $obj_pdo=new DataBasePDO();
        $obj_pdo->addCount($bannerID);
        

    }
}







