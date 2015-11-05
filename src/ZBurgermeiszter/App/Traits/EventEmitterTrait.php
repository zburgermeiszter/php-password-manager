<?php

namespace ZBurgermeiszter\App\Traits;

trait EventEmitterTrait
{
    private $eventsArray = [];
    private $afterAlls = [];

    public function emit($eventName, $payload = null)
    {
        if (array_key_exists($eventName, $this->eventsArray) && is_array($this->eventsArray[$eventName])) {
            foreach($this->eventsArray[$eventName] as $eventListener) {
                if($eventListener instanceof \Closure) {
                    $eventListener($payload);
                }
            }
            $this->notifyAfterAlls();
        }
    }

    public function on($eventName, \Closure $eventListener)
    {
        $this->eventsArray[$eventName][] = $eventListener;
    }

    private function notifyAfterAlls()
    {
        foreach($this->afterAlls as $afterClosure) {
            $afterClosure();
        }
    }

    /**
     * Register a function to run after all event listener notified.
     * @param \Closure $closure
     */
    public function registerAfterAll(\Closure $closure)
    {
        $this->afterAlls[] = $closure;
    }
}