<?php

require 'directoryUtil.php';

$config = array(
	'directory' => './',
	
	'exceptions' => array(
		'index.php',
		'index.html'
	),
	
	'showDirectories' => true,
	
	'showHiddenFiles' => false
);

$dirUtil = new DirectoryUtil( $config );

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Title</title>
</head>
<body>

<?php echo $dirUtil->listItems("ol"); ?>

</body>
</html>
