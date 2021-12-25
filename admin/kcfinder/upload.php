<?php

/** This file is part of KCFinder project
  *
  *      @desc Upload calling script
  *   @package KCFinder
  *   @version 3.12
  *    @author Pavel Tzonkov <sunhater@sunhater.com>
  * @copyright 2010-2014 KCFinder Project
  *   @license https://opensource.org/licenses/GPL-3.0 GPLv3
  *   @license https://opensource.org/licenses/LGPL-3.0 LGPLv3
  *      @link https://kcfinder.sunhater.com
  */

require "core/bootstrap.php";
$uploader = "kcfinder\\uploader";  // To execute core/bootstrap.php on older
$uploader = new $uploader();       // PHP versions (even PHP 4)
$uploader->upload();
