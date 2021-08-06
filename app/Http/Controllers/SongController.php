<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\song;
use App\Models\requestedsong;
use App\Models\artist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    public function showSongMain(){
        return view('songs.songmain');
    }

    public function showSongs($major){
        $songs=song::where('type',$major)
                ->orderBy('id','desc')->simplepaginate(10);


        return view('songs.songs',[
            'songs'=>$songs,
            'major'=>$major
        ]);
        
    }


    public function showAddSong($major){
        return view('songs.addsong',[
            'major'=>$major
        ]);
    }

    public function addSong(Request $req, $major){
        $req->validate([
            'title'=>'required',
            'artist'=>'required',
            'audioFile'=>'required',
            'imageFile'=>'required',
            'lyricsFile'=>'required'
        ]);

        
        $date = round(microtime(true) * 1000);
        $title=$req->title;
        $artist=$req->artist;
        if(empty($req->drama)){
            $drama="...";
            $myFileName=$title."( ".$artist." )";
        }else{
            $drama=$req->drama;
             $myFileName=$title."( ".$artist."_".$drama." )";
        }
        
        $myFileName=str_replace(" ","",$myFileName);
        
    
  
        $req->lyricsFile->move('../uploads/songs/lyrics',$myFileName.".txt");
        $req->audioFile->move('../uploads/songs/audio',$myFileName.".mp3");
        $req->imageFile->move('../uploads/songs/image', $myFileName.".png");
        
        $song=new song;
        $song->song_id=$date;
        $song->title=$title;
        $song->artist=$artist;
        $song->drama=$drama;
        $song->like_count=0;
        $song->comment_count=0;
        $song->download_count=0;
        $song->url=$myFileName;
        $song->type=$major;
        $song->save();

        return back()->with('msgSong','Song was successfully added');
        
    }

    public function showRequestedSong($major){
        $songs=DB::table('requestedsongs')
        ->selectRaw("
            requestedsongs.id as id,
            requestedsongs.name as title,
            requestedsongs.vote as vote,
            artists.name as artist
        ")
        ->where('artists.nation',$major)
        ->join('artists','requestedsongs.artist_id','=','artists.id')
        ->orderBy('vote','desc')
        ->simplepaginate(30);
        
        return view('songs.requestedsongs',[
            'songs'=>$songs,
            'major'=>$major
        ]);
    }

    public function deleteRequestedSong(Request $req){
        $id=$req->id;
        requestedsong::where('id',$id)->delete();
        return back()->with('msgSongReq','Song was successfully deleted');
    }
    
    public function showArtist($major){
        $artists=artist::where('nation',$major)->get();
        return view('songs.artist',[
            'major'=>$major,
            'artists'=>$artists
        ]);
    }

    
    public function showAddArtist($major){
        return view ('songs.addartist',[
            'major'=>$major
        ]);
    }

    public function addArtist(Request $req){
        $req->validate([
            'name'=>'required'
        ]);

        $isExist=artist::where('nation',$req->major)->where('name',$req->name)->first();
        if($isExist){
            return back()->with('error','The artist name has already existed');
        }else{
            $artist=new artist;
            $artist->nation=$req->major;
            $artist->name=$req->name;
            $artist->save();
            return back()->with('msg',$req->name.' was successfully added');

        }
   }

   public function deleteArtist(Request $req){
        $id=$req->id;
        $isExist=requestedsong::where('artist_id',$id)->first();

        if($isExist){
            return back()->with('error',$req->artist.' cannot be deleted');
        }else{
            artist::where('id',$id)->delete();
            return back()->with('msg',$req->artist.' was successfully deleted');
        }
     
   }
   
    public function showRequestedSongByArtist($artist){
        $art=artist::find($artist);
        $songs=DB::table('requestedsongs')
        ->selectRaw("
            requestedsongs.id as id,
            requestedsongs.name as title,
            requestedsongs.vote as vote,
            artists.name as artist
        ")
        ->where('requestedsongs.artist_id',$artist)
        ->join('artists','requestedsongs.artist_id','=','artists.id')
        ->orderBy('vote','desc')
        ->simplepaginate(30);
        
        return view('songs.requestedsongs',[
            'songs'=>$songs,
            'major'=>$art->name
        ]);
    }
   
   
   
}
