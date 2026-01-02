@extends('layouts.main')

@section('content')

<div class="row">
  <div class="col-xl-12 col-md-12 mb-4">
    <div class="card course-form-card">
      <div class="language-data-header d-flex align-items-center justify-content-between flex-wrap gap-3" style="border-left: 3px solid #4CAF50;">
        <h5 class="language-data-title mb-0" style="color: #4CAF50;">
          <i class="fas fa-info-circle me-2"></i>Language Details - {{$language->display_name}}
        </h5>
        <div>
          <a href="{{route('languages.edit', $language->id)}}" class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i> Edit
          </a>
          <a href="{{route('languages.index')}}" class="btn-back btn-sm">
            <i class="fas fa-arrow-left"></i> Back
          </a>
        </div>
      </div>
      <div class="card-body course-form-body">
        <div class="row">
          <div class="col-md-6">
            <table class="table table-bordered">
              <tr>
                <th width="40%">Language Name</th>
                <td>{{$language->name}}</td>
              </tr>
              <tr>
                <th>Code</th>
                <td><code>{{$language->code}}</code></td>
              </tr>
              <tr>
                <th>Display Name</th>
                <td>{{$language->display_name}}</td>
              </tr>
              <tr>
                <th>Module Code</th>
                <td><code>{{$language->module_code}}</code></td>
              </tr>
              <tr>
                <th>Status</th>
                <td>
                  @if($language->is_active)
                    <span class="badge bg-success">Active</span>
                  @else
                    <span class="badge bg-secondary">Inactive</span>
                  @endif
                </td>
              </tr>
              <tr>
                <th>Sort Order</th>
                <td>{{$language->sort_order}}</td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <table class="table table-bordered">
              <tr>
                <th width="40%">Primary Color</th>
                <td>
                  <span class="badge" style="background-color: {{$language->primary_color ?? '#2196F3'}}; color: white;">
                    {{$language->primary_color ?? 'N/A'}}
                  </span>
                </td>
              </tr>
              <tr>
                <th>Secondary Color</th>
                <td>
                  <span class="badge" style="background-color: {{$language->secondary_color ?? '#1976D2'}}; color: white;">
                    {{$language->secondary_color ?? 'N/A'}}
                  </span>
                </td>
              </tr>
              <tr>
                <th>Image Path</th>
                <td>{{$language->image_path ?? 'N/A'}}</td>
              </tr>
              <tr>
                <th>Notification Owner ID</th>
                <td>{{$language->notification_owner_id ?? 'N/A'}}</td>
              </tr>
              <tr>
                <th>Firebase Topic</th>
                <td><code>{{$language->firebase_topic ?? 'N/A'}}</code></td>
              </tr>
              <tr>
                <th>User Data Table</th>
                <td><code>{{$language->getUserDataTableName()}}</code></td>
              </tr>
            </table>
          </div>
        </div>
        
        <div class="mt-4">
          <h6>Usage Statistics</h6>
          <div class="row">
            <div class="col-md-4">
              <div class="card">
                <div class="card-body text-center">
                  <h3>{{DB::table('lessons')->where('major', $language->code)->count()}}</h3>
                  <p class="mb-0">Lessons</p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-body text-center">
                  <h3>{{DB::table('lessons_categories')->where('major', $language->code)->count()}}</h3>
                  <p class="mb-0">Categories</p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-body text-center">
                  <h3>{{DB::table('courses')->where('major', $language->code)->count()}}</h3>
                  <p class="mb-0">Courses</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

