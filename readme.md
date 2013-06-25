Follomonk
=========

Follomonk is a PHP plugin for followerwonk.com: it allows you search twitter bios according criterias.

followerwonk.com does not sponsor this API.


Requirements
------------
* PHP 5.2.0 or newer
* <a href="https://github.com/92bondstreet/swisscode" target="_blank">SwissCode</a>


What comes in the package?
--------------------------
1. `follomonk.php` - The Follomonk class functions to get results from request to followerwonk.com
2. `example.php` - All Follomonk functions call


Example.php
-----------

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


To start the demo
-----------------
1. Upload this package to your webserver.
4. Open `example.php` in your web browser and check screen output. 
5. Enjoy !


Project status
--------------
Follomonk is currently maintained by Yassine Azzout.


Authors and contributors
------------------------
### Current
* [Yassine Azzout][] (Creator, Building keeper)

[Yassine Azzout]: http://www.92bondstreet.com


License
-------
[MIT license](http://www.opensource.org/licenses/Mit)

