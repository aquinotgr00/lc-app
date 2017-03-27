<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_details" data-toggle="tab" aria-expanded="true">Expedisi</a></li>
        <li class=""><a href="#tab_options" data-toggle="tab" aria-expanded="false">{!! trans('general.tabs.details') !!}</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_details">
            <div class="form-group">
                {!! Form::label('name', trans('admin/expeditions/general.columns.name')) !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('contact', trans('admin/expeditions/general.columns.contact')) !!}
                {!! Form::textarea('contact', null, ['class' => 'form-control', 'rows' => 3]) !!}
            </div>

            <div class="form-group">
                {!! Form::label('description', trans('admin/expeditions/general.columns.description')) !!}
                {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) !!}
            </div>
        </div>
        <div class="tab-pane" id="tab_options">
            <div class="form-group">
                {!! Form::label('area', 'Area') !!}
                <table class="table">
                    <tr>
                        <td>
                            <input placeholder="name" type="text" v-model="newDetail.name" id="kokab_name" class="form-control">
                        </td>
                        <td>
                            <input placeholder="price" type="number" v-model="newDetail.price" class="form-control">
                        </td>
                        <td>
                            <button class="btn btn-default" @click.prevent="addDetail">
                                <i class="fa fa-plus-square"></i>
                            </button>
                        </td>
                    </tr>
                    @if(isset($expedition))
                        @if($expedition->expeditionDetails)
                            <?php $x = 99; ?>
                            @foreach($expedition->expeditionDetails as $key => $value)
                                <tr id="tr{{$x}}">
                                    {!! Form::hidden('detail['. $x .'][master_kokab_id]', $value->master_kokab_id) !!}
                                    <td>{!! Form::text('kokab_name', $value->kokab->nama, ['disabled']) !!}</td>
                                    <td>{!! Form::text('detail['. $x .'][price]', $value->price) !!}</td>
                                    <td>
                                        <a href="#" class="removee" data-id="{{ $x }}"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                            <?php $x++; ?>
                            @endforeach
                        @endif
                    @endif
                    <tr v-for="detail in details">
                        <input type="hidden" name="detail[@{{ $index }}][master_kokab_id]" value="@{{ detail.id }}">
                        <td><input type="text" value="@{{ detail.name }}" disabled></td>
                        <td><input name="detail[@{{ $index }}][price]" type="text" value="@{{ detail.price }}"></td>
                        <td>
                            <a href="#" v-on:click.prevent="removeDetail(detail)"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>