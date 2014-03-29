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

namespace urlshortener\data;

class Url {

    private $url;

    public static function constructUrl($url) {
        $validated = self::validate($url);
        if ($validated != null) {
            return new Url($validated);
        } else {
            return null;
        }
    }

    protected function __construct($url) {
        $this->url = $url;
    }

    public function getUrl() {
        return $this->url;
    }

    private static function validate($url, $firstTry = true) {
        if (!filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED)) {
            if ($firstTry) {
                return self::validate("http://".$url, false);
            } else {
                return null;
            }
        } else {
            return $url;
        }
    }

}
