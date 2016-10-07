<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */
namespace YarCode\Event;

trait EventEmitterTrait
{
    protected $listeners = [];

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
     * @return array
     */
    public function listeners($eventName)
    {
        return isset($this->listeners[$eventName]) ? $this->listeners[$eventName] : [];
    }

    /**
     * @param string $eventName
     * @param Event $event
     */
    public function emit($eventName, Event $event = null)
    {
        $listeners = $this->listeners($eventName);

        if (empty($listeners)) {
            return;
        }

        if ($event === null) {
            $event = new Event;
        }

        $event->name = $eventName;
        $event->handled = false;

        foreach ($this->listeners($eventName) as $listener) {
            call_user_func($listener, $event);
            if ($event->handled) {
                return;
            }
        }
    }
}
