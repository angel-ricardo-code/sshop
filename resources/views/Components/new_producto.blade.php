<div class="productCard">
    <div class="field">
        <label for="{{"nombre[".$i."]"}}">Nombre</label>
        <input type="text" name="{{"productos[" . $i . "][nombre]"}}" id="{{"nombre[".$i."]"}}">
    </div>
    <div class="field">
        <label for="{{"cantidad[".$i."]"}}">Cantidad</label>
        <div>
            <input type="number" name="{{"productos[" . $i . "][cantidad]"}}" id="{{"cantidad[".$i."]"}}">
            <span class="pesos">u</span>
        </div>
    </div>
    <div class="field">
        <label for="{{"p_c[".$i."]"}}">Precio Compra</label>
        <div>
            <input type="number" name="{{"productos[" . $i . "][precio_compra]"}}" id="{{"p_c[".$i."]"}}">
            <span class="pesos">cup</span>
        </div>

    </div>
    <div class="field">

        <label for="{{"p_v[".$i."]"}}">Precio Venta</label>
        <div>
            <input type="number" name="{{"productos[" . $i . "][precio_venta]"}}" id="{{"p_v[".$i."]"}}">
            <span class="pesos">cup</span>
        </div>


    </div>
    <div class="field">

        <label for="{{"categoria[".$i."]"}}">Categoría</label>

        <select name="{{"productos[" . $i . "][categoria]"}}" id="{{"categoria[".$i."]"}}">
            <option value="Comestible">Comestibles</option>
            <option value="Gastables">Gastables</option>
            <option value="Ropa">Ropa</option>
            <option value="Electrónicos">Electrónicos</option>
            <option value="Materiales">Materiales</option>
        </select>
    </div>


        @if($errors->any())
        <div class="errors">
            @foreach( $errors->all() as $error)
                <span class="error">{{$error}}</span>
            @endforeach
        </div>
        @endif

</div>
