<?php


namespace Bootstrap;

use Bootstrap\Helpers\ArrayHelper;
use Bootstrap\Requests\Request;

class UrlManager extends Request
{
    use ArrayHelper;

    protected function is($route): bool
    {
        return trim($route) === basename(request()->getUri());
    }
}
