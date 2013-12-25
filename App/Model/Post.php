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
        if (false === ($this->name = filter_input(INPUT_POST, array()))) {

        }
    }


}