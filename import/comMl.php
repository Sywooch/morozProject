<?php

require_once 'settings.php';

class parser_com_ml {

    private $xml;

    /**
     *
     * @param $file - путь к файлу
     * @throws Exception если неверный формат файла
     */
    public function __construct($file) {
        if (!file_exists($file) || !is_file($file)) {
            mylog("File not found");
            throw new Exception('Нет файла');
        }
        $xml = simplexml_load_file($file);
        if (!$xml) {
            $err = '';
            foreach (libxml_get_errors() as $error) {
                $err .= "\t" . $error->message;
            }
            mylog("Error read xml " . $err);
            throw new Exception('Ошибка чтения xml. ' . $err);
        }
        $this->xml = $xml;
    }

    /**
     * Рекурсивное построение массива категорий
     * @return array['name' => ..., '1c_id' => ..., 'parent_1c_id' => ...]
     */
    public function parseTree() {
        $tree = $this->RecurseXML($this->xml->Классификатор->Группы);
        return $tree;
    }

    private function RecurseXML($xml, $parent_id = 'root', $result = array()) {
        foreach ($xml->children() as $item) {
            /* Поля категорий */
            $id = (string) $item->Ид;
            $name = (string) $item->Наименование;
            /* -- */
            $result[] = array(
                'name' => $name,
                '1c_id' => $id,
                'parent_1c_id' => $parent_id
            );
            if ($item->Группы->count()) {
                $res = $this->RecurseXML($item->Группы, $id);
                $result = array_merge($result, $res);
            }
        }
        return $result;
    }

    /**
     * Возвращает массив товаров без учета остатков
     * @return array
     */
    public function parseGoods(&$goods_attr) {
		$goods_attr['test']="test";
        $res = array();
        foreach ($this->xml->Каталог->Товары->Товар as $item) {
            
            /* Поля товара */
            $status = ((string) $item->attributes()->Статус == 'Удален') ? 'del' : '';
            $id = (string) $item->Ид;
            $articul = (string) $item->Артикул;
            $name = (string) $item->Наименование;
            $base_ed = (string) $item->БазоваяЕдиница;
            $parent_1c_id = (string) $item->Группы->Ид[0]; //предпологается что товар может быть только в одной группе
            //$description0 = (string) $item->Описание;
            // формируем массив изображений
            $imgs = array();
            foreach ($item->Картинка as $img) {
                $imgs[] = (string) $img;
            }
			
            /* ЗначенияРеквизитов упаковываем в массив $properties[Наименование реквизита]=array('Значение' =>"значение реквизита")
             * Простые свойства товаров */
            // нужно ли записывать пустые свойства, без значения?
            $properties = array();
            if ($item->ЗначенияРеквизитов->count()) {
                foreach ($item->ЗначенияРеквизитов->ЗначениеРеквизита as $prop) {                 
                    $properties[(string) $prop->Наименование] = array('Наименование' => (string) $prop->Наименование, 'Значение' => (string) $prop->Значение);
                }
            }
            /* ЗначенияСвойств упаковываем в массив $properties_spr[Ид свойства, т.е. справочника]=array('Значение' =>"Ид значение свойства в справочнике")
             * Свойства значения которых ссылаются на справочники и их значения */  
            // нужно ли записывать пустые свойства, без значения?
           $properties_spr = array();
            if ($item->ЗначенияСвойств->count()) {
                foreach ($item->ЗначенияСвойств->ЗначенияСвойства as $prop_spr) {   
                    $properties_spr[(string) $prop_spr->Ид] = array('Ид' => (string) $prop_spr->Ид, 'Значение' => (string) $prop_spr->Значение);
                }
            }
			
            //echo "<pre>";
            //var_dump($properties_spr);
            //echo "</pre>";
            //exit();
            /* -- */
			
            $res[$id] = array(
                'status' => $status,
                '1c_id' => $id,
                'articul' => $articul,
                'name' => $name,
                'base_ed' => trim($base_ed),			
                'parent_1c_id' => $parent_1c_id,
                //'description0' => $description0,
                'imgs' => $imgs,
                'properties' => $properties,
                'properties_spr' => $properties_spr,
                'price' => '',
            );
        }
        return $res;
    }

    public function parseSpr() {
        $res = array();       
        foreach ($this->xml->Классификатор->Свойства->Свойство as $item) {            
            /* Поля свайства */            
            // если свойство не для товаров, пропускаем
            $for_goods=(string)$item->ДляТоваров;
            //if($for_goods!==true)
            //    continue;
            $id = (string) $item->Ид;            
            $name = (string) $item->Наименование;
            $tip_znacheniy  = (string) $item->ТипЗначений;
            $variants = array();

            // если тип значений справочник, то парсим ворианты значений
            if($tip_znacheniy=="Справочник")
            {
                foreach ($item->ВариантыЗначений->Справочник as $variant) {                   
                    $variants[(string)$variant->ИдЗначения] = array("ИдЗначения" => (string)$variant->ИдЗначения,"Значение"=> (string)$variant->Значение);                 
                }
            }
            $res[$id] = array(
                'name' => $name,
                'tip_znacheniy' => $tip_znacheniy,			               
                'variants' => $variants,                
            );
            
//            echo "<pre>";
//            var_dump($res);
//            echo "</pre>";	
//            exit;
        }
        return $res;
    }	
    public function parseGoodsPrice() {
        
        $res = array();
        foreach ($this->xml->ПакетПредложений->Предложения->Предложение as $item) {
            /* Поля товара */
            $status = ((string) $item->attributes()->Статус == 'Удален') ? 'del' : '';
            $id = (string) $item->Ид;	
            if(isset($item->Цены->Цена))
                $price =  (string) $item->Цены->Цена->ЦенаЗаЕдиницу;
            else
                $price = '';
//            echo "<pre>";
//            var_dump((string)$item->Цены->Цена->ЦенаЗаЕдиницу);
//            echo "</pre>";			
            //exit;	

                        
                        
            //$articul = (string) $item->Артикул;
            $name = (string) $item->Наименование;
            $base_ed = (string) $item->БазоваяЕдиница;
            //$parent_1c_id = (string) $item->Группы->Ид[0]; //предпологается что товар может быть только в одной группе
            //$description0 = (string) $item->Описание;
			/*
            $imgs = array();
            foreach ($item->Картинка as $img) {
                $imgs[] = (string) $img;
            }
			*/
            /* Значения свойств */
//            $properties = array();
//            if ($item->ЗначенияРеквизитов->count()) {
//                foreach ($item->ЗначенияРеквизитов->ЗначениеРеквизита as $prop) {
//   //                 $properties[(string) $prop->Наименование] = array('Ид' => (string) $prop->Ид, 'Значение' => (string) $prop->Значение);
//                    $properties[(string) $prop->Наименование] = array(/*'Ид' => (string) $prop->Ид,*/ 'Значение' => (string) $prop->Значение);
//                }
//            }
            /* -- */
            $res[$id] = array(
                'status' => $status,
                '1c_id' => $id,
		'price' => $price,
                //'articul' => $articul,
                'name' => $name,
                'base_ed' => trim($base_ed),			
                //'parent_1c_id' => $parent_1c_id,
                //'description0' => $description0,
               // 'imgs' => $imgs,
               // 'properties' => $properties
            );
        }
        return $res;
    }
    /**
     * парсим остатки; формируем массив с ценами, и массив с остатками
     * @return array('prices' => ..., 'offers' => ...)
     */
    public function parseGoodsOffers() {
        $prices = array();
        $offers = array();
        foreach ($this->xml->ПакетПредложений->Предложения->Предложение as $item) {
            /* Поля предложения (остатка) */
            $id = (string) $item->Ид;
            $price = (string) $item->Цены->Цена[0]->ЦенаЗаЕдиницу;
            /* -- */
            $prices[] = array(
                'id' => $id,
                'price' => $price
            );
            if ($item->Склад->count()) {
                foreach ($item->Склад as $sklad) {
                    $attr = $sklad->attributes();
                    /* Поля склада, включая остаток */
                    $sklad_1c_id = (string) $attr['ИдСклада'];
                    $cnt = (string) $attr['КоличествоНаСкладе'];
                    /* -- */
                    $offers[] = array(
                        'good_1c_id' => $id,
                        'sklad_1c_id' => $sklad_1c_id,
                        'cnt' => $cnt
                    );
                }
            } else {
                $offers[] = array(
                    'good_1c_id' => $id,
                    'cnt' => NULL
                );
            }
        }
        return array('prices' => $prices, 'offers' => $offers);
    }

    /**
     * добавить в товарам цену т.к. она берется из другого файла
     * @param array $goods - обновляется во время выполнения функции
     * @param array $prices - массив $..['prices'] из функции parseGoodsOffers
     */
    public function goodsPlusPrices(&$goods, $prices) {
        foreach ($prices as $key => $item) {            	            
            if (isset($goods[$item['1c_id']])) {
                $goods[$item['1c_id']]['price'] = $item['price'];
            }
        }
    }
    public function goodsMixPrices(&$goods, $prices) {
        foreach ($prices as $key => $item) {
            if (isset($goods[$item['id']])) {
                $goods[$item['id']]['price'] = $item['price'];
            }
        }
    }
    public function parseSklad() {
        $xml = $this->xml;
        $res = array();
        if ($xml->ПакетПредложений->Склады->count()) {
            foreach ($xml->ПакетПредложений->Склады->Склад as $item) {
                $res[] = array(
                    '1c_id' => (string) $item->Ид,
                    'name' => (string) $item->Наименование
                );
            }
        }
        return $res;
    }

}

?>
