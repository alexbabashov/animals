<?php

namespace App\Observers;

use App\Models\Animal;
use Illuminate\Support\Facades\Cache;

class AnimalObserver
{
    public function creating(Animal $animal)
    {
        //
    }

    /**
     * Handle the Animal "created" event.
     *
     * @param  \App\Models\Animal  $animal
     * @return void
     */
    public function created(Animal $animal)
    {
        Cache::forget(Animal::CASHE_KEY);
        //
    }


    public function updating(Animal $animal)
    {
        //
    }

    /**
     * Handle the Animal "updated" event.
     *
     * @param  \App\Models\Animal  $animal
     * @return void
     */
    public function updated(Animal $animal)
    {
        Cache::forget(Animal::CASHE_KEY);
        //
    }

    /**
     * Handle the Animal "deleted" event.
     *
     * @param  \App\Models\Animal  $animal
     * @return void
     */
    public function deleted(Animal $animal)
    {
        Cache::forget(Animal::CASHE_KEY);
        //
    }

    /**
     * Handle the Animal "restored" event.
     *
     * @param  \App\Models\Models\Animal  $animal
     * @return void
     */
    public function restored(Animal $animal)
    {
        Cache::forget(Animal::CASHE_KEY);
        //
    }

    /**
     * Handle the Animal "force deleted" event.
     *
     * @param  \App\Models\Animal  $animal
     * @return void
     */
    public function forceDeleted(Animal $animal)
    {
        Cache::forget(Animal::CASHE_KEY);
        //
    }
}
