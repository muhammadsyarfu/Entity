<?php

namespace GooGee\Entity\Generator;


class File
{
    public $name;
    public $path;

    function __construct($name, $path)
    {
        $this->name = $name;
        $this->path = $path;
    }

    public function save($content)
    {
        $fullPath = base_path($this->path);
        if (!is_dir($fullPath)) {
            mkdir($fullPath);
        }

        $file = $fullPath . DIRECTORY_SEPARATOR . $this->name;
        if (file_exists($file)) {
            $old = $file . '.txt';
            if (file_exists($old)) {
                //
            } else {
                rename($file, $old);
            }
        }
        file_put_contents($file, $content);
    }

}