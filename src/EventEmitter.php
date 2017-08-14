<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */

namespace YarCode\Events;

/**
 * Class EventEmitter
 *
 * Standalone implementation of the EventEmitter.
 *
 * @package YarCode\Events
 */
class EventEmitter implements EventEmitterInterface
{
    use EventEmitterTrait;
}
