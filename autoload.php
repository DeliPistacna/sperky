<?php

spl_autoload_register(function ($class) {
	$prefix = 'Sperky\\'; // Namespace prefix
	$base_dir = __DIR__.'/'; // Base directory for the namespace
	
	// Check if the class uses the namespace prefix
	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !== 0) {
		// Not in our namespace, skip
		return;
	}
	
	// Get the relative class name
	$relative_class = substr($class, $len);
	
	// Replace namespace separators with directory separators in the relative class name
	$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
	
	// If the file exists, require it
	if (file_exists($file)) {
		require $file;
	} else {
		// Optional debugging output
		echo "Class $class could not be autoloaded. Tried $file\n";
	}
});
