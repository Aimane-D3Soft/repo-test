@extends('layouts.app')
@section('content')

    <div class="container">
        <form action="{{route('create_groupe')}}" method="post">
            @csrf
            <div class="row">
                <h1 class="my-4 text-center">Assingé les roles aux utilisateurs</h1>
                <div class="col-md-4 mb-3">
                    <h2>Liste des utilisateurs</h2>
                    <select name="users" id="users">
                        @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <h2>Liste des groupes</h2>
                    <div id="groups-checkbox"></div>
                </div>
                <div class="col-md-4 mb-3">
                    <h2>Liste des permissions</h2>
                    @foreach ($permissions as $permission)    
                        <label for="permissions">{{ $permission->name }}</label>
                        <input 
                            type="checkbox" 
                            name="permissions[]" 
                            id="permissions" 
                            class="permissions"
                            value="{{$permission->id}}"
                        />
                        <br>
                    @endforeach
                </div>
                <div class="col-md-6 mb-3">
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </div>
        </form>
        <hr>
        <form action="{{route('group_permissions')}}" method="post">
            @csrf
            <div class="row">
                <h1 class="my-4 text-center">Assingé les Permissions aux groupes</h1>
                <div class="col-md-6">
                    <h2>Liste des groupes</h2>
                    <select name="group" id="group">
                        @foreach ($groups as $group)
                            <option value="{{$group->id}}">{{$group->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <h2>Liste des permissions</h2>
                    <div id="permission-checkbox"></div>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </div>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#group').change(function(event){
                let group_id = $(this).val();
                $.get('/get-group/'+ group_id, function (data) {
                    console.log(data);
                    $('#permission-checkbox').html('');
                    $.each(data.permissions, function(key, value){
                        console.log(value)
                            if(data.group_permissions.includes(value.id)){
                            $('#permission-checkbox').append(
                                '<label class="me-2">'+value.name+'</label><input type="checkbox" value="'+value.id+'" checked name="permissions[]"/><br>'
                            );
                        }else{
                            $('#permission-checkbox').append(
                                '<label class="me-2">'+value.name+'</label><input type="checkbox" value="'+value.id+'" name="permissions[]"/><br>'
                            );
                        }
                    })
                })
            })
            $('#group').trigger('change')
            $('#users').change(function(event){
                // $.ajaxSetup({
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     }
                // });
                let user_id = $(this).val();
                $.get('/create/'+ user_id, function (data) {
                    // console.log(data.user_groups);
                    $('#groups-checkbox').html('');
                    $.each(data.groups, function(x,y){
                        if(data.user_groups.includes(y.id)){
                            $('#groups-checkbox').append(
                                '<label class="me-2">'+y.name+'</label><input type="checkbox" value="'+y.id+'" checked name="groups[]"/><br>'
                            );
                        }else{
                            $('#groups-checkbox').append(
                                '<label class="me-2">'+y.name+'</label><input type="checkbox" value="'+y.id+'" name="groups[]"/><br>'
                            );
                        }
                    })
                })
            })
            $('#users').trigger('change')
            // $('#users').change(function(event){
            //     $.ajaxSetup({
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         }
            //     });
            //     let user_id = $(this).val();
            //     console.log(user_id);
            //     $('.permissions').each(function() {
            //         let product_id = $(this).val();
            //         $.ajax({
            //             url: '/check-permission',
            //             type: 'GET',
            //             data: { user_id: user_id, product_id: product_id },
            //             success: function(data) {
            //                 if (data.exists) {
            //                     $(this).prop('checked', true);
            //                 } else {
            //                     $(this).prop('checked', false);
            //                 }
            //             }
            //         });
            //     });
            // })
        });
    </script>
@endsection