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

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
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
    <div class="card course-form-card">
      <div class="course-title-header">
        <div class="d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <i class="fas fa-sort me-3" style="font-size: 24px; color: #32cd32;"></i>
            <h4 class="mb-0">Sort Categories - {{$course_title}} ({{$languageName}})</h4>
          </div>
          <a href="{{route('lessons.byLanguage', $language)}}" class="btn-back btn-sm">
            <i class="fas fa-arrow-left"></i>
            <span>Back</span>
          </a>
        </div>
      </div>
      <div class="card-body course-form-body">
        @if(count($categories) > 0)
        <form action="{{route('lessons.updateSortCategories', ['language' => $language, 'course' => $course_id])}}" method="POST" id="sortForm">
          @csrf
          
          <div class="form-section">
            <h6 class="form-section-title">
              <i class="fas fa-sort-numeric-down me-2"></i>Category Sorting
            </h6>
            <p class="text-muted mb-4">Set the sort order for each category. Lower numbers appear first. Categories are currently displayed in their current sort order.</p>
            
            <div class="sort-categories-list">
              @foreach($categories as $index => $category)
              <div class="sort-category-item">
                <div class="d-flex align-items-center">
                  <div class="sort-handle me-3" style="cursor: move; color: #6c757d;">
                    <i class="fas fa-grip-vertical fa-lg"></i>
                  </div>
                  
                  <div class="category-image-container me-3">
                    @if ($category->course_id == 9)
                      <img src="https://www.calamuseducation.com/uploads/icons/videoplaylist.png" class="category-image-small" alt="{{$category->category_title}}"/>
                    @else
                      <img src="{{$category->image_url}}" class="category-image-small" alt="{{$category->category_title}}" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'40\' height=\'40\'%3E%3Crect width=\'40\' height=\'40\' fill=\'%233d3d3d\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' fill=\'%239e9e9e\' font-size=\'16\'%3E📚%3C/text%3E%3C/svg%3E'"/>
                    @endif
                  </div>
                  
                  <div class="flex-grow-1">
                    <h6 class="mb-1">{{$category->category_title}}</h6>
                    <small class="text-muted">Current Order: {{$category->sort_order}}</small>
                  </div>
                  
                  <div class="category-actions me-3">
                    <a href="{{route('lessons.editCategory', $category->id)}}" class="btn btn-sm btn-outline-primary" title="Edit Category">
                      <i class="fas fa-edit"></i>
                    </a>
                  </div>
                  
                  <div class="sort-order-input-container">
                    <label for="sort_order_{{$category->id}}" class="form-label small mb-1">Sort Order</label>
                    <input 
                      type="number" 
                      class="form-control modern-input sort-order-input" 
                      id="sort_order_{{$category->id}}" 
                      name="categories[{{$index}}][sort_order]" 
                      value="{{$category->sort_order}}" 
                      min="0" 
                      required
                      style="width: 100px;"
                    >
                    <input type="hidden" name="categories[{{$index}}][id]" value="{{$category->id}}">
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>

          <div class="form-actions">
            <a href="{{route('lessons.byLanguage', $language)}}" class="btn-back btn-sm">
              <i class="fas fa-times"></i>
              <span>Cancel</span>
            </a>
            <button type="submit" class="new-category-btn">
              <i class="fas fa-save"></i>
              <span>Update Sorting</span>
            </button>
          </div>
        </form>
        @else
        <div class="alert alert-info">
          <i class="fas fa-info-circle me-2"></i>
          No categories found for this course. <a href="{{route('lessons.addCategory', ['language' => $language, 'course' => $course_id])}}">Add a category</a> first.
        </div>
        @endif
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sortList = document.querySelector('.sort-categories-list');
    
    if (sortList && typeof Sortable !== 'undefined') {
        const sortable = Sortable.create(sortList, {
            handle: '.sort-handle',
            animation: 150,
            onEnd: function(evt) {
                // Update sort order inputs based on new position
                const items = sortList.querySelectorAll('.sort-category-item');
                items.forEach(function(item, index) {
                    const input = item.querySelector('.sort-order-input');
                    if (input) {
                        // Use index * 10 to allow insertion between items
                        input.value = (index + 1) * 10;
                    }
                });
            }
        });
    }
});
</script>

<style>
.sort-categories-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.sort-category-item {
    padding: 1rem;
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: 8px;
    background: var(--bg-secondary);
    transition: all 0.3s ease;
}

.sort-category-item:hover {
    border-color: #9c27b0;
    box-shadow: 0 2px 8px rgba(156, 39, 176, 0.15);
}

.sort-category-item.sortable-ghost {
    opacity: 0.4;
    background: rgba(156, 39, 176, 0.1);
}

.sort-category-item.sortable-drag {
    opacity: 0.8;
}

.category-image-container {
    flex-shrink: 0;
}

.category-image-small {
    width: 48px;
    height: 48px;
    border-radius: 8px;
    object-fit: cover;
    border: 2px solid rgba(0, 0, 0, 0.1);
}

.category-actions {
    flex-shrink: 0;
}

.sort-order-input-container {
    flex-shrink: 0;
    text-align: center;
}

.sort-handle:hover {
    color: #9c27b0 !important;
}

body.dark-theme .sort-category-item {
    border-color: rgba(255, 255, 255, 0.2);
    background: var(--bg-secondary);
}

body.dark-theme .sort-category-item:hover {
    border-color: #9c27b0;
    background: rgba(156, 39, 176, 0.05);
}

body.light-theme .sort-category-item {
    border-color: rgba(0, 0, 0, 0.125);
    background: #ffffff;
}

body.light-theme .sort-category-item:hover {
    border-color: #9c27b0;
    background: #f8f9fa;
}

/* Remove unnecessary dividers from form sections */
.form-section {
    border-bottom: none !important;
}

.form-section-title {
    border-bottom: none !important;
}
</style>
@endpush

@endsection

