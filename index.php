<?php

// Include the PHP class
require 'directoryUtil.php';

// Apply any custom settings
// Listed below are the default settings - so feel free to omit them
$config = array(
	'directory' => './',
	
	'exceptions' => array(
		'index.php',
		'index.html'
	),
	
	'showDirectories' => true,
	
	'showHiddenFiles' => false
);

// Instantiate the class
$dirUtil = new DirectoryUtil( $config );

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Directory Utility class - PHP</title>
</head>
<body>

<?php 

// Print out an ordered list of HTML links, pointing to the directory items
// You can pass 'ul' instead of 'ol', if you prefer
echo $dirUtil->listItems( 'ol' );

?>

</body>
</html>
