# API Update Summary - Dynamic Language Support

## Overview
The API has been updated to support all languages dynamically (korea, english, chinese, japanese, russian) instead of being limited to korea only. All backward compatibility has been removed for consistency across all applications.

## Changes Made

### 1. GET /users/vip/{id} - Get User VIP Information

**Before:**
- Only supported korea
- Response used `koreaData` and `coursesKorea` fields
- No `major` parameter support

**After:**
- Supports all languages: korea, english, chinese, japanese, russian
- Accepts `major` query parameter (defaults to `korea` if not provided)
- Consistent response format for all languages:
  - `languageData` - Language-specific user data
  - `courses` - Array of course IDs
  - `major` - The language code queried

**Example Requests:**
```
GET /users/vip/12?phone=09123456789&major=korea
GET /users/vip/12?phone=09123456789&major=english
GET /users/vip/12?phone=09123456789&major=chinese
GET /users/vip/12?phone=09123456789&major=japanese
GET /users/vip/12?phone=09123456789&major=russian
```

**Response Format (Same for all languages):**
```json
{
  "learner": {
    "id": "123",
    "learner_name": "John Doe",
    "learner_phone": "09123456789",
    "learner_image": "https://example.com/profile.jpg"
  },
  "languageData": {
    "id": "456",
    "token": "firebase_fcm_token_here",
    "is_vip": 1,
    "gold_plan": 0
  },
  "mainCourses": [...],
  "courses": [1, 2, 3],
  "major": "korea"
}
```

### 2. POST /users/vipadding/{learner_id} - Add VIP Access

**Before:**
- Only supported korea with `vip_korea` field
- Hardcoded language-specific logic

**After:**
- Supports all languages dynamically
- VIP field name must match major:
  - `vip_korea` for korea
  - `vip_english` for english
  - `vip_chinese` for chinese
  - `vip_japanese` for japanese
  - `vip_russian` for russian
- `gold_plan` now supported for all languages (previously only korea and english)

**Example Request (English):**
```
POST /users/vipadding/123
Content-Type: multipart/form-data

major=english
amount=50000
gold_plan=on
vip_english=on
api=api
1=on
2=on
myfile=[binary image data]
```

### 3. POST /users/transfer-vip-access - Transfer VIP Access

**Status:** Already supported all languages via switch statement. No changes needed.

## Implementation Details

### Helper Method Added
A new private method `getLanguageModel($major)` maps major codes to their corresponding Eloquent models:
- `korea` → `EasyKoreanUserData`
- `english` → `EasyEnglishUserData`
- `chinese` → `EasyChineseUserData`
- `japanese` → `EasyJapaneseUserData`
- `russian` → `EasyRussianUserData`

### Validation
All endpoints now validate the `major` parameter to ensure only valid language codes are accepted:
- Valid: `korea`, `english`, `chinese`, `japanese`, `russian`
- Invalid values return HTTP 400 with error message

## Migration Guide for Android App

### 1. Update GET /users/vip/{id} calls

**Old Code:**
```java
// Only worked for korea
GET /users/vip/12?phone=09123456789
// Response had: koreaData, coursesKorea
```

**New Code:**
```java
// Works for all languages
GET /users/vip/12?phone=09123456789&major=korea
GET /users/vip/12?phone=09123456789&major=english
// Response has: languageData, courses, major
```

**Response Parsing Changes:**
- Replace `koreaData` with `languageData`
- Replace `coursesKorea` with `courses`
- Use `major` field to identify the language

### 2. Update POST /users/vipadding/{learner_id} calls

**Old Code:**
```java
// Only korea
vip_korea=on
```

**New Code:**
```java
// Dynamic based on major
if (major.equals("korea")) {
    vip_korea=on
} else if (major.equals("english")) {
    vip_english=on
} else if (major.equals("chinese")) {
    vip_chinese=on
} else if (major.equals("japanese")) {
    vip_japanese=on
} else if (major.equals("russian")) {
    vip_russian=on
}
```

## Benefits

1. **Consistency:** All languages use the same response format
2. **Maintainability:** Single code path for all languages
3. **Extensibility:** Easy to add new languages in the future
4. **Clarity:** Response includes `major` field to identify language
5. **Full Support:** All features (VIP, gold plan, courses) work for all languages

## Testing

Test all endpoints with each language:
- ✅ korea
- ✅ english
- ✅ chinese
- ✅ japanese
- ✅ russian

Verify:
- Response format is consistent
- VIP status updates correctly
- Gold plan updates correctly
- Course access grants/revokes correctly
- Error handling for invalid major

## Notes

- Default language is still `korea` if `major` parameter is omitted (for backward compatibility during migration)
- All endpoints return consistent error messages
- Response structure is identical across all languages for easier client-side parsing
