<?php
/**
 * Follomonk
 *
 * Followerwonk non-official PHP API. PHP plugin for followerwonk.com
 * Search twitter bios request
 * followerwonk.com does not sponsor this API.
 *
 * Copyright (c) 2013 - 92 Bond Street, Yassine Azzout
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 *	The above copyright notice and this permission notice shall be included in
 *	all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package Follomonk
 * @version 1.0
 * @copyright 2013 - 92 Bond Street, Yassine Azzout
 * @author Yassine Azzout
 * @link http://www.92bondstreet.com Follomonk
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
 
require_once('follomonk.php');

// Init constructor with false value: no dump log file
$Followerwonk = new FolloMonk();

// Get twitter account from query : in all fields. Order by followers
$bios = $Followerwonk->search_bios(array(ALL => "macklemore"), FOLLOWERS,75); 
print_r($bios);

// Get twitter account from query : name and location. Order by social authority
$bios = $Followerwonk->search_bios(array(NAME => "geek", LOCATION => "nyc"), AUTHORITY,10);
print_r($bios);

// Get twitter account from query : url and location. Order by tweets
$bios = $Followerwonk->search_bios(array(URL => "music", LOCATION => "usa"), TWEETS,60);
print_r($bios);

?>