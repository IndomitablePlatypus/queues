<?php

namespace Queues\Api\V1\Presentation\Http\Responses;

use App\Models\Card;
use JsonSerializable;

class BusinessCard implements JsonSerializable
{
    public function __construct(private Card $card)
    {
    }

    public static function of(Card $card): static
    {
        return new static($card);
    }

    public function jsonSerialize(): array
    {
        return [
            'cardId' => $this->card->card_id,
            'planId' => $this->card->plan->plan_id,
            'customerId' => $this->card->customer_id,
            'isIssued' => $this->card->issued_at !== null,
            'isSatisfied' => $this->card->satisfied_at !== null,
            'isCompleted' => $this->card->completed_at !== null,
            'isRevoked' => $this->card->revoked_at !== null,
            'isBlocked' => $this->card->blocked_at !== null,
            'achievements' => $this->card->achievements,
            'requirements' => $this->card->requirements,
        ];
    }

}
