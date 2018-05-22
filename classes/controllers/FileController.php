<?php
namespace Artemio\controllers;

use Artemio\forms\FileForm;
use Artemio\models\FileModel;
use Artemio\services\FileUploader;
use Artemio\helpers\Utils;

class FileController extends BaseController {

    public function actionAdd() {

        $this->pageTitle = 'Загрузка изображений';
        $form  = new FileForm();

        $model = $this->modelFactory->getEmptyModel(FileModel::class);

        if( $this->isAjax() ){
            if ($form->isSubmitted()) {

                $form->validate();

                if ($form->isValid()) {
                    $imageInfo = [];
                    $normalizesFiles = Utils::reArrayFiles($_FILES['path']);

                    foreach ($normalizesFiles as $val){
                        $fileUploader = new FileUploader($val, UPLOAD_PATH, 'path');
                        $path = $fileUploader->generateFilename('img');

                        if($fileUploader->upload($path)){
                            $insertId = $model->saveNewFile($this->user->getUserModel()->id,$path,$fileUploader->getClientOriginalName());

                            if($insertId){
                                $imageInfo[$insertId] = '/uploads/'. $path;
                            }

                            unset($fileUploader);
                        }
                    }

                    echo json_encode(['info' => $imageInfo,'errorFlag' => 0]);
                    die();
                }else{
                    $errors = $form->getError('path');
                    echo json_encode(['errors' =>$errors,'errorFlag' => 1]);
                    die();
                }
            }
        }

        $view_params = ['form' => $form,'title' => $this->pageTitle,'maxFiles' => FileForm::MAX_FILE_UPLOADS, 'maxSize' => FileForm::UPLOAD_MAX_FILESIZE];
        return $this->templateEngine->render('saver/add',$view_params );
    }

    public function actionView() {
        $id = $this->getParam('id');

        $data  = $this->modelFactory->load(FileModel::class, $id);
        $this->pageTitle = 'Изображение #'. $data->id;

        $view_params = ['data' => $data,'title' => $this->pageTitle];
        return $this->templateEngine->render('saver/view', $view_params);
    }

    public function actionAll(){
        $this->pageTitle = 'Загруженные изображения';
        $model = $this->modelFactory->getEmptyModel(FileModel::class);

        $userImages = $model->findAllBy(['user_id' =>$this->user->getUserModel()->id]);

        $view_params = ['images' => $userImages, 'title' => $this->pageTitle];

        return $this->templateEngine->render('saver/all', $view_params);
    }
}