<?php

if ( ! function_exists('temp_path'))
{
    /**
     * Get the path to the temp folder.
     *
     * @param string $path
     * @return string
     */
    function temp_path($path = '')
    {
        return storage_path('temp') . ($path ? '/' . $path : $path);
    }
}

if ( ! function_exists('image_path'))
{
    /**
     * Get the path to the image folder.
     *
     * @param string $path
     * @return string
     */
    function image_path($path = '')
    {
        return storage_path('app/images') . ($path ? '/' . $path : $path);
    }
}

if ( ! function_exists('image_thumbnail_path'))
{
    /**
     * Get the path to the image thumbnail folder.
     *
     * @param string $path
     * @return string
     */
    function image_thumbnail_path($path = '')
    {
        return storage_path('app/images/thumbnails') . ($path ? '/' . $path : $path);
    }
}

if ( ! function_exists('logging'))
{
    function logging($text = [], $userId = '')
    {
        if ( ! is_array($text) || ! count($text))
        {
            return false;
        }

        return \Activity::log(json_encode(array_merge($text, ['agent' => Agent::getUserAgent()])), $userId);
    }
}

if ( ! function_exists('http_404'))
{
    function http_404($route = null, $parameters = [])
    {
        flash()->error(trans('error.http.404'));

        if (null !== $route)
        {
            return redirect()->route($route, $parameters);
        }
    }
}

if ( ! function_exists('upload_images'))
{
    function upload_images(array $images = [], $public = false)
    {
        $image = new App\Infoexam\Image();

        return $image->uploadImages($images, $public);
    }
}

if ( ! function_exists('maybe_unserialize'))
{
    function maybe_unserialize($original)
    {
        if (is_serialized($original))
        {
            return unserialize($original);
        }

        return $original;
    }
}

if ( ! function_exists('is_serialized'))
{
    function is_serialized($data, $strict = true)
    {
        if ( ! is_string($data))
        {
            return false;
        }
        else if ('N;' == ($data = trim($data)))
        {
            return true;
        }
        else if (strlen( $data ) < 4)
        {
            return false;
        }
        else if (':' !== $data[1])
        {
            return false;
        }

        if ($strict)
        {
            $lastc = substr( $data, -1 );

            if ((';' !== $lastc) && ('}' !== $lastc))
            {
                return false;
            }
        }
        else
        {
            $semicolon = strpos($data, ';');
            $brace = strpos($data, '}');

            if ((false === $semicolon) && (false === $brace))
            {
                return false;
            }
            else if ((false !== $semicolon) && ($semicolon < 3))
            {
                return false;
            }
            else if ((false !== $brace) && ($brace < 4))
            {
                return false;
            }
        }

        $token = $data[0];

        switch ($token)
        {
            case 's':
                if ($strict)
                {
                    if ('"' !== substr($data, -2, 1))
                    {
                        return false;
                    }
                }
                else if (false === strpos($data, '"'))
                {
                    return false;
                }
            case 'a':
            case 'O':
                return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
            case 'b':
            case 'i':
            case 'd':
                $end = $strict ? '$' : '';
                return (bool) preg_match("/^{$token}:[0-9.E-]+;$end/", $data);
        }

        return false;
    }
}