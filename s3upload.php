<?php

/**
 * SDKの読み込みとS3Clientインスタンスの生成
 */
require_once("aws.phar");

use Aws\S3\S3Client;
use Aws\Common\Enum\Region;
use Aws\S3\Exception\S3Exception;
use Guzzle\Http\EntityBody;

// キー、シークレットキー、リージョンを指定
$client = S3Client::factory(array(
            'key' => 'Your Access Key',
            'secret' => 'Your Secret Key',
            'region' => Region::AP_NORTHEAST_1));

//フォームからアップロードされたファイル
$tmpfile = $_FILES["upfile"]["tmp_name"];

//ファイルがアップロードされていない場合は終了
if (!is_uploaded_file($tmpfile)) {
    die('ファイルがアップロードされていません');
}

// バケット名
$bucket = "Your Bucket Name";
// アップロード先のキー(ファイル識別子)
$key = "test2.jpg";

try {
    $result = $client->putObject(array(
        'Bucket' => $bucket,
        'Key' => $key,
        'Body' => EntityBody::factory(fopen($tmpfile, 'r')),
    ));
    
} catch (S3Exception $exc) {
    echo "アップロード失敗";
    echo $exc->getMessage();
}
?>
