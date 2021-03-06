@extends('layouts.app')


@section('content')

<div class="container">



    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">Units</div>

                <div class="card-body">



                  <form action="{{ route('units') }}" method="POST" class="row">
                      @csrf

                          <div class="form-group col-md-6">
                              <label for="unit_name">Unit Name</label>
                              <input type="text" class="form-control" id="unit_name" placeholder="Unit Name" name="unit_name" required>
                            </div>

                            <div class="form-group col-md-6">
                              <label for="unit_code">Unit Code</label>
                              <input type="text" class="form-control" id="unit_code" placeholder="Unit Code" name="unit_code" required>
                            </div>

                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary">Seve New Unit</button>
                            </div>



                  </form>




                   <div class="row">
                    @foreach($units as $unit)

                        <div class="col-md-3">
                           <div class="alert alert-primary" role="alert">
                            <span class="buttons-span">

                                <span><a class="edit-unit"
                                     data-unitname="{{ $unit->unit_name }}"
                                     data-unitcode="{{ $unit->unit_code }}"
                                     data-unitid="{{ $unit->id }}" ><i class="fas fa-edit"></i></a></span>

                                     <span><a class="delete-unit"
                                    data-unitname="{{ $unit->unit_name }}"
                                    data-unitcode="{{ $unit->unit_code }}"
                                     data-unitid="{{ $unit->id }}"> <i class="fas fa-trash-alt"></i></a>
                                </span>

                            </span>



                            <p> {{ $unit->unit_name }} , {{ $unit->unit_code }}</p>

                           </div>
                        </div>

                    @endforeach
                   </div>


                   {{--الطريقة الاولى {{ (is_a(! $units,'LengthAwarePaginater') ? $units->links() : '') }} --}}

                   {{-- الطريقة الثانية --}}
                   {{ (!is_null($showLinks) && $showLinks) ? $units->links() : '' }}


                   <form action="{{ route('search-units') }}" method="GET">
                       @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="unit_search">Search</label>
                                <input type="text" class="form-control" id="unit_search" placeholder="Unit Search" name="unit_search" required>
                            </div>

                            <div class="form-group col-md-6">
                                <button type="submit" class="btn btn-primary">Search </button>
                            </div>

                        </div>
                   </form>

                </div>
            </div>
        </div>
    </div>
</div>








<div class="modal edit-window" tabindex="-1" role="dialog" id="edit-window">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Unit</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>


    <form action="{{ route('units') }}" method="POST" >
            @csrf
            <div class="modal-body">

                <div class="form-group col-md-6">
                    <label for="edit_unit_name">Unit Name</label>
                    <input type="text" class="form-control"
                    id="edit_unit_name" placeholder="Unit Name" name="unit_name" required>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="edit_unit_code">Unit Code</label>
                    <input type="text" class="form-control" id="edit_unit_code" placeholder="Unit Code" name="unit_code" required>
                  </div>

                  <input type="hidden" name="unit_id" id="edit_unit_id"/>
                  <input type="hidden" name="_method" value="PUT"/>


              </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Update</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>

    </form>
      </div>
    </div>
  </div>




  <div class="modal delete-window" tabindex="-1" role="dialog" id="delete-window">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete Unit</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>


        <form action="{{ route('units') }}" method="POST" style="position: relative;">
            <div class="modal-body">
                <p id="delete-message"></p>
                   @csrf
                   <input type="hidden" name="_method" value="delete"/>
                   <input type="hidden" name="unit_id" value="" id="unit_id"/>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
      </form>
      </div>
    </div>
  </div>





@if(Session::has('message'))
    <div class="toast" style="position: absolute;z-index:99999; top: 5%; right: 5%;">
      <div class="toast-header">
        <strong class="mr-auto">Units</strong>

        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="toast-body">


            {{ Session::get('message') }}


      </div>
    </div>
@endif

@endsection

@section('scripts')
<script>

    jQuery(document).ready(function(){
        var $deleteUnit=$('.delete-unit');
        var $deleteWindow=$('#delete-window');
        var $unitId=$('#unit_id');

        var $deleteMessage=$('#delete-message');

        $deleteUnit.on('click',function(element){
            element.preventDefault();
            var unit_id=$(this).data('unitid');
            var $unitName=$(this).data('unitname');
            var $unitCode=$(this).data('unitcode');
            $unitId.val(unit_id);
            $deleteMessage.text('Are you sure you want to delete ' + $unitName + ' with code '+$unitCode+' ? ');
            $deleteWindow.modal('show');

        });


        var $editUnit=$('.edit-unit');
        var $editWindow=$('#edit-window');
        var $edit_unit_name=$('#edit_unit_name');
        var $edit_unit_code=$('#edit_unit_code');
        var $edit_unit_id=$('#edit_unit_id');

        $editUnit.on('click',function(element){
            element.preventDefault();
            var $unit_id=$(this).data('unitid');
            var $unitName=$(this).data('unitname');
            var $unitCode=$(this).data('unitcode');

            $edit_unit_code.val($unitCode);
            $edit_unit_name.val($unitName);
            $edit_unit_id.val($unit_id);

            $editWindow.modal('show');
        });


    });

</script>



    @if(Session::has('message'))


        <script>

            jQuery(document).ready(function($){
                var $toast=$('.toast').toast({
                    autohide:false
                });
                $toast.toast('show');
            });
        </script>


    @endif
@endsection
