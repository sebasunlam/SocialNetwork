<hr>
{{ csrf_field() }}
<div class="row">
    <div class="form-group">
        <label for="nombre" class="col-md-4 control-label">Nombre</label>
        <div class="col-md-6">
            <input type="text" id="nombre" name="nombre" class="col-md-6 form-control">
            @if ($errors->has('nombre'))
                <span class="help-block">
                    <strong>{{ $errors->first('nombre') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="apellido" class="col-md-4 control-label">Apellido</label>
        <div class="col-md-6">
            <input type="text" id="apellido" name="apellido" class="form-control">
            @if ($errors->has('apellido'))
                <span class="help-block">
                    <strong>{{ $errors->first('apellido') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label for="fechanacimiento" class="col-md-4 control-label">Fecha de Nacimiento</label>
        <div class="col-md-6">
            <input type="text" id="fechanacimiento" name="fechanacimiento" class="form-control">
            @if ($errors->has('fechanacimiento'))
                <span class="help-block">
                    <strong>{{ $errors->first('fechanacimiento') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="telefono" class="col-md-4 control-label">Telefono</label>
        <div class="col-md-6">
            <input type="tel" id="telefono" name="telefono" class="form-control">
            @if ($errors->has('telefono'))
                <span class="help-block">
                    <strong>{{ $errors->first('telefono') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <button class="btn btn-primary" type="submit">Guardar</button>
</div>
