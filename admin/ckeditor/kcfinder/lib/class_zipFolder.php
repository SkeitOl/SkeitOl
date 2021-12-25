<?php

/** This file is part of KCFinder project. The class are taken from
  * https://www.php.net/manual/en/function.ziparchive-addemptydir.php
  *
  *      @desc Directory to ZIP file archivator
  *   @package KCFinder
  *   @version 2.52
  *    @author Pavel Tzonkov <sunhater@sunhater.com>
  * @copyright 2010-2014 KCFinder Project
  *   @license https://www.opensource.org/licenses/gpl-2.0.php GPLv2
  *   @license https://www.opensource.org/licenses/lgpl-2.1.php LGPLv2
  *      @link https://kcfinder.sunhater.com
  */

class zipFolder {
    protected $zip;
    protected $root;
    protected $ignored;

    function __construct($file, $folder, $ignored=null) {
        $this->zip = new ZipArchive();

        $this->ignored = is_array($ignored)
            ? $ignored
            : ($ignored ? array($ignored) : array());

        if ($this->zip->open($file, ZIPARCHIVE::CREATE) !== TRUE)
            throw new Exception("cannot open <$file>\n");

        $folder = rtrim($folder, '/');

        if (strstr($folder, '/')) {
            $this->root = substr($folder, 0, strrpos($folder, '/') + 1);
            $folder = substr($folder, strrpos($folder, '/') + 1);
        }

        $this->zip($folder);
        $this->zip->close();
    }

    function zip($folder, $parent=null) {
        $full_path = "{$this->root}$parent$folder";
        $zip_path = "$parent$folder";
        $this->zip->addEmptyDir($zip_path);
        $dir = new DirectoryIterator($full_path);
        foreach ($dir as $file)
            if (!$file->isDot()) {
                $filename = $file->getFilename();
                if (!in_array($filename, $this->ignored)) {
                    if ($file->isDir())
                        $this->zip($filename, "$zip_path/");
                    else
                        $this->zip->addFile("$full_path/$filename", "$zip_path/$filename");
                }
            }
    }
}

?>