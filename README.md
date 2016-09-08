# Postcode Resolver
Resolves a list of postcodes (or any location really) to a lat/long

### Usage

 1. Clone project
 2. Populate `config.php` (see below)
 3. `chmod +x process.php`
 4. `./process.php`

### config.php
Unless you have a premium account for use with the geocoding API, you can use an array of API keys

    <?php
     
    $google_api_keys = [
    	'your-first-key-here',
    	'your-second-key-here',
    	'your-third-key-here',
    	'...'
    ];
 
