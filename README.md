# Directory Utility PHP class

This is a simple PHP directory helper class. I built this because I wanted an automated method of generating HTML links from the directory contents with minimal hassle.

### Instructions

1. Create an index file for the directory *(e.g. index.php)*
2. Include the PHP class *(see index.php for details)*
3. Setup any custom configuration in an array *(see index.php for details)*
4. Instantiate the `directoryUtil` class
5. Run the public `listItems` method, and kick back!

### Example usage

This is also inside `index.php` to help get you started. The settings passed to `$config` below are already **the defaults**, but they're here for you to see.

```php
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

echo $dirUtil->listItems( "ol" );
```
