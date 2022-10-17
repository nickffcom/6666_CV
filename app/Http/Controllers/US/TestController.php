<?php

namespace App\Http\Controllers\US;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request ){

       $nullnek = null;
       if(!empty($nullnek)){
        dd("kk");
       }
        $arrnek = [1,2,3];
        dd(count($arrnek));
        if(empty($arrnek)){
            $temp = json_encode($arrnek);
            // dd($temp);
        }
        // if (in_array("Glenn", $people))
        // {
        // echo "Match found";
        // }
        // else
        // {
        // echo "Match not found";
        // }
        $temp = $request->cookie('myshowroom1',null);
        dd($temp);
        $temp = json_decode($temp);
        // dd($temp);
        $showroomID=7;
         if (in_array($showroomID, $temp)){
            // array_diff($temp,$showroomID);
            // dd($temp);
  
        echo "Match found";
        }
        else
        {
        echo "Match not found";
        }
        if(count($temp)>3){
            echo "Lớn hơn 3";
            array_push($temp,5);
            dd($temp);
            $isDisplay =null;
        }
        if(count($temp) <3){
            echo "Bé hơn 3";
             if (in_array("1", $temp) ){

            }
        }
        if (($key = array_search($showroomID, $temp)) !== false) {
            unset($temp[$key]);
            echo "Xóa ok rồi ạ";
            // dd($temp);
        }else{
            echo "Ko xóa đc";
        }
        // dd($temp);
        $arr=["7", "8", "88", "77"];
        $ck = cookie("myshowroom",json_encode($arr),600);
        return response("haizz")->cookie($ck);

    }
}
