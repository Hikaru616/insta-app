{{-- Edit --}}
<div class="modal fade" id="edit-category-{{ $category->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header border-warning">
                <h3 class="h5 modal-title text-warning">
                    <i class="fa-solid fa-pen"></i> Edit Category
                </h3>
            </div>
            <form action="{{ route('admin.categories.update',$category->id) }}" method="POST" >
                @csrf
                @method('PATCH')
                <div class="d-flex justify-content-center modal-body">
                    <div class="input-group mb-3 mt-4 w-75">
                        <input type="text" name="category" class="form-control" value="{{ $category->name }}" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-outline-warning" type="submit" id="button-addon2">Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Delete --}}
<div class="modal fade" id="delete-category-{{ $category->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h3 class="h5 modal-title text-danger">
                    <i class="fa-solid fa-trash"></i> Delete Category
                </h3>
            </div>
            <form action="{{ route('admin.categories.destroy',$category->id) }}" method="POST" >
                @csrf
                @method('DELETE')

                       <h4 class="text-center mt-4">Are you sure delete "{{ $category->name }}"?</h4>

                <div class="text-center mt-3 mb-3">
                    <button class="btn btn-outline-danger rounded form-control w-50" type="submit">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
