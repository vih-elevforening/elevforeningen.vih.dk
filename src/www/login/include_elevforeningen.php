<?php
require('../config.elevforeningen.php');
//require('LiveUser/LiveUser.php');
require('HTML/QuickForm.php');
//require('DB.php');
//require(PATH_INCLUDE_VIH . 'elevforeningen/Medlem.php');

require(dirname(__FILE__) . '/Auth.php');
require(dirname(__FILE__) . '/DebtorClient.php');
require(dirname(__FILE__) . '/ContactClient.php');
require(dirname(__FILE__) . '/WebshopClient.php');
require(dirname(__FILE__) . '/Template/Template.php');
require('MDB2.php');

function e($phrase)
{
	echo htmlentities($phrase);
}

function __($phrase)
{
	return $phrase;
}

function url($phrase)
{
    return $phrase;
}

// get_secure_server();

function _is_jubilar($auth) {
	$jubilar = false;
	$db = new DB_Sql;
	$db->query("SELECT aargange FROM elevforeningen_jubilar ORDER BY id DESC");
	if ($db->nextRecord()){
		$jubilar_aargange = array_values(unserialize($db->f('aargange')));
	}

	$contact = $auth->get();
	$keywords = $auth->contact_client->getConnectedKeywords($contact['id']);
	$jubilar = false;

	if (is_array($keywords)) {
		foreach ($keywords AS $key => $value) {
			if (in_array($value, $jubilar_aargange)) {
				$jubilar = true;
			}
		}
	}
	return $jubilar;
}

