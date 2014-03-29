<?php

/* 
 * Copyright (C) 2014 Maciej Mionskowski
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace urlshortener;
error_reporting(0);
use urlshortener\etc\Router as Router;

define('BASE_PATH', realpath(dirname(__FILE__)));
spl_autoload_extensions('.class.php');
spl_autoload_register(function ($class) {
    $filename = BASE_PATH . str_replace(__NAMESPACE__, "", str_replace('\\', '/', $class));
    spl_autoload($filename);
});
if(!Router::getInstance()->isApiCall()) {
    include('/templates/header.php');
}
Router::getInstance()->route();
if(!Router::getInstance()->isApiCall()) {
    include('/templates/footer.php');
}