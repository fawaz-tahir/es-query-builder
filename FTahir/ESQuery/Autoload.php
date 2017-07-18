<?php

namespace FTahir\ESQuery;

class Autoload {

	private $baseDirectory;
	private $prefix;
	private $prefixLength;

	public function __construct($directory = __DIR__) {
		$this->baseDirectory = $directory;
		$this->prefix = __NAMESPACE__.'\\';
		$this->prefixLength = strlen($this->prefix);
	}

	public static function register($prepend = false) {
		spl_autoload_register([ new self(), 'autoload' ], true, $prepend);
	}

	public function autoload($className) {

		if ( 0 === strpos($className, $this->prefix) ) {
			$classPath = substr( $className, $this->prefixLength );
			$classParts = explode( '\\', $classPath );

			$path = $this->baseDirectory.DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR, $classParts ).'.php';

			if (is_file($path) === true) {
				require_once( $path );
			}
		}
	}
}
