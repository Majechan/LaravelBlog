<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; //sql method getting data form database
use Illuminate\Support\Facades\Storage;
use App\Bloglist; //model

class BloglistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $userid=auth()->user()->id;
        $posts = DB::select('SELECT a.*,b.name FROM bloglists a  inner join users b on a.createdby = b.id where a.createdby="'.$userid.'" and a.deleted<>"Y" order by a.created_at desc');
        return view('pages.bloglist')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //process post request and insert to DB
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999' // validation of the uploaded file and file size
        ]);
        
        //handle file upload
        if($request->hasFile('cover_image'))
        {
            //get filename with extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // get filename no extension
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            // get file extension
            $extention = $request->file('cover_image')->getClientOriginalExtension();
            $filenameToStore =$filename.'_'.time().'.'.$extention;
            //upload image
            $path = $request->file('cover_image')->storeAs('public/images',$filenameToStore);
            //file will be save to store/app/public/cover_images which is not accessible in the browser so image will not load
            //to be able to show and have symlink to public forther
            //php artisan storage:link
        }
        else
        {
            $filenameToStore='noimage.png';
        }

        // create post
        $post = new Bloglist;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->createdby = auth()->user()->id;
        $post->deleted = 'N';
        $post->image = $filenameToStore;
        $post->save();

        return redirect('/bloglist')->with('success','Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $posts = DB::select('SELECT a.*,b.name FROM bloglists a  inner join users b on a.createdby = b.id where a.id="'.$id.'"');
        if(count($posts)<1)
        {
            return redirect('/')->with('error','Post not exist.');
        }
        return view('pages.blog')->with('posts',$posts);
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
        $posts = DB::select('SELECT a.*,b.name FROM bloglists a  inner join users b on a.createdby = b.id where a.id="'.$id.'"');
        if(count($posts)<1)
        {
            return redirect('/')->with('error','Unauthorized Page.');
        }
        return view('pages.edit')->with('posts',$posts);
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
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        //handle file upload
        if($request->hasFile('image'))
        {
            //get filename with extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            // get filename no extension
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            // get file extension
            $extention = $request->file('image')->getClientOriginalExtension();
            $filenameToStore =$filename.'_'.time().'.'.$extention;
            //upload image
            $path = $request->file('image')->storeAs('public/images',$filenameToStore);
            //file will be save to store/app/public/cover_images which is not accessible in the browser so image will not load
            //to be able to show and have simlink to public forther
            //php artisan storage:link

            
               //delete old image in storage or rather move to different folder
            Storage::move('public/images/'.$request->input('oldimage'),'public/deleted_images/'.$request->input('oldimage'));
                    //move('public/deleted_images/'.$post->cover_image, $post->cover_image);
            
        }
        
        // update post
        $post = Bloglist::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('image'))
        {
            $post->image = $filenameToStore;
        }
        $post->save();

        return redirect('/bloglist')->with('success','Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Bloglist::find($id);
        // check for correct user
        if(auth()->user()->id !== $post->createdby)
        {
            return redirect('/bloglist')->with('error','Unauthorized Page');
        }
        if($post->image!='noimage.png')
        {
           //delete image in storage or rather move to different folder
                Storage::move('public/images/'.$post->image,'public/deleted_images/'.$post->image);
                //move('public/deleted_images/'.$post->cover_image, $post->cover_image);
        }
        //$post->delete();
        $post->deleted = 'Y';
        $post->save();
        return redirect('/bloglist')->with('success','Post Removed');
    }
}
