<?php

namespace App\Http\Controllers;

use App\Type;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class RestfulController extends Controller
{

    private $documentationURL = 'https://elitechlab.atlassian.net/wiki/pages/viewpage.action?pageId=3637270';
    /**
     * @param \Illuminate\Http\Request $request
     * @param string $resource
     * @param int $id
     *
     * @return string
     */
    public function checkMethod(Request $request, $resource, $id=0){

        if (Schema::hasTable($resource)) {
            /** @var  \Illuminate\Http\Request $request */
            switch ($request->method()) {
                case 'POST':
                    return $this->postResource($request, $resource, $id);
                    break;
                case 'GET':
                    return $this->getResource($request, $resource, $id);
                    break;
                case 'PUT':
                    return $this->putResource($request, $resource, $id);
                    break;
                case 'DELETE':
                    return $this->deleteResource($request, $resource, $id);
                    break;
            }
        } else {
            return \Response::json(
                [
                    'code'        => 404,
                    'message'     => 'The resource '.$resource.' is not found',
                    'userMessage' => '',
                    'moreInfo'    => $this->documentationURL,
                ], 404);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string $resource
     * @param int $id
     * @return string
     */
    private function postResource($request, $resource, $id)
    {
        //Filter model
        $arJson = $request->json()->all();
        if (isset($arJson['data']) && is_array($arJson['data']) && $id == 0) {
            try {
                DB::table($resource.'po')->insert($arJson['data']);
                return \Response::json(DB::table($resource)->where('id', DB::getPdo()->lastInsertId())->get(), 200);
            } catch (\Illuminate\Database\QueryException $e) {
                return \Response::json(
                    [
                        'code'        => 400,
                        'message'     => $e->errorInfo[2],
                        'userMessage' => '',
                        'moreInfo'    => $this->documentationURL,
                    ], 400);
            }


        } else {
            return \Response::json(
                [
                    'code'        => 400,
                    'message'     => 'There is an error in the send info',
                    'userMessage' => '',
                    'moreInfo'    => $this->documentationURL,
                ], 400);
        }

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string $resource
     * @param int $id
     * @return string
     */
    private function getResource($request, $resource, $id=0)
    {
        if ($request->has('offset') && $request->has('limit')) {
            $offset = $request->get('offset')?$request->get('offset'):0;
            $limit = $request->get('limit')?$request->get('limit'):0;
            return \Response::json(DB::table($resource)
                ->offset($offset-1)
                ->take($limit)
                ->get(), 200);
        } else if($id != 0) {
            return \Response::json(DB::table($resource)->where('id', $id)->get(), 200);
        } else {
            return \Response::json(DB::table($resource)->get(), 200);
        }

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string $resource
     * @param int $id
     * @return string
     */
    private function putResource($request, $resource, $id=0)
    {
        //Filter model
        $arJson = $request->json()->all();
        if ($id == 0 && isset($arJson['data'])) {
            foreach($arJson['data'] as $data){
                if(isset($data['id'])){
                    try {
                        DB::table($resource)
                            ->where('id', $data['id'])
                            ->update($data);
                    } catch (\Illuminate\Database\QueryException $e) {
                        return \Response::json(
                            [
                                'code'        => 400,
                                'message'     => $e->errorInfo[2],
                                'userMessage' => '',
                                'moreInfo'    => $this->documentationURL,
                            ], 400);

                    }
                }
            }
            return \Response::json(
                [
                    'code'        => 200,
                    'message'     => 'The records were updated',
                    'userMessage' => '',
                    'moreInfo'    => $this->documentationURL,
                ], 200);
        } else if($id != 0 && isset($arJson['data']) && !is_array($arJson['data'])) {
            try {
                DB::table($resource)
                    ->where('id', $id)
                    ->update($arJson['data']);
                return \Response::json(DB::table($resource)->where('id', $id)->get(), 200);
            } catch (\Illuminate\Database\QueryException $e) {
                return \Response::json(
                    [
                        'code'        => 400,
                        'message'     => $e->errorInfo[2],
                        'userMessage' => '',
                        'moreInfo'    => $this->documentationURL,
                    ], 400);

            }
        } else {
            return \Response::json(
                [
                    'code'        => 400,
                    'message'     => 'There is an error in the request',
                    'userMessage' => '',
                    'moreInfo'    => $this->documentationURL,
                ], 400);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string $resource
     * @param int $id
     * @return string
     */
    private function deleteResource($request, $resource, $id=0){
        //Filter model
        if ($id != 0 & is_integer($id)) {
            DB::table($resource)->where('id', '=', $id)->delete();
            return \Response::json(
                [
                    'code'        => 200,
                    'message'     => 'The record has been deleted',
                    'userMessage' => '',
                    'moreInfo'    => $this->documentationURL,
                ], 200);
        } else if( $id == 0){
            DB::table($resource)->delete();
            return \Response::json(
                [
                    'code'        => 200,
                    'message'     => 'The records are deleted',
                    'userMessage' => '',
                    'moreInfo'    => $this->documentationURL,
                ], 200);
        } else {
            return \Response::json(
                [
                    'code'        => 400,
                    'message'     => 'There is an error in the send info',
                    'userMessage' => '',
                    'moreInfo'    => $this->documentationURL,
                ], 400);
        }
    }
}
