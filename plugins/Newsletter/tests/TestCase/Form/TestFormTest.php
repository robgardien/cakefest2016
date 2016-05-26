<?php
namespace Newsletter\Test\TestCase\Form;

use Cake\TestSuite\TestCase;
use Newsletter\Form\TestForm;

/**
 * Newsletter\Form\TestForm Test Case
 */
class TestFormTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Newsletter\Form\TestForm
     */
    public $Test;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Test = new TestForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Test);

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
