<?php
/*
 * This is a simple database setup helper for this demo project
 * You can update values in App/Database/config.php manually
 * Make sure to add data to tables manually
 */

// Ensure the script can only be run via CLI
use Sperky\App\Database\DatabaseSeeder;

if ( php_sapi_name() !== 'cli' ) {
	die("This script can only be run from the command line.");
}

require_once __DIR__ . '/autoload.php';


function __($text)
{
	$red = "\033[31m";
	$reset = "\033[0m";
	$text = preg_replace('/\<(.*?)\>/', $red . '$1' . $reset, $text);
	return $text;
}


function separator()
{
	print_r("---------------------------------------" . PHP_EOL);
}


function clear()
{
	for ( $i = 0; $i < 50; $i++ ) {
		print_r(PHP_EOL);
	}
}


function greet()
{
	clear();
	separator();
	print_r(
		__("This is a setup script for <Sperky>,")
		. PHP_EOL .
		__("please provide needed information")
		. PHP_EOL
	);
	separator();
}


function writeConfig($data)
{
	$configContent = "<?php\n\n";
	$configContent .= "return [\n";
	$configContent .= "    'host' => '" . addslashes($data['host']) . "',\n";
	$configContent .= "    'database' => '" . addslashes($data['database']) . "',\n";
	$configContent .= "    'login' => '" . addslashes($data['login']) . "',\n";
	$configContent .= "    'password' => '" . addslashes($data['password']) . "',\n";
	$configContent .= "];\n";
	
	file_put_contents(__DIR__ . '/App/Database/config.php', $configContent);
}


greet();
// DB ADDRESS
print_r(
	__("Please enter <Database host>")
	. PHP_EOL
);
$host = readline('(Enter for localhost):');
$host = $host ?: 'localhost';

print_r(
	__("Please enter <Database name>")
	. PHP_EOL
);
$db = readline(':');
$db = $db ?: '';

greet();
// DB LOGIN
print_r(
	__("Please enter <User name>")
	. PHP_EOL
);
$user = readline(':');
$user = $user ?: '';


greet();
// DB LOGIN
print_r(
	__("Please enter <User password>")
	. PHP_EOL
);
$pass = readline(':');
$pass = $pass ?: '';

$data = [
	'host' => $host,
	'database' => $db,
	'login' => $user,
	'password' => $pass,
];
writeConfig($data);

clear();
print_r(
	__('<Config> has been updated!') . PHP_EOL
);

print_r(
	__("Do you wish to run <Seeder?>")
	. PHP_EOL .
	__("<WARNING!> This will drop all tables in the database! Type <yes> or press <Enter> to continue.")
	. PHP_EOL
);
$shouldSeed = readline('(Enter for yes):');
$shouldSeed = $shouldSeed ?: 'yes';

if($shouldSeed == 'yes'){
	( new DatabaseSeeder() )->seed();
	
	print_r(
		__('Done <seeding>!') . PHP_EOL
	);
}else{
	print_r(
		__('Skipped <seeding>! Done.') . PHP_EOL
	);
}


