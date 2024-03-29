<?php

namespace FredBradley\Cacher\Frameworks;

/**
 * Interface CacherFrameworkInterface
 * @package FredBradley\Cacher
 */
interface CacherFrameworkInterface
{
    /**
     * @param  string  $key
     *
     * @return mixed
     */
    public function get(string $key);

    /**
     * @param  string  $key
     *
     * @return bool
     */
    public function forget(string $key);

    /**
     * @param  string  $key
     * @param  int  $seconds
     * @param  \Closure  $callback
     *
     * @return mixed
     */
    public function remember(string $key, int $seconds, \Closure $callback);
}
