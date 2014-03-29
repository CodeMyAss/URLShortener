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

use urlshortener\etc\Database as DB;

class ShortenedUrl extends Url {

    private $code;

    public static function constructFromUrl(Url $url, $prefferedCode=null) {
        try {
            $stmt = DB::getInstance()->prepare("SELECT * FROM urls WHERE url=?");
            $stmt->bindValue(1, $url->getUrl());
            $stmt->execute();
            $res = $stmt->fetch();
            if (!empty($res)&&empty($prefferedCode)) {
                return new ShortenedUrl($res['code'], $url->getUrl());
            } else {
                $id = !empty($prefferedCode) && !self::exists($prefferedCode) && self::validateCode($prefferedCode)!=null ? self::validateCode($prefferedCode) : self::getRandomId();
                $addstmt = DB::getInstance()->prepare("INSERT INTO urls (`url`,`code`) VALUES(?,?)");
                $addstmt->bindValue(1, $url->getUrl());
                $addstmt->bindParam(2, $id);
                $addstmt->execute();
                return new ShortenedUrl($id, $url->getUrl());
            }
        } catch (\PDOException $e) {
            header("Location: ./error");
        }
    }

    public static function getByCode($code) {
        try {
            $stmt = DB::getInstance()->prepare("SELECT * FROM urls WHERE code=?");
            $stmt->bindParam(1, $code);
            $stmt->execute();
            $res = $stmt->fetch();
            if (!empty($res)) {
                return new ShortenedUrl($res['code'], $res['url']);
            }
            return null;
        } catch (\PDOException $e) {
            header("Location: ./error");
        }
    }

    public static function validateCode($code) {
        if(!preg_match("/([A-Za-z]+)$/",$code)) {
            return null;
        } else {
            if(strlen($code)>20) {
                return substr($code,20);
            } else {
                return $code;
            }
        }
    }
    
    public static function getRandomId() {
        $random = self::getRandString();
        if (self::exists($random)) {
            return self::getRandomId();
        } else {
            return $random;
        }
    }

    public static function exists($code) {
        try {
            $stmt = DB::getInstance()->prepare("SELECT * FROM urls WHERE code=?");
            $stmt->bindParam(1, $code);
            $stmt->execute();
            $res = $stmt->fetch();
            return !empty($res);
        } catch (\PDOException $e) {
            header("Location: ./error");
        }
    }

    private static function getRandString($length = 5, $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') {
        $str = '';
        $count = strlen($characters);
        while ($length--) {
            $str .= $characters[mt_rand(0, $count-1)];
        }
        return $str;
    }

    protected function __construct($code, $url) {
        parent::__construct($url);
        $this->code = $code;
    }
    
    public function getCode() {
        return $this->code;
    }

    public function route() {
        header("Location: ".parent::getUrl());
    }

}
