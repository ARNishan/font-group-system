<?php

require_once 'FontValidation.php';
class FontUploader {
    private $validator,$target_dir = "fonts/";

    public function __construct() {
        $this->validator = new FontValidation();
    }

    public function upload($file) {
        if (!$this->validator->isValid($file)) {
            return ['error' => 'Invalid file type. Only TTF files are allowed.'];
        }
        $target_file = $this->target_dir . basename($file["name"]);

        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return [
                'fontName' => $file["name"],
                'fontUrl' => $target_file
            ];
        }

        return ['error' => 'Error uploading file.'];
    }
}

