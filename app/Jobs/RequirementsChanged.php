<?php

namespace App\Jobs;

use App\Models\Card;
use App\Models\Plan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RequirementsChanged implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected Plan $plan,
    ) {
    }

    public function handle(): void
    {
        $cards = $this->plan->getCards();
        $compactRequirements = Plan::compactRequirements($this->plan->getRequirements()->toArray());
        /** @var Card $card */
        foreach ($cards as $card) {
            $card->acceptRequirements($compactRequirements)->persist();
        }
    }
}
