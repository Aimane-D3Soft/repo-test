@extends('layouts.app')
<head>
    <title>Show products</title>
</head>
@section('content')
    <div class="container">
        <div class="d-flex align-items-center mt-5 justify-content-center">
            <h1 class="text-center">List des produits</h1>
            @if (Auth::user()->hasGroup('Modérateur'))
                <a href="{{url('/product')}}" class="ms-5"><i class="fa-solid fa-plus fs-2 text-success"></i></a>
            @endif
            {{-- @if (Auth::user()->hasPermission('créer-produit'))
                <a href="{{url('/product')}}" class="ms-5"><i class="fa-solid fa-plus fs-2 text-success"></i></a>
            @endif --}}
        </div>
        @if (session('update'))
            <div class="alert alert-success text-center" role="alert">
                {{session('update')}}
            </div>
        @endif
        @if (session('delete'))
            <div class="alert alert-success text-center" role="alert">
                {{session('delete')}}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success text-center" role="alert">
                {{session('success')}}
            </div>
        @endif
        @if(session('failed'))
            <div class="alert alert-danger text-center" role="alert">
                {{session('dailed')}}
            </div>
        @endif
        <div class="row justify-content-center my-4">
            <h3 class="my2- text-center">Télecharger les tables</h3>
            <div class="d-flex justify-content-center">
                <div>
                    <form action="{{route('download_products')}}" method="get" id="btn-submit">
                        @csrf
                        <p class="text-center pointer" onclick="downloadFile()">
                            <i class="fa-solid fa-file-excel pointer fs-2 text-success"></i><br>
                            Table de produits
                        </p>
                    </form>
                </div>
                <div class="ms-3">
                    <form action="{{route('download_product-tag')}}" method="get" id="btn-submit-tag-product">
                        @csrf
                        <p class="text-center pointer" onclick="downloadFileProductTag()">
                            <i class="fa-solid fa-file-excel pointer fs-2 text-success"></i><br>
                            Table de produit_tag
                        </p>
                    </form>
                </div>
                <div class="ms-3">
                    <form action="{{route('download_product-category')}}" method="get" id="btn-submit-category">
                        @csrf
                        <p class="text-center pointer" onclick="uploadFileCategory()">
                            <i class="fa-solid fa-file-excel pointer fs-2 text-success"></i><br>
                            Table de catégorie
                        </p>
                    </form>
                </div>
            </div>
            <h3 class="my2- text-center">Charger les tables</h3>
            <div class="d-flex justify-content-center">
                <div class="ms-3 text-center">
                    <form action="{{route('upload_product')}}" method="post" id="btn-submit-product" enctype="multipart/form-data">
                        @csrf
                        <label for="label-control">Table de produit</label>
                        <input 
                            type="file"
                            class="file-control"
                            name="table" 
                            id="table"
                        >
                        <button type="submit" class="btn btn-primary mt-2">Valider</button>
                    </form>
                </div>
                <div class="ms-3 text-center">
                    <form action="{{route('upload_product-tag')}}" method="post" id="btn-submit-product" enctype="multipart/form-data">
                        @csrf
                        <label for="label-control">Table de tag_produit</label>
                        <input 
                            type="file"
                            class="file-control"
                            name="table_tag" 
                            id="table_tag"
                        >
                        <button type="submit" class="btn btn-primary mt-2">Valider</button>
                    </form>
                </div>
                <div class="ms-3 text-center">
                    <form action="{{route('upload_categories')}}" method="post" id="btn-submit-categories" enctype="multipart/form-data">
                        @csrf
                        <label for="label-control">Table de catégories</label>
                        <input 
                            type="file"
                            class="file-control"
                            name="table_category" 
                            id="table_category"
                        >
                        <button type="submit" class="btn btn-primary mt-2">Valider</button>
                    </form>
                </div>
            </div>
            <h3 class="my2- text-center">Imprimer les tables</h3>
            <div class="d-flex justify-content-center">
                <div class="ms-3">
                    <a href="{{ url('/print_product') }}" target="_blank">
                        <i class="fa-solid fa-file-pdf pointer fs-2 text-danger"></i>
                        Table de produit
                    </a>
                    </form>
                </div>
            </div>
            {{-- <details> 
                <summary>Définition du HTML</summary> 
                <p>Le HTML (HyperText Markup Language) est un langage de balisage utilisé pour décrire la structure et le contenu des pages web. Il utilise des balises pour définir les différents éléments de la page, tels que le texte, les images, les liens, etc., permettant ainsi aux navigateurs web de les afficher correctement.</p> 
            </details>   --}}
            {{-- <div>
                <input type="text" name="" list="country" class="form-control">
            </div>
            <datalist id="country">
                <option value="Maroc">
                <option value="Espagne">
                <option value="France">
            </datalist> --}}
            <div class="col-md-10">
                <table class="table table-dark table-striped">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Produit</th>
                        <th>Catégorie</th>
                        <th>Prix</th>
                        <th>Tags</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    @php
                        $i = 1
                    @endphp
                    @foreach ($products as $product)
                        <tr class="text-center">
                            <td> {{ $i++ }} </td>
                            <td> {{ $product->name }} </td>
                            <td> {{ $product->category->categories }} </td>
                            <td> {{ $product->price }} </td>
                            <td> 
                                {{empty($product->tags->pluck('tag')->toArray()) ? 'Pas de tag' : join(',', $product->tags->pluck('tag')->toArray())}}
                            </td>
                            <td> <img src="{{asset('storage/'.$product->image)}}" style="width: 80px"> </td>
                            <td>
                                <div class="row justify-content-center">
                                    <div class="col-md-4">
                                        <a href="{{url('/edit/'.$product->id)}}">
                                            <i class="fa-solid fa-pen-to-square fs-4 text-success"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-7">
                                        <form action="{{route('delete_product', $product->id)}}" method="post">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="bg-transparent border-0" onclick="return confirm('Voulez vous supprimer ce produit')"><i class="fa-solid fa-trash fs-4 text-danger"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>    
                    @endforeach  
                </table>
            </div>
        </div>
    </div>
@endsection