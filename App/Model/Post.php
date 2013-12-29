<?php

class Post
{
    protected $id;

    protected $name;

    protected $description;

    protected $filePath;

    protected $validationErrors = array();

    /**
     * Validates input
     * @return bool
     */
    public function validate()
    {
        if (false === ($this->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING))) {
            $this->validationErrors['name'] = 'This field is wrong.';
            return false;
        }

        if (false === ($this->description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING))) {
            $this->validationErrors['description'] = 'This field is wrong.';
            return false;
        }

        $this->filePath = $this->checkUploadedFile();

        return (bool)$this->filePath;
    }

    /**
     * Checks the uploaded file, move it to upload directory.
     * @return bool|string Filename on success or false on failure.
     */
    protected function checkUploadedFile()
    {
        $whitelist = array('jpg', 'gif', 'jpeg', 'JPG', 'GIF', 'JPEG');

        if ($_FILES['file']['error']) {
            $this->validationErrors['file'] = 'Error occured when uploading file.';

            return false;
        } else {
            $fileExtension = array_pop(explode('.', $_FILES['file']['name']));

            if (false === in_array($fileExtension, $whitelist)) {
                $this->validationErrors['file'] = "You can not upload file of type $fileExtension.";
            }

            $filename = md5(time()) . '.' . $fileExtension;
            $filepath = ROOT. '/upload/' . $filename;
            move_uploaded_file($_FILES['file']['tmp_name'], $filepath);

            return $filename;
        }
    }

    public function getValidationErrors()
    {
        return $this->validationErrors;
    }

    public function save()
    {
        global $app;

        $app['db']->insert('post', array(
                                        'name' => $this->name,
                                        'description' => $this->description,
                                        'file_path' => $this->filePath,
                                   ));
    }
}