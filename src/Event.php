<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */
namespace YarCode\Event;

class Event
{
    /** @var string */
    public $name;
    /** @var bool */
    public $handled = false;
    /** @var array */
    public $payload = [];
}