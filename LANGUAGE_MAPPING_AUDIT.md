# Language Mapping Audit Report

## Summary
This document tracks all hardcoded language mappings found in the codebase and their replacement status.

## Files with Hardcoded Language Mappings

### ✅ Fixed Files

1. **app/Http/Controllers/LessonController.php**
   - ✅ All language validations now use `LanguageService::isValidCode()`
   - ✅ All display names now use `LanguageService::getDisplayName()`
   - ✅ Notification owner IDs use `LanguageService::getNotificationOwnerId()`
   - ✅ Firebase topics use `LanguageService::getFirebaseTopic()`

2. **app/Http/Controllers/CourseController.php**
   - ✅ Language validation now uses `LanguageService::isValidCode()`
   - ✅ Display names now use `LanguageService::getDisplayName()`
   - ✅ Removed 2 instances of hardcoded language name arrays

### ⚠️ Partially Fixed / Needs Attention

3. **app/Http/Controllers/UserController.php**
   - ⚠️ Has multiple hardcoded `$languageMap` arrays (lines 249, 756, 886, 967)
   - ⚠️ These maps include model classes, table names, colors, and language names
   - **Issue**: Model classes are hardcoded (EasyEnglishUserData, EasyKoreanUserData, etc.)
   - **Solution Needed**: 
     - Use LanguageService for table names, colors, and display names
     - Keep model mapping but make it dynamic based on LanguageService
     - Or create a model resolver service

4. **app/Http/Controllers/GameWordController.php**
   - ⚠️ Uses hardcoded if statements for language codes (lines 21-70, 83-121, 160-227, 237-255)
   - **Issue**: Different models per language (GameWordEnglish, GameWordKorea, etc.)
   - **Solution Needed**: 
     - Create a model resolver or factory pattern
     - Use LanguageService for validation
     - Refactor to use dynamic model resolution

### 📋 View Files (Lower Priority)

5. **resources/views/posts/postmain.blade.php**
   - Hardcoded language links and names
   - Can be made dynamic using LanguageService in controller

6. **resources/views/layouts/overview.blade.php**
   - Hardcoded language names and image paths
   - Should be passed from controller using LanguageService

7. **resources/views/cloudmessaging/cloudmessaging.blade.php**
   - Hardcoded Firebase topic options
   - Should be generated from LanguageService

## Recommendations

### High Priority
1. ✅ **CourseController** - FIXED
2. ⚠️ **UserController** - Needs model mapping solution
3. ⚠️ **GameWordController** - Needs model mapping solution

### Medium Priority
4. Update views to use dynamic language data from controllers
5. Create helper methods in LanguageService for model resolution

### Low Priority
6. Refactor GameWordController to use factory pattern
7. Create LanguageModelResolver service for dynamic model mapping

## Next Steps

1. Enhance LanguageService with model mapping capabilities
2. Update UserController to use LanguageService for non-model mappings
3. Refactor GameWordController to use dynamic model resolution
4. Update view files to receive language data from controllers

---

*Generated: 2025-01-27*

