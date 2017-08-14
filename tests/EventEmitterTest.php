<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */
class EventEmitterTest extends \PHPUnit\Framework\TestCase
{
    /** @var \YarCode\Events\EventEmitter */
    public $emitter;

    protected function setUp()
    {
        $this->emitter = new \YarCode\Events\EventEmitter();
    }

    public function testAddListener()
    {
        $callback = function ($event) {
        };
        $this->emitter->addListener('test', $callback);
        $this->assertSame($callback, $this->emitter->listeners('test')[0]);
    }

    public function testRemoveListener()
    {
        $callback = function ($event) {
        };
        $this->emitter->addListener('test', $callback);
        $this->emitter->removeListener('test', $callback);
        $this->assertEmpty($this->emitter->listeners('test'));
    }

    public function testRemoveAllListenersForEvent()
    {
        $callback = function ($event) {
        };
        $this->emitter->addListener('test', $callback);
        $this->emitter->addListener('test', $callback);
        $this->emitter->removeAllListeners('test');
        $this->assertEmpty($this->emitter->listeners('test'));
    }

    public function testRemoveAllListeners()
    {
        $callback = function ($event) {
        };
        $this->emitter->addListener('test', $callback);
        $this->emitter->addListener('test', $callback);
        $this->emitter->removeAllListeners();
        $this->assertEmpty($this->emitter->listeners('test'));
    }

    public function testEmit()
    {
        $testOk = false;
        $callback = function ($event) use (&$testOk) {
            $testOk = true;
        };
        $this->emitter->addListener('test', $callback);
        $this->emitter->emit('test');
        $this->assertTrue($testOk);
    }

    public function testEmitMissing()
    {
        $testOk = false;
        $callback = function ($event) use (&$testOk) {
            $testOk = true;
        };
        $this->emitter->addListener('test', $callback);
        $this->emitter->emit('missing_event');
        $this->assertFalse($testOk);
    }

    public function testListeners()
    {
        $callback = function ($event) {
        };
        $this->emitter->addListener('test', $callback);
        $this->assertEquals($callback, $this->emitter->listeners('test')[0]);
    }
}