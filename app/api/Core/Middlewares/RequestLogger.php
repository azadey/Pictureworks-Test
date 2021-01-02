<?php

namespace Api\Core\Middlewares;

use Api\Core\Constants\AppConstants;
use Api\Core\Helpers\AppHelpers;
use DB;
use Request;


class RequestLogger
{
    protected $excludedPaths = [
        '/telescope/telescope-api/dumps',
    ];

    protected $queryTotals = [
        'time'  => 0,
        'count' => 0,
    ];

    protected $logQuery = false;

    public function handle($request, \Closure $next)
    {
        $this->logQuery = Request::has('sql') || env('DEBUG_SQL') == true;

        if ($this->logQuery) {
            DB::listen(function ($query) {
                \Log::info('[Query]', [
                    'sql'      => $query->sql,
                    'bindings' => $query->bindings,
                    'time'     => $query->time,
                ]);

                $this->queryTotals['time']  += $query->time;
                $this->queryTotals['count'] += 1;
            });
        }

        // run the request
        $response = $next($request);

        if ($this->logQuery) {
            \Log::info('[QuerySummary] totalTime=' . $this->queryTotals['time'] . 'ms count=' . $this->queryTotals['count']);
        }

        return $response;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $response
     */
    public function terminate($request, $response)
    {
        if (defined('LARAVEL_START')) {
            $responseTime = number_format((microtime(true) - LARAVEL_START) * 1000, 0);
        } else {
            $responseTime = 0;
        }

        $requestMethod = $request->method();
        $requestUri    = $request->getRequestUri();
        $responseCode  = $response->getStatusCode();

        if (in_array($requestUri, $this->excludedPaths)) {
            return;
        }

        if (app()->has(AppConstants::IOC_CLIENT)) {
            $userString = "Client/" . AppHelpers::currentClientOrFail()->name;

        } else if (\Auth::user()) {
            $userString = "User/" . \Auth::user()->username;

        } else {
            $userString = 'anon';
        }

        \Log::info("[Request] [${userString}] HTTP ${requestMethod} ${requestUri} status=${responseCode} time=${responseTime}ms");
    }
}
