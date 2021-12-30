<?php

namespace App\Jobs;

use App\Models\Card;
use App\Models\Plan;
use App\Models\Requirement;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RequirementChanged implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected Requirement $requirement,
    ) {
    }

    public function handle(): void
    {
        $cards = $this->requirement->plan->getCards();
        /** @var Card $card */
        foreach ($cards as $card) {
            $card->fixRequirementDescription($this->requirement->id, $this->requirement->description);
        }
    }
}
