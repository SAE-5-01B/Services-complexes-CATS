<?php
$CONFIG = array (
  'htaccess.RewriteBase' => '/',
  'memcache.local' => '\\OC\\Memcache\\APCu',
  'apps_paths' => 
  array (
    0 => 
    array (
      'path' => '/var/www/html/apps',
      'url' => '/apps',
      'writable' => false,
    ),
    1 => 
    array (
      'path' => '/var/www/html/custom_apps',
      'url' => '/custom_apps',
      'writable' => true,
    ),
  ),
  'upgrade.disable-web' => true,
  'passwordsalt' => '6BEvZrJ2G0ftGDGA36EOeW2YhFL0Fl',
  'secret' => 'iegCTCpVS1zo+ujIJ+SjpG4aK7bxTngdxBEfIiQ0kvxJzqmQ',
  'trusted_domains' => 
  array (
    0 => 'localhost',
    1 => 'SERVER_IP',
  ),
  'datadirectory' => '/var/www/html/data',
  'dbtype' => 'mysql',
  'version' => '28.0.1.1',
  'overwrite.cli.url' => 'http://localhost',
  'dbname' => 'nextcloud',
  'dbhost' => 'nextcloud_db',
  'dbport' => '',
  'dbtableprefix' => 'oc_',
  'mysql.utf8mb4' => true,
  'dbuser' => 'nextcloud',
  'dbpassword' => 'nextcloud_password',
  'installed' => true,
  'instanceid' => 'ocp68yiti78o',
  'allow_local_remote_servers' => true,
  'debug' => true,
);


