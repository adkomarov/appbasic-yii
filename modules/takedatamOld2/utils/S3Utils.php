<?php
use Aws\S3\S3Client;
use Aws\S3\ObjectUploader;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

class S3Utils {

    public $versionS3 = 'latest';
    public $regionS3 = 'msk';
    public $use_path_style_endpoint = true;

    public $key = Yii::$app->params['key'];
    public $secret = Yii::$app->params['secret'];
    public $endpoint = Yii::$app->params['endpoint'];
    public $bucket = Yii::$app->params['Bucket'];
    public $ContentDisposition = '"inline"';

    public $standartTimeLinkS3 = '+1000 minutes';

    public function ctxConnectS3 () {
        $customS3 = new S3Client([
            'version' => S3Utils::$versionS3,
            'region' => S3Utils::$regionS3,
            'use_path_style_endpoint' => S3Utils::$use_path_style_endpoint,
            'credentials' => [
                'key' => S3Utils::$key,
                'secret' => S3Utils::$secret,
            ],
            'endpoint' => S3Utils::$endpoint,
        ]);
        return $customS3;
    }

    //s3 = S3Utils::$ctxConnectS3;

    public function ctxPutObject($customS3, $namefile, $body, $testMimeType){
        $customS3->putObject([
            'Bucket' => S3Utils::$bucket,
            'Key' => $namefile,
            'Body' => file_get_contents($body),
            'ContentDisposition' => S3Utils::$ContentDisposition,
            'ContentType' => $testMimeType
        ]);
    }

    public function ctxGetLink($customS3, $namefile){
        $command = $customS3->getCommand('GetObject', [
            'Bucket' => S3Utils::$bucket,
            'Key' => $namefile
        ]);
        $myPresignedRequest = $customS3->createPresignedRequest($command, S3Utils::$standartTimeLinkS3);
        $presignedUrl = (string) $myPresignedRequest->getUri();
        $lastdotposition = strpos($presignedUrl, "?");
        if ($lastdotposition !== false) {
            $link = substr($presignedUrl, 0, $lastdotposition);
        }
        return $link;
    }

    //загрузка и ссылка в одну функцию

    public $acStandartsMimeTypes = array(
        "image/jpeg",//jpg or jpeg
        "image/png",//png
        "application/pdf",//pdf
        "application/msword",//doc (not docx)
        "application/vnd.ms-excel",//xls (not xlsx)
        "text/csv",//csv
        //"application/vnd.openxmlformats-officedocument.wordprocessingml.document",//docx
        //"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",//xlsx
        //"application/vnd.ms-powerpoint",//ppt
        //"application/vnd.openxmlformats-officedocument.presentationml.presentation",//pptx
    );

    public function isTheFileValid($testMimeType){
        if (in_array($testMimeType, $this->acStandartsMimeTypes)) {
            return true;
        }
        return false;
    }
}