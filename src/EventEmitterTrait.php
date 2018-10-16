<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */

namespace YarCode\Events;

trait EventEmitterTrait
{
    private $listeners = [];

    /**
     * @param string $eventName
     * @param callable $listener
     */
    public function addListener($eventName, callable $listener)
    {
        if (!isset($this->listeners[$eventName])) {
            $this->listeners[$eventName] = [];
        }

        $this->listeners[$eventName][] = $listener;
    }

    /**
     * @param string $eventName
     * @param callable $listener
     */
    public function removeListener($eventName, callable $listener)
    {
        if (isset($this->listeners[$eventName])) {
            if (false !== $index = array_search($listener, $this->listeners[$eventName], true)) {
                unset($this->listeners[$eventName][$index]);
            }
        }
    }

    /**
     * @param string|null $eventName
     */
    public function removeAllListeners($eventName = null)
    {
        if ($eventName !== null) {
            unset($this->listeners[$eventName]);
        } else {
            $this->listeners = [];
        }
    }

    /**
     * @param string $eventName
     * @param Event|mixed $eventData
     */
    public function emit($eventName, $eventData = null)
    {
        if (empty($this->listeners($eventName))) {
            return;
        }

        if ($eventData === null) {
            $eventData = new Event();
            $eventData->name = $eventName;
            $eventData->handled = false;
        }

        $this->runListeners($eventName, $eventData);
    }

    /**
     * @param string $eventName
     * @return array
     */
    public function listeners($eventName)
    {
        return isset($this->listeners[$eventName]) ? $this->listeners[$eventName] : [];
    }

    /**
     * @param string $eventName
     * @param Event|mixed $eventData
     */
    private function runListeners($eventName, $eventData)
    {
        foreach ($this->listeners($eventName) as $listener) {
            call_user_func($listener, $eventData, $this);
            if ($eventData instanceof Event) {
                if ($eventData->handled) {
                    break;
                }
            }
        }
    }
}
