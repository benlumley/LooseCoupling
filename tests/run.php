<?php

if (isset($argv[1])) {
  $_SERVER['DOCTRINE_DIR'] = $argv[1];
  unset($argv[1]);
  $_SERVER['argv'] = array_values($argv);
}

if (isset($_REQUEST['doctrine_dir'])) {
  $_SERVER['DOCTRINE_DIR'] = $_REQUEST['doctrine_dir'];
}

if ( ! isset($_SERVER['DOCTRINE_DIR'])) {
    throw new Exception('You must set the path to the DOCTRINE_DIR');
}

require $_SERVER['DOCTRINE_DIR'] . '/tests/bootstrap.php';

spl_autoload_register(array('Doctrine', 'extensionsAutoload'));

Doctrine::setExtensionsPath(realpath(dirname(__FILE__) . '/../'));

$manager = Doctrine_Manager::getInstance()
    ->registerExtension('LooseCoupling', realpath(dirname(__FILE__) . '/../lib'));

$test = new DoctrineTest();
$test->addTestCase(new Doctrine_Template_LooselyCoupleable_TestCase());
$test->addTestCase(new Doctrine_Template_LooselyCoupled_TestCase());
$test->addTestCase(new Doctrine_Template_LooselyCoupledListener_TestCase());
$test->addTestCase(new Doctrine_Hydrator_CoupledDriver_TestCase());

exit($test->run() ? 0 : 1);
