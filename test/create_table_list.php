<?php

class Creator_table 
{
    public $names;
    public $surnames;
    public $phones;
    public $db_link; 

    public function __construct($names, $surnames, $phones, $db_link)
    {
        $this->names = $names;
        $this->surnames = $surnames;
        $this->phones = $phones;
        $this->db_link = $db_link;

    }

    public function creatorTable()
    {
		$result = $this->db_link->query("SHOW TABLES LIKE 'people_list';");
		$is_table_exists = $result->fetch();
		if ($is_table_exists) {
			$get_data = $this->db_link->query("SELECT *  FROM `people_list`;");
			$is_data_exists = $get_data->fetch();
			if ($is_data_exists) {
				$detete_data = $this->db_link->query("TRUNCATE TABLE `people_list`");
				$is_deleted = $detete_data->fetch();
				if (!$is_deleted) {
					for ($i=0; $i <5000; $i++) {
						$name = $this->names[array_rand($this->names)];
						$surname = $this->surnames[array_rand($this->surnames)];
						$phone = $this->phones[array_rand($this->phones)];
						$this->db_link->prepare("INSERT INTO `people_list` (`name`, `surname`, `phone`) VALUES (?, ?, ?);")->execute( array($name , $surname, $phone));
					}
				}
			}	
		}
    }
}
$names = ['Bill', 'Piter','Janne', 'Tom', 'Jimmy', 'Kate'];
$surnames = ['Martin', 'Smith', 'Jones', 'Johson', 'Giacometti', 'Ford'];
$phones = [43343465767,54624345656,56454656456,7878789789,7878984564, 44768789789];
?>