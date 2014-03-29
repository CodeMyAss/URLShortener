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

class Database extends \PDO {
 
	protected static $instance;
	public static function getInstance() {
		if(empty(self::$instance)) {
			self::$instance = new Database("mysql:host=".Config::DB_HOST.';port='. Config::DB_PORT.';dbname='.Config::DB_NAME, Config::DB_USER, Config::DB_PASS);
		}
		return self::$instance;
	}
 
}