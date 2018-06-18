<?php

namespace System\Helpers;

class TextHelper
{
    public static function truncateString($string, $desired_length)
    {
        $parts = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
        $string_count = count($parts);

        $length = 0;
        $last_part = 0;
        for (; $last_part < $string_count; ++$last_part)
        {
            $length += strlen($parts[$last_part]);
            if ($length > $desired_length)
            {
                break;
            }
        }

        return implode(array_slice($parts, 0, $last_part));
    }

    public static function simpleTruncate($string, $length)
    {
        return substr($string, 0, strrpos(substr($string, 0, $length), ' '));
    }

    /**
     * trims text to a space then adds ellipses if desired
     * @param string $input text to trim
     * @param int $length in characters to trim to
     * @param bool $ellipses if ellipses (...) are to be added
     * @param bool $strip_html if html tags are to be stripped
     * @return string 
     */
    public static function truncateArticle($input, $length, $ellipses = true, $strip_html = true)
    {
        //strip tags, if desired
        if ($strip_html)
        {
            $input = strip_tags($input);
        }

        //no need to trim, already shorter than trim length
        if (strlen($input) <= $length)
        {
            return $input;
        }

        //find last space within length
        $last_space = strrpos(substr($input, 0, $length), ' ');
        $trimmed_text = substr($input, 0, $last_space);

        //add ellipses (...)
        if ($ellipses)
        {
            $trimmed_text .= '...';
        }

        return $trimmed_text;
    }

}
