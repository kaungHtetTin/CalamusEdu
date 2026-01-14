# API Documentation for Calamin API
## Base URL: `https://www.calamuseducation/calamin/api/`

This document outlines all API endpoints required by the Customer Service Android application.

## Language Support

All user-related endpoints support multiple languages dynamically. The following languages are supported:
- **korea** - Korean language courses
- **english** - English language courses
- **chinese** - Chinese language courses
- **japanese** - Japanese language courses
- **russian** - Russian language courses

The `major` parameter is used throughout the API to specify which language to operate on. If not specified, the API defaults to `korea` for backward compatibility.

**Response Format:** All language-specific endpoints return consistent field names:
- `languageData` - Contains language-specific user data (VIP status, gold plan, token, etc.)
- `courses` - Array of course IDs the user has VIP access to
- `major` - The language code that was queried

---

## 1. Payments API

### 1.1 Get Pending Payments
**Endpoint:** `GET /payments/pending`

**Query Parameters:**
- `major` (string, required): The major/language code (e.g., "korea")

**Request Example:**
```
GET /payments/pending?major=korea
```

**Response Format:**
```json
[
  {
    "id": "1",
    "user_id": "09123456789",
    "username": "John Doe",
    "amount": "50000",
    "screenshot": "https://example.com/payment-screenshot.jpg",
    "date": "2024-01-15 10:30:00"
  },
  {
    "id": "2",
    "user_id": "09987654321",
    "username": "Jane Smith",
    "amount": "75000",
    "screenshot": "https://example.com/payment-screenshot2.jpg",
    "date": "2024-01-16 14:20:00"
  }
]
```

**Response Fields:**
- `id` (string): Payment record ID
- `user_id` (string): User's phone number
- `username` (string): User's name
- `amount` (string): Payment amount
- `screenshot` (string): URL to payment screenshot image
- `date` (string): Payment date and time (format: "YYYY-MM-DD HH:mm:ss")

**Error Handling:**
- Returns empty array `[]` if no pending payments found
- HTTP 500 for server errors

---

## 2. Users API

### 2.1 Get User VIP Information
**Endpoint:** `GET /users/vip/{id}`

**Path Parameters:**
- `id` (integer): Route identifier (can be any number, typically language ID)

**Query Parameters:**
- `phone` (string, required): User's phone number
- `major` (string, optional): Language/major code. Valid values: `korea`, `english`, `chinese`, `japanese`, `russian`. Defaults to `korea` if not provided.

**Request Examples:**
```
GET /users/vip/12?phone=09123456789&major=korea
GET /users/vip/12?phone=09123456789&major=english
GET /users/vip/12?phone=09123456789&major=chinese
GET /users/vip/12?phone=09123456789&major=japanese
GET /users/vip/12?phone=09123456789&major=russian
```

**Response Format:**
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
  "mainCourses": [
    {
      "course_id": "1",
      "title": "Course Title 1",
      "major": "korea"
    },
    {
      "course_id": "2",
      "title": "Course Title 2",
      "major": "korea"
    }
  ],
  "courses": [1, 2, 3],
  "major": "korea"
}
```

**Response Fields:**
- `learner` (object): Basic learner information
  - `id` (string): Learner ID
  - `learner_name` (string): Learner's full name
  - `learner_phone` (string): Learner's phone number
  - `learner_image` (string): URL to profile image
- `languageData` (object): Language-specific user data (dynamic based on `major` parameter)
  - `id` (string): Language data ID
  - `token` (string): Firebase FCM token for push notifications
  - `is_vip` (integer): VIP status (1 = VIP, 0 = not VIP)
  - `gold_plan` (integer): Gold plan status (1 = active, 0 = inactive)
- `mainCourses` (array): List of all available courses for the specified major
  - `course_id` (string): Course ID
  - `title` (string): Course title
  - `major` (string): Course major/language code
- `courses` (array): Array of course IDs that the user has VIP access to for the specified major
- `major` (string): The language/major code that was queried

**Supported Languages:**
- `korea` - Korean language courses
- `english` - English language courses
- `chinese` - Chinese language courses
- `japanese` - Japanese language courses
- `russian` - Russian language courses

**Error Handling:**
- HTTP 400 if `phone` parameter is missing
- HTTP 400 if `major` parameter is invalid
- HTTP 404 if user doesn't exist
- HTTP 500 for server errors

---

### 2.2 Reset User Password
**Endpoint:** `POST /users/passwordreset`

**Request Body (Form Data):**
- `password` (string, required): New password
- `api` (string, required): API identifier (value: "api")
- `phone` (string, required): User's phone number

**Request Example:**
```
POST /users/passwordreset
Content-Type: application/x-www-form-urlencoded

password=newPassword123&api=api&phone=09123456789
```

**Response Format:**
```
Success message string (e.g., "Password reset successfully")
```

**Error Handling:**
- Returns error message string on failure
- HTTP 400 for invalid input
- HTTP 404 if user not found
- HTTP 500 for server errors

---

### 2.3 Add VIP Access to User
**Endpoint:** `POST /users/vipadding/{learner_id}`

**Path Parameters:**
- `learner_id` (string, required): The learner ID

**Request Body (Multipart Form Data):**
- `major` (string, required): Major/language code. Valid values: `korea`, `english`, `chinese`, `japanese`, `russian`
- `amount` (string, required): Payment amount
- `gold_plan` (string, required): "on" or "off"
- `vip_{major}` (string, required): VIP status field. Use the appropriate field based on major:
  - `vip_korea` for korea
  - `vip_english` for english
  - `vip_chinese` for chinese
  - `vip_japanese` for japanese
  - `vip_russian` for russian
  - Value: "on" or "off"
- `myfile` (file, required): Payment screenshot image file
- `api` (string, required): API identifier (value: "api")
- `partner_code` (string, optional): Partner referral code
- `{course_id}` (string, optional): Multiple fields, one per course. Value: "on" or "off" to grant/revoke VIP access to that course

**Request Examples:**

For Korea:
```
POST /users/vipadding/123
Content-Type: multipart/form-data

major=korea
amount=50000
gold_plan=on
vip_korea=on
api=api
1=on
2=on
3=off
myfile=[binary image data]
```

For English:
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

For Chinese:
```
POST /users/vipadding/123
Content-Type: multipart/form-data

major=chinese
amount=50000
gold_plan=on
vip_chinese=on
api=api
1=on
myfile=[binary image data]
```

**Response Format:**
```
Success message string (e.g., "VIP access activated successfully")
```

**Error Handling:**
- Returns error message string on failure
- HTTP 400 for invalid input or invalid major
- HTTP 404 if learner not found
- HTTP 500 for server errors

**Notes:**
- The endpoint:
  1. Updates user's VIP status based on `vip_{major}` field (e.g., `vip_korea`, `vip_english`, etc.)
  2. Updates gold plan status based on `gold_plan` field (supported for all languages)
  3. Grants/revokes VIP access to courses based on course_id fields
  4. Saves the payment screenshot
  5. Records the payment amount
  6. Supports all languages dynamically: korea, english, chinese, japanese, russian

---

### 2.4 Transfer VIP Access
**Endpoint:** `POST /users/transfer-vip-access`

**Request Body (Form Data):**
- `source` (string, required): Source user's phone number (must be VIP)
- `target` (string, required): Target user's phone number
- `major` (string, required): Major/language code (e.g., "korea")

**Request Example:**
```
POST /users/transfer-vip-access
Content-Type: application/x-www-form-urlencoded

source=09123456789&target=09987654321&major=korea
```

**Response Format (Success):**
```json
{
  "status": "success"
}
```

**Response Format (Error):**
```json
{
  "status": "error",
  "error": "Error message describing what went wrong"
}
```

**Error Scenarios:**
- Source account is not a VIP account
- Source and target numbers are the same
- Source or target user not found
- Transfer already completed

**Error Handling:**
- HTTP 400 for invalid input or business logic errors
- HTTP 404 if source or target user not found
- HTTP 500 for server errors

**Business Logic:**
1. Verify source account has VIP access
2. Transfer all VIP privileges from source to target
3. Revoke VIP access from source account
4. Transfer all course access from source to target

---

## 3. Save Replies API

### 3.1 Get All Save Replies
**Endpoint:** `GET /save-replies`

**Request Example:**
```
GET /save-replies
```

**Response Format:**
```json
[
  {
    "id": "1",
    "title": "Welcome Message",
    "message": "Thank you for contacting us. How can I help you today?",
    "major": "korea"
  },
  {
    "id": "2",
    "title": "Payment Confirmation",
    "message": "Your payment has been received and processed. Thank you!",
    "major": "korea"
  }
]
```

**Response Fields:**
- `id` (string): Save reply ID
- `title` (string): Reply title
- `message` (string): Reply message content (max 1000 characters)
- `major` (string): Major/language code (e.g., "korea")

**Error Handling:**
- Returns empty array `[]` if no replies found
- HTTP 500 for server errors

**Notes:**
- The app filters results by `major` field on the client side
- Consider adding `?major=korea` query parameter for server-side filtering

---

### 3.2 Create Save Reply
**Endpoint:** `POST /save-replies`

**Request Body (Form Data):**
- `title` (string, required): Reply title
- `message` (string, required): Reply message (max 1000 characters)
- `major` (string, required): Major/language code (e.g., "korea")

**Request Example:**
```
POST /save-replies
Content-Type: application/x-www-form-urlencoded

title=Welcome Message&message=Thank you for contacting us.&major=korea
```

**Response Format:**
```
Success response (can be empty or success message)
```

**Error Handling:**
- HTTP 400 for invalid input (empty title/message, message too long)
- HTTP 500 for server errors

**Validation:**
- `title`: Required, non-empty
- `message`: Required, non-empty, max 1000 characters
- `major`: Required

---

### 3.3 Update Save Reply
**Endpoint:** `PUT /save-replies/{id}`

**Path Parameters:**
- `id` (string, required): Save reply ID

**Query Parameters:**
- `title` (string, required): Updated reply title
- `message` (string, required): Updated reply message

**Request Body (Form Data):**
- `title` (string, required): Reply title
- `message` (string, required): Reply message (max 1000 characters)
- `major` (string, required): Major/language code (e.g., "korea")

**Request Example:**
```
PUT /save-replies/1?title=Updated Title&message=Updated message
Content-Type: application/x-www-form-urlencoded

title=Updated Title&message=Updated message&major=korea
```

**Response Format:**
```
Success response (can be empty or success message)
```

**Error Handling:**
- HTTP 400 for invalid input
- HTTP 404 if reply not found
- HTTP 500 for server errors

**Notes:**
- The app sends both query parameters and form data. Consider accepting either format.

---

### 3.4 Delete Save Reply
**Endpoint:** `DELETE /save-replies/{id}`

**Path Parameters:**
- `id` (string, required): Save reply ID

**Request Example:**
```
DELETE /save-replies/1
```

**Response Format:**
```
Success response (can be empty or success message)
```

**Error Handling:**
- HTTP 404 if reply not found
- HTTP 500 for server errors

---

## General API Requirements

### Authentication
Currently, the app does not send authentication tokens. Consider implementing:
- API key authentication
- JWT token authentication
- Basic authentication

### Error Response Format
For JSON error responses, use:
```json
{
  "status": "error",
  "error": "Error message here"
}
```

### HTTP Status Codes
- `200 OK`: Successful request
- `400 Bad Request`: Invalid input or business logic error
- `404 Not Found`: Resource not found
- `500 Internal Server Error`: Server error

### Content Types
- `application/json`: For JSON responses
- `application/x-www-form-urlencoded`: For form data requests
- `multipart/form-data`: For file uploads

### CORS
If accessed from web clients, ensure CORS headers are properly configured.

### Rate Limiting
Consider implementing rate limiting to prevent abuse.

### Data Validation
- Validate all input parameters
- Sanitize user inputs to prevent SQL injection
- Validate file uploads (type, size)
- Enforce maximum lengths for text fields

---

## Testing Examples

### Test Requests

**Get Pending Payments:**
```bash
curl "https://www.calamuseducation.com/calamin/api/payments/pending?major=korea"
```

**Get User VIP Info (Korea):**
```bash
curl "https://www.calamuseducation.com/calamin/api/users/vip/12?phone=09123456789&major=korea"
```

**Get User VIP Info (English):**
```bash
curl "https://www.calamuseducation.com/calamin/api/users/vip/12?phone=09123456789&major=english"
```

**Get User VIP Info (Chinese):**
```bash
curl "https://www.calamuseducation.com/calamin/api/users/vip/12?phone=09123456789&major=chinese"
```

**Reset Password:**
```bash
curl -X POST "https://www.calamuseducation.com/calamin/api/users/passwordreset" \
  -d "password=newpass123&api=api&phone=09123456789"
```

**Transfer VIP Access:**
```bash
curl -X POST "https://www.calamuseducation.com/calamin/api/users/transfer-vip-access" \
  -d "source=09123456789&target=09987654321&major=korea"
```

**Get Save Replies:**
```bash
curl "https://www.calamuseducation.com/calamin/api/save-replies"
```

**Create Save Reply:**
```bash
curl -X POST "https://www.calamuseducation.com/calamin/api/save-replies" \
  -d "title=Welcome&message=Thank you&major=korea"
```

---

## Business Logic Summary

### GET /payments/pending
**What it does:**
- Queries pending payments filtered by `major` parameter
- Returns array of payment records with user info, amount, screenshot URL, and date
- Used in FragmentTwo to display pending payment list

### GET /users/vip/{id}
**What it does:**
- Fetches complete user profile by phone number and language major
- Returns learner info, VIP status, gold plan status, available courses, and user's course access
- Supports all languages dynamically: korea, english, chinese, japanese, russian
- Used in: FragmentTwo (search), PaymentDetailActivity, ChattingActivity, OldChattingActivity
- Response includes: `learner` object, `languageData` object, `mainCourses` array, `courses` array, `major` string
- Query parameter `major` determines which language data to retrieve (defaults to `korea`)

### POST /users/passwordreset
**What it does:**
- Resets user password by phone number
- Updates password in database
- Returns success/error message string
- Used in UserDetailActivity

### POST /users/vipadding/{learner_id}
**What it does:**
- Activates VIP access for a user for any supported language
- Handles multipart file upload for payment screenshot
- Updates VIP status, gold plan status (supports all languages)
- Grants/revokes access to individual courses based on dynamic course_id fields
- Records payment amount
- Sends notification to user (handled by app, but API should be ready)
- Used in UserDetailActivity
- Supports all languages dynamically: korea, english, chinese, japanese, russian
- VIP field name must match the major: `vip_korea`, `vip_english`, `vip_chinese`, `vip_japanese`, `vip_russian`

### POST /users/transfer-vip-access
**What it does:**
- Transfers VIP access from source user to target user
- Validates source user has VIP access
- Transfers all VIP privileges and course access
- Revokes VIP from source
- Returns JSON with status and error message
- Used in VipAccessTransferActivity

### GET /save-replies
**What it does:**
- Returns all saved replies
- App filters by `major` on client side (consider server-side filtering)
- Used in: SaveReplyActivity, ChattingActivity, OldChattingActivity

### POST /save-replies
**What it does:**
- Creates new saved reply
- Validates title and message (max 1000 chars)
- Stores with major association
- Used in AddSaveReplyActivity

### PUT /save-replies/{id}
**What it does:**
- Updates existing saved reply
- Accepts title and message in query params or form data
- Updates message and title fields
- Used in AddSaveReplyActivity (edit mode)

### DELETE /save-replies/{id}
**What it does:**
- Deletes saved reply by ID
- Returns success/error response
- Used in SaveReplyActivity

---

## Implementation Priority

1. **High Priority:**
   - GET /users/vip/12 (used in multiple activities)
   - GET /payments/pending (main feature)
   - POST /users/vipadding/{learner_id} (core functionality)

2. **Medium Priority:**
   - POST /users/transfer-vip-access
   - GET /save-replies
   - POST /save-replies

3. **Low Priority:**
   - PUT /save-replies/{id}
   - DELETE /save-replies/{id}
   - POST /users/passwordreset

---

## Implementation Notes

1. **Phone Number Format:** The app uses phone numbers without country codes (e.g., "09123456789"). Ensure your API handles this format consistently.

2. **Major Parameter:** The `major` parameter supports all languages: `korea`, `english`, `chinese`, `japanese`, `russian`. The API dynamically handles all languages. Default is `korea` for backward compatibility, but all endpoints support all languages.

3. **File Uploads:** The payment screenshot upload uses multipart/form-data. Ensure proper file handling, validation, and storage.

4. **Course Access:** The VIP adding endpoint accepts dynamic course_id fields. Your API should handle course access grants/revocations based on these fields.

5. **Response Consistency:** Maintain consistent response formats across all endpoints for easier client-side parsing.

6. **Error Messages:** Provide clear, user-friendly error messages that can be displayed directly to users.

7. **Data Integrity:** Implement proper transactions for operations like VIP transfer to ensure data consistency.

8. **Business Logic for VIP Transfer:**
   - Verify source account has VIP access
   - Transfer all VIP privileges from source to target
   - Revoke VIP access from source account
   - Transfer all course access from source to target

9. **Business Logic for VIP Adding:**
   - Update user's VIP status based on `vip_korea` field
   - Update gold plan status based on `gold_plan` field
   - Grant/revoke VIP access to courses based on course_id fields
   - Save the payment screenshot
   - Record the payment amount

---

## Contact

For questions or clarifications about these API requirements, please refer to the Android app source code or contact the development team.
