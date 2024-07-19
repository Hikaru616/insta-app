{{-- Deactivate --}}
<div class="modal fade" id="deactivate-post-{{ $post->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-secondary">
            <div class="modal-header border-secondary">
                <h3 class="h5 modal-title text-secondary">
                    <i class="fa-solid fa-eye-slash"></i> Hide Post
                </h3>
            </div>

            <div class="modal-body">
                <img src="{{ $post->image }}" alt="{{ $post->description }}" class="image-lg me-2">
                Are you sure you want to hide?
            </div>
            <p class="ms-3">{{ $post->description }}</p>


            <div class="modal-footer border-0">
                <form action="{{ route('admin.posts.deactivate', $post->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>

                    <button type="submit" class="btn btn-secondary btn-sm">Hide</button>
                </form>
            </div>
        </div>
    </div>
</div>


{{--  POST  --}}

<div class="modal fade" id="activate-post-{{ $post->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-primary">
            <div class="modal-header border-primary">
                <h3 class="h5 modal-title text-primary">
                    <i class="fa-solid fa-eye text-primary"></i> Visible Post
                </h3>
            </div>

            <div class="modal-body">
                <img src="{{ $post->image }}" alt="{{ $post->description }}" class="image-lg me-2">
                Are you sure you want to Activate <span class="fw-bold"></span>?
            </div>
            <p class="ms-3">{{ $post->description }}</p>

            <div class="modal-footer border-0">
                <form action="{{ route('admin.posts.activate',$post->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">Cancel</button>

                    <button type="submit" class="btn btn-primary btn-sm">Visible</button>
                </form>
            </div>
        </div>
    </div>
</div>
