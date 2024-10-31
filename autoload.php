<?php

spl_autoload_register(function ($class) {

	// project-specific namespace prefix
	$prefix = 'Prodigy\\';

	// base directory for the namespace prefix
	$base_dir = __DIR__ . '/';

	// does the class use the namespace prefix?
	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !== 0) {
		// no, move to the next registered autoloader
		return;
	}

	// get the relative class name
	$relative_class = substr($class, $len);

	$parts = explode('\\', $relative_class);
	$parts = array_map('strtolower', $parts);
	$file_name = 'class-' . str_replace('_', '-', array_pop($parts));


	// replace the namespace prefix with the base directory, replace namespace
	// separators with directory separators in the relative class name, append
	// with .php
	$file = $base_dir . implode('/', $parts) . '/' . $file_name . '.php';

	// if the file exists, require it
	if (file_exists($file)) {
		require $file;
	}
});