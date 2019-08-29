<?php

/** Создаем обект БД с доступом ТОЛЬКО к счетчику
* Доступны 2 метода - получить количество счетчика
* и записать +1 к количеству счетчика
*/

Class DataBasePDO
{
    private $pdo;

   	public function __construct()
        {
            $setting = (require_once ('config.php'))["db"];
            extract($setting);
            $this->pdo = new PDO('mysql:host='. $host .';dbname='.$db_name, $db_username, $db_password);
            $this->pdo->exec("set names utf8");
        }
	// Отдадим статистику 
    public function getCounter($id)
    {
		//Кстати неуказано тип записи и тип БД
        // Предположим что количество храниться в таблице mysql banner_table
        // поле count, при этом id баннера 
        //$sql="UPDATE `banner_table` SET `count`=`count` + 1 WHERE id=?";

		$sql="SELECT count FROM banner_table WHERE id=:id";
		$query = $this->pdo->query($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        return $query->execute();
    }
	
	
	// Добавим просмотр в статистику по бннеру с ID
	// Возвращать нечего
	public function addCount($id)
	{
	    print "Add + 1 $id";
		$sql="UPDATE banner_table SET count=count+1 WHERE id=:id";
		$query = $this->pdo->prepare($sql);
		$query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
	}
	
}