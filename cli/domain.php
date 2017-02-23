<?php

use Magento\Framework\App\Bootstrap;
 
require __DIR__ . '../../../../../app/bootstrap.php';
 
$params = $_SERVER;
 
$bootstrap = Bootstrap::create(BP, $params);
 
$obj = $bootstrap->getObjectManager();

$baseUrl = $obj->get('Magento\Store\Model\StoreManagerInterface')->getStore(0)->getBaseUrl(); 

$parseUrl = parse_url($baseUrl);

echo $parseUrl['host'];
