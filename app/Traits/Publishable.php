<?php

namespace Podium\Traits;

use Podium\Scopes\PublishableScope;

trait Publishable
{
    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootPublishable()
    {
        static::addGlobalScope(new PublishableScope);
    }

    /**
     * Get the IsPublished attribute.
     *
     * @return mixed
     */
    public function getIsPublishedAttribute()
    {
        return !is_null($this->publish_at) && !$this->publish_at->isFuture();
    }

    public function publish()
    {
        if ($this->fireModelEvent('publishing') === false) {
            return false;
        }

        $this->publish_at = $this->freshTimestamp();

        $result = $this->save();

        $this->fireModelEvent('published', false);

        return $result;
    }

    public function unpublish()
    {
        if ($this->fireModelEvent('unpublishing') === false) {
            return false;
        }

        $this->publish_at = null;

        $result = $this->save();

        $this->fireModelEvent('published', false);

        return $result;
    }

    // public function scopeWherePublished($query)
    // {
    //     $query->where('publish_at', '<=', $this->freshTimestamp())->whereNotNull('publish_at');
    // }
    //
    // public function scopeWhereUnpublished($query)
    // {
    //     $query->where(function($query) {
    //         $query->where('publish_at', '>', $this->freshTimestamp())->orWhere('publish_at', null);
    //     });
    // }
    //
    // public function scopeOrderByPublished($query, $direction = 'desc')
    // {
    //     $query->orderBy('publish_at', $direction);
    // }

    /**
     * Register a publishing model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function publishing($callback)
    {
        static::registerModelEvent('publishing', $callback);
    }

    /**
     * Register a published model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function published($callback)
    {
        static::registerModelEvent('published', $callback);
    }

    /**
     * Register an unpublishing model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function unpublishing($callback)
    {
        static::registerModelEvent('unpublishing', $callback);
    }

    /**
     * Register an unpublished model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function unpublished($callback)
    {
        static::registerModelEvent('unpublished', $callback);
    }

    public function getPublishAtColumn()
    {
        return 'publish_at';
    }

    public function getQualifiedPublishAtColumn()
    {
        return $this->getTable().'.'.$this->getPublishAtColumn();
    }
}
