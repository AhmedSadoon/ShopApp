@extends('layouts.app')
@section( 'content')

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">Categories</div>

                <div class="card-body">

                    <form action="{{ route('categories') }}" method="POST" class="row">
                        @csrf

                            <div class="form-group col-md-6">
                                <label for="category_name">Category Name</label>
                                <input type="text" class="form-control" id="category_name" placeholder="Category Name" name="category_name" required>
                              </div>



                              <div class="form-group col-md-12">
                                  <button type="submit" class="btn btn-primary">Seve New Category</button>
                              </div>



                    </form>

                   <div class="row">
                    @foreach($categories as $category)

                        <div class="col-md-3">
                           <div class="alert alert-primary" role="alert">

                            <span class="buttons-span">

                                <span><a class="edit-unit"
                                     data-categoryname="{{ $category->name }}"
                                     data-categoryid="{{ $category->id }}" ><i class="fas fa-edit"></i></a></span>

                                     <span><a class="delete-unit"
                                    data-categoryname="{{ $category->tag }}"
                                     data-categoryid="{{ $category->id }}"> <i class="fas fa-trash-alt"></i></a>
                                </span>

                            </span>



                            <p> {{ $category->name }}</p>

                           </div>
                        </div>

                    @endforeach
                   </div>
                   {{ (!is_null($showLinks) && $showLinks) ? $categories->links() : '' }}


                   <form action="{{ route('search-categories') }}" method="GET">
                    @csrf
                     <div class="row">
                         <div class="form-group col-md-6">
                             <label for="tags_search">Search</label>
                             <input type="text" class="form-control" id="category_search" placeholder="Categories Search" name="category_search" required>
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


@if(Session::has('message'))
    <div class="toast" style="position: absolute;z-index:99999; top: 5%; right: 5%;">
      <div class="toast-header">
        <strong class="mr-auto">Category</strong>

        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="toast-body">


            {{ Session::get('message') }}


      </div>
    </div>
@endif


<div class="modal delete-window" tabindex="-1" role="dialog" id="delete-window">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete Category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>


        <form action="{{ route('categories') }}" method="POST" style="position: relative;">
            <div class="modal-body">
                <p id="delete-message"></p>
                   @csrf
                   <input type="hidden" name="_method" value="delete"/>
                   <input type="hidden" name="category_id" value="" id="category_id"/>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
      </form>
      </div>
    </div>
  </div>



  <div class="modal edit-window" tabindex="-1" role="dialog" id="edit-window">
    <div class="modal-dialog" role="document">
    <form action="{{ route('categories') }}" method="POST" >
            @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>



            <div class="modal-body">

                <div class="form-group col-md-6">
                    <label for="edit_category_name">Category Name</label>
                    <input type="text" class="form-control"
                    id="edit_category_name" placeholder="Category Name" name="category_name" required>
                  </div>



                  <input type="hidden" name="category_id" id="edit_category_id"/>
                  <input type="hidden" name="_method" value="PUT"/>


              </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Update</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>


      </div>
    </form>
    </div>
  </div>

@endsection



@section('scripts')
<script>

    jQuery(document).ready(function(){
        var $deleteUnit=$('.delete-unit');
        var $deleteWindow=$('#delete-window');
        var $categoryID=$('#category_id');

        var $deleteMessage=$('#delete-message');

        $deleteUnit.on('click',function(element){
            element.preventDefault();
            var category_id=$(this).data('categoryid');
            $categoryID.val(category_id);
            $deleteMessage.text('Are you sure you want to delete category ?');
            $deleteWindow.modal('show');

        });


        var $editTag=$('.edit-unit');
        var $editWindow=$('#edit-window');
        var $edit_category_name=$('#edit_category_name');
        var $edit_category_id=$('#edit_category_id');

        $editTag.on('click',function(element){
            element.preventDefault();
            var $category_id=$(this).data('categoryid');
            var $categoryName=$(this).data('categoryname');

            $edit_category_name.val($categoryName);
            $edit_category_id.val($category_id);
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
