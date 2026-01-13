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
        // Get statistics
        $english_songs = song::where('type', 'english')->count();
        $korean_songs = song::where('type', 'korea')->count();
        $chinese_songs = song::where('type', 'chinese')->count();
        $japanese_songs = song::where('type', 'japanese')->count();
        $russian_songs = song::where('type', 'russian')->count();
        $total_songs = $english_songs + $korean_songs + $chinese_songs + $japanese_songs + $russian_songs;
        
        $total_artists = artist::count();
        $total_requested = requestedsong::count();
        
        // Detect already uploaded requested songs for all languages
        // Match by title and language only (not artist)
        // Using COLLATE to fix collation mismatch between tables
        $already_uploaded = DB::table('requestedsongs')
            ->selectRaw("
                requestedsongs.id as requested_id,
                requestedsongs.name as requested_title,
                requestedsongs.vote as vote,
                artists.name as requested_artist,
                artists.nation as language,
                songs.id as song_id,
                songs.title as song_title,
                songs.artist as song_artist,
                songs.url as song_url,
                songs.type as song_type
            ")
            ->join('artists', 'requestedsongs.artist_id', '=', 'artists.id')
            ->join('Songs as songs', function($join) {
                $join->on(DB::raw('requestedsongs.name COLLATE utf8mb4_unicode_ci'), '=', DB::raw('songs.title COLLATE utf8mb4_unicode_ci'));
            })
            ->whereRaw("
                (artists.nation COLLATE utf8mb4_unicode_ci = songs.type COLLATE utf8mb4_unicode_ci) OR 
                (artists.nation COLLATE utf8mb4_unicode_ci = 'korean' AND songs.type COLLATE utf8mb4_unicode_ci = 'korea') OR
                (artists.nation COLLATE utf8mb4_unicode_ci = 'korea' AND songs.type COLLATE utf8mb4_unicode_ci = 'korea')
            ")
            ->orderBy('requestedsongs.vote', 'desc')
            ->get();
        
        return view('songs.songmain', [
            'english_songs' => $english_songs,
            'korean_songs' => $korean_songs,
            'chinese_songs' => $chinese_songs,
            'japanese_songs' => $japanese_songs,
            'russian_songs' => $russian_songs,
            'total_songs' => $total_songs,
            'total_artists' => $total_artists,
            'total_requested' => $total_requested,
            'already_uploaded' => $already_uploaded
        ]);
    }

    public function showSongs($major, Request $req){
        $search = $req->get('search', '');
        $filter_artist = $req->get('artist', '');

        // Build query
        $query = song::where('type', $major);

        // Apply search filter
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                  ->orWhere('artist', 'LIKE', '%' . $search . '%')
                  ->orWhere('drama', 'LIKE', '%' . $search . '%');
            });
        }

        // Apply artist filter
        if (!empty($filter_artist)) {
            $query->where('artist', $filter_artist);
        }

        // Default sorting by id desc
        $songs = $query->orderBy('id', 'desc')->simplepaginate(10)->withQueryString();

        // Calculate statistics for this specific language (unfiltered)
        $total_songs = song::where('type',$major)->count();
        $total_likes = song::where('type',$major)->sum('like_count');
        $total_downloads = song::where('type',$major)->sum('download_count');
        $total_comments = song::where('type',$major)->sum('comment_count');
        $total_artists = artist::where('nation',$major)->count();
        
        // Calculate requested songs for this language
        $total_requested = DB::table('requestedsongs')
            ->join('artists', 'requestedsongs.artist_id', '=', 'artists.id')
            ->where('artists.nation', $major)
            ->count();

        // Get artists for filter dropdown
        $artists = artist::where('nation', $major)->orderBy('name', 'asc')->get();

        return view('songs.songs',[
            'songs'=>$songs,
            'major'=>$major,
            'total_songs'=>$total_songs,
            'total_likes'=>$total_likes,
            'total_downloads'=>$total_downloads,
            'total_comments'=>$total_comments,
            'total_artists'=>$total_artists,
            'total_requested'=>$total_requested,
            'artists'=>$artists,
            'search'=>$search,
            'filter_artist'=>$filter_artist
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
        
    
        $mobileImage=$req->imageFile;
        $webImage=$req->imageFileWeb;
        $req->lyricsFile->move('../uploads/songs/lyrics',$myFileName.".txt");
        $req->audioFile->move('../uploads/songs/audio',$myFileName.".mp3");
        $mobileImage->move('../uploads/songs/image', $myFileName.".png");
        $webImage->move('../uploads/songs/web', $myFileName.".png");
        
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

    public function showRequestedSong($major, Request $req){
        $search = $req->get('search', '');
        
        // Build base query
        $baseQuery = DB::table('requestedsongs')
            ->selectRaw("
                requestedsongs.id as id,
                requestedsongs.name as title,
                requestedsongs.vote as vote,
                artists.name as artist
            ")
            ->where('artists.nation',$major)
            ->join('artists','requestedsongs.artist_id','=','artists.id');
        
        // Apply search filter
        if (!empty($search)) {
            $baseQuery->where(function($q) use ($search) {
                $q->where('requestedsongs.name', 'LIKE', '%' . $search . '%')
                  ->orWhere('artists.name', 'LIKE', '%' . $search . '%');
            });
        }
        
        // Get total count (filtered if search is applied)
        $total_requested = (clone $baseQuery)->count();
        
        // Get paginated songs
        $songs = (clone $baseQuery)
            ->orderBy('vote','desc')
            ->simplepaginate(30)
            ->withQueryString();
        
        return view('songs.requestedsongs',[
            'songs'=>$songs,
            'major'=>$major,
            'total_requested'=>$total_requested,
            'search'=>$search
        ]);
    }

    public function deleteRequestedSong(Request $req){
        $id = $req->id;
        
        // Check if the requested song exists
        $requestedSong = requestedsong::find($id);
        
        if (!$requestedSong) {
            return back()->with('error', 'Requested song not found');
        }
        
        // Delete the requested song
        $requestedSong->delete();
        
        // Check if we're coming from songmain page (check referer or use a parameter)
        $referer = $req->headers->get('referer');
        if (strpos($referer, '/song') !== false && strpos($referer, '/song/list/') === false) {
            return redirect()->route('showSongMain')->with('msgSongReq', 'Requested song was successfully deleted');
        }
        
        return back()->with('msgSongReq', 'Requested song was successfully deleted');
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
   
    public function showSongDetail($id, Request $req){
        $major = $req->get('major', '');
        $song = song::find($id);
        
        if (!$song) {
            return redirect()->route('showSongs', $major)->with('error', 'Song not found');
        }
        
        return view('songs.songdetail',[
            'song'=>$song,
            'major'=>$major
        ]);
    }

    public function editSong($id, Request $req){
        $major = $req->get('major', '');
        $song = song::find($id);
        
        if (!$song) {
            return redirect()->route('showSongs', $major)->with('error', 'Song not found');
        }
        
        return view('songs.editsong',[
            'song'=>$song,
            'major'=>$major
        ]);
    }

    public function updateSong(Request $req, $id){
        $song = song::find($id);
        
        if (!$song) {
            return redirect()->back()->with('error', 'Song not found');
        }

        $major = $req->major;
        
        $req->validate([
            'title'=>'required',
            'artist'=>'required'
        ]);

        $title = $req->title;
        $artist = $req->artist;
        if(empty($req->drama)){
            $drama = "...";
            $myFileName = $title."( ".$artist." )";
        } else {
            $drama = $req->drama;
            $myFileName = $title."( ".$artist."_".$drama." )";
        }
        
        $myFileName = str_replace(" ", "", $myFileName);
        
        // Update files only if new ones are provided
        if($req->hasFile('audioFile')){
            $req->audioFile->move('../uploads/songs/audio', $myFileName.".mp3");
        }
        
        if($req->hasFile('lyricsFile')){
            $req->lyricsFile->move('../uploads/songs/lyrics', $myFileName.".txt");
        }
        
        if($req->hasFile('imageFile')){
            $req->imageFile->move('../uploads/songs/image', $myFileName.".png");
        }
        
        if($req->hasFile('imageFileWeb')){
            $req->imageFileWeb->move('../uploads/songs/web', $myFileName.".png");
        }
        
        // Update song data
        $song->title = $title;
        $song->artist = $artist;
        $song->drama = $drama;
        $song->url = $myFileName;
        $song->save();

        return redirect()->route('showSongs', $major)->with('msgSong', 'Song was successfully updated');
    }
   
   
}
