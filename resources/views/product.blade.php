@extends('layouts.app')
<head>
    <title>Insérer produits</title>
</head>
@section('content')
    <div class="container mt-5">
        @if(session('add'))
            <div class="alert alert-success text-center" role="alert">
                {{session('add')}}
            </div>
        @endif
        <div class="row justify-content-around">
            <div class="col-md-11 mb-3">
                <a href="{{url('/index')}}">
                    <i class="fa-solid fa-arrow-left fs-2 text-dark"></i>
                </a>
            </div>
            <div class="col-md-5 bg-white p-4 rounded border shadow">
                <form action="{{route('add_category')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="category" class="form-label">Marque de produit</label>
                        <input 
                            type="text" 
                            class="form-control @error('categories') is-invalid @enderror" 
                            id="category" 
                            placeholder="Marque" 
                            name="categories"
                            value="{{old('categories')}}"
                        >
                        @error('categories')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </form>
                <hr>
                <form action="{{route('add_tags')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="tags" class="form-label">Tags</label>
                        <input 
                            type="text" 
                            class="form-control @error('tag') is-invalid @enderror" 
                            id="tag" 
                            placeholder="Tags" 
                            name="tag"
                            value="{{old('tag')}}"
                        >
                        @error('tag')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </form>
            </div>
            <div class="col-md-5 bg-white border shadow p-4 rounded">
                <form action="{{route('add_products')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="category" class="form-label">Marque du produit</label>
                        <select 
                            class="form-select @error('catgeory_id') is-invalid @enderror" 
                            aria-label="Default select example" 
                            name="catgeory_id"
                        >
                            <option value="">--Veuillez choisir votre marque--</option>
                            @foreach ($categories as $category)
                                <option value={{ $category->id }}>{{ $category->categories }}</option>
                            @endforeach
                        </select>
                        @error('catgeory_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom du produit</label>
                        <input 
                            type="text" 
                            class="form-control @error('name') is-invalid @enderror" 
                            id="name" 
                            placeholder="Nom du produit" 
                            name="name"
                            value="{{old('name')}}"
                        >
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Prix</label>
                        <input 
                            type="number" 
                            name="price" 
                            id="price"
                            min="0"
                            placeholder="Prix de produit"
                            class="form-control @error('price') is-invalid @enderror"
                            value="{{old('price')}}"
                        >
                        @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Date d'insertion</label>
                        <input 
                            type="date" 
                            name="insert_date" 
                            id="insert_date"
                            class="form-control @error('insert_date') is-invalid @enderror"
                            value="{{old('insert_date')}}"
                        >
                        @error('insert_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Déscription</label>
                        <textarea id="description" name="description" rows="10" cols="50" class="form-control @error('description') is-invalid @enderror">{{old('description')}}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label><br>
                        <input 
                            type="file"
                            class="file-control @error('image') is-invalid @enderror"
                            name="image" 
                            id="image"
                        >
                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <p>Tags</p>
                        @foreach ($tags as $tag)
                            <label 
                                for="tags" 
                                class="form-check-label"
                            >
                            {{ count($tags) > 0 ? $tag->tag : 'Pas de tag pour le moment' }}
                            </label>
                            <input 
                                type="checkbox" 
                                name="tags[]"
                                id="tags"
                                class="form-check-input @error('tags') is-invalid @enderror"
                                value="{{$tag->id}}"
                                {{ count($tags) < 0 ? 'disabled' : '' }}
                            >
                            @error('tags')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        @endforeach
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection