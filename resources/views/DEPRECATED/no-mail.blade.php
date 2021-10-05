<div class="container">
    <div class="row">
        <div class="col-lg-9 col-sm-12 col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Producto</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio Unitario</th>
                        <th scope="col">Subtotales</th>
                    </tr>
                </thead>
            @foreach ($carro as $c)
                <tbody>
                    <tr>
                        <th scope="row">{{ $c->producto->nombre }}</th>
                        <td>{{ $c->qty }}</td>
                        <td>{{ $c->producto->precio }}</td>
                        <td>
                        @php
                            $precioTotalPorProducto = $c->producto->precio * $c->qty;
                            echo $precioTotalPorProducto;    
                        @endphp
                        </td>
                    </tr>
                </tbody>
            @endforeach
            </table>
        </div>
        <div class="col-lg-3 col-sm-12 col-md-12">
            <div class="container pt-2">
                <p>Precio Total: $
                @php
                    $precioTotal = 0;
                    foreach ($carro as $c)
                        $precioTotal = ($c->producto->precio * $c->qty) + $precioTotal;    
                    echo $precioTotal
                @endphp
                </p>
            </div>
        </div>
    </div>
</div>
 