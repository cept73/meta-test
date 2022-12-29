<?php

namespace Meta;

require 'vendor/autoload.php';

use Meta\Classes\Application;
use Meta\Classes\ArrayHelper;

new Application(ArrayHelper::getWithoutFirstElement($argv));
