<?php 

namespace App\Http\Traits; 


trait ApiHandler {
    public function successMessage($message)
    {
        return response()->json([
            'status'=>true,
            'message'=>$message,
        ]);
    }
    public function errorMessage($message)
    {
        return response()->json([
            'status'=>false,
            'message'=>$message,
        ]);
    }
    public function ReturnData($key,$value,$message)
    {
        return response()->json([
            'status'=>false,
            'message'=>$message,
            $key=>$value,
        ]);
    }
}   



