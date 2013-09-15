<?php
/**
 * SDKの読み込みとS3Clientインスタンスの生成
 */
require_once("aws.phar");

use Aws\S3\S3Client;
use \Aws\Common\Enum\Region;

// キー、シークレットキー、リージョンを指定
$client = S3Client::factory(array(
            'key' => 'Your Access Key',
            'secret' => 'Your Secret Key',
            'region' => Region::AP_NORTHEAST_1));

/**
 * バケット・キーを指定しgetObjectメソッドでファイルのデータを取得
 */
// バケット名
$bucket = "Your Bucket Name";
// ダウンロード対象のキー(ファイル識別子)
$key = "test.jpg";

$result = $client->getObject(array(
    'Bucket' => $bucket,
    'Key' => $key
        ));

/**
 * 取得したデータのブラウザ出力
 */
//ファイルサイズ
$length = $result['ContentLength'];
//ファイルポインタを先頭に戻し、ファイルを読み込む
$result['Body']->rewind();
$data = $result['Body']->read($length);
//キーからファイル名だけ取り出す
$filename = end(explode('/', $key));

//ファイルダウンロード用のHTTPヘッダ
//Content-Type
header('Content-Type: application/octet-stream');
//ファイル名
$disposition = 'Content-Disposition: attachment; filename="' . $filename . '"';
header($disposition);
//Content-Length
$contentlength = 'Content-Length: ' . $length;
header($contentlength);
echo $data;

?>
