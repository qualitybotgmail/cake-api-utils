<?php
namespace Utils\Test\TestCase\Model\Behavior;

use Cake\TestSuite\TestCase;
use Utils\Model\Behavior\HistoryBehavior;

/**
 * Utils\Model\Behavior\HistoryBehavior Test Case
 */
class HistoryBehaviorTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Utils\Model\Behavior\HistoryBehavior
     */
    public $History;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->History = new HistoryBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->History);

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
