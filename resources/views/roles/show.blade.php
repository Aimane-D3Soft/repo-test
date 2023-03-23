@extends('layouts.app')
@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success text-center" role="alert">
            {{session('success')}}
        </div>
    @endif
    <form action="{{route('add_roles')}}" method="post">
        @csrf
        <div class="row">
            <h2 class="my-2 text-center">Création des permissions</h2>
            <div class="col-md-6 mb-3">
                <label for="group">Créer un groupe</label>
                <input type="text" name="group" id="group" class="form-control w-75">
            </div>
            <div class="col-md-6 mb-3">
                <label for="permission">Créer une permission</label>
                <input type="text" name="permission" id="permission" class="form-control w-75">
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>
    <table class="table table-dark table-striped">
        <tr class="text-center">
            <th>#</th>
            <th>Utilistateur</th>
            <th>Group</th>
            <th>Permissions</th>
            <th>Actions</th>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>
@endsection