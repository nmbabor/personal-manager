@extends('backend.master')

@section('title', 'Menu')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-5 border-right">
                    <fieldset>
                        <form action="{{ route('menus.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label class="mr-3">  <input class="menu-type" type="radio" name="type" value="1" checked> Custom URL </label>
                                    <label class="mr-3">  <input class="menu-type" type="radio" name="type" value="2"> Page URL </label>
                                    <label class="mr-3">  <input class="menu-type" type="radio" name="type" value="3"> Blog Category </label>
                                </div>
                            </div>
                            <div class="form-group custom-url">
                                <label class="col-md-12"> Menu Name <span class="text-danger">*</span> : </label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" placeholder="Name" name="name">
                                    @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group custom-url">
                                <label class="col-md-12"> Menu URL <span class="text-danger">*</span> : </label>
                                <div class="input-group">
                                    <button class="btn btn-light" type="button">
                                        {{url('/')}}/
                                    </button>

                                    <input type="text" class="form-control" name="url">

                                </div>
                            </div>
                            <div class="form-group page-url" style="display:none">
                                <label class="col-md-12"> Page <span class="text-danger">*</span> : </label>

                                <div class="col-md-12">
                                    {!! Form::select('page_id',$pages,'',['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group blog-category" style="display:none">
                                <label class="col-md-12"> Blog Category <span class="text-danger">*</span> : </label>

                                <div class="col-md-12">
                                    {!! Form::select('category_id',$blogCategory,'',['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <input type="hidden" min="1" value="{{count($allData)+1}}" name="serial_num">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn bg-gradient-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                            
                        </form>
                    </fieldset>
                    <hr>
                </div>

                <div class="col-md-7 table-responsive">
                    <table class="table table-hover">
                        <tbody class="row_position">
                            @foreach ($allData as $data)
                            <tr class="bg-light" id="{{$data->id}}">
                                <td width="100%" class="p-1">
                                    <div class="row pt-3 pb-3 border cursor-move">
                                        <div class="col-sm-4">
                                            @if($data->status==1)
                                            <span class="badge badge-success" title="Active"> <i class="fa fa-check"></i> </span>
                                            @else
                                            <span class="badge badge-danger" title="Inactive"> <i class="fa fa-times"></i> </span>
                                            @endif
                                            {{ $data->name }}
                                        </div>
                                        <div class="col-sm-4">
                                            <a href="{{ url($data->url) }}" target="_blank"> <i class="fa fa-link"></i> {{ $data->url }} </a>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="text-center">
                                                <button class="btn btn-xs btn-secondary" title="Add New Sub Menu"  data-toggle="modal" data-target="#addSubMenu-{{ $data->id }}"><i class="fa fa-plus-circle"></i></button>
                                                <!-- Button trigger modal -->
                                                <button title="Edit Menu" type="button" class="btn btn-info btn-xs"
                                                    data-toggle="modal" data-target="#editMenu-{{ $data->id }}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                                <a class="btn btn-danger btn-xs" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete Menu"
                                                                    href="javascript:void(0)"
                                                                    onclick='resourceDelete("{{ route('menus.destroy', $data->id) }}")'>
                                                                    <span class="delete-icon">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                            @include('backend.settings.menu.addSubMenu')
    
                                            <!-- Modal -->
                                            <div class="modal fade" id="editMenu-{{ $data->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    {!! Form::open(['method' => 'put', 'route' => ['menus.update', $data->id]]) !!}
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title fs-5" id="exampleModalLabel">
                                                                <i class="fas fa-pencil-alt"></i>
                                                                Edit Menu
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label class="control-label">Name:</label>
                                                                {!! Form::text('name', $data->name, ['class' => 'form-control', 'placeholder' => 'Name','required']) !!}
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Menu URL:</label>
                                                                {!! Form::text('url', $data->url, ['class' => 'form-control', 'placeholder' => 'Url', 'required']) !!}
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">Status:</label>
                                                                {!! Form::select('status',[1=>'Active', 0 =>'Inactive'], $data->status, ['class' => 'form-control','required']) !!}
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
                                        </div>
                                    </div>
                                    @if(count($data->subMenus)>0)
                                    <div class="col-md-12 mt-1">
                                        <ul class="list-group">
                                            @foreach($data->subMenus->sortBy('serial_num') as $subMenu)
                                            <li class="list-group-item p-2">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        @if($subMenu->status==1)
                                                        <i class="fa fa-check text-success" title="Active"></i>
                                                        @else
                                                        <i class="fa fa-times text-danger" title="Inactive"></i>
                                                        @endif
                                                        {{$subMenu->name}}
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <a href="{{ url($subMenu->url) }}" target="_blank"> <i class="fa fa-link"></i> {{ $subMenu->url }} </a>
                                                    </div>
                                                    <div class="col-sm-4">
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
                                                                            <label class="control-label">Sub Menu Name:</label>
                                                                            {!! Form::text('name', $subMenu->name, ['class' => 'form-control', 'placeholder' => 'Name','required']) !!}
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="control-label">Sub Menu URL:</label>
                                                                            {!! Form::text('url', $subMenu->url, ['class' => 'form-control', 'placeholder' => 'Url', 'required']) !!}
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="control-label">Serial No:</label>
                                                                            <input type="number" min="1" value="{{$subMenu->serial_num}}" name="serial_num" class="form-control" placeholder="Serial Number" required>
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
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                          </ul>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
 
@push('script')   
    <script>
        $( ".row_position" ).sortable({  
            delay: 150,  
            placeholder: "drop-zone",
            stop: function() {  
                var selectedData = new Array();  
                $('.row_position>tr.bg-light').each(function() {  
                    selectedData.push($(this).attr("id"));  
                });  
                //console.log(selectedData);
                updateOrder(selectedData);  
            }  
        });
        function updateOrder(data) {  
            $.ajax({  
                url:"{{route('menu-serial-update')}}",  
                type:'PUT',  
                data:{position:data},  
                success:function(){  
                    console.log('your change successfully saved');  
                },
                error: function(xhr, status, error) {
                    console.log(error)
                }
            })  
        } 
        $(document).ready(function(){
            $('.menu-type').on('change',function(){
                let type = $(this).val();
                $('.custom-url').hide();
                $('.page-url').hide();
                $('.blog-category').hide();
                if(type==1){
                    $('.custom-url').show();
                }else if(type==2){
                    $('.page-url').show();
                }else if(type==3){
                    $('.blog-category').show();
                }
            });
        })
    </script>
@endpush
