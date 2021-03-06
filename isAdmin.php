<?php

$user = samaccountname !! 

function isAdministration($user) {
    $groupeAdm = 'CN= XXXX,OU= XXXX,OU= XXXX ,OU= XXXX, OU= XXXX ,DC=XXX,DC=XXX,DC=XX';
    $basedn = 'OU=XX,DC=XX,DC=XXX,DC=XX';
    $ldapnom = 'CN=XXXX,OU=XXXXXX,OU=XXXX,DC=XXX,DC=XXX,DC=XX';
    $ldappass = 'XXXX';  // Mot de passe associé

    $ldapconnect = ldap_connect("your full ldap adress here") or die("Unable to connect to LDAP server...");
    $ldapbind = ldap_bind($ldapconnect, $ldapnom, $ldappass);

// get dn form user
    $result = ldap_search($ldapconnect, $basedn, "(samaccountname={$user})", array('dn'));
    if (!$result) {
        return false;
    }
    $entries = ldap_get_entries($ldapconnect, $result);
    if ($entries['count'] <= 0) {
        return false;
    }

    $userDN = $entries[0]['dn'];
    $result = ldap_read($ldapconnect, $userDN, "(memberof={$groupeAdm})", array('members'));
    if (!$result) {
        return false;
    }
    $entries = ldap_get_entries($ldapconnect, $result);
    return ($entries['count'] > 0);
}


function get_UserName() {
    $test = $_SERVER['REMOTE_USER'];
    $tab = split('[\]', $test);
    return($tab[1]);
}

$isAdm = isAdministration(get_UserName());



?>