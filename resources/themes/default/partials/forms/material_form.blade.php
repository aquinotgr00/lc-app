<div class="form-group">
    {!! Form::label('category', 'Kategori') !!}
    {!! Form::select('category', ['1' => 'Bahan', '2' => 'Bibit'], null, ['class' => 'form-control', 'placeholder' => 'Pilih Kategori']) !!}
</div>

<div class="form-group">
    {!! Form::label('name', trans('admin/materials/general.columns.name')) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('stock', trans('admin/materials/general.columns.stock')) !!}
    {!! Form::text('stock', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('price', trans('admin/materials/general.columns.price')) !!}
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('min_stock', trans('admin/materials/general.columns.min_stock')) !!}
    {!! Form::text('min_stock', null, ['class' => 'form-control']) !!}
</div>

@if( isset($material) && $material->category == 2 )
<div class="form-group">
    {!! Form::label('prime_plus', 'Prime Plus') !!}
    {!! Form::text('seedMaterial[prime_plus]', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('prime_standart', 'Prime Standart') !!}
    {!! Form::text('seedMaterial[prime_standart]', null, ['class' => 'form-control']) !!}
</div><div class="form-group">
    {!! Form::label('superior_a', 'Superior A') !!}
    {!! Form::text('seedMaterial[superior_a]', null, ['class' => 'form-control']) !!}
</div><div class="form-group">
    {!! Form::label('superior_b', 'Superior B') !!}
    {!! Form::text('seedMaterial[superior_b]', null, ['class' => 'form-control']) !!}
</div>
@endif