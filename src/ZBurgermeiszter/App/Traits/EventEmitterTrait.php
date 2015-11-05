<?php

namespace ZBurgermeiszter\App\Traits;

trait EventEmitterTrait
{
    protected $eventsArray = [];

    public function emit($eventName, $payload = null)
    {
        if (array_key_exists($eventName, $this->eventsArray) && is_array($this->eventsArray[$eventName])) {
            foreach($this->eventsArray[$eventName] as $eventListener) {
                if($eventListener instanceof \Closure) {
                    $eventListener($payload);
                }
            }
        }
    }

    public function on($eventName, \Closure $eventListener)
    {
        $this->eventsArray[$eventName][] = $eventListener;
    }
}