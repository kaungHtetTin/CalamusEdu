@extends('layouts.main')

@section('content')

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{session('success')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>{{session('error')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
  <div class="col-xl-12 col-md-12 mb-4">
    <div class="card course-form-card">
      <div class="language-data-header d-flex align-items-center justify-content-between flex-wrap gap-3" style="border-left: 3px solid #2196F3;">
        <h5 class="language-data-title mb-0" style="color: #2196F3;">
          <i class="fas fa-globe me-2"></i>Language Management
        </h5>
        <a href="{{route('languages.create')}}" class="btn btn-primary btn-sm">
          <i class="fas fa-plus"></i>
          <span>Add New Language</span>
        </a>
      </div>
      <div class="card-body course-form-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Sort</th>
                <th>Code</th>
                <th>Name</th>
                <th>Display Name</th>
                <th>Module Code</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($languages as $language)
              <tr>
                <td>{{$language->sort_order}}</td>
                <td><code>{{$language->code}}</code></td>
                <td>{{$language->name}}</td>
                <td>{{$language->display_name}}</td>
                <td><code>{{$language->module_code}}</code></td>
                <td>
                  @if($language->is_active)
                    <span class="badge bg-success">Active</span>
                  @else
                    <span class="badge bg-secondary">Inactive</span>
                  @endif
                </td>
                <td>
                  <div class="btn-group" role="group">
                    <a href="{{route('languages.show', $language->id)}}" class="btn btn-sm btn-info" title="View">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{route('languages.edit', $language->id)}}" class="btn btn-sm btn-warning" title="Edit">
                      <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{route('languages.destroy', $language->id)}}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this language?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center">No languages found. <a href="{{route('languages.create')}}">Add your first language</a></td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

