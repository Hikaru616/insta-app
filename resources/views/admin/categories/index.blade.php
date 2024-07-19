@extends('layouts.app')

@section('title', 'Admin: Posts')

@section('content')


<table class="table table-hover align-middle bg-white border text-secondary">

        <div class="input-group mb-3 w-75">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <input type="text" name="category" class="form-control rounded me-2" placeholder="Add a category...">
                <button class="btn btn-primary rounded" type="submit">+ Add</button>
            </form>
        </div>

        <thead class="small table-warning text-secondary">
            <tr>
                <th>#</th>
                <th>NAME</th>
                <th>COUNT</th>
                <th>LAST UPDATE</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_categories as $category)

            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->categoryPostCount($category->id) }}</td>
                <td>{{ $category->updated_at }}</td>
                <td class="d-flex flex-row">
                    <button type="submit" class="text-warning border-warning rounded form-control w-auto mx-1" data-bs-toggle="modal" data-bs-target="#edit-category-{{ $category->id }}">
                        <i class="fa-solid fa-pen"></i>
                    </button>
                    <button type="submit" class="text-danger border-danger rounded form-control w-auto mx-1" data-bs-toggle="modal" data-bs-target="#delete-category-{{ $category->id }}">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    @include('admin.categories.modal.status')
                </td>
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td>Uncategorized</td>
                <td>{{ $category->uncategorizedCount() }}</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
@endsection
