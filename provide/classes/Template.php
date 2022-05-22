<?php
/***
 * Copyright (c) 2022 DevRas
 * 
 */

class Template
{
    public function __construct($root)
    {
        $this->root = $root;
    }

    protected $root;

    public function viewModel($model, $args = [])
    {
        $args["__LOADER__"] = $this;

        $path = $this->root . DIRECTORY_SEPARATOR . $model . ".php";
        if (!file_exists($path))
        {
            return false;
        }

        return @include $path;
    }
}

