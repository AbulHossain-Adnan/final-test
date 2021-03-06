<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Models\Sub_category;
class SubcategoryController extends Controller
{
       public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index(){
        return view('admin/subcategory/index',[
            'categories'=>Category::all()

        ]);
    }
    public function alldata(){
        $data=Sub_category::orderBy('id', 'DESC')->get();
        // $data = DB::table('sub_categories')->paginate(10);
        return response()->json($data);
    }
    public function store(Request $request){
        $request->validate([
            'sub_category_name'=>'required',
            'category_id'=>'required'
        ]);
        $data = new Sub_category();
        $data->sub_category_name=$request->sub_category_name;
        $data->category_id =$request->category_id;
        $data->save();
        return response()->json($data);
    }
    public function edit($id){
        $data=Sub_category::findOrFail($id);
        return response()->json($data);
    }
    public function update(Request $request,$id){
        $data= Sub_category::findOrFail($id);
        $data->update([
            'sub_category_name'=>$request->sub_category_name,
            'category_id'=>$request->category_id
        ]);
        return response()->json($data);

    }
    public function delete($id){
        $data=Sub_category::findOrFail($id);
        $data->delete();
        return response()->json($data);
        
    }


    }

