@foreach($data->subMenus as $subMenu)
<tr class="sub-menu-row">
    <td style="border: none;"></td>
    <td>{{$subMenu->name}}</td>
    <td>{{$subMenu->url}}</td>
    <td>
        @if($subMenu->status==1)
        <i class="fa fa-check text-success" title="Active"></i>
        @else
        <i class="fa fa-times text-danger" title="Inactive"></i>
        @endif
    </td>
    <td>
        <div class="text-left">
            <!-- Button trigger modal -->
            <button title="Edit Sub Menu" type="button" class="btn btn-primary btn-xs"
                data-toggle="modal" data-target="#editSubMenu-{{ $subMenu->id }}">
                <i class="fas fa-pencil-alt"></i>
            </button>
            <a class="btn btn-danger btn-xs" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete Sub Menu"
                                href="javascript:void(0)"
                                onclick='resourceDelete("{{ route('sub-menus.destroy', $subMenu->id) }}")'>
                                <span class="delete-icon">
                <i class="fas fa-trash-alt"></i>
            </a>
        </div>
        <div class="modal fade" id="editSubMenu-{{ $subMenu->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                {!! Form::open(['method' => 'put', 'route' => ['sub-menus.update', $subMenu->id]]) !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5" id="exampleModalLabel">
                            <i class="fas fa-pencil-alt"></i>
                            Edit Sub Menu
                        </h5>
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Menu Name: <b>{{$data->name}}</b></label>
                            <input name="menu_id" value="{{$data->id}}" type="hidden">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Name:</label>
                            {!! Form::text('name', $subMenu->name, ['class' => 'form-control', 'placeholder' => 'Name','required']) !!}
                        </div>
                        <div class="form-group">
                            <label class="control-label">Menu URL:</label>
                            {!! Form::text('url', $subMenu->url, ['class' => 'form-control', 'placeholder' => 'Url', 'required']) !!}
                        </div>
                        <div class="form-group">
                            <label class="control-label">Status:</label>
                            {!! Form::select('status',[1=>'Active', 0 =>'Inactive'], $subMenu->status, ['class' => 'form-control','required']) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary"
                            data-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn bg-gradient-primary">
                            Save changes
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </td>
</tr>
@endforeach