<?php

$hostname_homepagesdb 		= "localhost";
$database_homepagesdb 		= "upbooking";
$database_geo_homepagesdb 	= "hgw_geoplaces";
$username_homepagesdb 		= "holyguard";
$password_homepagesdb 		= "boris01";
    /**********************************************************************
    *  ezSQL initialisation for mySQL
    */
    // Include ezSQL core
    require_once $_SERVER['DOCUMENT_ROOT'].'/httpDbReplica/core/ezsql3/shared/ez_sql_core.php';

    // Include ezSQL database specific component
    require_once $_SERVER['DOCUMENT_ROOT'].'/httpDbReplica/core/ezsql3/mysql/ez_sql_mysql.php';
	
	// Include ezSQL database specific component
    require_once $_SERVER['DOCUMENT_ROOT'].'/httpDbReplica/core/ezsql3/pdo/ez_sql_pdo.php';
	
	

    // Initialise database object and establish a connection
    // at the same time - db_user / db_password / db_name / db_host
    $db = new ezSQL_mysql($username_homepagesdb,$password_homepagesdb,$database_homepagesdb,$hostname_homepagesdb);
	
	$dbPDO = new ezSQL_pdo('mysql:host='.$hostname_homepagesdb.';dbname='.$database_homepagesdb.'',$username_homepagesdb,$password_homepagesdb);
	
            // Cache expiry
    $db->cache_timeout = 240; // Note: this is in hours
	$dbPDO->cache_timeout = 1; // Note: this is in hours

    // Specify a cache dir. Path is taken from calling script
    $db->cache_dir = $_SERVER['DOCUMENT_ROOT'].'/cache/ezsql/';
	$dbPDO->cache_dir = $_SERVER['DOCUMENT_ROOT'].'/cache/ezsql/';
	

    // (1. You must create this dir. first!)
    // (2. Might need to do chmod 775)

    // Global override setting to turn disc caching off
    // (but not on)
    $db->use_disk_cache = false;
	$dbPDO->use_disk_cache = false;

    // By wrapping up queries you can ensure that the default
    // is NOT to cache unless specified
    $db->cache_queries = false;
	$dbPDO->cache_queries = false;


