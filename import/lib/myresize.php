<?php

require_once 'resize/AcImage.php';

function goodresize($pic, $good = array()) {
    $default = 'img/default.gif';
    $url = $default;
    $root = $_SERVER['DOCUMENT_ROOT'];
    if ($pic == 'default.gif' || !file_exists($root . '/' . $pic) || !AcImage::isFileImage($root . '/' . $pic)) {
        return "<img height='110' src='/$url'>";
    }
    $dir = pathinfo($pic, PATHINFO_DIRNAME);
    $file_name = pathinfo($pic, PATHINFO_BASENAME);
    $full_url_small = $dir . '/small__' . $file_name;
    $url = $full_url_small;
    if (!file_exists($root . '/' . $full_url_small)) {
        try {
            $img = AcImage::createImage($root . '/' . $pic);
            $img->resize(300, 300);
            $img->saveAsJPG($full_url_small);
        } catch (FileNotFoundException $ex) {
            $url = $default;
        }
        catch (InvalidFileException $ex) {
            $url = $default;
        }
        catch (GDnotInstalledException $ex) {
            $url = $default;
        }
        catch (IllegalArgumentException $ex) {
            $url = $default;
        }

    }
    $alt = (isset($good['col1'])) ? $good['col1'] : '';
    return "<img src='/$url' alt='$alt'>";
}

function small_or_big($pic) {
    $root = $_SERVER['DOCUMENT_ROOT'];
    $dir = pathinfo($pic, PATHINFO_DIRNAME);
    $file_name = pathinfo($pic, PATHINFO_BASENAME);
    $full_url_small = $dir . '/small__' . $file_name;
    if (file_exists($root . '/' . $full_url_small)) {
        $url = $full_url_small;
    } else {
        $url = $pic;
    }
    return "<img src='/$url'>";
}
