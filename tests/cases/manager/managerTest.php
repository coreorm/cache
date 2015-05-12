<?php
/**
 * pdo adaptor
 *
 */
require_once __DIR__ . '/../header.php';

use \CoreORM\Cache\Manager as CM;

/**
 * test core
 */
class TestCacheManager extends PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $cm = new \CoreORM\Cache\Manager();
        parent::assertInstanceOf('\CoreORM\Cache\Manager', $cm);
        // test enabled, disabled
        $ops = array(
            \CoreORM\Cache\Enum\Manager::OPT_ENABLED => true,
        );
        $cm = CM::getInstance($ops);
        var_dump($cm, $cm->isCacheEnabled());

        // test turnning off
        CM::enableGlobally(false);
        var_dump($cm, $cm->isCacheEnabled());

    }

}
