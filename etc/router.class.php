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

namespace urlshortener\etc;

use urlshortener\etc\Config as Config;

class Router {
    private static $instance;
    private $url,
            $queryString;
    
    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new Router();
        }
        return self::$instance;
    }
    
    public function __construct() {
        $this->url = $_SERVER['REQUEST_URI'];
        $this->queryString = strpos($this->url,"?")!==FALSE ? '?'.explode("?",$this->url)[1] : "";
        $this->url = rtrim(ltrim(str_replace(Config::BASE_PATH, "", str_replace($this->queryString,"",$this->url)),'/'),'/');
    }
    
    public function getPath() {
        $folder = $this->isApiCall() ? Config::API_FOLDER : Config::TPL_FOLDER;
        return './'.$folder.explode("/",explode("?",$this->url)[0])[0].'.php';
    }
    
    public function getArgs() {
        
        $full = explode("/",$this->url);
        unset($full[0]);

        return array_values($full);
    }
    
    public function getUrl() {
        return $this->url;
    }
    
    public function getSite() {
        return explode("/",$this->url)[0];
    }
    
    public function isApiCall() {
        if(count($this->getArgs())>0&&end($this->getArgs())=="api") {
            return true;
        } else {
            return false;
        }
    }
    
    public function route() {
        if(file_exists($this->getPath())) {    
            include($this->getPath());
        } else {
            include('./'.Config::TPL_FOLDER.Config::DEFAULT_ROUTE.".php");
        }
    }
}
