<?php
/** @var \MercadoPago\Preference $preference */
?>
@extends('layouts.main')

@section('title', 'Integración con MP')

{{--@section('js')--}}
@push('js')
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
// Inicializamos MP.
const mp = new MercadoPago('TEST-edce4b63-a9fe-4834-b4cb-93af46c4d0f5', {
    locale: 'es-AR'
});

mp.checkout({
    preference: {
        // MUY IMPORTANTE: No se olviden de poner las comillas alrededor del php.
        id: '{{ $preference->id }}'
    },
    render: {
        container: '#aca-el-boton',
        label: 'Comprar'
    }
});
</script>
@endpush
{{--@endsection--}}

@section('main')
    <h1>Integrando con MercadoPago</h1>

    <div id="aca-el-boton"></div>
@endsection

