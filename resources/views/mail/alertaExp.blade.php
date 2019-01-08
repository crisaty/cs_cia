@component('mail::layout')
{{-- Header --}}
@slot('header')
    @component('mail::header', ['url' => config('app.url')])
        CS & CIA / Alerta de Expiracion
    @endcomponent
@endslot
{{-- Body --}}

 # Hola, {{ $cliente->nom_cliente }} !
 
@component('mail::panel') 
![alt text](https://i.imgur.com/HsPs1EW.png "CS & CIA")
@endcomponent

Tienes el siguiente producto / servicio que esta por expirar:
 
@component('mail::table')
| Producto                      | Fecha Expiracion           | Valor    |
| :---------------------------- |:--------------------------:| --------:|
| {{ $producto->nom_producto }} | {{ $producto->fecha_exp }} | ${{ $producto->precio_venta }}         |
@endcomponent
  
@component('mail::button', ['url' => 'www.sistema.sebastianalarcon.cl'])
IR AL SISTEMA
@endcomponent
 
Saludos.

{{-- Footer --}}
@slot('footer')
    @component('mail::footer')
        © {{ date('Y') }} CS & CIA
    @endcomponent
@endslot
@endcomponent