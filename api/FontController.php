<?php

class FontController {
    private $uploader;
    private $deleter;

    public function __construct() {
        $this->uploader = new FontUploader();
        $this->deleter = new FontDeleter();
    }

    public function handleUpload($file) {
        return $this->uploader->upload($file);
    }

    public function handleDelete($fontUrl) {
        return $this->deleter->delete($fontUrl);
    }
}
?>
