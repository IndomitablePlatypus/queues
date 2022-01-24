<?php

namespace Queues\Api\V1\Presentation\Http\Responses;

use App\Models\Card;
use JsonSerializable;

class IssuedCard implements JsonSerializable
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
            'workspaceName' => $this->card->workspace()->name,
            'workspaceAddress' => $this->card->workspace()->address,
            'customerId' => $this->card->customer_id,
            'description' => $this->card->description,
            'satisfied' => $this->card->satisfied_at !== null,
            'completed' => $this->card->completed_at !== null,
            'achievements' => $this->card->achievements,
            'requirements' => $this->card->requirements,
        ];
    }

}
