<head>
    <link rel="stylesheet" href="{{public_path('/css/pdf.css')}}">
</head>
<table>
    <tr style="text-align:center">
        <th>#</th>
        <th>Name</th>
        <th>Catégorie</th>
        <th>Prix</th>
        <th>Tags</th>
        <th>Image</th>
    </tr>
    @php
        $i = 1
    @endphp
    @foreach ($products as $product)
        <tr style="text-align:center">
            <td>{{ $i++ }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->categories }}</td>
            <td>{{ $product->price }}</td>
            <td> 
                {{empty($product->tags->pluck('tag')->toArray()) ? 'Pas de tag' : join(',', $product->tags->pluck('tag')->toArray())}}
            </td>
            <td> <img src="{{public_path('storage/'.$product->image)}}" style="width: 80px"> </td>
        </tr>
    @endforeach
</table>