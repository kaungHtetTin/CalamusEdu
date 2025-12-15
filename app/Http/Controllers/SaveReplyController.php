<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaveReply;

class SaveReplyController extends Controller
{

 
    public function index()
    {
        return SaveReply::all();
    }
    
    

    public function store(Request $req)
    {
       
        
        $title=$req->title;
        $message=$req->message;
        $major=$req->major;
       
        $saveReply=new SaveReply();
        
        $saveReply->title=$title;
        $saveReply->message=$message;
        $saveReply->major=$major;
        $saveReply->save();
    }


    public function show($id)
    {
        $message=SaveReply::find($id);
        return $message;
    }


    public function update($id)
    {
        $reply=SaveReply::find($id);
        $reply->title=request()->title;
        $reply->message=request()->message;
        
        $reply->save();
        
        return $reply;
      
    }


    public function destroy($id)
    {
        $message=SaveReply::find($id);
        $message->delete();
        return $message;
    }
}
