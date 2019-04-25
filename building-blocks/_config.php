<?php

// set image upload max size
define('VIDEO_FILE_SIZE_LIMIT', ini_get('upload_max_filesize'));
define('VIDEO_IMAGE_FILE_SIZE_LIMIT', '512000');

define('BUILDING_BLOCKS_DIR', basename(dirname(__FILE__)));