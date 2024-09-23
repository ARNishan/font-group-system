<?php

class FontDeleter {
    public function delete($fontUrl) {
        if (file_exists($fontUrl)) {
            unlink($fontUrl); // Deletes the file
            return ['success' => 'Font deleted successfully.'];
        }

        return ['error' => 'Error: File not found.'];
    }
}

