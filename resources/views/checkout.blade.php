@extends('layouts.app')
@section('content')
<div class="card p-2  m-2 table-responsive ">
  <table class="table table-striped table-sm table-hover btn-table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Preview</th>
        <th>Quantity</th>
        <th>Price</th>
        <th></th>
      </tr>
    </thead>
    <tbody class="p-1">
      @php ($total = 0)
      @foreach($items as $item)
        @foreach($basket as $id)
         @if ($id->product_id == $item->id)
         @php($total += $item->price)
          <tr>
          <td>{{$item->name}}</td>
          <td>{{$item->img}}</td>
          <td>1</td>
          <td>${{$item->price}}</td>
          <td>
            <form action="/removeItem/{{$item->id}}" method="POST">
              @csrf
              <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
            </form>
          </td>
        </tr>
         @endif
        @endforeach
      @endforeach
      <tr>
      	<td></td>
      	<td></td>
      	<td class="font-weight-bold">Total: {{count($basket)}}</td>
      	<td class="font-weight-bold">Total: ${{$total}}</td>
  	   </tr>
    </tbody>
  </table>
</div>
@endsection