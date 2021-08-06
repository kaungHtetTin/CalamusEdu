<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WordOfTheDayKorea;
use App\Models\WordOfTheDayEnglish;
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
        }else {
            return "An Error Occurred!";
        }
      
    }

    public function updateWordDay(Request $req){
      
        if($req->major=="english"){$myclass=new WordOfTheDayEnglish;}
        if($req->major=="korea"){$myclass=new WordOfTheDayKorea;}

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
        if($major=="english"){
            $req->validate([
                'english'=>'required',
                'speech'=>'required',    
                'myanmar'=>'required',    
                'image'=>'required',    
                'example'=>'required'
            ]);
            $myPath="https://www.calamuseducation.com/uploads/";
            $file=$req->file('image');
            $result=Storage::disk('calamusPost')->put('images',$file);
            $url=$myPath.$result;
            
            $word=new WordOfTheDayEnglish;
            $word->english=$req->english;
            $word->speech=$req->speech;
            $word->myanmar=$req->myanmar;
            $word->example=$req->example;
            $word->thumb=$url;
            $word->save();
            return back()->with('msg','successfully added');
            
        }
        
    }
}
