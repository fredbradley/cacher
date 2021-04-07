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
    public static function setAndGet(string $key, int $seconds, \Closure $callback)
    {
        $instance = new self();
        switch ($instance->engine) {
            case "Laravel":
            case "WordPress":
                return call_user_func([$instance, 'save' . $instance->engine . 'Cache'], $key, $seconds, $callback);
                break;
            default:
                // No cache driver could be found, so we just return the callback value.
                return call_user_func($callback);
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
    public function saveWordPressCache(string $key, int $seconds, \Closure $callback)
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
     * @param string   $key
     * @param int      $minutes Amount of minutes to keep value fresh in cache.
     * @param \Closure $callback
     *
     * @return mixed
     */
    public function saveLaravelCache(string $key, int $seconds, \Closure $callback)
    {
        if (\Illuminate\Support\Facades\Cache::get($key)===null) {
            \Log::error('Cacher looking for ' . $key); // until '.$this->getLaravelExpiryTime($key)->format('H:i:s'));
        }

        return \Illuminate\Support\Facades\Cache::remember($key, $seconds, $callback);
    }

    /**
     * @param  string  $key
     * @deprecated Temporary inclusion to debug an issue
     *
     * @return \Carbon\Carbon
     */
    public function getLaravelExpiryTime(string $key): \Carbon\Carbon
    {
        $parts = array_slice(str_split($hash = sha1($key), 2), 0, 2);
        $path = storage_path('framework/cache/data') . "/" . implode('/', $parts) . '/' . $hash;
        $expiryTimeStamp = substr(file_get_contents($path), 0, 10);
        return \Carbon\Carbon::createFromTimestamp($expiryTimeStamp);
    }
}
