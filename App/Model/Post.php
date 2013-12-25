<?php

class Post
{
    protected $id;

    protected $name;

    protected $description;

    protected $filePath;

    protected $validationErrors = array();

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

    protected function checkUploadedFile()
    {
        if (isset($_FILES['file']['error'])) {
            $this->validationErrors['file'] = 'Error occured when uploading file.';

            return false;
        } else {
            $filepath = ROOT.'/upload/'.md5(time());
            move_uploaded_file($_FILES['file']['tmp_name'], $filepath);

            return $filepath;
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