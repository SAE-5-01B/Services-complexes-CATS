<?php
class connectionLDAP
{
    private static $instance = null;
    private $ldap_conn;
    // Paramètres de la connexion LDAP pour Docker

    private function __construct()
    {

        $this->ldap_conn = ldap_connect("ldap-server", 389) or die("Could not connect to LDAP server.");

        ldap_set_option($this->ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new connectionLDAP();
        }
        return self::$instance;
    }
    public function getConnection()
    {
        return $this->ldap_conn;
    }
}
?>