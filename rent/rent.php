<?php
require_once 'simple_html_dom.php';

$pages = $argv[1];
$str = $argv[2];

$url = 'http://vkrent.ru/spb/page=';

$file_path = 'result.txt';

for ($p = 1; $p <= $pages; $p++) {
    $file = file_get_html($url . $p);
    echo 'PAGE: ' . $p . PHP_EOL;

    foreach ($file->find('li.on_like') as $li) {

        $link = $li->find('.postlink', 0);
        if (!is_object($link)) {
            continue;
        }

        $link = $link->attr['onclick'];
        $string = $li->find('.post_text', 0)->innertext;
        $date = $li->find('.data', 0)->innertext;


        if (stristr(strtolower($string), $str)) {
            $data = [
                'link' => $link,
                'data' => $string,
                'page' => $p,
                'date' => $date
            ];
            file_put_contents($file_path, print_r($data, true), FILE_APPEND);
        }
    }
}