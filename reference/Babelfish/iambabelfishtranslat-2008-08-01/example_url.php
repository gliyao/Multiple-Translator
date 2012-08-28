<?
	/**
	 *  IAM_BabelFish_Translate A class for translating text and URLs using Yahoo's BabelFish translation service
	 *  @desc IAM_BabelFish_Translate A class for translating text and URLs using Yahoo's BabelFish translation service
	 *  @package IAM_BabelFish_Translate
	 *  @author  Iván Ariel Melgrati <imelgrat@gmail.com>
	 *  @version 1.0
	 *  @copyright 2008
	 *
	 *  Requires PHP v 4.0+ with the cURL extension loaded
	 *
	 *  This library is free software; you can redistribute it and/or
	 *  modify it under the terms of the GNU Lesser General Public
	 *  License as published by the Free Software Foundation; either
	 *  version 2 of the License, or (at your option) any later version.
	 *
	 *  This library is distributed in the hope that it will be useful,
	 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
	 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
	 *  Lesser General Public License for more details.
	 */
 // Flag Latin1 text is coming
 header("Content-Type: text/html; charset=ISO-8859-1");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
</head>
<body>
<?php
// Include Class definition file
require_once("IAM_BabelFish_Translate.class.php");

// Create translator instance
$translator= new IAM_BabelFish_Translate('en', 'nl');

	//Print translation results.
	echo $translator->translateURL("http://babelfish.yahoo.com");
?>
</body>
</html>