<?php

namespace Api\Core\Base;

use Api\Core\Services\RequestQuery\QueryableModelInterface;
use Api\Core\Services\RequestQuery\RequestQueryService;
use Azaan\LaravelScene\Contracts\Transformer;
use Azaan\LaravelScene\SceneResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;


class BaseController extends Controller
{
    /**
     * Respond a json response
     *
     * @param mixed       $data
     * @param Transformer $transformer      an optional transformer
     * @param array       $extraFields      extra objects to be added to response. The key values
     *                                      passed in are added to the response. If a transformer is
     *                                      required pass it in the format ['key' => [$arr, $transformer]]
     *
     * @return JsonResponse|Response
     */
    protected function respond($data, Transformer $transformer = null, $extraFields = null)
    {
        return SceneResponse::respond($data, $transformer, $extraFields);
    }

    /**
     * Respond file
     *
     * @param        $obj
     * @param string $disposition
     *
     * @return Response
     */
    protected function respondFileArray($obj, $disposition = 'inline')
    {
        $name = str_replace('/', '_', $obj['filename']);
        $file = $obj['data'];

        return \Response::make($file, 200, [
            'Content-Type'        => $obj['type'],
            'Content-Disposition' => $disposition . '; filename="' . $name . '"',
        ]);
    }

    /**
     * Empty success response
     *
     * @return JsonResponse
     */
    protected function respondOk()
    {
        return new JsonResponse();
    }
}
