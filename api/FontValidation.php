<?php

class FontValidation {
    public function isValid($file) {
        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        return strtolower($file_extension) === 'ttf';
    }
}

