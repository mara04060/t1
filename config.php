<?php
return [
    "db"=>[
		 "host" => "localhost",
		 "db_name" => "banner_base",
         "db_username"=> "root",
         "db_password" => "root"],
	"bannerSetting"=>[
		 "bannerID" => 2,
		 "imagePath"=>"logo.png",
		 // Типы разрешенные для баннеропоказов
		 /**
		* Вывод изображений в одном из форматов
		* Mime type IMAGES
		image/gif: GIF(RFC 2045 и RFC 2046)
		image/jpeg: JPEG (RFC 2045 и RFC 2046)
		image/png: Portable Network Graphics[9](RFC 2083)
		image/svg+xml: SVG[10]
		image/tiff: TIFF(RFC 3302)
		image/vnd.wap.wbmp: WBMP
		image/webp: WebP
		*
		*Извините если забыл о каком либо...
		*
		*/

		 "mimeImageArrayAllowed" => [
			'image/gif','image/jpeg','image/png',
			'image/svg+xml','image/tiff',
			'image/vnd.wap.wbmp','image/webp'
		 ]
        ]
];