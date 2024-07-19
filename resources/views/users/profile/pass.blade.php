@extends('layouts.app')

@section('title',$user->name)

@section('content')
<body>
    <div class="container">
      <form action="{{ route('profile.editpass') }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="my-3">
            <label for="current_password" class="form-label">Current Password</label>
            <div class="position-relative">
                <input type="password" class="form-control" name="current_password" id="current_password" value="{{ old('current_password') }}"/>
            </div>
            @error('current_password')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="my-3 mt-3">
            <label for="new_password" class="form-label">New Password</label>
            <div class="position-relative">
                <input type="password" class="form-control" name="new_password" id="new_password" value="{{ old('new_password') }}"/>
            </div>
            @error('new_password')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="my-3 mt-3">
            <label for="con_password" class="form-label">Confirm Password</label>
            <div class="position-relative">
                <input type="password" class="form-control" name="con_password" id="con_password" value="{{ old('con_password') }}"/>
            </div>
            @error('con_password')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="my-3 mt-4 text-center">
            <button type="submit" class="btn btn-primary form-control" style="width: 30%">Change Password</button>
        </div>

      </form>
    </div>
  </body>
@endsection

