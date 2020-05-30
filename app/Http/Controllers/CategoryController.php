<?php

namespace App\Http\Controllers;

use App\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function index()
    {
        $categories=Category::paginate(env('PAGINATION_COUNT'));
        return view('admin.categories.categories')->with([
            'categories' => $categories,
            'showLinks'=>true,

        ]);

    }

    public function store(Request $request)
    {

        $request->validate([
            'category_name'=>'required',
        ]);

        $categoryName=$request->input('category_name');

        if( $this->categoryNameExists($categoryName)){
            Session::flash('message','Category Name {'.$categoryName.'}  already exists');
            return back();
        }

        $category=new Category();
        $category->name=$categoryName;
        $category->save();
        Session::flash('message','Category '.$categoryName.'  has been added');
        return back();


    }

    public function update(Request $request)
    {
        $request->validate([
            'category_id'=>'required',
            'category_name'=>'required',

        ]);

        $catName=$request->input('category_name');
        $catID=$request->input('category_id');


        if($this->categoryNameExists($catName)){
            Session::flash('message','Category Name {'.$catName.'}  already exists');

            return back();
        }

        $category=Category::find($catID);
        $category->name=$catName;
        $category->save();

        Session::flash('message','Category Name has been updated');
        return back();


    }

    public function destroy(Request $request)
    {
        $request->validate([
            'category_id'=>'required',
        ]);

        $catID =$request->input('category_id');

        Category::destroy($catID);

        Session::flash('message','Category  has been deleted');
        return back();

    }


    public function search(Request $request)
    {
        $request->validate([
            'category_search'=>'required'
            ]);

            $searchTerm=$request->input('category_search');

            $categories=Category::where(
                'name','LIKE','%'.$searchTerm.'%'

            )->get();

            if(count($categories)>0){
                return view('admin.categories.categories')->with([
                    'categories'=>$categories,
                    'showLinks'=>false,
                ]);
                Session::flash('message','Not found!!');
                return redirect()->back();
            }
    }

          /**
     * التحقق من اسم اليونت موجود لو لا
     */
    private function categoryNameExists($categoryName){

        $category=Category::where(

            'name', '=' , $categoryName

    )->get();

    if(count($category)>0){


            return true;

         }

         return false;
    }
}
