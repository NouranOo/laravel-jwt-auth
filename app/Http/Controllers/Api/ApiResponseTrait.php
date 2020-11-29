<?php

namespace App\Http\Controllers\Api;
use App\Http\Resources\PostResource;
use Validator;
trait ApiResponseTrait
{

    public function apiResponse($data = null , $error = null , $code = 200)
    {
        $array = [
          'data' => $data,
          'status' => in_array($code , $this->sucessCode()) == 200 ? true : false ,
          'error' => $error
        ];

        return response($array , $code);
    }
    public function sucessCode()
    {
        return [
          200, 201 , 202
        ];
    }

    public function notFoundResponse () {
        return $this->apiResponse( null,'We Not Found ', 404);
    }

    public function unKnown () {
        return $this->apiResponse( null,'UnKnown Error', 400);
    }

    public function returnSuccessPost($post){
        return $this->apiResponse(new PostResource($post));
    }

    public function createdResponse($data) {
        return $this->apiResponse($data, null , 201);
    }
    public function deletedResponse() {
        return $this->apiResponse(true, null , 200);
    }
    public function apiValodation ($request , $arrary) {
        $validate = Validator::make($request->all(), $arrary);

        if($validate->fails()) {
            return $this->apiResponse( null,$validate->errors(), 422    );

        }
    }



}
