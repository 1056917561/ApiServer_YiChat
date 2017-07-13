<?php

/*
 * CKFinder Configuration File
 *
 * For the official documentation visit http://docs.cksource.com/ckfinder3-php/
 */
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
/* ============================ PHP Error Reporting ==================================== */
// http://docs.cksource.com/ckfinder3-php/debugging.html
// Production
//error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
//ini_set('display_errors', 0);
// Development
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/* ============================ General Settings ======================================= */
// http://docs.cksource.com/ckfinder3-php/configuration.html

$config = [];

/* ============================ Enable PHP Connector HERE ============================== */

// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_authentication
/**
 * 加密和解密
 * @link http://www.comsenz.com/
 * @access public
 * @param string $string 字符
 * @param string $operation 加密(ENCODE)或解密(DECODE)
 * @param string $key
 * @param string $expiry
 * @return string
 */
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    $ckey_length = 4;
    $key = md5($key ?: '5014c77e08495c90dd664bc3f6f81c36');
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';
    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = [];
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    return $operation == 'DECODE' ? ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16) ? substr($result, 26) : '') : ($keyc . str_replace('=', '', base64_encode($result)));
}

$uid = 0;
if (!empty($_COOKIE['usersid'])) {
    $uid = authcode($_COOKIE['usersid'], 'DECODE');
    $uid = preg_match('/^[1-9][0-9]*$/i', $uid) ? (int) $uid : 0;
}
define('COMPANY_ID', (int) $uid);
$config['authentication'] = function () {
    return !empty(COMPANY_ID) ? true : false;
};

/* ============================ License Key ============================================ */
// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_licenseKey

$config['licenseName'] = '';
$config['licenseKey'] = '';

/* ============================ CKFinder Internal Directory ============================ */
// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_privateDir

$config['privateDir'] = array(
    'backend' => 'default',
    'tags' => '.ckfinder/tags',
    'logs' => '.ckfinder/logs',
    'cache' => '.ckfinder/cache',
    'thumbs' => '.ckfinder/cache/thumbs',
);

/* ============================ Images and Thumbnails ================================== */
// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_images

$config['images'] = array(
    'maxWidth' => 2000,
    'maxHeight' => 2000,
    'quality' => 100,
    'sizes' => array(
        'small' => array('width' => 480, 'height' => 320, 'quality' => 80),
        'medium' => array('width' => 600, 'height' => 480, 'quality' => 80),
        'large' => array('width' => 800, 'height' => 600, 'quality' => 80)
    )
);

/* =================================== Backends ======================================== */
// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_backends

$config['backends'][] = array(
    'name' => 'default',
    'adapter' => 'local',
    'baseUrl' => '/attached/',
    'root' => rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . DIRECTORY_SEPARATOR . 'attached' . DIRECTORY_SEPARATOR . md5(COMPANY_ID . '-5014c77e08495c90dd664bc3f6f81c36'),
    'chmodFiles' => 0777,
    'chmodFolders' => 0755,
    'filesystemEncoding' => 'UTF-8',
);

/* ================================ Resource Types ===================================== */
// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_resourceTypes

$config['defaultResourceTypes'] = '';

$config['resourceTypes'][] = array(
    'name' => 'Files', // Single quotes not allowed.
    'directory' => 'files',
    'maxSize' => 0,
    'allowedExtensions' => '7z,aiff,asf,avi,bmp,csv,doc,docx,fla,flv,gif,gz,gzip,jpeg,jpg,mid,mov,mp3,mp4,mpc,mpeg,mpg,ods,odt,pdf,png,ppt,pptx,pxd,qt,ram,rar,rm,rmi,rmvb,rtf,sdc,sitd,swf,sxc,sxw,tar,tgz,tif,tiff,txt,vsd,wav,wma,wmv,xls,xlsx,zip',
    'deniedExtensions' => '',
    'backend' => 'default'
);

$config['resourceTypes'][] = array(
    'name' => 'Images',
    'directory' => 'images',
    'maxSize' => 0,
    'allowedExtensions' => 'bmp,gif,jpeg,jpg,png',
    'deniedExtensions' => '',
    'backend' => 'default'
);

/* ================================ Access Control ===================================== */
// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_roleSessionVar

$config['roleSessionVar'] = 'CKFinder_UserRole';

// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_accessControl
$config['accessControl'][] = array(
    'role' => '*',
    'resourceType' => '*',
    'folder' => '/',
    'FOLDER_VIEW' => true,
    'FOLDER_CREATE' => true,
    'FOLDER_RENAME' => true,
    'FOLDER_DELETE' => true,
    'FILE_VIEW' => true,
    'FILE_CREATE' => true,
    'FILE_RENAME' => true,
    'FILE_DELETE' => true,
    'IMAGE_RESIZE' => true,
    'IMAGE_RESIZE_CUSTOM' => true
);


/* ================================ Other Settings ===================================== */
// http://docs.cksource.com/ckfinder3-php/configuration.html

$config['overwriteOnUpload'] = false;
$config['checkDoubleExtension'] = true;
$config['disallowUnsafeCharacters'] = false;
$config['secureImageUploads'] = true;
$config['checkSizeAfterScaling'] = true;
$config['htmlExtensions'] = array('html', 'htm', 'xml', 'js');
$config['hideFolders'] = array('.*', 'CVS', '__thumbs');
$config['hideFiles'] = array('.*');
$config['forceAscii'] = true;
$config['xSendfile'] = false;

// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_debug
$config['debug'] = false;

/* ==================================== Plugins ======================================== */
// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_plugins

$config['pluginsDirectory'] = __DIR__ . DIRECTORY_SEPARATOR . 'plugins';
$config['plugins'] = [];

/* ================================ Cache settings ===================================== */
// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_cache

$config['cache'] = array(
    'imagePreview' => 24 * 3600,
    'thumbnails' => 24 * 3600 * 365,
    'proxyCommand' => 0
);

/* ============================ Temp Directory settings ================================ */
// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_tempDirectory

$config['tempDirectory'] = sys_get_temp_dir();

/* ============================ Session Cause Performance Issues ======================= */
// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_sessionWriteClose

$config['sessionWriteClose'] = true;

/* ================================= CSRF protection =================================== */
// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_csrfProtection

$config['csrfProtection'] = true;

/* ============================== End of Configuration ================================= */

// Config must be returned - do not change it.
return $config;
