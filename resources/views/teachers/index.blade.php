@extends('layouts.navbar')

@section('searchbox')
@endsection

@section('content')

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{session('success')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card modern-table-card">
  <div class="card-header modern-table-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
      <div class="d-flex align-items-center gap-3">
        <h5 class="mb-0">
          <i class="fas fa-chalkboard-teacher me-2"></i>All Teachers
        </h5>
        <span class="badge modern-badge">{{number_format($teacher_count)}} Total</span>
      </div>
      <a href="{{route('teachers.create')}}" class="btn-primary btn-sm" title="Add New Teacher">
        <i class="fas fa-plus"></i>
        <span>Add Teacher</span>
      </a>
    </div>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table modern-table teachers-table mb-0">
        <thead>
          <tr>
            <th colspan="2" scope="col" class="teachers-table-name">Name</th>
            <th scope="col" class="teachers-table-rank">Rank</th>
            <th scope="col" class="teachers-table-courses">Total Courses</th>
            <th scope="col" class="teachers-table-actions">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($teachers as $teacher)
          <tr class="">
            <td class="teachers-table-avatar">
              <div class="user-avatar-wrapper">
                @if($teacher->profile)
                  <img src="{{asset($teacher->profile)}}" 
                       class="user-avatar" 
                       alt="{{$teacher->name}}"
                       onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'48\' height=\'48\'%3E%3Ccircle cx=\'24\' cy=\'24\' r=\'24\' fill=\'%233d3d3d\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' fill=\'%239e9e9e\' font-size=\'18\' font-weight=\'600\'%3E{{substr($teacher->name, 0, 1)}}%3C/text%3E%3C/svg%3E'">
                @else
                  <img src="{{asset('public/img/placeholder.png')}}" 
                       class="user-avatar" 
                       alt="{{$teacher->name}}"
                       onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'48\' height=\'48\'%3E%3Ccircle cx=\'24\' cy=\'24\' r=\'24\' fill=\'%233d3d3d\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' fill=\'%239e9e9e\' font-size=\'18\' font-weight=\'600\'%3E{{substr($teacher->name, 0, 1)}}%3C/text%3E%3C/svg%3E'">
                @endif
              </div>
            </td>
            <td class="teachers-table-name">
              <a href="{{route('teachers.show', $teacher->id)}}" class="user-name-link">
                <div class="user-name">{{$teacher->name}}</div>
              </a>
            </td>
            <td class="teachers-table-rank">
              <span class="table-text">{{$teacher->rank}}</span>
            </td>
            <td class="teachers-table-courses">
              <span class="table-text">{{$teacher->total_course}}</span>
            </td>
            <td class="teachers-table-actions">
              <a href="{{route('teachers.show', $teacher->id)}}" 
                 class="btn-action-primary" 
                 title="View Details">
                <i class="fas fa-eye"></i>
              </a>
              <a href="{{route('teachers.edit', $teacher->id)}}" 
                 class="btn-action-warning" 
                 title="Edit">
                <i class="fas fa-edit"></i>
              </a>
              <form action="{{route('teachers.destroy', $teacher->id)}}" 
                    method="POST" 
                    style="display: inline-block;" 
                    onsubmit="return confirm('Are you sure you want to delete this teacher?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-action-danger" title="Delete">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center py-5" style="width: 100%;">
              <div class="text-muted">
                <i class="fas fa-chalkboard-teacher fa-3x mb-3" style="opacity: 0.3;"></i>
                <p class="mb-0">No teachers found.</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer modern-table-footer">
      {{$teachers->links('pagination.default')}}
    </div>
  </div>
</div>

@endsection

