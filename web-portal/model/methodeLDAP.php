<?php
/*Pour choper les variables d'environnement il faut faire :
 * $ldap_server = getenv('NOM_VARIABLE_ENVIRONNEMENT');
 *
 */
//Récupération des variables d'environnement
$password_LDAP_ADMIN = getenv('LDAP_ADMIN_PASSWORD');
$domain_niveau_1 = getenv('DOMAINENIV1');
$domain_niveau_2 = getenv('DOMAINENIV2');


require "connectionLDAP.php";
/**
 * Cette fonction permet d'autentifier un utilisateur au LDAP
 * @param string $username
 * @param string $password
 * @return boolean
 */
function authentificationAuLDAP($username, $password)
{
    $ldap_conn = connectionLDAP::getInstance()->getConnection();
    if ($ldap_conn) {
        if (@ldap_bind($ldap_conn, "cn=admin,dc=".getenv('DOMAINENIV2').",dc=".getenv("DOMAINENIV1"), getenv('LDAP_ADMIN_PASSWORD'))) {
            $search = ldap_search($ldap_conn, "dc=".getenv('DOMAINENIV2') .",dc=".getenv("DOMAINENIV1"), "(uid=" . $username . ")");
            if ($search) {
                $entries = ldap_get_entries($ldap_conn, $search);
                if ($entries["count"] > 0) {
                    $userdn = $entries[0]["dn"];
                    if (@ldap_bind($ldap_conn, $userdn, $password)) {
                        return $entries[0];
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}

/*
 * Cette fonction permet de vérifier si un utilisateur est un administrateur
 * Revoir cette fonction pour qu'elle avec les groupes admin (LDAP).
 */
function isAdmin($username) {
    $ldap_conn = connectionLDAP::getInstance()->getConnection();
    if ($ldap_conn) {
        // Se connecter d'abord avec un compte de service/administrateur
        if (@ldap_bind($ldap_conn, "cn=admin,dc=".getenv('DOMAINENIV2') .",dc=".getenv("DOMAINENIV1"), getenv('LDAP_ADMIN_PASSWORD'))) {
            // Recherche de l'utilisateur par son uid
            $search = ldap_search($ldap_conn, "ou=utilisateurs,dc=".getenv('DOMAINENIV2') .",dc=".getenv("DOMAINENIV1"), "(uid=" . $username . ")");
            $entries = ldap_get_entries($ldap_conn, $search);

            // Vérifie si l'utilisateur a été trouvé et si son DN est dans le groupe "Administrateurs"
            if ($entries["count"] > 0 && strpos($entries[0]["dn"], "cn=Administrateurs,dc=mondomaine,dc=local") !== false) { //TODO : changer le domaine et tout
                return true; // L'utilisateur est un administrateur
            } else {
                return false; // L'utilisateur n'est pas un administrateur
            }
        } else {
            return false; // Connexion avec le compte admin échouée
        }
    } else {
        return false; // Connexion LDAP échouée
    }
}

/*
 * Cette fonction permet de changer le mot de passe d'un utilisateur LDAP
 *
 * Voici les différentes erreurs possibles :
 *
 * 'ERR_LDAP_CONNECTION' si la connexion LDAP échoue.
 * 'ERR_ADMIN_BIND' si la connexion en tant qu'administrateur échoue.
 * 'ERR_USER_SEARCH' si la recherche de l'utilisateur échoue.
 * 'ERR_USER_NOT_FOUND' si aucun utilisateur correspondant n'est trouvé.
 * 'ERR_OLD_PASSWORD' si l'ancien mot de passe est incorrect.
 * 'ERR_PASSWORD_CHANGE' si la modification du mot de passe échoue.
 * 'SUCCESS' si le changement de mot de passe est réussi.
 */
function passwordChange($username, $oldPassword, $newPassword) : string {
    $ldap_conn = connectionLDAP::getInstance()->getConnection();
    if ($ldap_conn) {
        // Se connecter d'abord avec un compte de service/administrateur
        if (@ldap_bind($ldap_conn, "cn=admin,dc=".getenv('DOMAINENIV2') .",dc=".getenv("DOMAINENIV1"), getenv('LDAP_ADMIN_PASSWORD'))) {
            // Recherche de l'utilisateur par son uid
            $search = ldap_search($ldap_conn, "ou=utilisateurs,dc=".getenv('DOMAINENIV2') .",dc=".getenv("DOMAINENIV1"), "(uid=" . ldap_escape($username, "", LDAP_ESCAPE_FILTER) . ")");
            if ($search === false) {
                // La recherche a échoué
                return 'ERR_USER_SEARCH'; // La recherche a échoué
            }

            $entries = ldap_get_entries($ldap_conn, $search);
            if ($entries === false || $entries["count"] === 0) {
                // Pas d'entrées trouvées ou une erreur est survenue
                return 'ERR_USER_NOT_FOUND'; // Pas d'entrées trouvées ou une erreur est survenue
            }

            $userDn = $entries[0]["dn"];

            // Vérification de l'ancien mot de passe en tentant une connexion
            if (@ldap_bind($ldap_conn, $userDn, $oldPassword)) {
                // Si la connexion réussit, l'ancien mot de passe est correct
                $newPasswordEncrypted = "{MD5}" . base64_encode(md5($newPassword, TRUE));
                $entry = ["userpassword" => $newPasswordEncrypted];

                // Modification du mot de passe
                if (ldap_modify($ldap_conn, $userDn, $entry)) {
                    return 'SUCCESS'; // Changement de mot de passe réussi
                } else {
                    return 'ERR_PASSWORD_CHANGE'; // Échec du changement de mot de passe
                }
            } else {
                return 'ERR_OLD_PASSWORD'; // L'ancien mot de passe est incorrect
            }
        } else {
            return 'ERR_ADMIN_BIND'; // Échec de la connexion avec le compte admin
        }
    } else {
        return 'ERR_LDAP_CONNECTION'; // Connexion LDAP échouée
    }
}
?>