@extends('layouts.app')

@section('title', 'Admin: Posts')

@section('content')
    <table class="table table-hover align-middle bg-white border text-secondary">
        <thead class="small table-primary text-secondary">
            <tr>
                <th></th>
                <th></th>
                <th>CATEGORY</th>
                <th>OWNER</th>
                <th>CREATED AT</th>
                <th>STATUS</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>
                        <img src="{{ $post->image }}" alt="{{ $post->description }}"class="image-lg">
                    </td>
                    <td>
                        @if ($post->hasCategoryPost())
                            @foreach ($post->categoryPost as $category_post)
                                <div class="badge bg-secondary bg-opacity-50">
                                    {{ $category_post->category->name }}
                                </div>
                            @endforeach
                        @else
                            <div class="badge bg-dark bg-opacity-50">
                                Uncategorized
                            </div>
                        @endif
                    </td>
                    <td>{{ $post->user->name }}</td>
                    <td>{{ $post->created_at }}</td>
                    <td>
                        @if ($post->trashed())
                        <i class="fa-solid fa-circle text-secondary"></i>&nbsp; Hidden
                    @else
                        <i class="fa-solid fa-circle text-primary"></i>&nbsp; Visible
                    @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="dropdown-item text-secondary" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>

                            <div class="dropdown-menu">
                                @if ($post->trashed())
                                    <button class="dropdown-item text-primary" data-bs-toggle="modal" data-bs-target="#activate-post-{{ $post->id }}"><i class="fa-solid fa-eye"></i> Unhide Post{{ $post->id }}
                                    </button>
                                @else
                                    <button class="dropdown-item text-secondary" data-bs-toggle="modal" data-bs-target="#deactivate-post-{{ $post->id }}"><i class="fa-solid fa-eye-slash"></i> Hide Post{{ $post->id }}
                                    </button>
                                @endif
                            </div>
                        </div>

                        @include('admin.posts.modal.status')
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $all_posts->links() }}
    </div>

@endsection
