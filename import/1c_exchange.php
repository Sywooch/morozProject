<?

$ar_types = array('catalog');
$ar_modes = array('init', 'file', 'import', 'checkauth');
$type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);
$mode = filter_input(INPUT_GET, 'mode', FILTER_SANITIZE_STRING);
$filename = filter_input(INPUT_GET, 'filename', FILTER_SANITIZE_STRING);
$cook_name = 'start_import';
$cook_value = '132456';
$zip = 'yes';
$max_size_file = 104857600; //в байтах, 100 мб
//echo "tes00000t";
$path = $_SERVER['DOCUMENT_ROOT'] . "/import_upload/";
$headers = getallheaders();
if (!in_array($type, $ar_types)) {
    die("failure\nError!!! не передан соответствующий тип данных catalog");
}
if (!in_array($mode, $ar_modes)) {
    die("failure\nError!!! не передан корректный режим передачи данных");
}
if ($type == 'catalog') {
    switch ($mode) {
        case 'checkauth':
            die("success\n{$cook_name}\n{$cook_value}");
            break;
        case 'init':
            check_cookie($headers, $cook_name, $cook_value);
            die("zip={$zip}\nfile_limit={$max_size_file}");
            break;
        case 'file':
            check_cookie($headers, $cook_name, $cook_value);
            $error = false;
            $body = file_get_contents('php://input');
            if (file_put_contents($path . $filename, $body) === false) {
                $error = true;
            };
            $ext = pathinfo($path . $filename, PATHINFO_EXTENSION);
            if ($ext == 'zip') {
                $zip = new ZipArchive();
                if ($zip->open($path . $filename) === true) {
                    $zip->extractTo($path);
                    $zip->close();
                    // пока не удаляем
					//unlink($path . $filename);
                } else {
                    $error = true;
                }
            }
            //file_put_contents('1.txt', var_export(getallheaders(), true) . "\n");
            if ($error) {
                die("failure\nError!!!");
            } else {
                die('success');
            }
            break;
        case 'import':
            if (file_exists($path . 'import0_1.xml') && file_exists($path . 'offers0_1.xml')) {
				echo "Файлы загружены на сервер";
			/*
                require 'import.php';
                $import = new Import();
                $import->start();
                unlink($path . 'import0_1.xml');
                unlink($path . 'offers0_1.xml');
                echo 'success';
                exit;
				*/
            } else {
                die('success');
            }
			
            break;
        default:
            die("failure\nError!!!");
    }
}

function check_cookie($headers, $cook_name, $cook_value) {
    if (!isset($headers['Cookie']) || $headers['Cookie'] != "{$cook_name}={$cook_value}") {
        die("failure\nError!!!");
    }
}

?>
