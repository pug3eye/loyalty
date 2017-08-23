@for ($i=0; $i < count($products); $i++)
  <a href="{{ url('sale/product/all/'.$products[$i]->id) }}">
    <div class="panel panel-default">
      <div class="panel-body">
        {{$products[$i]->barcode}} {{$products[$i]->name}}
      </div>
    </div>
  </a>
@endfor
