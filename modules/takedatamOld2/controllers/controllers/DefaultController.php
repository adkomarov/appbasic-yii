<?php

namespace app\modules\takedatam\controllers;

use Yii;
use yii\helpers\FileHelper;
use yii\db\Query;
use yii\web\Controller;
use app\modules\takedatam\models\Dataforms;
use app\modules\takedatam\models\Form2addres;
use app\modules\takedatam\models\Form2email;
use app\modules\takedatam\models\Savefiles;
use app\modules\takedatam\models\UploadForm;
use app\modules\takedatam\models\Fieldsforms;
use yii\web\UploadedFile;
use app\models\StorageUploadForm;
use common\models\storage\Upload;
use Aws\S3\S3Client;
use Aws\S3\ObjectUploader;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

/**
 * Default controller for the `newmodules` module
 */
class DefaultController extends Controller
{
    public function init()
    {
        parent::init();
    }

    public function beforeAction($action)
    {
        // if ($action->id == 'paid_edu') {
        //     $this->enableCsrfValidation = false;
        // }

        // $this->enableCsrfValidation = true; 
        Yii::$app->request->enableCsrfValidation = true;

        return parent::beforeAction($action);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionUpload()
    {
        $s3 = new S3Client([
            'version' => 'latest',
            'region' => 'msk',
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key' => 'minioadmin',
                'secret' => 'minioadmin',
            ],
            'endpoint' => 'http://192.168.9.2:9000',
        ]);
        $model = new UploadForm();
        $presignedUrl = "fdgfdg";
        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file && $model->validate()) {
                $s3->putObject([
                    'Bucket' => 'testbucket',
                    // 'Key'    => $model->file->baseName.'.'.$model->file->extension,//'desiredFileName',//'testkey',
                    'Key' => "xpnI101OqUCeujMzGPDIReDUSs0Tp3KrEnr9w4tUdD4p5Ysl6F." . $model->file->extension,
                    'Body' => file_get_contents($model->file->tempName),
                    //['ContentType' => $model->file->extension]),//'Hello from Sanechek',
                ]);

                $s3->listBuckets();

                // var_dump($amountBuckets);


                $command = $s3->getCommand('GetObject', [
                    'Bucket' => 'testbucket',
                    'Key' => $model->file->baseName . '.' . $model->file->extension
                ]);

                $myPresignedRequest = $s3->createPresignedRequest($command, '+10 minutes');
                $presignedUrl = (string) $myPresignedRequest->getUri(); //получили актуальную ссылку


                $insert = $s3->putObject([
                    'Bucket' => 'testbucket',
                    'Key' => 'desiredFileName',//'testkey',
                    'Body' => 'Hello from Sanechek'
                ]);

                echo $presignedUrl;
                //$model->file->saveAs('uploads/' . $model->file->baseName . '.' . $model->file->extension);
            }
        }

        return $this->render('upload', ['model' => $model, 'urlminio' => $presignedUrl]);
    }
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $saveintable = new Dataforms();
        $saveintable->titel = 'О полном наименовании образовательной организации';
        $dataht = $request->get('Textarea1');
        $saveintable->link = $dataht;
        $saveintable->save();

        $saveintable = new Dataforms();
        $saveintable->titel = 'Сокращенное (при наличии) наименование образовательной организации';
        $dataht = $request->get('Textarea2');
        $saveintable->link = $dataht;
        $saveintable->save();

        $saveintable = new Dataforms();
        $saveintable->titel = 'Дата создания образовательной организации';
        $dataht = $request->get('Textarea3');
        $saveintable->link = $dataht;
        $saveintable->save();

        return $this->render('index');
    }
    public function actionForm2()
    {
        $dataform = Dataforms::find()->all();
        $request = Yii::$app->request;
        if ($request->post('Massrows')) {
            foreach ($request->post('Massrows') as $number => $row) {
                $p = 0;
                foreach ($dataform as $idtable) {
                    if ($request->post('id')[$number] == $idtable['id']) {
                        $saveintable = Dataforms::findOne($request->post('id')[$number]);
                        $saveintable->link = $row[0][0];
                        $saveintable->save();
                        $saveintable = Dataforms::findOne($request->post('id')[$number] + 1);
                        $saveintable->link = $row[0][1];
                        $saveintable->save();
                        $saveintable = Dataforms::findOne($request->post('id')[$number] + 2);
                        $saveintable->link = $row[0][2];
                        $saveintable->save();
                        if (isset($row[1])) {
                            $saveintable = new Form2email();
                            $emails = $saveintable::findAll(['id' => $request->post('id')[$number]]);
                            foreach ($row[1] as $num => $row1) {
                                if (isset($emails[$num]['idform2email'])) {
                                    $save = $saveintable::findOne(['idform2email' => $emails[$num]['idform2email']]);
                                    $save->email = $row1;
                                    $save->save();
                                } else {
                                    $saveintable = new Form2email();
                                    $saveintable->email = $row1;
                                    $saveintable->id = $request->post('id')[$number];
                                    $saveintable->save();
                                }

                            }
                        }
                        if (isset($row[2])) {
                            $saveintable = new Form2addres();
                            $address = $saveintable::findAll(['id' => $request->post('id')[$number]]);
                            foreach ($row[2] as $n => $row2) {
                                if (isset($address[$n]['idform2addres'])) {
                                    $save = $saveintable::findOne(['idform2addres' => $address[$n]['idform2addres']]);
                                    $save->addres = $row2;
                                    $save->save();
                                } else {
                                    $saveintable = new Form2addres();
                                    $saveintable->addres = $row2;
                                    $saveintable->id = $request->post('id')[$number];
                                    $saveintable->save();
                                }

                            }
                        }
                        $p = 1;
                    }
                }
                if ($p == 0) {
                    //Сохранение всех textarea  в строке
                    $saveintable = new Dataforms();
                    $saveintable->titel = 'Наименование учредителя образовательной организации';
                    $saveintable->link = $row[0][0];
                    $saveintable->save();
                    $idfordop = Yii::$app->db->getLastInsertID();

                    $saveintable = new Dataforms();
                    $saveintable->titel = 'Юридический адрес учредителя';
                    $saveintable->link = $row[0][1];
                    $saveintable->save();

                    $saveintable = new Dataforms();
                    $saveintable->titel = 'Контактный телефон учредителя';
                    $saveintable->link = $row[0][2];
                    $saveintable->save();
                    //Конец сохранения всех textarea  в строке

                    //Сохранение адресов и сайтов
                    if (isset($row[1])) {
                        foreach ($row[1] as $row1) {
                            $saveintable = new Form2email();
                            $saveintable->id = $idfordop;
                            $saveintable->email = $row1;
                            $saveintable->save();
                        }
                    }
                    if (isset($row[2])) {
                        foreach ($row[2] as $row2) {
                            $saveintable = new Form2addres();
                            $saveintable->id = $idfordop;
                            $saveintable->addres = $row2;
                            $saveintable->save();
                        }
                    }
                }

            }
            //Конец сохранения адресов и сайтов
            return $this->redirect('form2');
        }
        $dataform = Dataforms::find()->one();
        $addres = Form2addres::find()->all();
        $email = Form2email::find()->all();
        $query = new Query();
        $query1 = $query->select(['id', 'link',])->from('dataforms')->where(['titel' => 'Наименование учредителя образовательной организации'])->all();
        $query2 = $query->select(['id', 'link',])->from('dataforms')->where(['titel' => 'Юридический адрес учредителя'])->all();
        $query3 = $query->select(['id', 'link',])->from('dataforms')->where(['titel' => 'Контактный телефон учредителя'])->all();
        return $this->render('form2', ['query1' => $query1, 'query2' => $query2, 'query3' => $query3, 'dataform' => $dataform, 'tableaddres' => $addres, 'tableemail' => $email]);
    }

    public function actionForm3()
    {
        $request = Yii::$app->request;
        $savefilestable = Savefiles::find()->all();
        $key = Yii::$app->params['key'];
        $secret = Yii::$app->params['secret'];
        $endpoint = Yii::$app->params['endpoint'];
        $bucket = Yii::$app->params['Bucket'];
        if (isset($_FILES['upload_file'])) {
            $savefilestable = Savefiles::find()->all();
            foreach ($_FILES['upload_file']['name'] as $file => $name) {
                $p = 0;
                if ($name != '') {
                    foreach ($savefilestable as $data) {
                        if ($_POST['upload_file'][$file] == $data['position']) {
                            $s3 = new S3Client([
                                'version' => 'latest',
                                'region' => 'msk',
                                'use_path_style_endpoint' => true,
                                'credentials' => [
                                    'key' => $key,
                                    'secret' => $secret,
                                ],
                                'endpoint' => $endpoint,
                            ]);
                            $position = $data['Position'];
                            $testMimeType = FileHelper::getMimeTypeByExtension($name);
                            $s3->putObject([
                                'Bucket' => $bucket,
                                'Key' => $position,
                                'Body' => file_get_contents($_FILES['upload_file']['tmp_name'][$file]),
                                'ContentDisposition' => '"inline"',
                                'ContentType' => $testMimeType
                            ]);
                            $s3->listBuckets();
                            $command = $s3->getCommand('GetObject', [
                                'Bucket' => $bucket,
                                'Key' => $position
                            ]);
                            $myPresignedRequest = $s3->createPresignedRequest($command, '+1000 minutes');
                            $presignedUrl = (string) $myPresignedRequest->getUri(); //получили актуальную ссылку
                            $lastdotposition = strpos($presignedUrl, "?");
                            if ($lastdotposition !== false) {
                                $link = substr($presignedUrl, 0, $lastdotposition);
                            }
                            $saveintable = Savefiles::findOne($data["id"]);
                            $saveintable->titel = $_POST['Textarea'][$file];
                            $saveintable->fieldsforms_id = $_POST['Textarea'][$file];
                            $saveintable->link = $link;
                            $saveintable->save();
                            $p = 1;
                            break;
                        }
                    }
                    if ($p == 0) {
                        $s3 = new S3Client([
                            'version' => 'latest',
                            'region' => 'msk',
                            'use_path_style_endpoint' => true,
                            'credentials' => [
                                'key' => $key,
                                'secret' => $secret,
                            ],
                            'endpoint' => $endpoint,
                        ]);
                        $randomString = Yii::$app->getSecurity()->generateRandomString();
                        $position = trim($randomString, "_-");
                        $testMimeType = FileHelper::getMimeTypeByExtension($name);
                        $s3->putObject([
                            'Bucket' => $bucket,
                            'Key' => $position,
                            'Body' => file_get_contents($_FILES['upload_file']['tmp_name'][$file]),
                            'ContentDisposition' => '"inline"',
                            'ContentType' => $testMimeType
                        ]);
                        $s3->listBuckets();
                        $command = $s3->getCommand('GetObject', [
                            'Bucket' => $bucket,
                            'Key' => $position
                        ]);
                        $myPresignedRequest = $s3->createPresignedRequest($command, '+1000 minutes');
                        $presignedUrl = (string) $myPresignedRequest->getUri(); //получили актуальную ссылку
                        $lastdotposition = strpos($presignedUrl, "?");
                        if ($lastdotposition !== false) {
                            $link = substr($presignedUrl, 0, $lastdotposition);
                        }
                        $saveintable = new Savefiles();
                        $saveintable->titel = $_POST['Textarea'][$file];
                        $saveintable->fieldsforms_id = $request->post('Textarea')[$file];
                        $saveintable->link = $link;
                        $saveintable->position = $position;
                        $saveintable->save();
                    }
                } else {
                    foreach ($savefilestable as $data) {
                        if ($_POST['upload_file'][$file] == $data['position']) {
                            $saveintable = Savefiles::findOne($data["id"]);
                            $saveintable->titel = $_POST['Textarea'][$file];
                            $saveintable->save();
                            $p = 1;
                            break;
                        }
                    }
                    if ($p == 0) {
                        $randomString = Yii::$app->getSecurity()->generateRandomString();
                        $position = trim($randomString, "_-");
                        $saveintable = new Savefiles();
                        $saveintable->titel = $_POST['Textarea'][$file];
                        $saveintable->position = $position;
                        $saveintable->save();
                    }
                }
            }
            $savefilestable = Savefiles::find()->all();
            return $this->redirect('form3');
        }
        return $this->render('form3', ['tabledata' => $savefilestable]);
    }
    public function actionForm4()
    {
        $request = Yii::$app->request;
        $dataforms = new Dataforms();
        $data = $dataforms::find()->select(['id'])->where(['titel' => 'Название для ссылки'])->all();
        if ($request->post('Fieldsurl')) {
            foreach ($request->post('Fieldsurl') as $number => $fild) {
                $p = 0;
                foreach ($data as $id) {
                    if ($request->post('id')[$number] == $id['id']) {
                        $dataforms = new Dataforms();
                        $save = $dataforms::findOne($request->post('id')[$number]);
                        $save->link = $fild[0];
                        $save->save();
                        $dataforms = new Dataforms();
                        $save = $dataforms::findOne($request->post('id')[$number] + 1);
                        $save->link = $fild[1];
                        $save->save();
                        $p = 1;
                    }
                }
                if ($p == 0) {
                    $dataforms = new Dataforms();
                    $dataforms->titel = 'Название для ссылки';
                    $dataforms->link = $fild[0];
                    $dataforms->save();
                    $dataforms = new Dataforms();
                    $dataforms->titel = 'Ссылка';
                    $dataforms->link = $fild[1];
                    $dataforms->save();
                }
            }
            return $this->redirect('form4');
        }
        $dataforms = new Dataforms();
        $nameurl = $dataforms::find()->where(['titel' => 'Название для ссылки'])->all();
        $url = $dataforms::find()->where(['titel' => 'Ссылка'])->all();
        return $this->render('form4', ['nameurl' => $nameurl, 'url' => $url]);
    }
    public function actionPaidedu()
    {
        $request = Yii::$app->request;
        if ($request->post('paid_educational')) {
            foreach ($request->post('paid_educational') as $row) {
                $p = 0;
                if (!empty($row[3])) {
                    //Проверка, что запись старая
                    if ($row[0] != '0') {
                        $saveintable = Dataforms::findOne($row[0]);
                        if (!empty($saveintable) && ($row[3] != $saveintable['link'] || $row[2] != $saveintable['titel'])) {
                            $saveintable->titel = $row[2];
                            $saveintable->link = $row[3];
                            $saveintable->updated_at = new \yii\db\Expression('NOW()');
                            if ($saveintable->validate()) {
                                $saveintable->save();
                            } else {
                                $p = 1;
                            }
                        }
                    } else {
                        $saveintable = new Dataforms();
                        $saveintable->fieldsforms_id = $row[1];
                        $saveintable->titel = $row[2];
                        $saveintable->link = $row[3];
                        $saveintable->position = 'No position';
                        if ($saveintable->validate()) {
                            $saveintable->save();
                        } else {
                            $p = 1;
                        }
                    }
                } else {
                    $p = 1;
                }
                if ($p == 1) {
                    //Заполняем пустую link следующим текстом
                    if (empty($row[3])) {
                        $row[3] = "Введите данные";
                    }
                    // Проверка на то какая это запись, новая или старая
                    if ($row[0] == 0) {
                        $wrong[] = [
                            "titel" => $row[2],
                            "id" => 0,
                            "link" => $row[3],
                            "fieldsforms_id" => $row[1]
                        ];
                    } else {
                        $wrong[] = [
                            "titel" => $row[2],
                            "id" => $row[0],
                            "link" => $row[3],
                            "fieldsforms_id" => $row[1]
                        ];
                    }
                    // Создание переменной в сесси wrong_data, которая будет содержать ошибки допущенные пользователем
                    Yii::$app->session->set('wrong_data', $wrong);
                    Yii::$app->session->setFlash('error', 'Проверьте правильность введенных данных.');
                }
            }
            return $this->redirect('');
        }
        $takedata = new Dataforms();
        $data = $takedata::find()
            ->joinWith('fieldsforms')
            ->andWhere(['fieldsforms.nameform' => 'paid_edu'])
            ->all();
        // Проверка на то  есть ли переменная wrong_data
        if (Yii::$app->session->has('wrong_data')) {
            $wrong_data = Yii::$app->session->get('wrong_data');
            //Если переменная wrong_data есть, сравнимаем полученные данные из таблицы 
            //и либо заменяем их, либо добавляем новые в массив data
            foreach ($wrong_data as $wr) {
                if ($wr["id"] != 0) {
                    foreach ($data as $tabledata) {
                        if ($wr["id"] == $tabledata["id"]) {
                            $tabledata["titel"] = $wr["titel"];
                            $tabledata["link"] = $wr["link"];
                            break;
                        }
                    }
                } else {
                    $data[] = $wr;
                }
            }
            Yii::$app->session->remove('wrong_data');
        }
        return $this->render('paid_edu', ['tabledata' => $data,]);
    }
    public function actionGrants()
    {
        $request = Yii::$app->request;
        if ($request->post('paid_educational')) {
            foreach ($request->post('paid_educational') as $row) {
                $p = 0;
                if (!empty($row[3])) {
                    if ($row[0] != '0') {
                        $saveintable = Dataforms::findOne($row[0]);
                        if (!empty($saveintable) && ($row[3] != $saveintable['link'] || $row[2] != $saveintable['titel'])) {
                            $saveintable->titel = $row[2];
                            $saveintable->link = $row[3];
                            $saveintable->updated_at = new \yii\db\Expression('NOW()');
                            if ($saveintable->validate()) {
                                $saveintable->save();
                            } else {
                                $p = 1;
                            }
                        }
                    } else {
                        $saveintable = new Dataforms();
                        $saveintable->fieldsforms_id = $row[1];
                        $saveintable->titel = $row[2];
                        $saveintable->link = $row[3];
                        $saveintable->position = 'No position';
                        if ($saveintable->validate()) {
                            $saveintable->save();
                        } else {
                            $p = 1;
                        }
                    }
                } else {
                    $p = 1;
                }
                if ($p == 1) {
                    //Заполняем пустую link следующим текстом
                    if (empty($row[3])) {
                        $row[3] = "Введите данные";
                    }
                    // Проверка на то какая это запись, новая или старая
                    if ($row[0] == 0) {
                        $wrong[] = [
                            "titel" => $row[2],
                            "id" => 0,
                            "link" => $row[3],
                            "fieldsforms_id" => $row[1]
                        ];
                    } else {
                        $wrong[] = [
                            "titel" => $row[2],
                            "id" => $row[0],
                            "link" => $row[3],
                            "fieldsforms_id" => $row[1]
                        ];
                    }
                    // Создание переменной в сесси wrong_data, которая будет содержать ошибки допущенные пользователем
                    Yii::$app->session->set('wrong_data', $wrong);
                    Yii::$app->session->setFlash('error', 'Проверьте правильность введенных данных.');
                }
            }
            return $this->redirect('grants');
        }
        $takedata = new Dataforms();
        $data = $takedata::find()
            ->joinWith('fieldsforms')
            ->andWhere(['fieldsforms.nameform' => 'grants'])
            ->all();
        // Проверка на то  есть ли переменная wrong_data
        if (Yii::$app->session->has('wrong_data')) {
            $wrong_data = Yii::$app->session->get('wrong_data');
            //Если переменная wrong_data есть, сравнимаем полученные данные из таблицы 
            //и либо заменяем их, либо добавляем новые в массив data
            foreach ($wrong_data as $wr) {
                if ($wr["id"] != 0) {
                    foreach ($data as $tabledata) {
                        if ($wr["id"] == $tabledata["id"]) {
                            $tabledata["titel"] = $wr["titel"];
                            $tabledata["link"] = $wr["link"];
                            break;
                        }
                    }
                } else {
                    $data[] = $wr;
                }
            }
            Yii::$app->session->remove('wrong_data');
        }
        return $this->render('grants', ['tabledata' => $data,]);
    }
    public function actionDocument()
    {
        $takedata = new Dataforms();
        $request = Yii::$app->request;
        $key = Yii::$app->params['key'];
        $secret = Yii::$app->params['secret'];
        $endpoint = Yii::$app->params['endpoint'];
        $bucket = Yii::$app->params['Bucket'];
        //массив с разрешенными расширениями файлов
        $acTypesFileForUploading = array(
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
        if (isset($_FILES['document']) && $request->post('document')) {
            foreach ($_FILES['document']['name'] as $file => $name) {
                $link = '';
                $p = 0;
                $position = '';
                //Проверка на наличие файла
                if ($name != '') {
                    $testMimeType = FileHelper::getMimeTypeByExtension($name);
                    //Проверка на расширение файла
                    if (in_array($testMimeType, $acTypesFileForUploading)) {
                        //Проверка, что запись старая
                        if ($request->post('document')[$file][0] != '0') {
                            //Поиск записи и её перезапись
                            $saveintable = Dataforms::findOne($request->post('document')[$file][0]);
                            if (!empty($savefilestable)) {
                                $s3 = new S3Client([
                                    'version' => 'latest',
                                    'region' => 'msk',
                                    'use_path_style_endpoint' => true,
                                    'credentials' => [
                                        'key' => $key,
                                        'secret' => $secret,
                                    ],
                                    'endpoint' => $endpoint,
                                ]);
                                $position = $saveintable['position'];
                                $s3->putObject([
                                    'Bucket' => $bucket,
                                    'Key' => $position,
                                    'Body' => file_get_contents($_FILES['document']['tmp_name'][$file]),
                                    'ContentDisposition' => '"inline"',
                                    'ContentType' => $testMimeType
                                ]);
                                $s3->listBuckets();
                                $command = $s3->getCommand('GetObject', [
                                    'Bucket' => $bucket,
                                    'Key' => $position
                                ]);
                                $myPresignedRequest = $s3->createPresignedRequest($command, '+1000 minutes');
                                $presignedUrl = (string) $myPresignedRequest->getUri(); //получили актуальную ссылку
                                $lastdotposition = strpos($presignedUrl, "?");
                                if ($lastdotposition !== false) {
                                    $link = substr($presignedUrl, 0, $lastdotposition);
                                }
                                $saveintable->titel = $request->post('document')[$file][2];
                                $saveintable->link = $link;
                                $saveintable->updated_at = new \yii\db\Expression('NOW()');
                                if ($saveintable->validate()) {
                                    $saveintable->save();
                                } else {
                                    $p = 1;
                                }
                            }
                        } else {
                            //Новая запись в бд
                            $s3 = new S3Client([
                                'version' => 'latest',
                                'region' => 'msk',
                                'use_path_style_endpoint' => true,
                                'credentials' => [
                                    'key' => $key,
                                    'secret' => $secret,
                                ],
                                'endpoint' => $endpoint,
                            ]);
                            $tabel_filds = Fieldsforms::findOne($request->post('document')[$file][1]);
                            $count_upload_doc = $tabel_filds->count_upload_doc + 1;
                            $position = $tabel_filds->fieldform . $count_upload_doc;
                            $testMimeType = FileHelper::getMimeTypeByExtension($name);
                            $s3->putObject([
                                'Bucket' => $bucket,
                                'Key' => $position,
                                'Body' => file_get_contents($_FILES['document']['tmp_name'][$file]),
                                'ContentDisposition' => '"inline"',
                                'ContentType' => $testMimeType
                            ]);
                            $s3->listBuckets();
                            $command = $s3->getCommand('GetObject', [
                                'Bucket' => $bucket,
                                'Key' => $position
                            ]);
                            $myPresignedRequest = $s3->createPresignedRequest($command, '+1000 minutes');
                            $presignedUrl = (string) $myPresignedRequest->getUri(); //получили актуальную ссылку
                            $lastdotposition = strpos($presignedUrl, "?");
                            if ($lastdotposition !== false) {
                                $link = substr($presignedUrl, 0, $lastdotposition);
                            }
                            $saveintable = new Dataforms();
                            $saveintable->titel = $request->post('document')[$file][2];
                            $saveintable->fieldsforms_id = $request->post('document')[$file][1];
                            $saveintable->link = $link;
                            $saveintable->position = $position;
                            if ($saveintable->validate()) {
                                $tabel_filds->count_upload_doc = $count_upload_doc;
                                $tabel_filds->save();
                                $saveintable->save();
                            } else {
                                $p = 1;
                            }
                        }
                    } else {
                        $p = 1;
                    }
                } else {
                    //Запись в бд при отсутствии файла
                    //Проверка,что запись старая
                    if ($request->post('document')[$file][0] != '0') {
                        $saveintable = Dataforms::findOne($request->post('document')[$file][0]);
                        //Поиск записи и её перезапись
                        if (!empty($saveintable) && $saveintable['titel'] != $request->post('document')[$file][2]) {
                            $saveintable->titel = $request->post('document')[$file][2];
                            $saveintable->updated_at = new \yii\db\Expression('NOW()');
                            if ($saveintable->validate()) {
                                $saveintable->save();
                            } else {
                                $p = 1;
                            }
                        }
                    } else {
                        //Запись новых данных
                        $tabel_filds = Fieldsforms::findOne($request->post('document')[$file][1]);
                        $count_upload_doc = $tabel_filds->count_upload_doc + 1;
                        $position = $tabel_filds->fieldform . $count_upload_doc;
                        $saveintable = new Dataforms();
                        $saveintable->titel = $request->post('document')[$file][2];
                        $saveintable->fieldsforms_id = $request->post('document')[$file][1];
                        $saveintable->position = $position;
                        if ($saveintable->validate()) {
                            $tabel_filds->count_upload_doc = $count_upload_doc;
                            $tabel_filds->save();
                            $saveintable->save();
                        } else {
                            $p = 1;
                        }
                    }
                }
                //Проверка была ли допущена,где-то ошибка при добавлении данных
                if ($p == 1) {
                    //Проверка, что  запись старая
                    if ($request->post('document')[$file][0] != '0') {
                        $saveintable = Dataforms::findOne(['position' => $request->post('document')[$file][0]]);
                        $wrong[] = [
                            'titel' => $request->post('document')[$file][2],
                            'fieldsforms_id' => $request->post('document')[$file][1],
                            'position' => $request->post('document')[$file][0],
                            'link' => $saveintable->link
                        ];
                    } else {
                        $wrong[] = [
                            'titel' => $request->post('document')[$file][2],
                            'fieldsforms_id' => $request->post('document')[$file][1],
                            'position' => '0',
                            'link' => ''
                        ];
                    }
                    //Создание в сесси переменной wrong_data, куда передается массив wrong с ошибками
                    Yii::$app->session->set('wrong_data', $wrong);
                    Yii::$app->session->setFlash('error', 'Проверьте правильность введенных данных.');
                }
            }
            return $this->redirect('document');
        }
        $savefilestable = $takedata::find()
            ->joinWith('fieldsforms')
            ->andWhere(['fieldsforms.nameform' => 'document'])
            ->all();
        $position_wrong[] = '';
        if (Yii::$app->session->has('wrong_data')) {
            $position_wrong[] = '0';
            $wrong_data = Yii::$app->session->get('wrong_data');
            //Если переменная wrong_data есть, сравнимаем полученные данные из таблицы 
            //и либо заменяем их, либо добавляем новые в массив data
            foreach ($wrong_data as $wr) {
                if ($wr["position"] != '0') {
                    foreach ($savefilestable as $tabledata) {
                        if ($wr["position"] == $tabledata["position"]) {
                            $tabledata["titel"] = $wr["titel"];
                            $position_wrong[] = $wr["position"];
                            break;
                        }
                    }
                } else {
                    $savefilestable[] = $wr;
                }
            }
            Yii::$app->session->remove('wrong_data');
        }
        return $this->render('document', ['tabledata' => $savefilestable, 'position_wrong' => $position_wrong]);
    }
    public function actionCommon(){
        return $this->render('common');
    }
    //Дальше идут удаления
    public function actionDeleteform2($post, $what_to_delete)
    {
        if ($what_to_delete == 'row') {
            $delintable = new Dataforms();
            $deldata = $delintable::findOne(['id' => $post]);
            $deldata->delete();
            $delintable = new Dataforms();
            $deldata = $delintable::findOne(['id' => $post + 1]);
            $deldata->delete();
            $delintable = new Dataforms();
            $deldata = $delintable::findOne(['id' => $post + 2]);
            $deldata->delete();
        }
        if ($what_to_delete == 'email') {
            $delintale = new Form2email;
            $deldata = $delintale::findOne(['idform2email' => $post]);
            $deldata->delete();
        }
        if ($what_to_delete == 'address') {
            $delintale = new Form2addres();
            $deldata = $delintale::findOne(['idform2addres' => $post]);
            $deldata->delete();
        }
        return $this->redirect('form2');
    }
    public function actionDeleteform3($post)
    {
        $saveintable = new Savefiles();
        $deldata = $saveintable::findOne(['Position' => $post]);
        $deldata->delete();
        return $this->redirect('form3');
    }
    public function actionDeleteform4($post)
    {
        $saveintable = new Dataforms();
        $deldata = $saveintable::findOne(['id' => $post]);
        $deldata->delete();
        $deldata = $saveintable::findOne(['id' => $post + 1]);
        $deldata->delete();
        return $this->redirect('form4');
    }
    public function actionDeletepaidedu()
    {
        $request = Yii::$app->request;
        $table = new Dataforms();
        $delintable = $table::find()
            ->joinWith('fieldsforms')
            ->andWhere(['fieldsforms.nameform' => 'paid_edu'])
            ->all();
        if ($request->post('paid_educational')) {
            $post_paid_educational = [];
            foreach ($request->post('paid_educational') as $postdata) {
                $post_paid_educational[] = $postdata[0];
            }
            foreach ($delintable as $deldata) {
                if (in_array($deldata['id'], $post_paid_educational)) {
                } else {
                    //Если enabled не существует то мы его удаляем, а если существует, скрываем элемент
                    if (!$request->post('enabled')) {
                        $del = $table::findOne($deldata['id']);
                        $del->delete();
                    } else {
                        $del = $table::findOne($deldata['id']);
                        $del->enabled = 0;
                        $del->updated_at = new \yii\db\Expression('NOW()');
                        $del->save();
                    }
                }
            }
        } else {
            $table = $table::find()
            ->joinWith('fieldsforms')
            ->andWhere(['and', ['fieldsforms.nameform' => 'paid_edu'], ['enabled' => 1]])
            ->one();
            if (!$request->post('enabled')) {
                $table->delete();
            }else{
                $table->enabled=0;
                $table->updated_at = new \yii\db\Expression('NOW()');
                $table->save();
            }
        }
    }
    public function actionDeletegrants()
    {
        $request = Yii::$app->request;
        $table = new Dataforms();
        $delintable = $table::find()
            ->joinWith('fieldsforms')
            ->andWhere(['fieldsforms.nameform' => 'grants'])
            ->all();
        if ($request->post('paid_educational')) {
            $post_paid_educational = [];
            foreach ($request->post('paid_educational') as $postdata) {
                $post_paid_educational[] = $postdata[0];
            }
            foreach ($delintable as $deldata) {
                if (in_array($deldata['id'], $post_paid_educational)) {
                } else {
                    //Если enabled не существует то мы его удаляем, а если существует, скрываем элемент
                    if (!$request->post('enabled')) {
                        $del = $table::findOne($deldata['id']);
                        $del->delete();
                    } else {
                        $del = $table::findOne($deldata['id']);
                        $del->enabled = 0;
                        $del->updated_at = new \yii\db\Expression('NOW()');
                        $del->save();
                    }
                }
            }
        } else {
            $table = $table::find()
            ->joinWith('fieldsforms')
            ->andWhere(['and', ['fieldsforms.nameform' => 'grants'], ['enabled' => 1]])
            ->one();
            if (!$request->post('enabled')) {
                $table->delete();
            }else{
                $table->enabled=0;
                $table->updated_at = new \yii\db\Expression('NOW()');
                $table->save();
            }
        }
    }
    public function actionDeletedocument()
    {
        $request = Yii::$app->request;
        $table = new Dataforms();
        if ($request->post('document')) {
            //создаем массив id из POST
            foreach ($request->post('document') as $postdata) {
                $post_document[] = $postdata[0];
            }
            $delintable = $table::find()
                ->joinWith('fieldsforms')
                ->andWhere(['fieldsforms.nameform' => 'document'])
                ->all();
            foreach ($delintable as $deldata) {
                if (in_array($deldata['position'], $post_document)) {
                } else {
                    //Если enabled не существует то мы его удаляем, а если существует, скрываем элемент
                    if (!$request->post('enabled')) {
                        $link = $table::findOne(['position' => $deldata['position']]);
                        //Если ссылка пустая, то удаляем только из таблицы, если нет, то удаляем еще и файл
                        if ($link['link'] == '') {
                            $del = $table::findOne(['position' => $deldata['position']]);
                            $del->delete();
                        } else {
                            if (!$request->post('enabled')) {
                                $key = Yii::$app->params['key'];
                                $secret = Yii::$app->params['secret'];
                                $endpoint = Yii::$app->params['endpoint'];
                                $bucket = Yii::$app->params['Bucket'];
                                $s3 = new S3Client([
                                    'version' => 'latest',
                                    'region' => 'msk',
                                    'use_path_style_endpoint' => true,
                                    'credentials' => [
                                        'key' => $key,
                                        'secret' => $secret,
                                    ],
                                    'endpoint' => $endpoint,
                                ]);
                                $s3->deleteObject([
                                    'Bucket' => $bucket,
                                    'Key' => $deldata['position'],
                                ]);
                                $del = $table::findOne(['position' => $deldata['position']]);
                                $del->delete();
                            } else {
                                $del = $table::findOne(['position' => $deldata['position']]);
                                $del->enabled = 0;
                                $del->save();
                            }
                        }
                    } else {
                        $del = $table::findOne(['position' => $deldata['position']]);
                        $del->enabled = 0;
                        $del->updated_at = new \yii\db\Expression('NOW()');
                        $del->save();
                    }
                }
            }
        } else {
            $table = $table::find()
                ->joinWith('fieldsforms')
                ->andWhere(['and', ['fieldsforms.nameform' => 'document'], ['enabled' => 1]])
                ->one();
            if (!$request->post('enabled')) {
                if ($table['link'] == '') {
                    $table->delete();
                } else {
                    $key = Yii::$app->params['key'];
                    $secret = Yii::$app->params['secret'];
                    $endpoint = Yii::$app->params['endpoint'];
                    $bucket = Yii::$app->params['Bucket'];
                    $s3 = new S3Client([
                        'version' => 'latest',
                        'region' => 'msk',
                        'use_path_style_endpoint' => true,
                        'credentials' => [
                            'key' => $key,
                            'secret' => $secret,
                        ],
                        'endpoint' => $endpoint,
                    ]);
                    $s3->deleteObject([
                        'Bucket' => $bucket,
                        'Key' => $table['position'],
                    ]);
                    $table->delete();
                }
            } else {
                $table->enabled = 0;
                $table->updated_at = new \yii\db\Expression('NOW()');
                $table->save();
            }
        }
    }

}


// $saveuploadfile=$uploadfile;
// $uploadfile = $uploaddir . basename("Устав.pdf");
// if(file_exists("/home/vagrant/test/portal_local_repo/app/app/web/downloads/Устав.pdf"))
// {
// unlink("/home/vagrant/test/portal_local_repo/app/app/web/downloads/Устав.pdf");
// }
// if (copy($saveuploadfile, $uploadfile)){
//     // echo "Файл корректен и был успешно загружен.\n";
//     // echo $uploaddir;
// }
