<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameWordKorea;
use App\Models\GameWordEnglish;
use Illuminate\Support\Facades\Storage;

class GameWordController extends Controller
{
    public function showGameWordMain(){
        return view('gamewords.gamewordmain');
    }

    public function showGameWord($major){
        if($major=="korea"){
            $word=GameWordKorea::orderBy('id','desc')->simplepaginate(10);
            $count=GameWordKorea::get()->count();
            return view('gamewords.gameword',[
                'words'=>$word,
                'major'=>$major,
                'count'=>$count
            ]);
        }

        if($major=="english"){
            $word=GameWordEnglish::orderBy('id','desc')->simplepaginate(10);
            $count=GameWordEnglish::get()->count();
            return view('gamewords.gameword',[
                'words'=>$word,
                'major'=>$major,
                'count'=>$count
            ]);
        }
         
    }

    public function showGameWordAdding($major){
        return view('gamewords.addgameword',[
            'major'=>$major
        ]);
    }

    public function editGameWord(Request $req, $id){
        $major=$req->major;
        if($major=="korea"){
            $word=GameWordKorea::find($id);
            return view('gamewords.editgameword',[
                'word'=>$word,
                'major'=>$major
            ]);
        }

        if($major=="english"){
            $word=GameWordEnglish::find($id);
            return view('gamewords.editgameword',[
                'word'=>$word,
                'major'=>$major
            ]);
        }
    }
    
    public function updateWord(Request $req){
        
    }
    
    
    public function addGameWord(Request $req,$major){
        
        $req->validate([
            'ans'=>'required'
            ]);
            
        
        if($req->category!="1"){
             $myPath="https://www.calamuseducation.com/uploads/";
             $file=$req->file('myfile');
             $result=Storage::disk('calamusPost')->put('gameassets',$file);
             $url=$myPath.$result;
        }
        
       
        if($req->category=="1"){
            $displayword=$req->displayword;
            $displayimage="";
            $displayaudio="";
        }else if($req->category=="2"){
            $displayword="";
            $displayimage=$url;
            $displayaudio="";
        }else{
            $displayword="";
            $displayimage="";
            $displayaudio=$url;
        }
        
        
        
        if($major=='english'){
            $gameword=new GameWordEnglish();
            $gameword->display_word=$displayword;
            $gameword->display_audio=$displayaudio;
            $gameword->display_image=$displayimage;
            $gameword->category=$req->category;
            $gameword->a=$req->ansA;
            $gameword->b=$req->ansB;
            $gameword->c=$req->ansC;
            $gameword->ans=$req->ans;
            $gameword->save();
            
        }
        
        if($major=='korea'){
            $gameword=new GameWordKorea();
            $gameword->display_word=$displayword;
            $gameword->display_audio=$displayaudio;
            $gameword->display_image=$displayimage;
            $gameword->category=$req->category;
            $gameword->a=$req->ansA;
            $gameword->b=$req->ansB;
            $gameword->c=$req->ansC;
            $gameword->ans=$req->ans;
            $gameword->save();
        }
        
         return back()->with('msg','Successfully Added');
    }
    
    public function deleteGameWord(Request $req){
        
         
        $id=$req->id;
        $major=$req->major;
        
        if($major=="korea"){
            GameWordKorea::where("id",$id)->delete();
        }
        
        if($major=="english"){
            GameWordEnglish::where("id",$id)->delete();
        }
        
        return back()->with('msg','Successfully deleted');
    }
}
