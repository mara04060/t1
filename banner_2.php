<?
/**
* Применим ООП подход
* Подключаемся к хранилищу и получаем из БД данные о баннере
* и его размещении файла
* Работаем со счетчиком добавляя за каждый вызов +1 в БД
* В момент добавление бннера в Хранилище необходимо будет парсить
* его mime, size modefine для того чтобы скрипты быстрее рботали 
* и не парсили файл бннера многократно при вызове 
*/

class Banner
{
	// свойства баннера и идентификатор для ведения статистики
	private $bannerId;
    public $size;
    public $mime;
    public $modefine;
	
	// Создаем баннер со всеми его параметрами
    public function __construct($size, $mime, $modefine, $bannerId) {
        $this->size = $size;
        $this->mime = $mime;
        $this->modefine = $modefine;
		$this->bannerId = $bannerId;
    }

    public function getBannerId() {
        return $this->bannerId;
    }
}


// Нам необходимо вне зависимости от хранилища
// иметь ВСЕГДА метод findID - чтобы вынуть наш баннер и 
// метод updID - чтобы добавить +1 к счетчику 
// Потом возможно будут меняться места хранения к данным
// учтем и такой подход
abstract class BannerRepository
{
    abstract public function findID();
	abstract public function updID();
}





class mysqlRepository extends Repository
{
    private $file;
	private $db;
	private $bannerId;

    public function __construct($file) {
		
        $this->file = $file;
    }
	
	public settingFile(){
		// распарсим файл с нстройками к БД
		// объект с ключами настроек БД
		$rows = simplexml_load_file($this->file);
		$settinds=[];
		foreach ($rows->settinds as $row) {
             $banners[] = new Banner($row->host, $row->password, $row->modefine);
        }
        return $banners;
	}
	public function dataBase(){
		if(!is_object($db))
        {
            $db = new PDO('mysql:host=localhost;dbname=banner_base', $user, $pass);
            ///Исключения не генерим , они будут только мешать выводу картинки
        }
        if(is_object($db)){
			
			$sql="UPDATE `banner_table` SET `count`=`count` + 1 WHERE id=?";
			//Когда соединение установлено , то просто выполним добавление +1 к количеству счетчика
            $db->prepare($sql)->execute($bannerId);
        }
	}
    public function findAll() {
        $rows = simplexml_load_file($this->file);
        $banners = [];
        foreach ($rows->banners as $row) {
            $banners[] = new Banner($row->size, $row->mime, $row->modefine);
        }
        return $banners;
    }
}











if ($type = 'mysql') {
    $bannerRepository = new mysqlRepository($db);
} else {
    $bannerRepository = new XMLRepository('setting.xml');
}


$banners = $bannerRepository->findAll();






		/// Генерим размер байт картинки
        header("Content-Length: ".$sizeImage."" );

        /// Генерируем в хедере в зависимости от картинки ее mime type
        header ("Content-Type:".$imageInfoArray['mime']."");

        /// Дату сформирует правильно настроенный сервер
        //header("Date: ".gmdate("D, j M Y H:i:s T", time()));

        //  Кешировать и срок кеширвоания картинки статические ОБЯЗАТЕЛЬНО!!!
        // хотябы на месяц
        // Средний месяц  30*24*60*60 = 2592000 сек
        header("Cache-Control: max-age=2592000");
        //  Дата последней модификации файла , а не скрипта
        header("Last-Modified: ".gmdate("D, j M Y H:i:s T", $dateModefine ));
        //  Уникальный тег для проверки кеша сервера на актуальность
        //  Оказывается ETags в заголовке HTTP не является обязательным
        //    как правильно генерить не указано , зато сказано только не
        //  CRC32 и CRC64, поэтому сформировал из 2х частей md5 от Даты модификации,
        // и ширина+высота изображения  выбирая только числа
        header("ETag: ".sprintf("\"%d-%d\"", md5($dateModefine), ($imageInfoArray[0]+$imageInfoArray[1]) ));

        /// Выведем само тело изображения
        readfile($imagePath);