<?php
require_once dirname(__FILE__) . '/include_elevforeningen.php';

/* TEMP HACK SENDING TO LOGIN */
if (!empty($_GET['code'])) {
	header('location: login.php?handle='.$_GET['code']);
	exit;
}
/* HACK END */

require_once 'MDB2.php';
require_once 'HTML/QuickForm.php';
require_once 'IntrafacePublic/Contact/XMLRPC/Client.php';
require_once 'IntrafacePublic/Debtor/XMLRPC/Client.php';
require_once 'IntrafacePublic/Shop/XMLRPC/Client.php';

session_start();

$credentials = array(
    'private_key' => INTRAFACE_PRIVATE_KEY,
    'session_id' => md5(session_id()));

function is_jubilar($auth) {
    $jubilar = false;
    $db = MDB2::factory(DB_DSN);
    $jubilar_aargange = array();
    $result = $db->query("SELECT aargange FROM elevforeningen_jubilar ORDER BY id DESC");
    if ($row = $result->fetchRow(MDB2_FETCHMODE_ASSOC)){
        $jubilar_aargange = array_values(unserialize($row['aargange']));
    }

    $keywords = $auth->getConnectedKeywords((int)$_SESSION['contact_id']);
    $jubilar = false;

    if (is_array($keywords)) {
        foreach ($keywords as $key => $value) {
            if (in_array($value['id'], $jubilar_aargange)) {
                $jubilar = true;
            }
        }
    }
    return $jubilar;
}

function utf8_decoding($string) {
    if (is_array($string)) {
        return array_map('utf8_decoding', $string);
    }
    if (is_object($string)) {
    	return $string->local;
    }
    return utf8_decode($string);
}

$auth = new IntrafacePublic_Contact_XMLRPC_Client($credentials, false);

if (!$auth->isLoggedIn()) {
    header('Location: login.php');
    exit;
}
