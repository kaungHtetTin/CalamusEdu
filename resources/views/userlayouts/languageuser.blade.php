@extends('layouts.main')

@section('content')
@php
  $languageConfig = $languageConfig ?? [];
  $languageName = $languageConfig['name'] ?? 'Language';
  $primaryColor = $languageConfig['primaryColor'] ?? '#2196F3';
  $secondaryColor = $languageConfig['secondaryColor'] ?? '#1976D2';
@endphp

<div class="row mb-4">
  {{-- Page Header --}}
  <div class="col-12 mb-4">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h2 class="mb-1" style="font-weight: 600; color: var(--text-primary);">Easy {{ $languageName }} Users</h2>
        <p class="mb-0 text-muted">Manage and view Easy {{ $languageName }} user data</p>
      </div>
      <div class="d-flex align-items-center gap-3">
        <div class="stat-card-mini" style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);">
          <div class="stat-value">{{ number_format($counts) }}</div>
          <div class="stat-label">Total Users</div>
        </div>
        <div class="stat-card-mini" style="background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);">
          <div class="stat-value">{{ number_format($vip_counts ?? 0) }}</div>
          <div class="stat-label">VIP Users</div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- User Activity Statistics --}}
<div class="row mb-4">
  <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">Active Users (Today)</div>
            <div class="activity-stat-value">{{number_format($active_users_today ?? 0)}}</div>
            <div class="activity-stat-subtext">
              Today's active users
            </div>
          </div>
          <div class="activity-stat-icon active-users-today">
            <i class="fas fa-user-clock"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">Active Users (7 Days)</div>
            <div class="activity-stat-value">{{number_format($active_users_7d ?? 0)}}</div>
            <div class="activity-stat-subtext">
              <span class="text-success">
                <i class="fas fa-arrow-up me-1"></i>{{($active_users_30d ?? 0) > 0 ? round((($active_users_7d ?? 0) / ($active_users_30d ?? 1)) * 100, 1) : 0}}%
              </span>
              of 30-day active
            </div>
          </div>
          <div class="activity-stat-icon active-users">
            <i class="fas fa-user-check"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">Active Users (30 Days)</div>
            <div class="activity-stat-value">{{number_format($active_users_30d ?? 0)}}</div>
            <div class="activity-stat-subtext">
              Monthly active users
            </div>
          </div>
          <div class="activity-stat-icon active-users-30">
            <i class="fas fa-users"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">New Users (Today)</div>
            <div class="activity-stat-value">{{number_format($new_users_today ?? 0)}}</div>
            <div class="activity-stat-subtext">
              Today's registrations
            </div>
          </div>
          <div class="activity-stat-icon new-users-today">
            <i class="fas fa-user-plus"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">New Users (7 Days)</div>
            <div class="activity-stat-value">{{number_format($new_users_7d ?? 0)}}</div>
            <div class="activity-stat-subtext">
              <span class="text-success">
                <i class="fas fa-arrow-up me-1"></i>{{($new_users_30d ?? 0) > 0 ? round((($new_users_7d ?? 0) / ($new_users_30d ?? 1)) * 100, 1) : 0}}%
              </span>
              of 30-day new
            </div>
          </div>
          <div class="activity-stat-icon new-users">
            <i class="fas fa-user-plus"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
    <div class="card activity-stat-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="activity-stat-label">New Users (30 Days)</div>
            <div class="activity-stat-value">{{number_format($new_users_30d ?? 0)}}</div>
            <div class="activity-stat-subtext">
              Monthly new registrations
            </div>
          </div>
          <div class="activity-stat-icon new-users-30">
            <i class="fas fa-user-friends"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card modern-table-card">
  <div class="card-header modern-table-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
      <h5 class="mb-0">
        <i class="fas fa-users me-2"></i>Easy {{ $languageName }} Users
      </h5>
      <div class="d-flex align-items-center gap-3">
        <form action="{{ request()->url() }}" method="GET" class="d-flex align-items-center search-form">
          <div class="search-input-wrapper">
            <input type="text" 
                   name="search" 
                   class="form-control modern-search-input" 
                   placeholder="Search by name, phone, or email..." 
                   value="{{ $search ?? '' }}"
                   autocomplete="off">
            @if(!empty($search))
              <a href="{{ request()->url() }}" class="clear-search" title="Clear search">
                <i class="fas fa-times"></i>
              </a>
            @endif
          </div>
          <button type="submit" class="btn btn-search ms-2">
            <i class="fas fa-search me-1"></i>Search
          </button>
        </form>
        <span class="badge modern-badge">{{ number_format($counts) }} Total</span>
      </div>
    </div>
  </div>
  <div class="card-body p-0">
    @if(!empty($search))
    <div class="search-results-info">
      <div class="alert alert-info mb-0 border-0 rounded-0" style="background: linear-gradient(90deg, rgba(50, 205, 50, 0.1) 0%, transparent 100%); border-left: 4px solid #32cd32 !important;">
        <i class="fas fa-info-circle me-2"></i>
        Showing search results for: <strong>"{{ $search }}"</strong>
        <a href="{{ request()->url() }}" class="ms-2 text-decoration-none">
          <i class="fas fa-times me-1"></i>Clear
        </a>
      </div>
    </div>
    @endif
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
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
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

