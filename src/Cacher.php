<?php

namespace FredBradley\Cacher;

use FredBradley\Cacher\Exceptions\FrameworkNotDetected;

/**
 * Class Cacher
 */
class Cacher
{
    /**
     * @var \FredBradley\Cacher\CacherFrameworkInterface
     */
    private $framework = null;

    /**
     * Cacher constructor.
     */
    public function __construct()
    {
        if (class_exists(\Illuminate\Support\Facades\Cache::class)) {
            $this->framework = new Laravel();
        }
        if (function_exists('set_transient') && defined('WPINC')) {
            $this->framework = new WordPress();
        }
    }

    /**
     * @param  string  $key
     *
     * @return false|mixed
     * @throws \FredBradley\Cacher\Exceptions\FrameworkNotDetected
     */
    public static function forget(string $key)
    {
        $instance = new self();
        if ($instance->framework === null) {
            throw new FrameworkNotDetected("Framework Not Detected. Could not find data for " . $key, 400);
        }
        return call_user_func([$instance->framework, 'forget'], $key);
    }

    /**
     * @param  string  $key
     *
     * @return false|mixed
     * @throws \FredBradley\Cacher\Exceptions\FrameworkNotDetected
     */
    public static function get(string $key)
    {
        $instance = new self();
        if ($instance->framework === null) {
            throw new FrameworkNotDetected("Framework Not Detected. Could not find data for " . $key, 400);
        }
        return call_user_func([$instance->framework, 'get'], $key);
    }

    /**
     * @param  string  $key
     * @param  int  $seconds  Time until expiration in Seconds.
     * @param  \Closure  $callback
     *
     * @return mixed
     * @deprecated Legacy - should use 'remember' now.
     *
     */
    public static function setAndGet(string $key, int $seconds, \Closure $callback)
    {
        return self::remember($key, $seconds, $callback);
    }

    /**
     * @param  string  $key
     * @param  int  $seconds
     * @param  \Closure  $callback
     *
     * @return mixed
     */
    public static function remember(string $key, int $seconds, \Closure $callback)
    {
        $instance = new self();
        if ($instance->framework === null) {
            return call_user_func($callback);
        }
        return call_user_func([$instance->framework, 'remember'], $key, $seconds, $callback);
    }
}
