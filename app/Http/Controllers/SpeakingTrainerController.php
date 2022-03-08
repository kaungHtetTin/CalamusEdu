<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Saturation;
use App\Models\SpeakingTrainer;

class SpeakingTrainerController extends Controller
{
    public function index(){
        $saturations=Saturation::orderBy('id','desc')->get();
       // return $saturations;
        return view('speakingtrainer.adddialog',[
            'saturations'=>$saturations
            ]);
    }
    
    public function addDialogue(Request $req){
        $req->validate([
                'person_a'=>'required',
                'person_a_mm'=>'required',
                'person_b'=>'required',
                'person_b_mm'=>'required'
            ]);
    
        $speaking=new SpeakingTrainer;
        $speaking->person_a=$req->person_a;
        $speaking->person_a_mm=$req->person_a_mm;
        $speaking->person_b=$req->person_b;
        $speaking->person_b_mm=$req->person_b_mm;
        $speaking->saturation_id=$req->saturation;
        $speaking->save();
        return back()->with('msgLesson','Saturation was successfully added');
        
    }
    
    public function addNewSaturation(Request $req){
         $req->validate([
            'title'=>'required',
        ]);
        
        $saturation=new Saturation;
        $saturation->title=$req->title;
        $saturation->saturation_id=time();
        $saturation->save();
        return back()->with('msgLesson','Saturation was successfully added');

    }
}
