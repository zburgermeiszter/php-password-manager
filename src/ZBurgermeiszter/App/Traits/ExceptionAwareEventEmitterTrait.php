<?php

namespace ZBurgermeiszter\App\Traits;

trait ExceptionAwareEventEmitterTrait
{
    use EventEmitterTrait {
        emit as eetEmit;
        on as eetOn;
    }

    public function emit($eventName, $payload = null)
    {
        try {
            $this->eetEmit($eventName, $payload);
        } catch (\Exception $e) {

            if (array_key_exists('error', $this->eventsArray) && is_array($this->eventsArray['error'])) {
                $this->emit('error', $e);
            } else {
                throw $e;
            }

        }
    }


}