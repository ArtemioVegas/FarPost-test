<?php
namespace Artemio\forms;
use Artemio\helpers\Utils;


class FileForm extends BaseForm {

    protected $fields = ['path'];
    protected $labels = [
        'path' => 'Изображения'
    ];
    protected $rules = [
        ['requiredFile', 'path'],
        ['maxCountFile', 'path'],
        ['maxSizeFile', 'path'],
        ['image', 'path'],
    ];

    const MAX_FILE_UPLOADS = 20;
    const UPLOAD_MAX_FILESIZE = 5242880; // 5MB

    public function __construct($data = false) {
        $this->name = 'saver';

        parent::__construct($data);
    }

    protected function runRequiredFileValidator($field) {
        $result = true;

        if ( !isset($_FILES[$field]) || empty($_FILES[$field]) ) {

            $result = false;
        }

        if (!$result) {
            $this->errors[$field][] = "Загрузите хотя бы 1 файл";
        }

        return $result;
    }

    protected function runMaxCountFileValidator($field) {
        $result = true;

        if ( count($_FILES[$field]['tmp_name']) > FileForm::MAX_FILE_UPLOADS ) {
            $result = false;
        }

        if (!$result) {
            $this->errors[$field][] = "Превышено максимальное количество файлов - " . FileForm::MAX_FILE_UPLOADS;
        }

        return $result;
    }

    protected function runMaxSizeFileValidator($field) {
        $result = true;

        if ( array_sum($_FILES[$field]['size']) > FileForm::UPLOAD_MAX_FILESIZE ) {
            $result = false;
        }

        if (!$result) {
            $this->errors[$field][] = "Превышен максимальный размер загружемых файлов - ". Utils::formatBytes(FileForm::UPLOAD_MAX_FILESIZE);
        }

        return $result;
    }
}