<?php

namespace App\Http\Controllers;

use App\Model\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TagController extends Controller
{
    public function index()
    {
        $tags=Tag::paginate(env('PAGINATION_COUNT'));
        return view('admin.tags.tags')->with([
            'tags'=>$tags,
            'showLinks'=>true,
        ]);

    }

    public function store(Request $request)
    {
        $request->validate([
            'tag_name'=>'required',
        ]);

        $tagName=$request->input('tag_name');
        $tag=Tag::where('tag','=', $tagName)->get();

        if(count($tag)>0){

            $request->session()->flash('message', 'Tag '.$tagName.' already exists');

            return redirect()->back();
        }

        $newTag=new Tag();
        $newTag->tag=$tagName;
        $newTag->save();

        $request->session()->flash('message', 'Tag '.$tagName.' has been added');
        return redirect()->back();



    }

    public function search(Request $request){

        $request->validate([
            'tag_search'=>'required'
            ]);

            $searchTerm=$request->input('tag_search');

            $tags=Tag::where(
                'tag','LIKE','%'.$searchTerm.'%'

            )->get();

            if(count($tags)>0){
                return view('admin.tags.tags')->with([
                    'tags'=>$tags,
                    'showLinks'=>false,
                ]);
                Session::flash('message','Not found!!');
                return redirect()->back();
            }

    }

    public function destroy(Request $request)
    {

        $request->validate([
            'tag_id'=>'required',
        ]);

        $tagID=$request->input('tag_id');

        Tag::destroy($tagID);
        $request->session()->flash('message', 'Tag has been deleted');
        return redirect()->back();

    }

    public function update(Request $request)
    {
        $request->validate([
            'tag_name'=>'required',
            'tag_id'=>'required',
        ]);

        $tagName=$request->input('tag_name');
        $tagID=$request->input('tag_id');



        if($this->tagNameExists($tagName)){

            return redirect()->back();
        }

        $tag=Tag::find($tagID);
        $tag->tag=$tagName;
        $tag->save();

        $request->session()->flash('message', 'Tag has been updated');
        return redirect()->back();


    }


       /**
     * التحقق من اسم اليونت موجود لو لا
     */
    private function tagNameExists($tagName){

        $tag=Tag::where(
            'tag', '=' , $tagName
    )->first();

    if(! is_null($tagName)){

            Session::flash('message','Tag Name {'.$tagName.'}  already exists');
            return false;

         }

         return true;


    }

}
