<?php

namespace Queues\Api\V1\Presentation\Http\Responses;

use App\Models\Card;
use JsonSerializable;

class IssuedCards implements JsonSerializable
{
    /** @var Card[] */
    protected array $cards;

    public function __construct(array $cards)
    {
        $this->cards = $cards;
    }

    public static function of(Card ...$cards): static
    {
        return new static($cards);
    }

    public function jsonSerialize(): array
    {
        return [
            ...array_map(fn($card) => IssuedCard::of($card)->jsonSerialize(), $this->cards),
        ];
    }

}
