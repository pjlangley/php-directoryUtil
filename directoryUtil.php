<?php

/*
 * Directory utility class
 * - Contains some useful methods when working with directory contents
 */
class DirectoryUtil
{
	/*
	 * References the directory in subject
	 * - This can be overidden in the settings, during instantiation. E.g.
	 *
	 * $config = array(
	 *   'directory' => '../../'
	 * );
	 * $dirUtil = new DirectoryUtil( $config );
	 */
	private $dir = './';

	/*
	 * References any items you want to remain hidden from any listing methods
	 * - This can be overidden in the settings, during instantiation. E.g.
	 *
	 * $config = array(
	 *   'exceptions' => array(
	 *     'index.php',
	 *     'somethingElse.html',
	 *     'secretDirectory'
	 *   );
	 * );
	 * $dirUtil = new DirectoryUtil( $config );
	 */
	private $exceptions = array(
		'index.html',
		'index.php'
	);
	
	/*
	 * References the available directory items
	 * - This is populated on instantiation
	 */
	private $directoryItems;
	
	/*
	 * References the default HTML tag for the listItems method
	 */
	public $listType = 'ol';
	
	/*
	 * Setting to include/exclude directories from the list of items
	 * - This setting will alter the final content of $this->directoryItems
	 * - This can be overidden in the settings, during instantiation. E.g.
	 *
	 * $config = array(
	 *   'showDirectories' => false
	 * );
	 * $dirUtil = new DirectoryUtil( $config );
	 */
	private $showDirectories = true;
	
	/*
	 * Setting to include/exclude hidden files from the list of items
	 * - This setting will alter the final content of $this->directoryItems
	 * - This can be overidden in the settings, during instantiation. E.g.
	 *
	 * $config = array(
	 *   'showHiddenFiles' => true
	 * );
	 * $dirUtil = new DirectoryUtil( $config );
	 */
	private $showHiddenFiles = false;
	
	/*
	 * Reference to any custom configuration passed in at instantiation
	 */
	private $userConfig;

	/*
	 * The all important constructor to kick things off
	 */
	public function __construct( $config ) {
		$this->userConfig = $config;
		$this->loadConfig();
		$this->directoryItems = scandir( $this->dir );
		$this->prepareList();
	}
	
	private function loadConfig() {
		/*
		 * Check if custom configuration has been passed in
		 * - Must be in array format
		 */
		if( is_array( $this->userConfig ) ) {
		
			/*
			 * Check for a custom directory in the config
			 */
			if( array_key_exists( 'directory', $this->userConfig ) ) {
				$this->setDirectory( $this->userConfig['directory'] );
			}
			
			/*
			 * Check for custom exceptions in the config
			 */
			if( array_key_exists( 'exceptions', $this->userConfig ) ) {
				$this->setExceptions( $this->userConfig['exceptions'] );
			}
			
			/*
			 * Check for a custom showDirectories option in the config 
			 */
			if( array_key_exists( 'showDirectories', $this->userConfig ) ) {
				$this->setShowDirectories( $this->userConfig['showDirectories'] );
			}
			
			/*
			 * Check for a custom showHiddenFiles option in the config 
			 */
			if( array_key_exists( 'showHiddenFiles', $this->userConfig ) ) {
				$this->setShowHiddenFiles( $this->userConfig['showHiddenFiles'] );
			}
		}
	}
	
	/*
	 * Set the custom directory
	 */
	private function setDirectory( $dir ) {
			return $this->dir = $dir;
	}
	
	/*
	 * Set the custom exceptions
	 */
	private function setExceptions( $exceptions ) {
			return $this->exceptions = $exceptions;
	}
	
	/*
	 * Set the custom showDirectories
	 */
	private function setShowDirectories( $showDirectories ) {
			return $this->showDirectories = $showDirectories;
	}
	
	/*
	 * Set the custom showHiddenFiles
	 */
	private function setShowHiddenFiles( $showHiddenFiles ) {
			return $this->showHiddenFiles = $showHiddenFiles;
	}
	
	/*
	 * Prepare the directory listing for display
	 */
	private function prepareList() {
	
		// Remove '.' and '..' from the listing
		$this->directoryItems = array_slice( $this->directoryItems, 2 );
		
		// Remove any custom exceptions from the listing
		foreach( $this->exceptions as $exception ) {
			$key = array_search( $exception, $this->directoryItems );
			if( $key !== FALSE ) {
				unset( $this->directoryItems[ $key ] );
			}
		}
		
		// If showDirectories is false, remove them from the listing
		if( ! $this->showDirectories ) {
			foreach( $this->directoryItems as $item ) {
				if( is_dir( $item ) ) {
					$key = array_search( $item, $this->directoryItems );
					unset( $this->directoryItems[ $key ] );
				}
			}
		}
		
		// If showHiddenFiles is false, remove them from the listing
		if( ! $this->showHiddenFiles ) {
			foreach( $this->directoryItems as $item ) {
				if( preg_match( '/^\./', $item ) ) {
					$key = array_search( $item, $this->directoryItems );
					unset( $this->directoryItems[ $key ] );
				}
			}
		}
	}
	
	/*
	 * HTML list output
	 * - Constructs an <ol> or <ul>
	 * @params $listType {String} - Specify the list type when called
	 */
	public function listItems( $listType ) {
		if( ! $listType ) $listType = $this->listType;
		
		$html = '<' . $listType . '>';
		foreach( $this->directoryItems as $item ) {
			$html .= '<li><a href="' . $item . '">' . $item . '</a></li>';
		}
		$html .= '</' . $listType . '>';
		
		return $html;
	}
}
