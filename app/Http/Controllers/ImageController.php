<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Images;
use Image;
use Session;
use Response;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $rules = [
        'image'=>'required|file',
        'view_status'=>'required'    
        ];
        $id = $request->input('album_id');
        $msg = [
            'image.required'=>'Please select a file',
            'image.file'=>'selected file must be of type image',
            'view_status'=>'Please select a privacy type'   
        ];
        $extensions = ['jpg','JPG','jpeg','JPEG','png','PNG','gif','GIF','svg','SVG'];
        $validator = Validator::make($input,$rules,$msg);
        if($validator->fails())
        {
           return redirect('/ViewAlbum'.'/'.$id)->withErrors($validator)
                                    ->withInput();
        }
        $ext  = request()->image->getClientOriginalExtension();
        if(in_array($ext,$extensions))
        {   
            $image_name = str_replace('.',"",microtime(TRUE));
            $image_name .= '.';
            $image_name .=$ext;
            $path = $request->image->storeAs('images',$image_name,'public');
            if($path!=null)
            {
              try 
              {
                $image_input=[
                    'user_id'=>auth()->id(),
                    'album_id'=>$id,
                    'caption'=>$request->caption,
                    'ext'=>$ext,
                    'size'=>request()->image->getClientSize(),
                    'mime'=>request()->image->getClientMimeType(),
                    'original_name'=>$request->image->getClientOriginalName(),
                    'image_name'=>$image_name,
                    'view_status'=>$request->view_status, 
                  ];
                Images::create($image_input);
                $image_thumbnail = Image::make(storage_path('app/public/images/' . $image_name))->resize(320,240);
                $image_thumbnail ->save(storage_path('app/public/images/'.'thumb_' . $image_name));
                return back();
                
              } 
              catch (Exception $e) 
              {
                echo $e->lineNumber();
              }  
              
            }

        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
     
       return \view('gallery',compact('id'));
    }
    public function retrieve(Request $request)
    {  
        $user = auth()->user();
        // return;
        $album_id = $request->input('album_id');
    

        $Images = images::with('album')->where([ 
            ['user_id', '=', auth()->id()],
            ['album_id', '=', $album_id]
        ])->get()->map(function($img) {
            $img->img_url = url(\Storage::url('public/images/thumb_'.$img->image_name));
            // $img->album = $img->album;
            return $img;
         });
        return Response::json($Images);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {   
        $id = $request->input('image_id');  
        $deleted = Images::find($id)->delete();
           
        return [
            'status' => $deleted
        ];
    }
   
}
