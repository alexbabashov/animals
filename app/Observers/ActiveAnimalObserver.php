<?php

namespace App\Observers;

use App\Models\ActiveAnimal;

class ActiveAnimalObserver
{
    /**
     * Handle the ActiveAnimal "created" event.
     *
     * @param  \App\Models\ActiveAnimal  $activeAnimal
     * @return void
     */
    public function created(ActiveAnimal $activeAnimal)
    {
        //
    }

    /**
     * Handle the ActiveAnimal "updated" event.
     *
     * @param  \App\Models\ActiveAnimal  $activeAnimal
     * @return void
     */
    public function updated(ActiveAnimal $activeAnimal)
    {
        //
    }

    /**
     * Handle the ActiveAnimal "deleted" event.
     *
     * @param  \App\Models\ActiveAnimal  $activeAnimal
     * @return void
     */
    public function deleted(ActiveAnimal $activeAnimal)
    {
        //
    }

    /**
     * Handle the ActiveAnimal "restored" event.
     *
     * @param  \App\Models\ActiveAnimal  $activeAnimal
     * @return void
     */
    public function restored(ActiveAnimal $activeAnimal)
    {
        //
    }

    /**
     * Handle the ActiveAnimal "force deleted" event.
     *
     * @param  \App\Models\ActiveAnimal  $activeAnimal
     * @return void
     */
    public function forceDeleted(ActiveAnimal $activeAnimal)
    {
        //
    }
}
