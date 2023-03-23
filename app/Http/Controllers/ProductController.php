<?php

namespace App\Http\Controllers;

use App\Exports\CategoryExport;
use App\Exports\ProductsExport;
use App\Exports\ProductTagExport;
use App\Imports\CategoryImport;
use App\Imports\ProductImport;
use App\Imports\TagProductImport;
use App\Imports\TestImport;
use App\Imports\TestProductImport;
use App\Jobs\MailJob;
use App\Mail\SendMail;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Barryvdh\DomPDF\Facade\PDF;
// use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function show(){
        $categories = DB::table('categories')->get();
        $tags = DB::table('tags')->get();
        return view('product', ['categories'=> $categories, 'tags' => $tags]);
    }
    public function create(Request $request){
        $validate = Validator::make($request->all(),[
            'catgeory_id' => 'required',
            'name' => 'required|string|unique:products',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'required|image',
            'tags' => 'required',
            'insert_date' => 'required'
        ]);
        if($validate->fails()){
            return Redirect::back()
            ->withErrors($validate)
            ->withInput($request->input());
        }else{
            $product = new Product();
            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = $image->getClientOriginalName();
                $imagePath = $image->storeAs('images/', $imageName, 'public');
                $product->image = $imagePath;
            }
            $product->name = $request->input('name');
            $product->price = $request->input('price');
            $product->description = $request->input('description');
            $product->category_id = $request->input('catgeory_id');
            $product->save();
            // TABLE INTERMIDIARE
            $product->tags()->attach($request->input('tags'), ['insert_date' => $request->input('insert_date')]);
            return Redirect::back()->with('add', 'Produit '.$request->input('name').' a été ajouté avec succès');
        }
    }
    public function index(){
        $products = Product::with('category')->get();
        // $user = Gate::check('exporter-produit');
        // dd($user);
        return view('index', ['products'=> $products]);
    }
    public function edit($id){
        $product = Product::find($id);
        $categories = Category::all();
        $tags = Tag::all();
        return view('update', [
            'product'=> $product, 
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }
    public function update(Request $request, $id){
        $product = Product::find($id);
        if($request->hasFile('image')){
            File::delete(public_path("storage/images/".$product->image));
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $imagePath = $image->storeAs('images/', $imageName, 'public');
            $product->image = $imagePath;
        }
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->category_id = $request->input('category');
        $product->update();
        // $product->tags()->detach();
        // $product->tags()->attach($request->input('tags'), ['insert_date' => date('Y-m-d')]);
        $product->tags()->syncWithPivotValues($request->input('tags'), ['insert_date' => Carbon::now()]);
        return redirect('index')->with('update', 'Le produit '.$request->input('name'). ' a été modifié avec succèss');
    }
    public function delete($id){
        $product = Product::find($id);
        if($product){
            DB::table('products')->delete($id);
            return Redirect::back()->with('delete', 'Le produit '. $product->name.' a été supprimé avec succès');
        }
    }
    public function export(){
        return Excel::download(new ProductsExport, 'products.xlsx');
    }
    public function exportProductTag(){
        return Excel::download(new ProductTagExport, 'product_tag.xlsx');
    }
    public function exportCategory(){
        return Excel::download(new CategoryExport, 'category.xlsx');
    }
    public function importProduct(Request $request){
        Excel::import(new TestImport, $request->file('table'));
        return redirect('index')->with('success', 'Table importé avec succèes');
    }
    public function importProductTag(Request $request){
        Excel::import(new TagProductImport, $request->file('table_tag'));
        return redirect('index')->with('success', 'Table importé avec succès');
    }
    public function importCategory(Request $request){
        Excel::import(new CategoryImport, $request->file('table_category'));
        return redirect('index')->with('success', 'Table catégories importé avec succèss');
    }
    public function productPDF(){
        $products = Product::all();
        $data = [
            'title' => 'Table de produits',
            'date' => date('m/d/Y'),
            'products' => $products,
        ]; 
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadHTML('
        //     <h1 style="text-align-center">Table de produits</h1>
        // ');
        // return $pdf->stream();
        $pdf = PDF::loadView('pdf', $data)->save(public_path('storage/files/my_file.pdf'));
        // $pdf->setPaper('L', 'landscape');
        // $pdf->setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        return $pdf->stream('pdf_file.pdf');
    }
    public function sendEmail(Request $request){
        // dd($request->file('fichier_odf'));
        $mailData = [
            // 'to' => $request->input('email'),
            'sujet' => $request->input('sujet'),
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'attachment' => base64_encode($request->file('fichier_pdf')),
            'image' => base64_encode($request->file('image')),
        ];
        Mail::to($request->input('email'))->queue(new SendMail($mailData));
        // dispatch(new MailJob($mailData));
        return redirect('index')->with('success', 'Email envoyé avec succès');
    }
}
