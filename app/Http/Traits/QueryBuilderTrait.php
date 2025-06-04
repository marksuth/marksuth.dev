<?php

namespace App\Http\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

trait QueryBuilderTrait
{
    /**
     * Apply common published content constraints to a query.
     */
    protected function applyPublishedConstraints(Builder $query, bool $excludeDistantPast = true, bool $excludeNearFuture = true): Builder
    {
        $query->where('meta->published', '1')
            ->whereNowOrPast('published_at');

        if ($excludeDistantPast) {
            $query->whereNull('meta->distant_past');
        }

        if ($excludeNearFuture) {
            $query->whereNull('meta->near_future');
        }

        return $query;
    }

    /**
     * Apply date filtering constraints to a query.
     *
     * @param  Builder  $query
     * @param  int|null  $year
     * @param  int|null  $month
     * @return Builder
     */
    protected function applyDateFilters($query, $year = null, $month = null)
    {
        if ($year) {
            $query->whereYear('published_at', $year);
        }

        if ($month) {
            $query->whereMonth('published_at', $month);
        }

        return $query;
    }

    /**
     * Apply slug constraint to a query.
     *
     * @param  Builder  $query
     * @param  string  $slug
     * @return Builder
     */
    protected function applySlugConstraint($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    /**
     * Apply year-month-slug constraints for URL pattern matching.
     *
     * @param  Builder  $query
     * @param  string  $year
     * @param  string  $month
     * @param  string  $slug
     * @return Builder
     */
    protected function applyYearMonthSlugConstraints($query, $year, $month, $slug)
    {
        return $query->where('published_at', 'like', $year.'-'.$month.'%')
            ->where('slug', $slug);
    }

    /**
     * Apply ordering by published date.
     *
     * @param  Builder  $query
     * @param  string  $direction
     * @return Builder
     */
    protected function applyPublishedDateOrdering($query, $direction = 'desc')
    {
        return $direction === 'desc'
            ? $query->latest('published_at')
            : $query->oldest('published_at');
    }

    /**
     * Apply eager loading to a query.
     *
     * @param  Builder  $query
     * @param  array|string  $relations
     * @return Builder
     */
    protected function applyEagerLoading($query, $relations = [])
    {
        if (! empty($relations)) {
            $query->with($relations);
        }

        return $query;
    }

    /**
     * Execute a query and return the results, or throw a 404 if no results are found.
     * Optionally applies caching and eager loading.
     *
     * @param  Builder  $query
     * @param  bool  $paginate
     * @param  int  $perPage
     * @param  array|string  $eagerLoad
     * @param  bool  $useCache
     * @param  int  $cacheMinutes
     * @return Collection|LengthAwarePaginator
     */
    protected function getResultsOrFail($query, $paginate = false, $perPage = 10, $eagerLoad = [], $useCache = true, $cacheMinutes = 60)
    {
        // Apply eager loading if relations are specified
        if (! empty($eagerLoad)) {
            $query->with($eagerLoad);
        }

        // Generate a cache key based on the query
        $cacheKey = $this->generateCacheKey($query, $paginate, $perPage);

        // Use caching if enabled
        if ($useCache) {
            $results = \Cache::remember($cacheKey, now()->addMinutes($cacheMinutes), function () use ($query, $paginate, $perPage) {
                return $paginate ? $query->paginate($perPage) : $query->get();
            });
        } else {
            $results = $paginate ? $query->paginate($perPage) : $query->get();
        }

        if ($results->isEmpty()) {
            abort(404);
        }

        return $results;
    }

    /**
     * Generate a cache key for a query.
     *
     * @param  Builder  $query
     * @param  bool  $paginate
     * @param  int  $perPage
     * @return string
     */
    protected function generateCacheKey($query, $paginate, $perPage)
    {
        $sql = $query->toSql();
        $bindings = $query->getBindings();
        $modelName = get_class($query->getModel());

        return 'query_'.md5($modelName.$sql.serialize($bindings).$paginate.$perPage);
    }
}
