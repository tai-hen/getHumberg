<?php

$url = "http://ajax.googleapis.com/ajax/services/search/images?v=1.0&imgsz=small&rsz=large&q=%s&start=%d";


if (empty($argv[1])) {
    echo 'no word ex) php src/action/image.php "ハンバーグ"';
    exit;
}

$word = $argv[1];
$word = urlencode($word);


umask(0022);
$work_dir = 'data/' . $argv[1];


if ( !is_dir( $work_dir ) ) {
    mkdir( $work_dir );
}


$page = 1;
if (isset($argv[2]) AND is_int($argv[2])) {
    $page = $argv[2];
}

$max = 100;
if (isset($argv[3]) AND is_int($argv[3])) {
    $max = $argv[3];
}




try {

    $page = 1;
    while (1){
        $data_url = sprintf($url,$word,$page);

        $raw_data = file_get_contents($data_url);
        $data = json_decode($raw_data,true);

        if (empty($data)){
            echo "API error";
            break;
        }


        if ($data['responseData'] === null){
            echo "finished ";
            break;
        }

        foreach ($data['responseData']['results'] as $key => $d) {

            try {

                $base_name = basename($d['url']);
                $names = explode('%3F',$base_name);
                //imageId 5byte add
                $file_name = substr($d['imageId'],-5,5).'_'.$names[0];

                $curl = curl_init();
                curl_setopt( $curl, CURLOPT_URL, $d['url'] );
                curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
                $data = curl_exec( $curl );
                file_put_contents($work_dir.'/'.$file_name,$data);

                curl_close($curl);

            } catch (\Exception $e) {
                continue;
            }
        }
        echo $page.' ';
        $page ++;

        if ($page === $max){
            echo "finished ";
            break;
        }

    }



} catch (\Exception $e) {
    var_dump($e->getMessage());
}

