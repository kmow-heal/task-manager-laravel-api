<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

trait CanLoadRelationships
{
    public function loadRelationships(
        Model|HasMany|EloquentBuilder|QueryBuilder $for,
        ?array                                     $relations = null
    ): Model|HasMany|EloquentBuilder|QueryBuilder
    {
        $relations = $relations ?? $this->relations ?? [];
        foreach ($relations as $relation) {
            $for->when(
                $this->shouldIncludeRelation($relation),
                fn($q) => $for instanceof Model ? $for->load($relation) : $q->with($relation)
            );
        }
        return $for;
    }

    public function shouldIncludeRelation(string $relation): bool
    {
        $include = request()->query('include');
        if (!$include)
            return false;
        $relations = array_map('trim', explode(',', $include));
        return in_array($relation, $relations);
    }

}
