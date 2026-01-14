# Required JS and CSS Files for Calamus Education Admin Dashboard

This document lists all required JavaScript and CSS files needed for the project to run properly on a server.

## 📋 Required CSS Files

### 1. External CDN CSS (Loaded from CDN)
These are loaded from external CDN sources and should be accessible via internet:

- **Font Awesome 5.11.2**
  - URL: `https://use.fontawesome.com/releases/v5.11.2/css/all.css`
  - Purpose: Icons throughout the application
  - Required: ✅ Yes

- **Google Fonts - Roboto**
  - URL: `https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap`
  - Purpose: Typography
  - Required: ✅ Yes

- **Material Icons**
  - URL: `https://fonts.googleapis.com/icon?family=Material+Icons`
  - Purpose: Material Design icons
  - Required: ✅ Yes (used in posts and other views)

### 2. Local CSS Files (Must be in `public/css/` directory)

- **MDB (Material Design for Bootstrap)**
  - File: `public/css/mdb.min.css`
  - Purpose: Core MDB framework styles
  - Required: ✅ Yes (Critical)
  - Alternative: `mdb.dark.min.css` or `mdb.rtl.min.css` if needed

- **Admin Custom Styles**
  - File: `public/css/admin.css`
  - Purpose: Custom admin dashboard styles, Vimeo-like theme, dark/light theme support
  - Required: ✅ Yes (Critical)

- **App Styles (if used)**
  - File: `public/css/app.css`
  - Purpose: Additional application styles
  - Required: ⚠️ Optional (check if referenced in other views)

## 📋 Required JavaScript Files

### 1. External CDN JavaScript (Loaded from CDN)

- **Chart.js 2.9.4**
  - URL: `https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js`
  - Integrity: `sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw==`
  - Purpose: Charts and graphs (dashboard user activity charts)
  - Required: ✅ Yes (Critical for dashboard)

### 2. Local JavaScript Files (Must be in `public/js/` directory)

- **MDB (Material Design for Bootstrap)**
  - File: `public/js/mdb.min.js`
  - Purpose: Core MDB framework JavaScript functionality
  - Required: ✅ Yes (Critical)

- **Admin Custom Scripts**
  - File: `public/js/admin.js`
  - Purpose: 
    - Navigation drawer toggle functionality
    - Theme toggle (dark/light mode)
    - User avatar dropdown
    - Chart initialization
  - Required: ✅ Yes (Critical)

## 📋 Additional Dependencies (Used in Other Views)

### Posts/Timeline View
- **jQuery 3.5.1** (if used in timeline.blade.php)
  - URL: `https://code.jquery.com/jquery-3.5.1.slim.min.js`
  - Required: ⚠️ Check if timeline view is used

- **Bootstrap 4.6.0 Bundle** (if used in timeline.blade.php)
  - URL: `https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js`
  - Required: ⚠️ Check if timeline view is used

- **Vimeo Player API** (for video posts)
  - URL: `https://player.vimeo.com/api/player.js`
  - Required: ⚠️ Only if video posts feature is used

### Payment View
- **Bootstrap 4.0.0 CSS** (if payment.blade.php is used)
  - URL: `https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css`
  - Required: ⚠️ Only if payment view is used

## 📁 Required Directory Structure

```
public/
├── css/
│   ├── mdb.min.css          ✅ REQUIRED
│   ├── admin.css            ✅ REQUIRED
│   └── app.css              ⚠️ Optional
├── js/
│   ├── mdb.min.js           ✅ REQUIRED
│   └── admin.js             ✅ REQUIRED
└── img/
    ├── easyenglish.png       ✅ REQUIRED (for dashboard)
    ├── easykorean.png       ✅ REQUIRED (for dashboard)
    ├── easychinese.png      ✅ REQUIRED (for dashboard)
    ├── easyjapanese.png      ✅ REQUIRED (for dashboard)
    ├── easyrussian.png       ✅ REQUIRED (for dashboard)
    └── placeholder.png      ⚠️ Optional
```

## ✅ Checklist for Server Deployment

### Critical Files (Must Have)
- [ ] `public/css/mdb.min.css`
- [ ] `public/css/admin.css`
- [ ] `public/js/mdb.min.js`
- [ ] `public/js/admin.js`
- [ ] Font Awesome CDN accessible
- [ ] Google Fonts CDN accessible
- [ ] Chart.js CDN accessible
- [ ] Material Icons CDN accessible

### Image Assets (For Dashboard)
- [ ] `public/img/easyenglish.png`
- [ ] `public/img/easykorean.png`
- [ ] `public/img/easychinese.png`
- [ ] `public/img/easyjapanese.png`
- [ ] `public/img/easyrussian.png`

## 🔧 Troubleshooting

### If CSS/JS files are missing:

1. **Check file paths**: Ensure files are in `public/css/` and `public/js/` directories
2. **Check asset helper**: Verify `asset("public/css/...")` paths are correct
3. **Check CDN access**: Ensure server has internet access for CDN resources
4. **Check file permissions**: Ensure web server can read the files
5. **Check Laravel public path**: Verify `public` directory is the document root

### Common Issues:

- **404 errors on CSS/JS**: Check if files exist and paths are correct
- **Styles not loading**: Check browser console for blocked resources
- **Charts not rendering**: Verify Chart.js CDN is accessible
- **Icons not showing**: Verify Font Awesome CDN is accessible

## 📝 Notes

- All CDN resources should be accessible from the server
- If CDN is blocked, consider hosting these files locally
- The `@stack('scripts')` directive in main.blade.php allows views to add additional scripts
- The dashboard overview view uses Chart.js for user activity charts
