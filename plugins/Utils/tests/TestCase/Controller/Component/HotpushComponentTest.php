<?php
namespace Utils\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use Utils\Controller\Component\HotpushComponent;

/**
 * Utils\Controller\Component\HotpushComponent Test Case
 */
class HotpushComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Utils\Controller\Component\HotpushComponent
     */
    public $Hotpush;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Hotpush = new HotpushComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Hotpush);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
