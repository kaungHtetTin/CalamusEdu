@extends('layouts.navbar')

@section('content')

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card">
            <div class="card-body">
                <span class="h4 align-self-center">Edit Teacher: {{$teacher->name}}</span>
                <hr>
                <div class="row">
                    <div class="col-xl-12 col-sm-12 col-12 mb-2 rounded" style="padding: 20px;">
                        <form action="{{route('teachers.update', $teacher->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{old('name', $teacher->name)}}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="rank" class="form-label">Rank <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="rank" name="rank" value="{{old('rank', $teacher->rank)}}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="profile" class="form-label">Profile Image</label>
                                @if($teacher->profile)
                                    <div class="mb-2">
                                        <img src="{{asset($teacher->profile)}}" style="width:100px; height:100px;" class="rounded-circle" alt="Current Profile"/>
                                        <p class="text-muted small mt-1">Current profile image</p>
                                    </div>
                                @endif
                                <input type="file" class="form-control" id="profile" name="profile" accept="image/*">
                                <small class="form-text text-muted">Leave empty to keep current image. Accepted formats: JPEG, PNG, JPG, GIF (Max: 2MB)</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4">{{old('description', $teacher->description)}}</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="qualification" class="form-label">Qualification</label>
                                <textarea class="form-control" id="qualification" name="qualification" rows="4">{{old('qualification', $teacher->qualification)}}</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="experience" class="form-label">Experience</label>
                                <textarea class="form-control" id="experience" name="experience" rows="4">{{old('experience', $teacher->experience)}}</textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="facebook" class="form-label">Facebook URL</label>
                                    <input type="url" class="form-control" id="facebook" name="facebook" value="{{old('facebook', $teacher->facebook)}}" placeholder="https://facebook.com/...">
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="telegram" class="form-label">Telegram URL</label>
                                    <input type="url" class="form-control" id="telegram" name="telegram" value="{{old('telegram', $teacher->telegram)}}" placeholder="https://t.me/...">
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="youtube" class="form-label">YouTube URL</label>
                                    <input type="url" class="form-control" id="youtube" name="youtube" value="{{old('youtube', $teacher->youtube)}}" placeholder="https://youtube.com/...">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="total_course" class="form-label">Total Courses</label>
                                <input type="number" class="form-control" id="total_course" name="total_course" value="{{old('total_course', $teacher->total_course)}}" min="0">
                            </div>
                            
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary" style="width: 150px;">Update Teacher</button>
                                <a href="{{route('teachers.index')}}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

