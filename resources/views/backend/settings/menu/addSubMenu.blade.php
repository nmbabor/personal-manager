
<div class="modal fade" id="addSubMenu-{{ $data->id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        {!! Form::open(['method' => 'post', 'route' => 'sub-menus.store']) !!}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="exampleModalLabel">
                    <i class="fas fa-pencil-alt"></i>
                    Add Sub Menu
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
                    <label class="col-md-12">Sub Menu URL <span class="text-danger">*</span> : </label>
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
                <input type="hidden" min="1" value="{{count($data->subMenus)+1}}" name="serial_num">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary"
                    data-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn bg-gradient-primary">
                    Submit
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>