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


// SwissCode plugin
// Download on https://github.com/92bondstreet/swisscode
require_once('swisscode.php');	

// Followerwonk results order
define("RELEVANCE","r");			// by relevance
define("TWEETS","stct");			// tweets number
define("FOLLOWING","fr");			//	following
define("FOLLOWERS","fl");			// followers
define("DAYS_OLD","crdt");			// days old account
define("AUTHORITY","influence");	// social authority
 
// Followerwonk options
define("ALL","q");			// all 
define("LOCATION","l");		// geo location
define("NAME","n");			// account nale
define("URL","url");			// accout url

define("FOLLOWERWONK_URL","http://followerwonk.com/bio/?");		
define("RESULTS_PER_PAGE","50");		
 
 
 //Report all PHP errors
error_reporting(E_ALL);
set_time_limit(0);



class TwitterAccount { 
	// Twitter name
	public $name = "";
	// Twitter account name
	public $account = "";
	// Number of tweets
	public $tweets = "";
	// Following number
	public $following = "";
	// Following number
	public $followers = "";
	// Days old of account
	public $days_old = "";
	// Following number
	public $social_authority = "";
}


class FolloMonk{
		
	// file dump to log
	private  $enable_log;
	private  $log_file_name = "rapummies.log";
	private  $log_file;
	
	
	/**
	 * Constructor, used to input the data
	 *
	 * @param bool $log
	 */
	public function __construct($log=false){
					
		$this->enable_log = $log;
		if($this->enable_log)
			$this->log_file = fopen($this->log_file_name, "w");
		else
			$this->log_file = null;
			
	}
	
	/**
	 * Destructor, free datas
	 *
	 */
	public function __destruct(){
	
		// and now we're done; close it
		if(isset($this->log_file))
			fclose($this->log_file);
	}
	
	/**
	 * Write to log file
	 *
	 * @param $value string to write 
	 *
	 */
	function dump_to_log($value){
		fwrite($this->log_file, $value."\n");
	}
	
	
	/**
	 * Get twitter account from query
	 *
	 * @param 	$query 			array of parameters (location, name...)
	 * @param 	$order_by 		
	 * @param 	$bios			number of accounts to return 	
	 *
	 * @return array|null
	 */
	
	
	function search_bios($query, $order_by=FOLLOWERS, $bios=50){
		
		if(isset($query) && count($query)>0){
			$follower_request =  $this->custom_request($query, $order_by);
			return $this->generate_screenname($follower_request, $bios);
		}
		
		return null;
	}
	
	/**
	 * Custom a search bios request
	 *
	 * @param 	$query 			array of parameters (location, name...)
	 * @param 	$order_by
	 *
	 * @return string|null
	 */

	function custom_request($query, $order_by=FOLLOWERS){

		if(isset($query) && count($query)>0){
			$param = NULL;
					
			// query with keywords...
			if(array_key_exists(ALL,$query))
				$param .= ALL."=".urlencode($query[ALL])."&";
			if(array_key_exists(LOCATION,$query))
				$param .= LOCATION."=".urlencode($query[LOCATION])."&";
			if(array_key_exists(NAME,$query))
				$param .= NAME."=".urlencode($query[NAME])."&";
			if(array_key_exists(URL,$query))
				$param .= URL."=".urlencode($query[URL])."&";		
			if(!isset($param))
				return NULL;

			// order by
			$param .= "s=".$order_by;
					
			return FOLLOWERWONK_URL.$param;			 
		}
		
		return null;
	}

	/**
	 * Get twitter accout name from request
	 *
	 * @param 	$url 			with request
	 * @param 	$bios 			number of accounts to return 	
	 *
	 * @return string|null
	 */
	function generate_screenname($url, $bios){

		if(!isset($url))
			return false;

		$twitter_accounts = array();

		// Step 0. Get page number according to number results
		$nb_pages = ceil($bios / RESULTS_PER_PAGE);

		// Step 1. call all urls
		for($page=1;$page<=$nb_pages;$page++){

			$bio_url = $url."&p=".$page;
			$html = MacG_connect_to($bio_url);
			$html = str_get_html($html);
			
			// parse all pages
			$accounts = $html->find('.stripable_doublerow');
			foreach($accounts as $result){
				
				$current_result = new TwitterAccount();

				$name =  $result->find(".person_fulln",0)->plaintext;
				$account =  str_replace("@","",$result->find(".person_scrn",0)->innertext);
				
				$current_result->name = $name;
				$current_result->account = $account;
				$twitter_accounts[] = $current_result;
			}	
					
			unset($html);
		}

		return array_slice($twitter_accounts,0,$bios);		// get only number of results defined by users 
	}

}
?>