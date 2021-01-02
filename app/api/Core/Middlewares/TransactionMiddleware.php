<?php

namespace Api\Core\Middlewares;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class TransactionMiddleware
{
    /**
     * @param Request  $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if (in_array($request->method(), ['GET', 'OPTIONS'])) {
            return $next($request);
        }

        // because of how laravel middlewares work exceptions are not propagated
        // till here. They are caught in the exception handler and converted to a
        // response.
        // we check if the result is an http error and roll back. This is hacky
        // and will not work for automatically retrying deadlock errors etc
        // because at this point we don't have access to the actual exception object

        try {
            \DB::beginTransaction();

            /** @var Response $response */
            $response = $next($request);

            if ($response->status() >= 400) {
                // error. rollback
                \DB::rollBack();
            } else {
                // valid
                \DB::commit();
            }

            return $response;

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;

        } catch (\Throwable $e) {
            \DB::rollBack();
            throw $e;
        }
    }
}
