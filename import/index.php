<?
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Import</title>
        <style>
            .container{
                width: 800px;
                margin: 50px auto;
                border: 1px solid #ccc;
                padding: 20px;
            }
            p{
                color: #333;
                margin: 20px 0;
            }
            .err{
                color: red;
            }
            .ok{
                color: #008000;
            }
        </style>
    </head>
    <body>
       <div class="container">
            <?
            $root = $_SERVER['DOCUMENT_ROOT'];
            $import0_1 = '/import_upload/import0_1.xml';
            $offers0_1 = '/import_upload/offers0_1.xml';
            $files_flag = false;
            if (!file_exists($root . $import0_1) /*|| !file_exists($root . $offers0_1)*/) {
                    echo "<p class='err'>В папке <b>import_upload</b> нет файлов <b>import0_1.xml</b> или  <b>offers0_1.xml</b></p>";
            }else{
                echo "<p class='ok'>В папке <b>import_upload</b> найдены файлы <b>import0_1.xml</b> и <b>offers0_1.xml</b></p>";
                echo '<form method="post"><button type="submit" name="import_start">Начать импорт</button></form>';
                $files_flag = true;
            }
            if (isset($_POST['import_start']) && $files_flag) {
                require 'import.php';
                $import = new Import('manual');
                $import->start();
               // unlink($root . $import0_1);
                //unlink($root . $offers0_1);
                echo '<p>Завершено</p>';
            }
            ?>
        </div>
    </body>
</html>