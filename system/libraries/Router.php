<?php

namespace System\Libraries;

// TO DO remove the static output from method add.

class Router
{
    protected static $allow_query = true;
    protected static $routes = array();

    /**
     * Router::add()
     * 
     * @param mixed $src
     * @param mixed $dest
     * @return
     */
    public static function add($src, $dest = null)
    {
        // TODO: Validate the routes?
        if (is_array($src))
        {
            foreach ($src as $key => $val)
            {
                static::$routes[$key] = $val;
                //echo $val.'<br/>';
            }
        } elseif ($dest)
        {
            static::$routes[$src] = $dest;
        }
    }
    /**
     * Router::route()
     * 
     * @param mixed $src
     * @param mixed $uri
     * @param mixed $dest
     * @return
     */
    public static function route($src, $uri, $dest = null)
    {
        self::add($src);

        $qs = '';
        if (static::$allow_query && strpos($uri, '?') !== false)
        {
            // Break the query string off and attach later
            $qs = '?' . parse_url($uri, PHP_URL_QUERY);
            $uri = str_replace($qs, '', $uri);
        }
        // Is there a literal match?
        if (isset(static::$routes[$uri]))
        {
            return static::$routes[$uri] . $qs;
        }

        // Loop through the route array looking for wild-cards
        foreach (static::$routes as $key => $val)
        {
            // Convert wild-cards to RegEx
            $key = str_replace(':any', '.+', $key);
            $key = str_replace(':num', '[0-9]+', $key);
            $key = str_replace(':nonum', '[^0-9]+', $key);
            $key = str_replace(':alpha', '[A-Za-z]+', $key);
            $key = str_replace(':alnum', '[A-Za-z0-9]+', $key);
            $key = str_replace(':hex', '[A-Fa-f0-9]+', $key);
            // Does the RegEx match?
            if (preg_match('#^' . $key . '$#', $uri))
            {
                // Do we have a back-reference?
                if (strpos($val, '$') !== false && strpos($key, '(') !== false)
                {
                    $val = preg_replace('#^' . $key . '$#', $val, $uri);
                }
                return $val . $qs;
            }
        }
        return $uri . $qs;
    }
    /**
     * Router::reverseRoute()
     * 
     * @param mixed $controller
     * @param string $root
     * @return
     */
    public static function reverseRoute($controller, $root = "/")
    {
        $index = array_search($controller, static::$routes);
        if ($index === false)
            return null;
        return $root . static::$routes[$index];
    }

    /**
     * Router::testRouter()
     * 
     * @return
     */
    public static function testRouter()
    {
        echo 'This is an output from a test of :' . __class__ . '<br/>';
    }
}
