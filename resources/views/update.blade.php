@extends('layouts.app')
<head>
    <title>{{ $product->name }}</title>
</head>
@section('content')
    <div class="container">
        <h2 class="text-center mt-4">Modifier le produit <u>{{ $product->name }}</u></h2>
        <form action="{{route('update_product', $product->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row justify-content-center mt-5">
                <div class="col-md-10 mb-3">
                    <a href="{{url('/index')}}">
                        <i class="fa-solid fa-arrow-left fs-3 text-dark"></i>
                    </a>
                </div>
                <div class="col-md-10 bg-white p-5 rounded border shadow">
                    <div class="text-center">
                        <img src="{{asset('storage/'.$product->image)}}" alt="prodcut_image" class="img-fluid rounded-circle">
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Categories</label>
                        <select 
                            class="form-select" 
                            aria-label="Default select example" 
                            name="category"
                        >
                            @foreach ($categories as $category)
                                <option value={{ $category->id }} 
                                    {{$product->category->id == $category->id ? 'selected' : ''}} >{{ $category->categories }}
                                </option>   
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom du produit</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="name" 
                            placeholder="Nom du produit" 
                            name="name"
                            value="{{ $product->name }}"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Prix</label>
                        <input 
                            type="number" 
                            name="price" 
                            id="price"
                            class="form-control"
                            value="{{$product->price}}"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Déscription</label>
                        <textarea id="description" name="description" rows="10" cols="50" class="form-control">{{$product->description}}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="label-form">Image</label><br>
                        <input 
                            type="file"
                            class="file-control"
                            name="image" 
                            id="image"
                        >
                    </div>
                    <div class="mb-3">
                        <p>Tags</p>
                        @foreach ($tags as $tag)
                            <label 
                                for="tags" 
                                class="form-check-label"
                            >
                            {{$tag->tag}}
                            <input 
                                type="checkbox" 
                                name="tags[]"
                                id="tags"
                                class="form-check-input"
                                value="{{$tag->id}}"
                                {{in_array($tag->id, $product->tags->pluck('id')->toArray()) ? 'checked' : ''}}
                            >
                            <br>
                        @endforeach
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection