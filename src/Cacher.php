<?php

namespace FredBradley\Cacher;

/**
 * Class Cacher
 */
class Cacher
{
    /**
     * @var string
     */
    private $engine = '';

    /**
     * Cacher constructor.
     */
    public function __construct()
    {
        if (class_exists(\Illuminate\Support\Facades\Cache::class)) {
            $this->engine = "Laravel";
        }
        if (function_exists('set_transient') && defined('WPINC')) {
            $this->engine = "WordPress";
        }
    }


    /**
     * @param string   $key
     * @param int      $minutes Time until expiration in Minutes.
     * @param \Closure $callback
     *
     * @return \Closure|mixed
     */
    public static function setAndGet(string $key, int $minutes, \Closure $callback)
    {
        $instance = new self();
        switch ($instance->engine) {
            case "Laravel":
            case "WordPress":
                return call_user_func([$instance, 'save' . $instance->engine . 'Cache'], $key, $minutes, $callback);
                break;
            default:
                // No cache driver could be found, so we just return the callback value.
                return $callback;
                break;
        }
    }

    /**
     * @param string   $key
     * @param int      $minutes Amount of minutes to keep value fresh in cache.
     * @param \Closure $callback
     *
     * @return mixed
     */
    public function saveWordPressCache(string $key, int $minutes, \Closure $callback)
    {
        $transient = get_transient($key);
        if ($transient !== false) {
            return $transient;
        }
        if (! is_callable($callback)) {
            wp_die("No (valid) callback function provided.");
        }
        // Remember, WordPress wants the TTL in Seconds, so we times our value by 60
        set_transient($key, $data = call_user_func($callback), $minutes * 60);

        return $data;
    }

    /**
     * @param string   $key
     * @param int      $minutes Amount of minutes to keep value fresh in cache.
     * @param \Closure $callback
     *
     * @return mixed
     */
    public function saveLaravelCache(string $key, int $minutes, \Closure $callback)
    {
        return \Illuminate\Support\Facades\Cache::remember($key, $minutes, $callback);
    }
}
