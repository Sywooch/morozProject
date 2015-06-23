<?php
/*
из attr_val - удалить id? он там не нужен, что сделать primary key?
//Получим все аттрибуты товара со значениями из справочников и названиями справочников
SELECT  `id_goods`, `spr`.`name_spr`, `spr_data`.`name_spr_data`  FROM `attr_val` 
left join `spr_data`
on `attr_val`.`id_spr_data` = `spr_data`.`id_spr_data`
left join `spr`
on `attr_val`.`id_spr` = `spr`.`id_spr`

//  Получение основных полей товара и всех аттрибутов
//  TODO: результат нужно будет упаковать в массив вида 
// goods[id][name]
// goods[id][prop]=array(name, val, new_price)
// упаковывать так можно  независимо от того справочник это или реквизит 


SELECT  `id_goods`, `val_str`, `val_int`,`val_text`,`spr`.`name_spr`, `spr_data`.`name_spr_data`,   `attr`.`name`, `attr`.`name_val`
FROM `attr_val` 
left join `spr_data`
on `attr_val`.`id_spr_data` = `spr_data`.`id_spr_data`
left join `spr`
on `attr_val`.`id_spr` = `spr`.`id_spr`
left join `attr`
on `attr_val`.`id_attr` = `attr`.`id`




*/
require_once("config.php");
require_once("translit.php");
require_once("comMl.php");
require_once 'settings.php';
ini_set('memory_limit', '128M');

class Import {

    public $ar_filters = array();
    public $ar_filters_names = array();
    private $db;
    private $type_mode_start; //тип запуска manual или auto (1с)

    public function __construct($type_mode_start = 'auto') {
        $this->type_mode_start = $type_mode_start;
        if($this->type_mode_start == 'manual'){
            echo "<p>Импорт запущен в ручном режиме</p>";
        };
        global $server, $username, $password, $db;
        try {
            $this->db = new PDO("mysql:host=$server;charset=utf8;dbname=$db", $username, $password);
            $this->db->exec('SET NAMES UTF8');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception($e);
        }
    }

    public function start() {

		
        try {
            mylog("\n---------Импорт старт---------\n");
            $import0_1 = $_SERVER['DOCUMENT_ROOT'] . '/import_upload/import0_1.xml';
            //$offers0_1 = $_SERVER['DOCUMENT_ROOT'] . '/import_upload/offers0_1.xml';
            $offers0_1 = $_SERVER['DOCUMENT_ROOT'] . '/import_upload/offers0_1.xml';
			
            $parser = new parser_com_ml($import0_1);
            //$parser2 = new parser_com_ml($offers0_1);
            $parser2 = new parser_com_ml($offers0_1);
            mylog('файлы: ок');
			
            echo "Файл загружен в ОП<br>";			
           
			
            $tree = $parser->parseTree();
			//echo "<pre>";
			//var_dump($tree);
			//echo "</pre>";			
			//echo "Закончили парс Разделов каталога<br>";			
			//exit;
			
			// парсим из каталога товары
            $goods_attr = array();
			$goods = $parser->parseGoods($goods_attr);			
			//echo "<pre>";
			//var_dump($goods_attr);
			//echo "</pre>";			
			//exit;
			
//			echo "<pre>";
//			var_dump($goods);
//			echo "</pre>";			
//			exit;	
            $spravochniki = $parser->parseSpr();
            echo "Закончили парс Справочников<br>";		
			//echo "<pre>";
			//var_dump($spravochniki);
			//echo "</pre>";
			$this->import_spr($spravochniki); 
			 echo "Загрузили справочники в таблицы<br>";	
			//exit;	
			//парсим из прайса
            $goods_price = $parser2->parseGoodsPrice();			
			//echo "Закончили парс Товаров из прайса<br>";		
			
			
            //$skladi = $parser2->parseSklad();
            //$offers = $parser2->parseGoodsOffers();
            //$parser2->goodsMixPrices($goods, $offers['prices']); //допишем в goods цену */
            $parser2->goodsPlusPrices($goods, $goods_price); //допишем в goods цену */            	
            mylog('пасринг файлов: ок');
			
//          krumo($offers);

 //           $this->res_copy_bd();
 //           mylog('резервное копирование БД: ок');
           $this->insert_tmp_tree($tree); 
			
		   $this->insert_tmp_goods($goods);
           
	   //$this->insert_tmp_filters();
            mylog('Этап 1: ок');
            $this->replic_tree();
			        	
            			
            mylog('Этап 2: ок');
            $this->replic_goods();
			echo "Товары  и аттрибуты  обновлены<br>";
            mylog('Этап 3: ок');
            $this->goods_img();
			
			echo "картинки в базу занесены";
            exit;
            /*
			$this->import_skladi($skladi);
            mylog('Этап 4: ок');
            $this->import_offers($offers['offers']);
            mylog('Этап 5: ок');
            $this->import_filters();
            mylog('Этап 6: ок');
            
            mylog('Этап 7: ок');
            $this->uvedomit();
			*/
            mylog('\n---------Импорт успешно завершен---------\n');
            //
            //
        //     $import->add_old_filter();
            //    $import->add_1c_id_tree($tree);
            //    $import->add_1c_id_goods($goods);
        } catch (Exception $e) {
            mylog('error detected', $e);
            exit;
        }
    }

    public function res_copy_bd() {
        global $server, $username, $password, $db;
        $name = 'res_' . date('d_m_Y__H_i');
        chdir('res_bd');
        $old_files = 302400 * 2; //время хранения старых файлов 1 недели
        $cur_time = time();
        foreach (glob("*.gz") as $filename) {
            $time_file = filemtime($filename);
            if (($cur_time - $time_file) > $old_files) {
                @unlink($filename);
            }
        }
        shell_exec("mysqldump --skip-opt --quick -u$username -h$server -p$password $db | gzip -c > $name.sql.gz");
		echo "создали резервную копию <br>";
    }

    public function insert_tmp_tree($tree_ar) {
        $this->db->exec('TRUNCATE TABLE tmp_catalog');
        $placeholder = '';
        $placeholder_ar = array();
        $fields_name = array('name', '1c_id', 'parent_1c_id', 'translit');
        foreach ($tree_ar as $ar) {
            //формируем строку вида (?,?,?),(?,?,?),(?,?,?) для нонейм плейсхолдеров и массив подстановки
            $placeholder .= '(?,?,?,?),';
            foreach ($fields_name as $name) {
                if ($name == 'translit') {
                    $placeholder_ar[] = (isset($ar['name'])) ? translit($ar['name']) : '';
                    continue;
                }
                $placeholder_ar[] = (isset($ar[$name])) ? $ar[$name] : '';
            }
        }
        $placeholder = trim($placeholder, ',');
        $all_fields_str = implode(',', $fields_name);
        $query = $this->db->prepare('INSERT INTO tmp_catalog (' . $all_fields_str . ') VALUES ' . $placeholder);
        try {
            $query->execute($placeholder_ar);
        } catch (PDOException $e) {
//            mylog('error PDO. ', $e);
            throw new Exception($e);
        }
    }

    public function insert_tmp_goods($goods_ar) {
        $this->db->exec('TRUNCATE TABLE tmp_goods');
        $this->db->exec('TRUNCATE TABLE tmp_goods_pics');
        $this->db->exec('TRUNCATE TABLE tmp_attr');
        $this->db->exec('TRUNCATE TABLE tmp_attr_rekvizit');
        $placeholder = '';
        $placeholder_img = '';
        $placeholder_attr = '';
        $placeholder_rekvizit = '';
        $placeholder_ar = array();
        $placeholder_ar_img = array();
        $placeholder_ar_attr = array();
        $placeholder_ar_rekvizit = array();
        //массив полей tmp_goods
        $fields_name = array('1c_id', 'parent_1c_id', 'articul', 'name', 'status', 'price');
		
		
        //массив полей tmp_goods - то же самое, только поступают во влож.массиве properties
        //$prop_fields_name = array('title' => '', 'description' => '', 'keywords' => '');
        $prop_fields_name = array();
        $cnt_field = count($fields_name) + count($prop_fields_name);
        foreach ($goods_ar as $c1_id => $ar) {
            //формируем строку вида (?, ?, ?), (?, ?, ?), (?, ?, ?) для нонейм плейсхолдеров и массив подстановки
            $placeholder .= '(' . str_repeat('?,', $cnt_field - 1) . '?),';
            //$placeholder .= '(?,?,?,?,?,?,?,?,?,?),';
            foreach ($fields_name as $name) {
                $placeholder_ar[] = (isset($ar[$name])) ? $ar[$name] : '';
            }
			// Дополнительные реквизиты будем хранить спец таблицах или attr или др.  
            foreach ($prop_fields_name as $name => $name000) {
				if ($name == 'text') {
					continue;
				}
                $placeholder_ar[] = (isset($ar['properties'][$name])) ? $ar['properties'][$name]['Значение'] : '';
            }
			// формируем значения свойств для таблицы attr (фактически ссылаются на справочники)
			if(isset($ar['properties_spr']))
			{
				foreach ($ar['properties_spr'] as $key => $val)
				{
					// записываем аттрибут, если значение не пустое
					if(isset($val['Значение']) && !empty($val['Значение']))
					{
						$placeholder_attr .= '(?,?,?),';
					
						$placeholder_ar_attr[]=$c1_id; // 1c_id_goods - Ид товара
						$placeholder_ar_attr[]=$key;   // 1c_id_spr  - Ид справочника (из таблицы spr)
						$placeholder_ar_attr[]=$val['Значение'];	// 1c_id_val - ИД значения справочника (из таблицы spr_data) 			
					}
				}				
			}
			
			if(isset($ar['properties']))
			{
				foreach ($ar['properties'] as $key => $val)
				{
					// записываем аттрибут, если значение не пустое
					if(isset($val['Значение']) && !empty($val['Значение']))
					{
						$placeholder_rekvizit .= '(?,?,?),';
					
						$placeholder_ar_rekvizit[]=$c1_id; // 1c_id_goods - Ид товара
						$placeholder_ar_rekvizit[]=$val['Наименование'];   // Наименование реквизита
						$placeholder_ar_rekvizit[]=$val['Значение'];	// Значение реквизита
					}
				}				
			}			
            //формируем плейсхолдер для изображений
            foreach ($ar['imgs'] as $img) {
                $placeholder_img .= '(?,?),';
                
                $placeholder_ar_img[] = $ar['1c_id'];
                $placeholder_ar_img[] = $img;
            }
        }
        $placeholder = trim($placeholder, ',');
        $all_fields_str = implode(',', array_merge($fields_name, array_keys($prop_fields_name)));
        $query = $this->db->prepare('INSERT INTO tmp_goods (' . $all_fields_str . ') VALUES ' . $placeholder);
//		echo "<pre>";
//			var_dump($query);
//			echo "</pre>";
//		exit;
        //img
        $placeholder_img = trim($placeholder_img, ',');
        $placeholder_attr = trim($placeholder_attr, ',');
        $placeholder_rekvizit = trim($placeholder_rekvizit, ',');
        try {
           $query->execute($placeholder_ar);
		   
		   
		   
		   // вставка свойств  в temp таблицу
		   if (!empty($placeholder_rekvizit) && $this->type_mode_start == 'manual') {
				// вставка в таблицу attr  названий новых реквизитов (фактически - это возможные поля в системе)
				$query_rekvizit = $this->db->prepare('INSERT IGNORE INTO attr (name) SELECT name FROM tmp_attr_rekvizit group by name');
				$query_rekvizit->execute();
				 // вставка свойств  в temp таблицу
                $query_attr = $this->db->prepare('INSERT INTO tmp_attr_rekvizit (1c_id_goods, name, value) VALUES ' . $placeholder_rekvizit);             
                $query_attr->execute($placeholder_ar_rekvizit);
				//////////
				///////////
				// echo "<pre>";
				// var_dump($query_attr);
				 //echo "</pre>";
				// exit;
            }
			if (!empty($placeholder_attr) && $this->type_mode_start == 'manual') {
                $query_attr = $this->db->prepare('INSERT INTO tmp_attr (1c_id_goods, 1c_id_spr, 1c_id_val) VALUES ' . $placeholder_attr);             
                $query_attr->execute($placeholder_ar_attr);
				//////////
				///////////
				// echo "<pre>";
				// var_dump($query_attr);
				 //echo "</pre>";
				// exit;
            }
			// вставка изображений в temp таблицу
           if (!empty($placeholder_img) && $this->type_mode_start == 'manual') {
 
                $query_img = $this->db->prepare('INSERT INTO tmp_goods_pics (parent_1c_id, pict_big) VALUES ' . $placeholder_img);
             
                $query_img->execute($placeholder_ar_img);
				//      echo "<pre>";
				//		var_dump($query_img);
				//		echo "</pre>";
				//		exit;
            }
            //exit;
        } catch (PDOException $e) {
//            mylog('error PDO. ', $e);
            throw new Exception($e);
        }
    }

    public function import_offers($offers_ar) {
        if (!is_array($offers_ar) || empty($offers_ar)) {
            return false;
        }
        //$this->db->exec('TRUNCATE TABLE goods_offers');
        $placeholder = '';
        $del_ar = array();
        $placeholder_ar = array();
        //формируем строку вида (?,?,?),(?,?,?),(?,?,?) для нонейм плейсхолдеров и массив подстановки
        foreach ($offers_ar as $ar) {
            //перед вставкой удалим все записи с 1c_id
            if (!in_array($ar['good_1c_id'], $del_ar)) {
                $del_ar[] = $ar['good_1c_id'];
            }
            if ($ar['cnt'] === NULL) {
                continue;
            }
            $placeholder .= '(?,?,?),';
            $placeholder_ar[] = (isset($ar['good_1c_id'])) ? $ar['good_1c_id'] : '';
            $placeholder_ar[] = (isset($ar['sklad_1c_id'])) ? $ar['sklad_1c_id'] : '';
            $cnt = (isset($ar['cnt'])) ? $ar['cnt'] : 0;
            $placeholder_ar[] = ($cnt > 0 ) ? $cnt : 0;
        }
        $placeholder = trim($placeholder, ',');
        if (!empty($placeholder_ar)) {
            $query = $this->db->prepare('INSERT INTO goods_offers (good_1c_id, sklad_1c_id, cnt) VALUES ' . $placeholder);
        }
        $placeholder_del = '';
        foreach ($del_ar as $item) {
            $placeholder_del .= '"' . $item . '",';
        }
        $placeholder_del = rtrim($placeholder_del, ',');
        try {
            //перед вставкой удалим все записи с 1c_id
            $this->db->exec('DELETE FROM goods_offers WHERE good_1c_id IN(' . $placeholder_del . ')');
            if (!empty($placeholder_ar)) {
                $query->execute($placeholder_ar);
            }
        } catch (PDOException $e) {
//            mylog('error PDO. ', $e);
            throw new Exception($e);
        }
    }
        public function import_spr($spr) {
        $this->db->exec('TRUNCATE TABLE spr_tmp');
        $this->db->exec('TRUNCATE TABLE spr_data_tmp');
        $placeholder_spr = '';
        $placeholder_spr_data = '';
        $placeholder_ar_spr = array();
        $placeholder_ar_spr_data = array();
        //массив полей spr: название справочника и id_1с
        $fields_name_spr = array('name_spr', 'id_1c_spr');
		// массив полей для spr_data: id_1c (id значения), parent_1c (родительское id 1c справочника), название свойства
        $fields_name_spr_data = array('parent_1c_spr_data', 'id_1c_spr_data',  'name_spr_data');
		
		
        //массив полей tmp_goods - то же самое, только поступают во влож.массиве properties
        //$prop_fields_name = array('title' => '', 'description' => '', 'keywords' => '');
        // $prop_fields_name = array();
        $cnt_field_spr = count($fields_name_spr);
		
        foreach ($spr as $id_1c_spr => $ar) {
            //формируем строку вида (?, ?, ?), (?, ?, ?), (?, ?, ?) для нонейм плейсхолдеров и массив подстановки
            $placeholder_spr .= '(' . str_repeat('?,', $cnt_field_spr - 1) . '?),';
            //$placeholder .= '(?,?,?,?,?,?,?,?,?,?),';
			// формируем значения, которые будем вставлять в справочник spr
			// Название справочника
			$placeholder_ar_spr[] = (isset($ar['name'])) ? $ar['name'] : '';
			// id_1с
			$placeholder_ar_spr[] = (isset($id_1c_spr)) ? $id_1c_spr : '';
            //формируем плейсхолдер для spr_data
            foreach ($ar['variants'] as $id_1c_spr_data => $spr_data) {
                $placeholder_spr_data .= '(?,?,?),';
                
                $placeholder_ar_spr_data[] = $id_1c_spr;
                $placeholder_ar_spr_data[] = $id_1c_spr_data;
                $placeholder_ar_spr_data[] = $spr_data['Значение'];
            }
        }
        $placeholder_spr = trim($placeholder_spr, ',');
        $all_fields_str = implode(',', $fields_name_spr);
		$all_fields_str_data = implode(',', $fields_name_spr_data);
        $query = $this->db->prepare('INSERT INTO spr_tmp (' . $all_fields_str . ') VALUES ' . $placeholder_spr );
	
		//echo "<pre>";
		//	var_dump($query);
		//	echo "</pre>";
		//exit;
        //Справочники Данные 
		
        $placeholder_spr_data = trim($placeholder_spr_data, ',');
        try {
           $query->execute($placeholder_ar_spr);
		   // репликация с spr
		   $query_spr_replic = $this->db->prepare('
                  INSERT INTO spr (name_spr, id_1c_spr)
                  SELECT name_spr, id_1c_spr FROM spr_tmp
                  ON DUPLICATE KEY UPDATE
                        spr.name_spr = spr_tmp.name_spr                        
            ');
		   $query_spr_replic->execute();
		   		   		   
           if (!empty($placeholder_spr_data) && $this->type_mode_start == 'manual') { 
                $query_spr_data = $this->db->prepare('INSERT INTO spr_data_tmp  (' . $all_fields_str_data . ') VALUES ' . $placeholder_spr_data);             
                $query_spr_data->execute($placeholder_ar_spr_data);
				
				$query_spr_data_replic = $this->db->prepare('
                  INSERT INTO spr_data (parent_1c_spr_data, id_1c_spr_data, name_spr_data)
                  SELECT parent_1c_spr_data, id_1c_spr_data, name_spr_data FROM spr_data_tmp
                  ON DUPLICATE KEY UPDATE
                        spr_data.name_spr_data = spr_data_tmp.name_spr_data,
                        spr_data.parent_1c_spr_data = spr_data_tmp.parent_1c_spr_data
                        
				');
				$query_spr_data_replic->execute();
				
				// проставим паренты для нашей системы			
				$query_spr_data_set_parent = $this->db->prepare('
                REPLACE INTO spr_data (id_spr_data, parent_id_spr_data, name_spr_data, id_1c_spr_data, parent_1c_spr_data )
				( SELECT t2.id_spr_data, spr.id_spr AS parent_id_spr_data, t2.name_spr_data, t2.id_1c_spr_data, t2.parent_1c_spr_data 
				  FROM spr
				  RIGHT JOIN spr_data t2 ON spr.id_1c_spr = t2.parent_1c_spr_data)                     
				');				
				$query_spr_data_set_parent->execute();			
				//echo "<pre>";
				//	var_dump($query_spr_data);
				//echo "</pre>";
				//exit;
            }
            //exit;
        } catch (PDOException $e) {
//            mylog('error PDO. ', $e);
            throw new Exception($e);
        }
    }

    public function import_skladi($skladi) {
        if (!is_array($skladi) || empty($skladi)) {
            return false;
        }
        $placeholder_ar = array();
        foreach ($skladi as $ar) {
            $placeholder_ar[':1c_id'] = (isset($ar['1c_id'])) ? $ar['1c_id'] : '';
            $placeholder_ar[':name'] = (isset($ar['name'])) ? $ar['name'] : '';
            $query = $this->db->prepare('INSERT INTO skladi (1c_id, name) VALUES (:1c_id, :name)
                ON DUPLICATE KEY UPDATE name = :name
            ');
            try {
                $query->execute($placeholder_ar);
            } catch (PDOException $e) {
                throw new Exception($e);
            }
        }
    }

    public function replic_tree() {
//вставка или обновление существующих
        $query = $this->db->prepare('
                  INSERT INTO catalog (1c_id_cat, parent_1c_id_cat, name_cat, link_cat,  pid_cat)
                  SELECT 1c_id, parent_1c_id, name, translit, -1 FROM tmp_catalog
                  ON DUPLICATE KEY UPDATE
                        catalog.name_cat = tmp_catalog.name,
                        catalog.parent_1c_id_cat = tmp_catalog.parent_1c_id,
                        catalog.pid_cat = -1
            ');
			
//обновим tree_pid для всех записей (чтобы учесть перенос категорий); 128 - tree_id страницы каталог
        $query2 = $this->db->prepare('
                  REPLACE INTO catalog (
                        id_cat,
                        1c_id_cat,
                        parent_1c_id_cat,
                        link_cat,
                        name_cat,
                        title_cat,
                        prior_cat,                        
                        status_cat,
                        pid_cat,
                        text_cat,
                        text_small_cat,
                        keywords_cat,
                        description_cat
                    )
                  SELECT
                        t1.id_cat,
                        t1.1c_id_cat,
                        t1.parent_1c_id_cat,
                        t1.link_cat,
                        t1.name_cat,
                        IF (t1.title_cat = "", t1.name_cat, t2.title_cat),
                        t1.prior_cat,                        
                        t1.status_cat,
                        IF (t1.parent_1c_id_cat = "root", 0 , t2.id_cat),
                        t1.text_cat,
                        t1.text_small_cat,
                        t1.keywords_cat,
                        t1.description_cat
                  FROM catalog t1
                  LEFT JOIN catalog t2 ON t1.parent_1c_id_cat = t2.1c_id_cat
                  WHERE t1.pid_cat = -1 
            ');
//Пометить записи в tree, у которых 1c_id отсутствует в tmp_tree
//НЕ ИСПОЛЬЗУЕТСЯ
        /* $query3 = $this->db->prepare('
          UPDATE tree t LEFT JOIN tmp_tree tmp ON t.1c_id = tmp.1c_id
          SET tree_comment = "deleted", tree_status = 0
          WHERE t.1c_id IS NOT NULL AND t.tree_type = 5 AND tmp.1c_id IS NULL
          '); */
        try {
//выполняем в транзакции
            $this->db->beginTransaction();
            $query->execute();
            $query2->execute();
            //$query3->execute();
            $this->db->exec('TRUNCATE TABLE tmp_catalog');
            $this->db->commit();
        } catch (PDOException $e) {
            $this->db->rollBack(); //откатим изменения
//            mylog('Ошибка replic_tree. ', $e);
            throw new Exception($e);
        }
    }

    public function replic_goods() {
		//exit;
        //вставка или обновление существующих
        $query = $this->db->prepare('
                INSERT INTO goods(
                        id_1c,
                        cat_id_1c,
                        name,
                        price,
                        articul,
                        cat_id,
                        status
                )
                SELECT
                        1c_id,
                        parent_1c_id,
                        name,
                        price,
                        articul,
                        -1,
                        status                        
                FROM tmp_goods t
                ON DUPLICATE KEY UPDATE
                        cat_id_1c = t.parent_1c_id,
						id_1c = t.1c_id,
                        name = t.name,
                        price = t.price,
                        articul = t.articul,
                        cat_id = -1,						
                        status = t.status
                        
            ');
        //обновим pid для всех записей (чтобы учесть перенос товаров в другие категории);
        $query2 = $this->db->prepare('
                REPLACE INTO goods (
                    id,
                    id_1c,
					cat_id_1c,
					name,
					price,
					articul,
					cat_id,
					status,
					hit,
					sale,
					goods_type,
					prior
                )
                SELECT
                    g.id,
                    g.id_1c,
					g.cat_id_1c,
					g.name,
					g.price,
					g.articul,
					t.id_cat,
					g.status,
					g.hit,
					g.sale,
					g.goods_type,
					g.prior
                FROM goods g
                LEFT JOIN catalog t ON t.1c_id_cat = g.cat_id_1c
                WHERE g.cat_id = -1
            ');
        //Удалить записи в goods, для которых в tmp_goods есть пометка del
        //DELETE FROM goods WHERE 1c_id IN (SELECT 1c_id FROM tmp_goods WHERE status = "del")
        $query3 = $this->db->prepare('
                  UPDATE goods SET visible = 0 WHERE id_1c IN (SELECT 1c_id FROM tmp_goods WHERE status = "del")
            ');
		// вставляем атрибуты товара в таблицу attr_val
		/*
		получаем все атрибуты из tmp_attr таблицы вместе id товара из goods 
		INSERT INTO  attr_val(
			id_goods,
			id_spr,
			id_spr_data,
			1c_id_goods,
			1c_id_spr,
			1c_id_val,
			new_price
		)
		Select 	goods.id,
			spr.id_spr,
			spr_data.id_spr_data,
			tmp_attr.1c_id_goods, 
			tmp_attr.1c_id_spr, 
			tmp_attr.1c_id_val, 
			tmp_attr.new_price 
		from tmp_attr
		left join goods 
		on tmp_attr.1c_id_goods = goods.id_1c
		left join spr_data
		on tmp_attr.1c_id_val  = spr_data.id_1c_spr_data
		left join spr
		on tmp_attr.1c_id_spr  = spr.id_1c_spr	
		*/
		// 1. Удаляем ве аттрибуты подгруженные из 1С
		// 2. На всякий случай делаем replace вместо insert
		// ИЛИ 
		// 1. Сначала удаляем все атрибуты, относящиеся к товарам, которые будем вносить из 1С (находим их по 1C_id_goods )
		// 2. Вставляем аттрибуты с помощью инсерт
		$query_attr_del = $this->db->prepare('DELETE  
		FROM attr_val
		WHERE 1c_id_goods
		IN (
			SELECT tmp_attr.1c_id_goods
			FROM tmp_attr
		)		
            ');
		// вставляем атрибуты из справочников
		$query_attr = $this->db->prepare('
        INSERT INTO  attr_val(
			id_goods,
			id_spr,
			id_spr_data,
			1c_id_goods,
			1c_id_spr,
			1c_id_val,
			new_price
		)
		Select 	goods.id,
			spr.id_spr,
			spr_data.id_spr_data,
			tmp_attr.1c_id_goods, 
			tmp_attr.1c_id_spr, 
			tmp_attr.1c_id_val, 
			tmp_attr.new_price 
		from tmp_attr
		left join goods 
		on tmp_attr.1c_id_goods = goods.id_1c
		left join spr_data
		on tmp_attr.1c_id_val  = spr_data.id_1c_spr_data
		left join spr
		on tmp_attr.1c_id_spr  = spr.id_1c_spr

            ');
		 // вставка данных из таблицы реквизитов
		$query_attr_rekvizit = $this->db->prepare('
        INSERT INTO  attr_val(
			id_goods,			
			1c_id_goods,
			id_attr,
			val_str			
		)
		Select 
			goods.id,			
			tmp_attr_rekvizit.1c_id_goods,
			attr.id,
			tmp_attr_rekvizit.value	
		from  tmp_attr_rekvizit
		left join goods 
		on tmp_attr_rekvizit.1c_id_goods = goods.id_1c
		left join attr
		on tmp_attr_rekvizit.name  = attr.name
		

            ');
        try {
            //выполняем в транзакции
            $this->db->beginTransaction();
            $query->execute();
            $query2->execute();
            $query3->execute();
			$query_attr_del->execute();
			$query_attr->execute();
			$query_attr_rekvizit->execute();
            /* $res = $query->rowCount();
              $res2 = $query2->rowCount();
              $res3 = $query3->rowCount();
              var_dump($res, $res2, $res3); */
            $this->db->exec('TRUNCATE TABLE tmp_goods');
            $this->db->commit();
        } catch (PDOException $e) {
            $this->db->rollBack(); //откатим изменения
//            mylog('error PDO. ', $e);
            throw new Exception($e);
        }
    }

    public function goods_img() {
	
        $query = $this->db->prepare('
             INSERT INTO goods_images(
                        1c_goods_id,
                        imgname
                )
                SELECT
                    t.parent_1c_id,
                    t.pict_big
                FROM tmp_goods_pics t
                ON DUPLICATE KEY UPDATE
                    1c_goods_id = t.parent_1c_id
        ');
        $query2 = $this->db->prepare('
            UPDATE goods_images
            LEFT join goods g ON g.id_1c = goods_images.1c_goods_id
            SET goods_id = g.id
            WHERE goods_images.1c_goods_id IS NOT NULL
        ');
 //echo "дошли до изображений";
 //       exit();
              
	   try {
            if($this->type_mode_start == 'manual'){
                $this->db->beginTransaction();
               // $this->db->exec('truncate goods_images');
                $query->execute();
                $query2->execute();
                $this->db->exec('TRUNCATE TABLE tmp_goods_pics');
                $this->db->commit();
            }
        } catch (Exception $e) {
            $this->db->rollBack(); //откатим изменения
//            mylog('error PDO. ', $e);
            throw new Exception($e);
        }
    }

    //вставка фильтров во временную таблицу
    public function insert_tmp_filters() {
        if (empty($this->ar_filters)) {
            return false;
        }
        $this->db->exec('TRUNCATE TABLE tmp_filters');
        $placeholder = '';
        $placeholder_ar = array();
        $del_str = '';
        foreach ($this->ar_filters as $good_1c_id => $ar) {
            if ($ar === NULL) {
                $del_str = "'" . $good_1c_id . "',";
                continue;
            }
            foreach ($ar as $name_filter => $item_filter) {
                $placeholder .= '(?,?),';
                $placeholder_ar[] = $item_filter['Ид'];
                $placeholder_ar[] = $good_1c_id;
                $this->ar_filters_names[$item_filter['Ид']] = $name_filter;
            }
        }
        $del_str = rtrim($del_str, ",");
        $placeholder = trim($placeholder, ',');
        try {
            if (!empty($placeholder_ar)) {
                $query = $this->db->prepare('INSERT INTO tmp_filters (filter_1c_id, good_1c_id) VALUES ' . $placeholder);
                $query->execute($placeholder_ar);
            }
            if ($del_str != '') {
                //удалим фильтры для товаров, для которых нет фильров в выгрузке
                $this->db->exec('DELETE FROM filters WHERE good_1c_id IN (' . $del_str . ')');
            }
        } catch (PDOException $e) {
//            mylog('error PDO. ', $e);
            throw new Exception($e);
        }
    }

    //переносим фильтры из tmp в filters и импорт названий фильтров
    public function import_filters() {
        $query = $this->db->prepare('
                INSERT INTO filters_name (name, 1c_id)
                VALUES (:name, :1c_id)
                ON DUPLICATE KEY UPDATE name = :name
          ');
        //$this->db->exec('TRUNCATE TABLE filters');
        $query2 = $this->db->prepare('
                INSERT INTO filters (id_filter, good_1c_id)
                SELECT fn.id, tmp.good_1c_id  FROM tmp_filters tmp
                INNER JOIN filters_name fn ON fn.1c_id = tmp.filter_1c_id
            ');
        $query_del = $this->db->prepare("DELETE FROM filters WHERE good_1c_id IN (SELECT DISTINCT good_1c_id FROM tmp_filters)");
        try {
            $this->db->beginTransaction();
            foreach ($this->ar_filters_names as $filter_1c_id => $name) {
                $data = array(':name' => $name, ':1c_id' => $filter_1c_id);
                $query->execute($data);
            }
            $query_del->execute();
            $query2->execute();
            $this->db->exec('TRUNCATE TABLE tmp_filters');
            $this->db->commit();
        } catch (PDOException $e) {
//            mylog('error PDO. ', $e);
            throw new Exception($e);
        }
    }

    //функций уведомления о поступлении товара
    public function uvedomit() {
        $query = '
            SELECT u.id, u.email, u.cnt, g.col1 as name, g.parent_id, g.id as good_id,
            (select sum(o.cnt) from goods_offers o WHERE o.good_1c_id = g.1c_id) as realcnt
            FROM uvedom u
            INNER JOIN goods g
                ON u.1c_id = g.1c_id
            HAVING realcnt > 0';
        try {
            $res = $this->db->query($query);
        } catch (Exception $e) {
//            mylog('error PDO. ', $e);
        }
        //$this->db->exec('SET NAMES CP1251');
        $queery_tree = $this->db->query('SELECT * from tree WHERE tree_type = 5');
        //$this->db->exec('SET NAMES UTF8');
        $tree = array();
        while ($row = $queery_tree->fetch(PDO::FETCH_ASSOC)) {
            $tree[$row['tree_id']] = $row;
        }
        $uvedom = array();
        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $uvedom[$row['email']][$row['id']] = $row;
            $url = $this->path_create($row['parent_id'], $tree);
            $uvedom[$row['email']][$row['id']]['url_page'] = $url . "?show = " . $row['good_id'];
        }
        $delete_uvedom = array();
        global $base;
        foreach ($uvedom as $email => $goods) {
            ob_start();
            include($_SERVER["DOCUMENT_ROOT"] . '/tmpl/email/v_uvedom.php');
            $tpl = ob_get_clean();
            //file_put_contents($email . '.html', $tpl);
            $subject = iconv('UTF-8', 'CP1251', 'Интересующие вас товары в наличии');
            if (email_smtp($email, $tpl, $subject)) {
                $tmp = array_keys($goods);
                $delete_uvedom = array_merge($delete_uvedom, $tmp);
            }
        }
        if (!empty($delete_uvedom)) {
            $this->db->exec("DELETE FROM uvedom WHERE id IN(" . implode(',', $delete_uvedom) . ")");
        }
    }

    //функуия для построения ссылки (url) товара
    private function path_create($id, $tree, $ar = array()) {
        if (isset($tree[$id])) {
            $ar[] = $tree[$id]['tree_link'];
            return $this->path_create($tree[$id]['tree_pid'], $tree, $ar);
        }
        $ar = array_reverse($ar);
        return "galery/" . implode('/', $ar
        );
    }

    //категории сопоставляем по названию
    //В ИМПОТРЕ НЕ ИСПОЛЬЗУЕТСЯ
    public function add_1c_id_tree($tree) {

        $query = $this->db->prepare('UPDATE tree SET 1c_id = ? WHERE tree_type = 5 AND tree_name = ?');
        foreach ($tree as $key => $item) {
            $placeholder_ar = array($item['1c_id'], $item['name']);
            try {
                $query->execute($placeholder_ar);
            } catch (PDOException $e) {
//                mylog('error PDO. ', $e);
                throw new Exception($e);
            }
        }
    }

    //сопоставим старые фильтры с новыми
    //В ИМПОТРЕ НЕ ИСПОЛЬЗУЕТСЯ
    public function add_old_filter() {
        $old_filters = array(
            0 => array(1, 2),
            1 => array(3, 4),
            2 => array(5, 6)
        );
        $tree_obj = $this->db->query('select id, col9 from goods where col9 is not null');
        $tree = $tree_obj->fetchAll(PDO::FETCH_ASSOC);
        $query = $this->db->prepare('INSERT INTO filters (id_filter, id_good) VALUES(?,?)');
        foreach ($tree as $row) {
            $id = $row['id'];
            $old_f = $row['col9'];
            if (!isset($old_filters[$old_f])) {
                continue;
            }
            foreach ($old_filters[$old_f] as $num_new_filter) {
                $data = array($num_new_filter, $id);
                $query->execute($data);
            }
        }
    }

    //товары сопостовляем по артикулу
    //В ИМПОТРЕ НЕ ИСПОЛЬЗУЕТСЯ
    public function add_1c_id_goods($goods) {
        $query = $this->db->prepare('UPDATE goods SET 1c_id = ?, parent_1c_id = ? WHERE col12 = ?');
        foreach ($goods as $key => $item) {
            $placeholder_ar = array($item['1c_id'], $item['parent_1c_id'], $item['articul']);
            try {
                $query->execute($placeholder_ar);
            } catch (PDOException $e) {
//                mylog('error PDO. ', $e);
                throw new Exception($e);
            }
        }
    }

}

?>