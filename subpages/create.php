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
namespace urlshortener\subpages;
use urlshortener\etc\Config as Config;

include(Config::API_FOLDER."create.php");

if(!empty($params['code'])) {
    echo '<div class="info">'.Config::ADDR.$params['code'].'</div>';
}
if($params['result']!="success"&&!empty($_GET['url'])) {
     echo '<div class="info">'.$params['result'].'</div>';
}
    ?>
<form action="./create" method="GET">
    <fieldset>
        <label for="url">Url</label>
        <input id="url" type="text" name="url" placeholder="http://..." class="url">
        <label for="code">Url</label>
        <input id="code" type="text" name="code" placeholder="Code (optional)" maxlength="20" class="code">
        <input type="submit" value="Short it!" class="submit">
    </fieldset>
</form>
    <?php

