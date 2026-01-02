# Language Management System - User Guide

## Overview
The Language Management System allows you to centrally manage all languages in the Calamus Education platform through a web-based admin console. This eliminates the need to hardcode language configurations throughout the codebase.

## Features
- ✅ Add new languages from admin panel
- ✅ Edit existing language configurations
- ✅ View language details and usage statistics
- ✅ Enable/disable languages
- ✅ Automatic caching for performance
- ✅ Centralized language service for code reuse

## Setup Instructions

### 1. Run Migration
First, enhance the languages table with new fields:
```bash
php artisan migrate
```

### 2. Seed Initial Languages
Populate the database with existing languages:
```bash
php artisan db:seed --class=LanguageSeeder
```

This will add:
- English (Easy English)
- Korean (Easy Korean)
- Chinese (Easy Chinese)
- Japanese (Easy Japanese)
- Russian (Easy Russian)

### 3. Access Language Management
Navigate to: `/languages` in your admin panel

## Adding a New Language

### Step 1: Navigate to Languages
Go to `/languages` and click "Add New Language"

### Step 2: Fill in Required Fields

**Basic Information:**
- **Language Name**: Internal name (e.g., "Spanish")
- **Code**: Unique identifier (e.g., "spanish") - lowercase, no spaces
- **Display Name**: Name shown to users (e.g., "Easy Spanish")
- **Module Code**: Short code for tables (e.g., "es")

**Configuration:**
- **Primary Color**: Theme color (hex format)
- **Secondary Color**: Secondary theme color
- **Image Path**: Path to language icon (e.g., "/img/easyspanish.png")
- **Notification Owner ID**: ID for notification system (optional)
- **Firebase Topic**: Firebase topic for push notifications (e.g., "spanishUsers")
- **User Data Table Prefix**: Prefix for user data table (e.g., "es" creates "es_user_datas")
- **Sort Order**: Display order (lower numbers appear first)
- **Active**: Enable/disable the language

### Step 3: Create Database Tables
After adding a language, you'll need to create the corresponding database tables:
- `{prefix}_user_datas` (e.g., `es_user_datas`)
- `{prefix}_game_words` (e.g., `es_game_words`)
- `{prefix}_word_of_days` (e.g., `es_word_of_days`)

### Step 4: Update Routes (if needed)
If you're adding a new language that should be accessible via routes, update:
- `routes/web.php` - Add language to route constraints
- Any language-specific route patterns

## Using LanguageService in Code

### Get Language Display Name
```php
use App\Services\LanguageService;

$displayName = LanguageService::getDisplayName('english');
// Returns: "Easy English"
```

### Validate Language Code
```php
if (LanguageService::isValidCode('english')) {
    // Language is valid
}
```

### Get All Active Languages
```php
$languages = LanguageService::active();
```

### Get Language Configuration
```php
$config = LanguageService::getLanguageConfig('english');
// Returns array with all language properties
```

### Get Notification Owner ID
```php
$ownerId = LanguageService::getNotificationOwnerId('english');
// Returns: "1002"
```

### Get Firebase Topic
```php
$topic = LanguageService::getFirebaseTopic('english');
// Returns: "englishUsers"
```

### Get User Data Table Name
```php
$tableName = LanguageService::getUserDataTableName('english');
// Returns: "ee_user_datas"
```

### Get Language Mapping (for backward compatibility)
```php
$mapping = LanguageService::getLanguageMapping();
// Returns array of all languages with their configurations
```

## Cache Management

The LanguageService uses caching for performance. Cache is automatically cleared when:
- A language is created
- A language is updated
- A language is deleted

To manually clear cache:
```php
LanguageService::clearCache();
```

## Language Fields Reference

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `name` | string | Yes | Internal language name |
| `code` | string | Yes | Unique identifier (lowercase) |
| `display_name` | string | Yes | Name shown to users |
| `module_code` | string | Yes | Short code for modules |
| `primary_color` | string | No | Primary theme color (hex) |
| `secondary_color` | string | No | Secondary theme color (hex) |
| `image_path` | string | No | Path to language icon |
| `notification_owner_id` | string | No | Notification system ID |
| `firebase_topic` | string | No | Firebase topic name |
| `user_data_table_prefix` | string | Yes | Prefix for user data tables |
| `is_active` | boolean | No | Enable/disable language |
| `sort_order` | integer | No | Display order |

## Example: Adding Spanish Language

1. **Add Language via Admin Panel:**
   - Name: Spanish
   - Code: spanish
   - Display Name: Easy Spanish
   - Module Code: es
   - User Data Table Prefix: es
   - Firebase Topic: spanishUsers
   - Primary Color: #E91E63
   - Secondary Color: #C2185B

2. **Create Database Tables:**
   ```sql
   CREATE TABLE `es_user_datas` (
     -- Same structure as other language user_datas tables
   );
   
   CREATE TABLE `es_game_words` (
     -- Same structure as other game_words tables
   );
   
   CREATE TABLE `es_word_of_days` (
     -- Same structure as other word_of_days tables
   );
   ```

3. **Use in Code:**
   ```php
   $spanishName = LanguageService::getDisplayName('spanish');
   // Returns: "Easy Spanish"
   ```

## Migration from Hardcoded Languages

The system has been updated to use LanguageService. Old hardcoded arrays have been replaced with service calls.

**Before:**
```php
$languageNames = [
    'english' => 'Easy English',
    'korea' => 'Easy Korean',
    // ...
];
```

**After:**
```php
$languageName = LanguageService::getDisplayName($code);
```

## Troubleshooting

### Language not appearing in dropdowns
- Check if language is marked as `is_active = true`
- Clear cache: `LanguageService::clearCache()`
- Verify language exists in database

### Validation errors when adding language
- Ensure `code` and `module_code` are unique
- Check that all required fields are filled
- Verify `code` is lowercase with no spaces

### Cache not updating
- Manually clear cache using `LanguageService::clearCache()`
- Check cache configuration in `config/cache.php`

## Best Practices

1. **Always use LanguageService** instead of hardcoded arrays
2. **Validate language codes** before using them
3. **Use display names** from service for user-facing text
4. **Keep language codes consistent** across the system
5. **Test new languages** thoroughly before marking as active
6. **Document custom configurations** for each language

## API Reference

### LanguageService Methods

| Method | Parameters | Returns | Description |
|-------|-----------|---------|-------------|
| `all()` | - | Collection | Get all languages |
| `active()` | - | Collection | Get active languages |
| `findByCode($code)` | string | Language\|null | Find language by code |
| `getDisplayName($code)` | string | string | Get display name |
| `getValidCodes()` | - | array | Get valid language codes |
| `isValidCode($code)` | string | bool | Validate code |
| `getLanguageMapping()` | - | array | Get all languages as array |
| `getNotificationOwnerId($code)` | string | string\|null | Get notification owner ID |
| `getFirebaseTopic($code)` | string | string\|null | Get Firebase topic |
| `getUserDataTableName($code)` | string | string\|null | Get user data table name |
| `getLanguageConfig($code)` | string | array\|null | Get full language config |
| `clearCache()` | - | void | Clear language cache |

---

*Last Updated: 2025-01-27*

