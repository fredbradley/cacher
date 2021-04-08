<?php

namespace FredBradley\Cacher;

use Illuminate\Support\Facades\Cache;

/**
 * Class Laravel
 * @package FredBradley\Cacher
 */
class Laravel implements CacherFrameworkInterface
{
    /**
     * @param  string  $key
     * @param  int  $seconds
     * @param  \Closure  $callback
     *
     * @return mixed
     */
    public function remember(string $key, int $seconds, \Closure $callback)
    {
        return Cache::remember($key, $seconds, $callback);
    }

    /**
     * @param  string  $key
     *
     * @return mixed
     */
    public function get(string $key)
    {
        return Cache::get($key);
    }

    /**
     * @param  string  $key
     *
     * @return mixed
     */
    public function forget(string $key)
    {
        return Cache::forget($key);
    }
}
