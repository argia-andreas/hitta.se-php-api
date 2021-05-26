<?php


namespace Grafstorm\Hitta\Exceptions;

class HittaApiException extends \Exception
{
    public static function ResponseCode($code = null): HittaApiException
    {
        return new static('Response codes are of the charts... Server responded with a:' . $code);
    }

    public static function UninitializedSearchQuery()
    {
        return new static('SearchQuery not initialized! You need to use what() or where() to actually search for something.');
    }

    public static function NoDetailId()
    {
        return new static('No detail id.');
    }

    public static function InvalidMethod($message = 'Invalid Method')
    {
        return new static($message);
    }
}
