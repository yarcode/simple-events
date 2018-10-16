<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */

namespace YarCode\Events;

interface EventEmitterInterface
{
    /**
     * @param string $eventName
     * @param callable $listener
     */
    public function addListener($eventName, callable $listener);

    /**
     * @param string $eventName
     * @param callable $listener
     */
    public function removeListener($eventName, callable $listener);

    /**
     * @param string|null $eventName
     */
    public function removeAllListeners($eventName = null);

    /**
     * @param string $eventName
     * @return array
     */
    public function listeners($eventName);

    /**
     * @param string $eventName
     * @param Event|mixed $eventData
     */
    public function emit($eventName, $eventData = null);
}
