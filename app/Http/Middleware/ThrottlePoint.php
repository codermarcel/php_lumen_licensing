<?php

namespace App\Http\Middleware;

class ThrottlePoint extends ThrottleIp
{
    /**
     * Resolve request signature.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function resolveRequestSignature($request)
    {
        return $this->makeHash(json_encode($request->route()), $request->ip());
    }
}