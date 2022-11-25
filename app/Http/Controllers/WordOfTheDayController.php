<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WordOfTheDayKorea;
use App\Models\WordOfTheDayEnglish;
use App\Models\WordOfTheDayChinese;
use App\Models\WordOfTheDayJapanese;
use App\Models\WordOfTheDayRussian;
use Illuminate\Support\Facades\Storage;
class WordOfTheDayController extends Controller
{


    public function showWordOfTheDayMain(){
        return view('wordoftheday.wordmain');
    }

    public function showWordOfTheDay($major){
        if($major=="korea"){
            $words=WordOfTheDayKorea::orderBy('id','desc')->simplepaginate(10);
            return view('wordoftheday.word',[
                'major'=>$major,
                'words'=>$words
            ]);
        }

        if($major=="english"){
            $words=WordOfTheDayEnglish::orderBy('id','desc')->simplepaginate(10);
            return view('wordoftheday.word',[
                'major'=>$major,
                'words'=>$words
            ]);
        }
        
        if($major=="chinese"){
            $words=WordOfTheDayChinese::orderBy('id','desc')->simplepaginate(10);
            return view('wordoftheday.word',[
                'major'=>$major,
                'words'=>$words
            ]);
        }
        
        if($major=="japanese"){
            $words=WordOfTheDayJapanese::orderBy('id','desc')->simplepaginate(10);
            return view('wordoftheday.word',[
                'major'=>$major,
                'words'=>$words
            ]);
        }
        
        if($major=="russian"){
            $words=WordOfTheDayRussian::orderBy('id','desc')->simplepaginate(10);
            return view('wordoftheday.word',[
                'major'=>$major,
                'words'=>$words
            ]);
        }
    }

    public function showDetailWordDay(Request $req,$id){
        $major=$req->major;
        
        if($major=='korea'){
            $word=WordOfTheDayKorea::where('id',$id)->first();
            return view('wordoftheday.worddetail',[
                'word'=>$word,
                'major'=>$major
            ]);
        }else if($major=='english'){
            $word=WordOfTheDayEnglish::where('id',$id)->first();
            return view('wordoftheday.worddetail',[
                'word'=>$word,
                'major'=>$major
            ]);
        }else if($major=='chinese'){
            $word=WordOfTheDayChinese::where('id',$id)->first();
            return view('wordoftheday.worddetail',[
                'word'=>$word,
                'major'=>$major
            ]);
        }else if($major=='japanese'){
            $word=WordOfTheDayJapanese::where('id',$id)->first();
            return view('wordoftheday.worddetail',[
                'word'=>$word,
                'major'=>$major
            ]);
        }else if($major=='russian'){
            $word=WordOfTheDayRussian::where('id',$id)->first();
            return view('wordoftheday.worddetail',[
                'word'=>$word,
                'major'=>$major
            ]);
        }else {
            return "An Error Occurred!";
        }
      
    }

    public function updateWordDay(Request $req){
      
        if($req->major=="english"){$myclass=new WordOfTheDayEnglish;}
        if($req->major=="korea"){$myclass=new WordOfTheDayKorea;}
        if($req->major=="chinese"){$myclass=new WordOfTheDayChinese;}
        if($req->major=="japanese"){$myclass=new WordOfTheDayJapanese;}
        if($req->major=="russian"){$myclass=new WordOfTheDayRussian;}

        if($req->myfile!=null){
            //search and delete old image
            $word=$myclass::find($req->id);
            $image=basename($word->thumb);
            $file=$_SERVER['DOCUMENT_ROOT'].'/uploads/images/'.$image; 
            if(file_exists($file)){
                unlink($file);
            }
            //insert new image
            $newFile=$req->file('myfile');
            $myPath="https://www.calamuseducation.com/uploads/";
            $result=Storage::disk('calamusPost')->put('images',$newFile);
            $url=$myPath.$result;
            $myclass::where('id',$req->id)->update(['thumb'=>$url]);
        }

        $myclass::where('id',$req->id)
        ->update([
            $req->major=>$req->word,
            'myanmar'=>$req->myanmar,
            'speech'=>$req->speech,
            'example'=>$req->example
        ]);

        return back()->with('msg','successfully updated');
    }

    public function showWordDayAdding($major){
        return view('wordoftheday.addwordday',[
            'major'=>$major
        ]);
    }

    public function addWordDay(Request $req,$major){
        
        if($major=="chinese"){ $word=new WordOfTheDayChinese;}
        if($major=="korea"){ $word=new WordOfTheDayKorea;}
        if($major=="english"){ $word=new WordOfTheDayEnglish;}
        if($major=="japanese"){ $word=new WordOfTheDayJapanese;}
        if($major=="russian"){ $word=new WordOfTheDayRussian;}
        
        $req->validate([
                "$major"=>'required',
                'speech'=>'required',    
                'myanmar'=>'required',    
                'image'=>'required',    
                'example'=>'required'
            ]);
        
        $myPath="https://www.calamuseducation.com/uploads/";
        $file=$req->file('image');
        $result=Storage::disk('calamusPost')->put('images',$file);
        $url=$myPath.$result;
        
        
        $word->$major=$req->$major;
        $word->speech=$req->speech;
        $word->myanmar=$req->myanmar;
        $word->example=$req->example;
        $word->thumb=$url;
        $word->save();
        return back()->with('msg','successfully added');
        
    }
}
