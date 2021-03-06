<?php

namespace FA\Tests\Service;

use FA\Service\FlickrService;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-11-14 at 19:33:03.
 */
class FlickrServiceTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var FlickrService
     */
    protected $service;

    /**
     * @var array
     */
    protected static $config;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$config = require_once APPLICATION_PATH . '/config.php';
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->service = new FlickrService(self::$config['flickr.api.key']);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        $this->service = null;
    }

    public function testCreation()
    {
        $this->assertInstanceOf('FA\Service\FlickrService', $this->service);
        $this->assertInstanceOf('FA\Service\FlickrInterface', $this->service);
    }

    /**
     * @covers FA\Service\FlickrService::getSizes
     */
    public function testGetSizes()
    {
        $photoId = 5977249629;
        $image = $this->service->getSizes($photoId);
        $this->assertNotNull($image);
        $this->assertInternalType('array', $image);
        $this->assertEquals('ok', $image['stat']);
        // I'm assuming there will always be a square and at least one other size
        $this->assertGreaterThanOrEqual(2, $image['sizes']['size']);
        $this->assertArrayHasKey('source', $image['sizes']['size'][0]);
        $this->assertArrayHasKey('width', $image['sizes']['size'][0]);
        $this->assertArrayHasKey('height', $image['sizes']['size'][0]);
    }

}
