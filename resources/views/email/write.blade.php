@extends('layouts.app')
<title>Email</title>
@section('content')
    <div class="container">
        <form action="{{route('email')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="sujet">Sujet de l'email</label>
                <input type="text" name="sujet" class="form-control">
            </div>
            <div class="mb-3">
                <label for="email">Envoyer à</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="mb-3">
                <label for="title">Titre de l'email</label>
                <input type="text" name="title" class="form-control">
            </div>
            <div class="mb-3">
                <label for="body" class="">Corps de l'email</label>
                <textarea name="body" id="body" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="fichier_pdf">Fichier pdf</label>
                <input type="file" name="fichier_pdf" id="fichier_pdf">
            </div>
            <div class="mb-3">
                <label for="image">image</label>
                <input type="file" name="image" id="image">
            </div>
            <button type="submit" class="btn btn-primary">Valider</button>
        </form>
    </div>
@endsection