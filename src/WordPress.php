<?php

namespace FredBradley\Cacher;

/**
 * Class WordPress
 * @package FredBradley\Cacher
 */
class WordPress implements CacherFrameworkInterface
{
    /**
     * @param  string  $key
     *
     * @return mixed
     */
    public function get(string $key)
    {
        return get_transient($key);
    }

    /**
     * @param  string  $key
     * @param  int  $seconds
     * @param  \Closure  $callback
     *
     * @return false|mixed
     */
    public function remember(string $key, int $seconds, \Closure $callback)
    {
        $transient = get_transient($key);
        if ($transient !== false) {
            return $transient;
        }
        if (! is_callable($callback)) {
            wp_die("No (valid) callback function provided.");
        }

        set_transient($key, $data = call_user_func($callback), $seconds);

        return $data;
    }

    /**
     * @param  string  $key
     *
     * @return mixed
     */
    public function forget(string $key)
    {
        return delete_transient($key);
    }
}
