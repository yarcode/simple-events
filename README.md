# Simple Events
Simple event dispatching library for PHP

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/67392651-70e1-43c7-b815-6cded0d98e32/big.png)](https://insight.sensiolabs.com/projects/67392651-70e1-43c7-b815-6cded0d98e32)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yarcode/simple-events/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yarcode/simple-events/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/yarcode/simple-events/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/yarcode/simple-events/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/yarcode/simple-events/badges/build.png?b=master)](https://scrutinizer-ci.com/g/yarcode/simple-events/build-status/master)

## Installation

### Composer

The preferred way to install this extension is through [Composer](http://getcomposer.org/).

Either run

```
composer require yarcode/simple-events
```

or add

```
"yarcode/simple-events": "*"
```

to the require section of your `composer.json`

## Usage

### Via EventEmitterTrait

Attach `\YarCode\Events\EventEmitterTrait` to your class to make it `EventEmitter`

```php
class MyClass {
    use \YarCode\Events\EventEmitterTrait;
    ...
}
$emitter = new MyClass();
```

### Standalone EventEmitter

Or create an instance of `\YarCode\Events\EventEmitter`.

```php
$emitter = new \YarCode\Events\EventEmitter();
```

### Adding listeners
You can add `callable` listener for any string event name.
```
$emitter->addListener('TestEvent', function (\YarCode\Events\Event $event) {
    echo "{$event->name} was emitted";
});
$emitter->addListener('TestEvent', function (\YarCode\Events\Event $event) {
    echo "{$event->name} was emitted one more time";
});
```

### Emitting events
You can emit named event with default event object.
```php
$emitter->emit('TestEvent');
// TestEvent was emitted
// TestEvent was emitted one more time
```
Or you can pass `\YarCode\Events\Event` object to the listeners.
```php
$event = new \YarCode\Events\Event();
$event->payload['key'] = 'value';
$emitter->emit('TestEvent', $event);
// TestEvent was emitted
// TestEvent was emitted one more time
```

### Removing listeners
You can remove one concrete listener.
```
$callback = function (\YarCode\Events\Event $event) {
    echo "{$event->name} was emitted third time";
});
$emitter->addListener('TestEvent', $callback);
$emitter->removeListener('TestEvent', $callback);
```
Or remove all the listeners for the event.
```php
$emitter->removeAllListeners('TestEvent');
```
Or remove all the listeners for all events.
```php
$emitter->removeAllListeners();
```

### Breaking the execution

Set the `$event->handled` property to `true` to stop the further listeners execution.

```php
$emitter->addListener('TestEvent', function (\YarCode\Events\Event $event) {
    $event->handled = true;
});
$emitter->addListener('TestEvent', function (\YarCode\Events\Event $event) {
    echo "This callback for {$event->name} would never run";
});
$emitter->emit('TestEvent);
```

## License

MIT