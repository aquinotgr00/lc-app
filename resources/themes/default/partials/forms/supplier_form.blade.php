<!-- Custom Tabs -->
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_details" data-toggle="tab" aria-expanded="true">Supplier</a></li>
        <li class=""><a href="#tab_options" data-toggle="tab" aria-expanded="false">{!! trans('general.tabs.details') !!}</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_details">
            <div class="form-group">
                {!! Form::label('name', trans('admin/suppliers/general.columns.name')) !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('category', trans('admin/suppliers/general.columns.category')) !!}
                {!! Form::select('category', config('constant.supplier-categories'), null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('contact', trans('admin/suppliers/general.columns.contact')) !!}
                {!! Form::textarea('contact', null, ['rows'=>'3', 'class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('address', trans('admin/suppliers/general.columns.address')) !!}
                {!! Form::textarea('address', null, ['rows'=>'3', 'class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('description', trans('admin/suppliers/general.columns.description')) !!}
                {!! Form::textarea('description', null, ['rows'=>'3', 'class' => 'form-control']) !!}
            </div>
        </div>
        <div class="tab-pane" id="tab_options">
            <div class="form-group">
                {!! Form::label('materials', trans('admin/formulas/general.columns.materials')) !!}
                <table class="table">
                    <tr>
                        <td>
                            <input placeholder="name" type="text" v-model="newMaterial.name" id="material_name" class="form-control">
                        </td>
                        <td>
                            <input placeholder="price" type="number" v-model="newMaterial.price" class="form-control">
                        </td>
                        <td>
                            <button class="btn btn-default" @click.prevent="addMaterial">
                                <i class="fa fa-plus-square"></i>
                            </button>
                        </td>
                    </tr>
                    @if(isset($supplier))
                        @if($supplier->supplierDetails)
                            <?php $x = 99; ?>
                            @foreach($supplier->supplierDetails as $key => $value)
                                <tr id="tr{{$x}}">
                                    {!! Form::hidden('material['. $x .'][material_id]', $value->material_id) !!}
                                    <td>{!! Form::text('material_name', $value->material->name, ['disabled']) !!}</td>
                                    <td>{!! Form::text('material['. $x .'][price]', $value->price) !!}</td>
                                    <td>
                                        <a href="#" class="removee" data-id="{{ $x }}"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                            <?php $x++; ?>
                            @endforeach
                        @endif
                    @endif
                    <tr v-for="material in materials">
                        <input type="hidden" name="material[@{{ $index }}][material_id]" value="@{{ material.id }}">
                        <td><input type="text" value="@{{ material.name }}" disabled></td>
                        <td><input name="material[@{{ $index }}][price]" type="text" value="@{{ material.price }}"></td>
                        <td>
                            <a href="#" v-on:click.prevent="removeMaterial(material)"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
