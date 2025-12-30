@extends('layouts.main')

@section('content')
<div class="row mb-4">
  {{-- Page Header --}}
  <div class="col-12 mb-4">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h2 class="mb-1" style="font-weight: 600; color: var(--text-primary);">Easy Korean Users</h2>
        <p class="mb-0 text-muted">Manage and view Easy Korean user data</p>
      </div>
      <div class="d-flex align-items-center gap-3">
        <div class="stat-card-mini" style="background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);">
          <div class="stat-value">{{ number_format($counts) }}</div>
          <div class="stat-label">Total Users</div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Filter Section --}}
<div class="card mb-4" style="border-radius: 12px; overflow: hidden;">
  <div class="card-header" style="background: rgba(255, 152, 0, 0.1); border-bottom: 1px solid rgba(255, 152, 0, 0.2);">
    <h5 class="mb-0" style="color: #FF9800; font-weight: 600;">
      <i class="fas fa-filter me-2"></i>Filter Users
    </h5>
  </div>
  <div class="card-body">
    <form method="GET" action="{{ route('filterKoreaUser') }}" class="filter-form">
      <div class="row g-3">
        <div class="col-md-3">
          <label class="form-label" style="font-weight: 500; margin-bottom: 8px;">Category</label>
          <select name="sqlrow" class="form-control modern-select" id="filterCategory">
            <option value="login_time">Login Time</option>
            <option value="game_score">Game Score</option>
            <option value="basic_exam">Basic Exam</option>
            <option value="song">Song</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label" style="font-weight: 500; margin-bottom: 8px;">Count</label>
          <input name="count" type="number" class="form-control modern-input" placeholder="Count" min="1">
        </div>
        <div class="col-md-2">
          <label class="form-label" style="font-weight: 500; margin-bottom: 8px;">Last Days</label>
          <input name="ago" type="number" class="form-control modern-input" placeholder="Days" min="1">
        </div>
        <div class="col-md-3 d-flex align-items-end">
          <div class="form-check modern-checkbox">
            <input name="vip" class="form-check-input" type="checkbox" id="vipCheck">
            <label class="form-check-label" for="vipCheck">
              <i class="fas fa-crown me-1" style="color: #FFD700;"></i>VIP Users Only
            </label>
          </div>
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button type="submit" class="btn btn-primary w-100" style="border-radius: 8px; padding: 10px; font-weight: 500;">
            <i class="fas fa-search me-2"></i>Apply Filter
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="card modern-table-card">
  <div class="card-header modern-table-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
      <h5 class="mb-0">
        <i class="fas fa-users me-2"></i>Easy Korean Users
      </h5>
      <div class="d-flex align-items-center gap-3">
        <span class="badge modern-badge">{{ number_format($counts) }} Total</span>
      </div>
    </div>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table modern-table mb-0">
        <thead>
          <tr>
            <th colspan="2" scope="col" class="table-user">Name</th>
            <th scope="col" class="table-phone">Phone</th>
            <th scope="col" class="table-email">Email</th>
            <th scope="col" class="table-region">Region</th>
            <th scope="col" class="table-actions">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($users as $user)
          <tr class="">
            <td class="">
              <div class="user-avatar-wrapper">
                <img src="{{ $user->learner_image ?? '' }}" 
                     class="user-avatar" 
                     alt="{{ $user->learner_name }}"
                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'48\' height=\'48\'%3E%3Ccircle cx=\'24\' cy=\'24\' r=\'24\' fill=\'%233d3d3d\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' fill=\'%239e9e9e\' font-size=\'18\' font-weight=\'600\'%3E{{ substr($user->learner_name ?? 'U', 0, 1) }}%3C/text%3E%3C/svg%3E'">
              </div>
            </td>
            <td class="table-user">
              <a href="{{ route('detail') }}?phone={{ $user->learner_phone }}" class="user-name-link">
                <div class="user-name">{{ $user->learner_name }}</div>
              </a>
            </td>
            <td class="table-phone">
              <span class="table-text">{{ $user->learner_phone }}</span>
            </td>
            <td class="table-email">
              <span class="table-text">{{ $user->learner_email ?: 'N/A' }}</span>
            </td>
            <td class="table-region">
              <span class="table-text">{{ $user->region ?: 'N/A' }}</span>
            </td>
            <td class="table-actions">
              <a href="{{ route('detail') }}?phone={{ $user->learner_phone }}" 
                 class="btn-action" 
                 title="View Details">
                <i class="fas fa-eye"></i>
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-5">
              <div class="text-muted">
                <i class="fas fa-inbox fa-3x mb-3" style="opacity: 0.3;"></i>
                <p class="mb-0">No users found</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($users->hasPages())
    <div class="card-footer modern-table-footer">
      {{ $users->links('pagination.default') }}
    </div>
    @endif
  </div>
</div>

<style>
.stat-card-mini {
  padding: 16px 24px;
  border-radius: 12px;
  color: white;
  text-align: center;
  box-shadow: 0 4px 12px rgba(255, 152, 0, 0.3);
  min-width: 140px;
}

.stat-value {
  font-size: 28px;
  font-weight: 700;
  line-height: 1;
  margin-bottom: 4px;
}

.stat-label {
  font-size: 12px;
  opacity: 0.9;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.filter-form {
  margin: 0;
}

.modern-select,
.modern-input {
  border-radius: 8px;
  border: 1px solid rgba(0, 0, 0, 0.1);
  padding: 10px 14px;
  transition: all 0.3s ease;
}

body.dark-theme .modern-select,
body.dark-theme .modern-input {
  background-color: #2d2d2d;
  border-color: rgba(255, 255, 255, 0.1);
  color: #ffffff;
}

body.light-theme .modern-select,
body.light-theme .modern-input {
  background-color: #ffffff;
  border-color: rgba(0, 0, 0, 0.1);
  color: #202124;
}

.modern-select:focus,
.modern-input:focus {
  border-color: #FF9800;
  box-shadow: 0 0 0 3px rgba(255, 152, 0, 0.1);
  outline: none;
}

.modern-checkbox {
  padding-top: 8px;
}

.modern-checkbox .form-check-input {
  width: 18px;
  height: 18px;
  margin-top: 2px;
  cursor: pointer;
}

.modern-checkbox .form-check-label {
  cursor: pointer;
  user-select: none;
}

body.dark-theme .card {
  background-color: #2d2d2d;
  border-color: rgba(255, 255, 255, 0.1);
}

body.light-theme .card {
  background-color: #ffffff;
  border-color: rgba(0, 0, 0, 0.1);
}

body.dark-theme .card-header {
  background-color: rgba(255, 255, 255, 0.05);
  border-color: rgba(255, 255, 255, 0.1);
}

body.light-theme .card-header {
  background-color: rgba(0, 0, 0, 0.02);
  border-color: rgba(0, 0, 0, 0.1);
}

@media (max-width: 768px) {
  .stat-card-mini {
    min-width: 100px;
    padding: 12px 16px;
  }
  
  .stat-value {
    font-size: 24px;
  }
  
  .stat-label {
    font-size: 11px;
  }
}
</style>
@endsection
