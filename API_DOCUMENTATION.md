# Post, Like, and Comment API Documentation

## Base URL
All API endpoints are prefixed with `/api`

---

## POST API Endpoints

### 1. Create Post
**POST** `/api/posts`

**Request Body:**
```json
{
    "learner_id": 10000,
    "body": "Post content here",
    "major": "english",
    "myfile": [file] // optional image file
}
```

**Response:**
```json
{
    "success": true,
    "message": "Post created successfully",
    "data": {
        "post_id": 1234567890123,
        "body": "Post content here",
        "image": "https://www.calamuseducation.com/uploads/posts/image.jpg",
        "major": "english",
        "created_at": 1234567890123
    }
}
```

---

### 2. Get Post
**GET** `/api/posts/{postId}`

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "post_id": 1234567890123,
        "learner_id": 10000,
        "body": "Post content",
        "image": "https://...",
        "post_like": 10,
        "comments": 5,
        ...
    }
}
```

---

### 3. Update Post
**PUT** `/api/posts/{postId}`

**Request Body:**
```json
{
    "body": "Updated post content",
    "myfile": [file] // optional image file
}
```

**Response:**
```json
{
    "success": true,
    "message": "Post updated successfully",
    "data": { ... }
}
```

---

### 4. Delete Post
**DELETE** `/api/posts/{postId}`

**Response:**
```json
{
    "success": true,
    "message": "Post deleted successfully"
}
```

---

## POST LIKE API Endpoints

### 5. Like/Unlike Post
**POST** `/api/posts/like`

**Request Body:**
```json
{
    "user_id": 10000,
    "post_id": 1234567890123
}
```

**Response:**
```json
{
    "success": true,
    "message": "Post liked",
    "data": {
        "count": 11,
        "isLike": true
    }
}
```

---

## COMMENT API Endpoints

### 6. Get Comments
**GET** `/api/comments/{major}?user_id=10000&post_id=1234567890123`

**Parameters:**
- `major`: english, korea, chinese, japanese, russian
- `user_id`: User ID (query parameter)
- `post_id`: Post ID (query parameter)

**Response:**
```json
{
    "success": true,
    "post": [{
        "postId": 1234567890123,
        "userId": 10000
    }],
    "comments": [
        {
            "id": 1,
            "post_id": 1234567890123,
            "writer_id": 10000,
            "body": "Comment text",
            "commentImage": "",
            "time": 1234567890123,
            "parent": 0,
            "likes": 2,
            "userName": "John Doe",
            "userImage": "https://...",
            "is_liked": 0
        }
    ]
}
```

---

### 7. Create Comment
**POST** `/api/comments`

**Request Body:**
```json
{
    "writer_id": 10000,
    "post_id": 1234567890123,
    "body": "Comment text here",
    "owner_id": 10001,
    "action": 0,
    "myfile": [file] // optional image file
}
```

**Response:**
```json
{
    "success": true,
    "message": "Comment created successfully",
    "data": {
        "id": 1,
        "post_id": 1234567890123,
        "body": "Comment text here",
        "time": 1234567890123
    }
}
```

---

### 8. Update Comment
**PUT** `/api/comments/{commentId}`

**Request Body:**
```json
{
    "body": "Updated comment text",
    "myfile": [file] // optional image file
}
```

**Response:**
```json
{
    "success": true,
    "message": "Comment updated successfully",
    "data": { ... }
}
```

---

### 9. Delete Comment
**DELETE** `/api/comments/{commentId}`

**Response:**
```json
{
    "success": true,
    "message": "Comment deleted successfully"
}
```

---

## COMMENT LIKE API Endpoints

### 10. Like/Unlike Comment
**POST** `/api/comments/like`

**Request Body:**
```json
{
    "user_id": 10000,
    "post_id": 1234567890123,
    "comment_id": 1234567890123
}
```

**Response:**
```json
{
    "success": true,
    "message": "Comment liked",
    "data": {
        "count": 3,
        "isLike": true
    }
}
```

---

## Error Responses

All endpoints return errors in the following format:

```json
{
    "success": false,
    "message": "Error description",
    "errors": { ... } // for validation errors
}
```

**HTTP Status Codes:**
- `200` - Success
- `201` - Created
- `404` - Not Found
- `422` - Validation Error
- `500` - Server Error

---

## Notes

1. All timestamps are in milliseconds (Unix timestamp * 1000)
2. Image uploads are optional for posts and comments
3. The `comment_id` in like comment API refers to the comment's `time` field
4. Post likes are stored in JSON format in the `mylikes` table
5. Comment likes are stored in the `comment_likes` table
6. All endpoints require proper authentication (user_id should be valid)
