<?php

namespace AbdullahFaqeir\LaravelRating;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use AbdullahFaqeir\LaravelRating\Models\Rating;
use Illuminate\Database\Eloquent\Relations\Relation;

class LaravelRating
{
    public const TYPE_LIKE = 'like';

    public const TYPE_RATE = 'rate';

    public const TYPE_VOTE = 'vote';

    public function rate($user, $rateable, $value, $type): Rating
    {
        if ($this->isRated($user, $rateable, $type)) {
            $rate = $user
                ->{$this->resolveTypeRelation($type)}()
                ->where('rateable_id', $rateable->id)
                ->where('type', $type)
                ->where('rateable_type', $this->getRateableByClass($rateable))
                ->first();
            $rate->update(['value' => $value]);
            return $rate;
        }

        return $user
            ->{$this->resolveTypeRelation($type)}()
            ->create([
                'rateable_id'   => $rateable->id,
                'rateable_type' => $this->getRateableByClass($rateable),
                'value'         => $value,
                'type'          => $type,
            ]);
    }

    public function unRate($user, $rateable, $type): bool
    {
        if ($this->isRated($user, $rateable, $type)) {
            return $user
                ->{$this->resolveTypeRelation($type)}()
                ->where('rateable_id', $rateable->id)
                ->where('type', $type)
                ->where('rateable_type', $this->getRateableByClass($rateable))
                ->delete();
        }

        return false;
    }

    public function isRated($user, $rateable, $type): bool
    {
        $rating = $user
            ->{$this->resolveTypeRelation($type)}()
            ->where('rateable_id', $rateable->id)
            ->where('rateable_type', $this->getRateableByClass($rateable))
            ->where('type', $type)
            ->first();

        return $rating !== null;
    }

    public function getRatingValue($user, $rateable, $type): ?float
    {
        $rating = $user
            ->{$this->resolveTypeRelation($type)}()
            ->where('rateable_id', $rateable->id)
            ->where('rateable_type', $this->getRateableByClass($rateable))
            ->where('type', $type)
            ->first();

        return $rating?->value;
    }

    private function resolveTypeRelation($type): string
    {
        $lookup = [
            static::TYPE_LIKE => 'likes',
            static::TYPE_RATE => 'ratings',
            static::TYPE_VOTE => 'votes',
        ];

        return $lookup[$type];
    }

    public function resolveRatedItems(Collection $items): Collection
    {
        $collection = collect();

        foreach ($items as $item) {
            $rateableClass = $this->getRateableByKey($item->rateable_type);
            $collection->push((new $rateableClass)->find($item->rateable_id));
        }

        return $collection;
    }

    private function getRateableByClass(Model $rateable): ?string
    {
        $rateableClass = get_class($rateable);
        if (in_array($rateableClass, Relation::$morphMap, false) && $found = array_search($rateableClass, Relation::$morphMap, false)) {
            $rateableClass = $found;
        }

        return $rateableClass;
    }

    private function getRateableByKey(string $rateable): string
    {
        if (array_key_exists($rateable, Relation::$morphMap)) {
            $rateable = Relation::$morphMap[$rateable];
        }

        return $rateable;
    }
}
