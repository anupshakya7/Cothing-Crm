<?php

namespace Modules\SMS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [];
    public static function getBalance(){
        $url = "https://smssharda.com/backend/api/balancecheck?auth_key=A2VT2DIy27kjRPSrFS_sXBxHz72xCUhj";
		$curl = curl_init();
		   curl_setopt($curl, CURLOPT_URL, $url);
		   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
		   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		   
		   $response = curl_exec($curl);
           //dd($response);
		   if(!$response){
			  $response = "500";
		   }else{
		       $data = json_decode($response, true);
            $response = $data['total_credit'];
		   }
		   curl_close($curl);
		   return $response;
    }
    
    // protected static function newFactory()
    // {
    //     return \Modules\SMS\Database\factories\MessageFactory::new();
    // }
}
