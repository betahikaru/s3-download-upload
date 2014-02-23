<?php
/**
 * SDKの読み込みとS3Clientインスタンスの生成
 */
require_once("aws.phar");
require_once("secret.php");

use Aws\S3\S3Client;
use Aws\Common\Enum\Region;

// キー、シークレットキー、リージョンを指定
$client = S3Client::factory(array(
            'key' => $iam_key,
            'secret' => $iam_pass,
            'region' => Region::AP_NORTHEAST_1));

/**
 * バケット・キーを指定しgetObjectメソッドでファイルのデータを取得
 */
// バケット名
$bucket = $s3_bucket;
// ダウンロード対象のキー(ファイル識別子)
$key = "images/generated/avator.jpg";

$result = $client->getObject(array(
    'Bucket' => $bucket,
    'Key' => $key
        ));

$filename = end(explode('/', $key));
//ファイルサイズ
$length = $result['ContentLength'];
//ファイルポインタを先頭に戻し、ファイルを読み込む
$result['Body']->rewind();
$data = $result['Body']->read($length);
try {
    $fp = fopen("./tmp/" . $filename, "w");
    fwrite($fp, $data);
    fclose($fp);
    chmod("./tmp/" . $filename, 0755);
    echo $filename;
} catch(Exceptin $e) {
}

?>
