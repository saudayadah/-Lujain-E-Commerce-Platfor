# 📱 توثيق API - متجر لُجين للعسل والعطارة

<div align="center">

![Version](https://img.shields.io/badge/version-1.0.0-blue)
![API](https://img.shields.io/badge/API-RESTful-green)
![Auth](https://img.shields.io/badge/Auth-Sanctum-red)

**دليل شامل لواجهة برمجة التطبيقات**

</div>

---

## 📋 جدول المحتويات

1. [نظرة عامة](#1-نظرة-عامة)
2. [المصادقة](#2-المصادقة)
3. [Products API](#3-products-api)
4. [Categories API](#4-categories-api)
5. [Cart API](#5-cart-api)
6. [Orders API](#6-orders-api)
7. [User API](#7-user-api)
8. [Payments API](#8-payments-api)
9. [Wishlist API](#9-wishlist-api)
10. [رموز الأخطاء](#10-رموز-الأخطاء)

---

## 1. نظرة عامة

### معلومات عامة
```yaml
المشروع: متجر لُجين للعسل والعطارة
النوع: E-Commerce REST API
اللغات: عربي (افتراضي) + إنجليزي
Backend: Laravel 10.x
Authentication: Laravel Sanctum (Token-Based)
Response Format: JSON
```

### Base URL
```
Development: http://localhost:8000
Production:  https://lujain.sa
API Prefix:  /api/v1
```

### Headers المطلوبة
```http
Accept: application/json
Content-Type: application/json
Authorization: Bearer {your_token}
X-Localization: ar|en
```

### معدلات الاستخدام (Rate Limiting)
```
Guest:        60 requests/minute
Authenticated: 120 requests/minute
```

---

## 2. المصادقة

### 2.1 التسجيل (Register)
إنشاء حساب عميل جديد.

**Endpoint:** `POST /api/v1/register`

**Request Body:**
```json
{
  "name": "محمد أحمد",
  "email": "mohammed@example.com",
  "phone": "0501234567",
  "password": "SecurePass123",
  "password_confirmation": "SecurePass123"
}
```

**Response (201):**
```json
{
  "success": true,
  "message": "تم التسجيل بنجاح",
  "data": {
    "user": {
      "id": 1,
      "name": "محمد أحمد",
      "email": "mohammed@example.com",
      "phone": "0501234567",
      "role": "customer",
      "is_active": true,
      "created_at": "2025-10-23T10:30:00.000000Z"
    },
    "token": "1|abcd1234token..."
  }
}
```

**Validation Rules:**
- `name`: required, string, max:255
- `email`: required, email, unique:users
- `phone`: required, regex:/^05[0-9]{8}$/, unique:users
- `password`: required, min:8, confirmed

---

### 2.2 تسجيل الدخول (Login)
**Endpoint:** `POST /api/v1/login`

**Request Body:**
```json
{
  "email": "mohammed@example.com",
  "password": "SecurePass123"
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "تم تسجيل الدخول بنجاح",
  "data": {
    "user": {
      "id": 1,
      "name": "محمد أحمد",
      "email": "mohammed@example.com",
      "phone": "0501234567",
      "role": "customer"
    },
    "token": "2|xyz5678token..."
  }
}
```

**Error Response (401):**
```json
{
  "success": false,
  "message": "البريد الإلكتروني أو كلمة المرور غير صحيحة"
}
```

---

### 2.3 تسجيل الخروج (Logout)
**Endpoint:** `POST /api/v1/logout`

**Headers:**
```http
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "message": "تم تسجيل الخروج بنجاح"
}
```

---

### 2.4 معلومات المستخدم الحالي
**Endpoint:** `GET /api/v1/user`

**Headers:**
```http
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "محمد أحمد",
    "email": "mohammed@example.com",
    "phone": "0501234567",
    "role": "customer",
    "total_orders": 15,
    "total_spent": "3500.00",
    "created_at": "2025-01-15T10:30:00.000000Z"
  }
}
```

---

## 3. Products API

### 3.1 عرض جميع المنتجات
**Endpoint:** `GET /api/v1/products`

**Query Parameters:**
```
?page=1
&per_page=20
&category_id=5
&search=عسل
&sort=price_asc|price_desc|newest
&min_price=50
&max_price=500
```

**Response (200):**
```json
{
  "success": true,
  "data": {
    "products": [
      {
        "id": 1,
        "name_ar": "عسل سدر جبلي فاخر",
        "name_en": "Premium Mountain Sidr Honey",
        "slug": "premium-mountain-sidr-honey",
        "description_ar": "عسل سدر جبلي طبيعي 100%",
        "price": "350.00",
        "sale_price": "320.00",
        "discount_percentage": 9,
        "unit": "كجم",
        "stock": 50,
        "in_stock": true,
        "is_featured": true,
        "is_special_offer": false,
        "image": "https://images.unsplash.com/photo-1587049352846...",
        "images": [
          "products/honey-1.jpg",
          "products/honey-2.jpg"
        ],
        "category": {
          "id": 1,
          "name_ar": "العسل الطبيعي",
          "slug": "natural-honey"
        },
        "average_rating": 4.8,
        "reviews_count": 127
      }
    ],
    "pagination": {
    "total": 150,
      "per_page": 20,
      "current_page": 1,
      "last_page": 8,
      "from": 1,
      "to": 20
    }
  }
}
```

---

### 3.2 تفاصيل منتج واحد
**Endpoint:** `GET /api/v1/products/{id}`

**Response (200):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "sku": "HON-SDR-001",
    "name_ar": "عسل سدر جبلي فاخر",
    "name_en": "Premium Mountain Sidr Honey",
    "slug": "premium-mountain-sidr-honey",
    "description_ar": "عسل سدر جبلي طبيعي 100% من أشجار السدر البري",
    "description_en": "100% natural mountain sidr honey from wild sidr trees",
    "price": "350.00",
    "sale_price": "320.00",
    "discount_percentage": 9,
    "unit": "كجم",
    "stock": 50,
    "low_stock_alert": 10,
    "in_stock": true,
    "is_featured": true,
    "is_special_offer": false,
    "image": "products/sidr-honey-main.jpg",
    "images": [
      "products/sidr-honey-1.jpg",
      "products/sidr-honey-2.jpg",
      "products/sidr-honey-3.jpg"
    ],
    "attributes": {
      "origin": "اليمن",
      "harvest_season": "الربيع",
      "certification": "عضوي"
    },
    "category": {
      "id": 1,
      "name_ar": "العسل الطبيعي",
      "name_en": "Natural Honey",
      "slug": "natural-honey",
      "parent": null
    },
    "rating": {
      "average": 4.8,
      "count": 127
    },
    "related_products": [
      {
        "id": 2,
        "name_ar": "عسل طلح جبلي",
        "slug": "talh-honey",
        "price": "280.00",
        "image": "products/talh-honey.jpg"
      }
    ],
    "created_at": "2025-01-01T00:00:00.000000Z",
    "updated_at": "2025-10-23T10:30:00.000000Z"
  }
}
```

**Error Response (404):**
```json
{
  "success": false,
  "message": "المنتج غير موجود"
}
```

---

### 3.3 المنتجات المميزة
**Endpoint:** `GET /api/v1/products/featured`

**Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name_ar": "عسل سدر جبلي فاخر",
      "price": "350.00",
      "sale_price": "320.00",
      "image": "products/sidr-honey.jpg",
      "category": "العسل الطبيعي"
    }
  ]
}
```

---

## 4. Categories API

### 4.1 عرض جميع الفئات
**Endpoint:** `GET /api/v1/categories`

**Query Parameters:**
```
?parent_only=true  // فقط الفئات الرئيسية
&with_products=true  // مع المنتجات
```

**Response (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name_ar": "العسل الطبيعي",
      "name_en": "Natural Honey",
      "slug": "natural-honey",
      "description_ar": "أجود أنواع العسل الطبيعي",
      "image": "categories/honey.jpg",
      "products_count": 25,
      "sort_order": 1,
      "is_active": true,
      "children": [
        {
          "id": 2,
          "name_ar": "عسل سدر",
          "name_en": "Sidr Honey",
          "slug": "sidr-honey",
          "products_count": 8
        },
        {
          "id": 3,
          "name_ar": "عسل طلح",
          "name_en": "Talh Honey",
          "slug": "talh-honey",
          "products_count": 6
        }
      ]
    },
    {
      "id": 4,
      "name_ar": "البهارات والتوابل",
      "name_en": "Spices & Seasonings",
      "slug": "spices",
      "description_ar": "بهارات طبيعية عالية الجودة",
      "image": "categories/spices.jpg",
      "products_count": 42,
      "children": []
    }
  ]
}
```

---

### 4.2 تفاصيل فئة مع منتجاتها
**Endpoint:** `GET /api/v1/categories/{id}`

**Response (200):**
```json
{
  "success": true,
  "data": {
    "category": {
      "id": 1,
      "name_ar": "العسل الطبيعي",
      "name_en": "Natural Honey",
      "slug": "natural-honey",
      "description_ar": "أجود أنواع العسل الطبيعي من أفضل المناحل",
      "image": "categories/honey.jpg",
      "is_active": true
    },
    "products": [
      {
        "id": 1,
        "name_ar": "عسل سدر جبلي فاخر",
        "price": "350.00",
        "sale_price": "320.00",
        "image": "products/sidr-honey.jpg",
        "in_stock": true
      }
    ],
    "pagination": {
      "total": 25,
      "current_page": 1,
      "last_page": 2
    }
  }
}
```

---

## 5. Cart API

### 5.1 عرض السلة
**Endpoint:** `GET /api/v1/cart`

**Response (200):**
```json
{
  "success": true,
  "data": {
    "items": [
      {
        "id": "cart_item_1",
        "product_id": 1,
        "product": {
          "id": 1,
          "name_ar": "عسل سدر جبلي فاخر",
          "image": "products/sidr-honey.jpg",
          "price": "320.00",
          "stock": 50
        },
        "quantity": 2,
        "unit_price": "320.00",
        "subtotal": "640.00"
      },
      {
        "id": "cart_item_2",
        "product_id": 15,
        "product": {
          "id": 15,
          "name_ar": "بهارات كبسة فاخرة",
          "image": "products/kabsa-spices.jpg",
          "price": "45.00",
          "stock": 100
        },
        "quantity": 3,
        "unit_price": "45.00",
        "subtotal": "135.00"
      }
    ],
    "summary": {
      "items_count": 2,
      "subtotal": "775.00",
      "shipping": "30.00",
      "discount": "0.00",
      "coupon": null,
      "tax": "0.00",
      "total": "805.00"
    }
  }
}
```

---

### 5.2 إضافة منتج للسلة
**Endpoint:** `POST /api/v1/cart/add`

**Request Body:**
```json
{
  "product_id": 1,
  "quantity": 2
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "تمت الإضافة للسلة بنجاح",
  "data": {
    "cart": {
      "items_count": 3,
      "total": "1125.00"
    }
  }
}
```

**Error Response (422):**
```json
{
  "success": false,
  "message": "الكمية المطلوبة غير متوفرة",
  "errors": {
    "quantity": [
      "الكمية المتوفرة في المخزون: 5"
    ]
  }
}
```

---

### 5.3 تحديث كمية منتج
**Endpoint:** `PATCH /api/v1/cart/update/{item_id}`

**Request Body:**
```json
{
  "quantity": 5
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "تم تحديث الكمية بنجاح",
  "data": {
    "item": {
      "id": "cart_item_1",
      "quantity": 5,
      "subtotal": "1600.00"
    },
    "cart_total": "1910.00"
  }
}
```

---

### 5.4 حذف منتج من السلة
**Endpoint:** `DELETE /api/v1/cart/remove/{item_id}`

**Response (200):**
```json
{
  "success": true,
  "message": "تم حذف المنتج من السلة",
  "data": {
    "cart": {
      "items_count": 1,
      "total": "135.00"
    }
  }
}
```

---

### 5.5 تطبيق كوبون خصم
**Endpoint:** `POST /api/v1/cart/apply-coupon`

**Request Body:**
```json
{
  "coupon_code": "HONEY20"
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "تم تطبيق الكوبون بنجاح",
  "data": {
    "coupon": {
      "code": "HONEY20",
      "type": "percentage",
      "value": 20,
      "discount_amount": "155.00"
    },
    "cart": {
      "subtotal": "775.00",
      "discount": "155.00",
      "total": "650.00"
    }
  }
}
```

**Error Response (422):**
```json
{
  "success": false,
  "message": "الكوبون غير صالح أو منتهي الصلاحية"
}
```

---

### 5.6 إزالة الكوبون
**Endpoint:** `DELETE /api/v1/cart/remove-coupon`

**Response (200):**
```json
{
  "success": true,
  "message": "تم إزالة الكوبون",
  "data": {
    "cart": {
      "subtotal": "775.00",
      "discount": "0.00",
      "total": "805.00"
    }
  }
}
```

---

## 6. Orders API

### 6.1 إنشاء طلب جديد (Checkout)
**Endpoint:** `POST /api/v1/checkout`

**Headers:**
```http
Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "shipping_address": {
    "full_name": "محمد أحمد",
    "phone": "0501234567",
    "address": "شارع الملك عبدالعزيز، حي النزهة",
    "city": "الرياض",
    "postal_code": "12345",
    "notes": "بجوار مسجد النور"
  },
  "payment_method": "moyasar_creditcard",
  "coupon_code": "HONEY20"
}
```

**Response (201):**
```json
{
  "success": true,
  "message": "تم إنشاء الطلب بنجاح",
  "data": {
    "order": {
      "id": 1523,
      "order_number": "ORD-20251023-ABC123",
      "status": "pending",
      "subtotal": "775.00",
      "shipping_cost": "30.00",
      "discount": "155.00",
      "total": "650.00",
      "items": [
        {
          "product_id": 1,
          "product_name": "عسل سدر جبلي فاخر",
          "quantity": 2,
          "unit_price": "320.00",
          "subtotal": "640.00"
        }
      ],
      "shipping_address": {
        "full_name": "محمد أحمد",
        "phone": "0501234567",
        "address": "شارع الملك عبدالعزيز، حي النزهة",
        "city": "الرياض"
      },
      "created_at": "2025-10-23T12:30:00.000000Z"
    },
    "payment": {
      "id": "pay_abc123xyz",
      "method": "moyasar_creditcard",
      "status": "pending",
      "amount": "650.00",
      "payment_url": "https://api.moyasar.com/v1/payments/abc123/checkout"
    }
  }
}
```

---

### 6.2 عرض طلبات المستخدم
**Endpoint:** `GET /api/v1/orders`

**Headers:**
```http
Authorization: Bearer {token}
```

**Query Parameters:**
```
?status=pending|confirmed|processing|shipped|delivered|cancelled
&page=1
&per_page=10
```

**Response (200):**
```json
{
  "success": true,
  "data": {
    "orders": [
      {
        "id": 1523,
        "order_number": "ORD-20251023-ABC123",
        "status": "confirmed",
        "status_ar": "مؤكد",
        "total": "650.00",
        "items_count": 2,
        "created_at": "2025-10-23T12:30:00.000000Z",
        "estimated_delivery": "2025-10-26"
      },
      {
        "id": 1450,
        "order_number": "ORD-20251015-XYZ789",
        "status": "delivered",
        "status_ar": "تم التوصيل",
        "total": "425.00",
        "items_count": 3,
        "created_at": "2025-10-15T09:15:00.000000Z",
        "delivered_at": "2025-10-18T14:20:00.000000Z"
      }
    ],
    "pagination": {
      "total": 15,
      "current_page": 1,
      "last_page": 2
    }
  }
}
```

---

### 6.3 تفاصيل طلب واحد
**Endpoint:** `GET /api/v1/orders/{id}`

**Headers:**
```http
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "data": {
    "order": {
      "id": 1523,
      "order_number": "ORD-20251023-ABC123",
    "status": "confirmed",
      "status_ar": "مؤكد",
      "subtotal": "775.00",
      "shipping_cost": "30.00",
      "discount": "155.00",
      "total": "650.00",
      "coupon_code": "HONEY20",
      "payment_method": "moyasar_creditcard",
    "payment_status": "paid",
      "notes": null,
    "items": [
      {
        "id": 1,
          "product_id": 1,
          "product_name": "عسل سدر جبلي فاخر",
          "product_image": "products/sidr-honey.jpg",
        "quantity": 2,
          "unit_price": "320.00",
          "subtotal": "640.00"
        },
        {
          "id": 2,
          "product_id": 15,
          "product_name": "بهارات كبسة فاخرة",
          "product_image": "products/kabsa.jpg",
          "quantity": 3,
          "unit_price": "45.00",
          "subtotal": "135.00"
        }
      ],
      "shipping_address": {
        "full_name": "محمد أحمد",
        "phone": "0501234567",
        "address": "شارع الملك عبدالعزيز، حي النزهة",
        "city": "الرياض",
        "postal_code": "12345"
      },
      "tracking": {
        "current_status": "confirmed",
        "history": [
      {
        "status": "pending",
            "status_ar": "قيد الانتظار",
            "timestamp": "2025-10-23T12:30:00.000000Z"
      },
      {
        "status": "confirmed",
            "status_ar": "مؤكد",
            "timestamp": "2025-10-23T13:15:00.000000Z"
          }
        ]
      },
      "invoice": {
        "invoice_number": "INV-2025-001523",
        "pdf_url": "/invoices/1523/pdf",
        "qr_code": "data:image/png;base64,..."
      },
      "created_at": "2025-10-23T12:30:00.000000Z",
      "updated_at": "2025-10-23T13:15:00.000000Z"
    }
  }
}
```

---

### 6.4 إلغاء طلب
**Endpoint:** `POST /api/v1/orders/{id}/cancel`

**Headers:**
```http
Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "reason": "تغيير في الطلب"
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "تم إلغاء الطلب بنجاح",
  "data": {
    "order": {
      "id": 1523,
      "status": "cancelled",
      "refund_status": "pending"
    }
  }
}
```

**Error Response (422):**
```json
{
  "success": false,
  "message": "لا يمكن إلغاء الطلب بعد الشحن"
}
```

---

## 7. User API

### 7.1 تحديث الملف الشخصي
**Endpoint:** `PUT /api/v1/user/profile`

**Headers:**
```http
Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "name": "محمد أحمد السعيد",
  "phone": "0501234567",
  "address": "شارع الملك عبدالعزيز",
  "city": "الرياض",
  "postal_code": "12345"
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "تم تحديث البيانات بنجاح",
  "data": {
    "user": {
      "id": 1,
      "name": "محمد أحمد السعيد",
      "email": "mohammed@example.com",
      "phone": "0501234567",
      "address": "شارع الملك عبدالعزيز",
      "city": "الرياض",
      "postal_code": "12345"
    }
  }
}
```

---

### 7.2 تغيير كلمة المرور
**Endpoint:** `PUT /api/v1/user/password`

**Headers:**
```http
Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "current_password": "OldPass123",
  "new_password": "NewSecurePass456",
  "new_password_confirmation": "NewSecurePass456"
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "تم تغيير كلمة المرور بنجاح"
}
```

**Error Response (422):**
```json
{
  "success": false,
  "message": "كلمة المرور الحالية غير صحيحة"
}
```

---

## 8. Payments API

### 8.1 التحقق من حالة الدفع
**Endpoint:** `GET /api/v1/payments/{payment_id}/status`

**Headers:**
```http
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "data": {
    "payment": {
      "id": "pay_abc123xyz",
      "order_id": 1523,
      "status": "paid",
      "status_ar": "مدفوع",
      "method": "moyasar_creditcard",
      "amount": "650.00",
      "paid_at": "2025-10-23T12:35:00.000000Z",
      "transaction_id": "txn_xyz789"
    }
  }
}
```

**Payment Status Values:**
```
- pending    - قيد الانتظار
- paid       - مدفوع
- failed     - فشل
- refunded   - مسترد
```

---

### 8.2 Webhook لتحديثات الدفع
**Endpoint:** `POST /api/webhooks/saudi-payments`

**Note:** هذا Endpoint يُستدعى من بوابة الدفع، ليس من التطبيق.

**Request Body (من Moyasar):**
```json
{
  "id": "pay_abc123xyz",
  "status": "paid",
  "amount": 65000,
  "currency": "SAR",
  "description": "طلب رقم: ORD-20251023-ABC123",
  "metadata": {
    "order_id": "1523"
  }
}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Webhook processed successfully"
}
```

---

## 9. Wishlist API

### 9.1 عرض قائمة الأمنيات
**Endpoint:** `GET /api/v1/wishlist`

**Headers:**
```http
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "data": {
    "wishlist": [
      {
        "id": 1,
        "product": {
          "id": 5,
          "name_ar": "عسل مانوكا نيوزيلندي",
          "price": "450.00",
          "sale_price": null,
          "image": "products/manuka-honey.jpg",
          "in_stock": true,
          "stock": 25
        },
        "added_at": "2025-10-20T10:15:00.000000Z"
      },
      {
        "id": 2,
        "product": {
          "id": 12,
          "name_ar": "زعفران إيراني فاخر",
          "price": "380.00",
          "sale_price": "350.00",
          "image": "products/saffron.jpg",
          "in_stock": true,
          "stock": 10
        },
        "added_at": "2025-10-22T14:30:00.000000Z"
      }
    ],
    "count": 2
  }
}
```

---

### 9.2 إضافة منتج للأمنيات
**Endpoint:** `POST /api/v1/wishlist/toggle`

**Headers:**
```http
Authorization: Bearer {token}
```

**Request Body:**
```json
{
  "product_id": 5
}
```

**Response (200) - تمت الإضافة:**
```json
{
  "success": true,
  "message": "تمت الإضافة لقائمة الأمنيات",
  "data": {
    "is_wishlisted": true
  }
}
```

**Response (200) - تم الحذف:**
```json
{
  "success": true,
  "message": "تم الحذف من قائمة الأمنيات",
  "data": {
    "is_wishlisted": false
  }
}
```

---

### 9.3 نقل الكل للسلة
**Endpoint:** `POST /api/v1/wishlist/move-all-to-cart`

**Headers:**
```http
Authorization: Bearer {token}
```

**Response (200):**
```json
{
  "success": true,
  "message": "تم نقل 2 منتج للسلة",
  "data": {
    "moved_items": 2,
    "cart_total": "1585.00"
  }
}
```

---

## 10. رموز الأخطاء

### HTTP Status Codes
```
200 OK                 - نجح الطلب
201 Created            - تم الإنشاء بنجاح
204 No Content         - نجح الطلب بدون محتوى
400 Bad Request        - طلب غير صحيح
401 Unauthorized       - غير مصرح
403 Forbidden          - محظور
404 Not Found          - غير موجود
422 Unprocessable      - بيانات غير صحيحة
429 Too Many Requests  - تجاوز الحد المسموح
500 Server Error       - خطأ في السيرفر
```

### Error Response Format
```json
{
  "success": false,
  "message": "رسالة الخطأ الرئيسية",
  "errors": {
    "field_name": [
      "تفاصيل الخطأ 1",
      "تفاصيل الخطأ 2"
    ]
  }
}
```

### أمثلة الأخطاء الشائعة

#### 401 Unauthorized
```json
{
  "success": false,
  "message": "يجب تسجيل الدخول أولاً"
}
```

#### 404 Not Found
```json
{
  "success": false,
  "message": "المنتج غير موجود"
}
```

#### 422 Validation Error
```json
{
  "success": false,
  "message": "البيانات المدخلة غير صحيحة",
  "errors": {
    "email": [
      "البريد الإلكتروني مطلوب",
      "صيغة البريد الإلكتروني غير صحيحة"
    ],
    "password": [
      "كلمة المرور يجب أن تكون 8 أحرف على الأقل"
    ]
  }
}
```

#### 429 Rate Limit
```json
{
  "success": false,
  "message": "تجاوزت الحد المسموح من الطلبات. حاول مرة أخرى بعد دقيقة"
}
```

---

## 📝 ملاحظات مهمة

### الأمان
- ✅ جميع Endpoints الخاصة بالمستخدم تحتاج Token
- ✅ Tokens صالحة لمدة 30 يوماً
- ✅ يمكن تسجيل الخروج لإلغاء Token
- ✅ حماية CSRF مفعلة
- ✅ Rate Limiting مفعل

### التاريخ والوقت
- جميع التواريخ بصيغة ISO 8601
- المنطقة الزمنية: UTC
- مثال: `2025-10-23T12:30:00.000000Z`

### الأسعار
- جميع الأسعار بالريال السعودي (SAR)
- بصيغة Decimal بدقتين عشريتين
- مثال: `"350.00"`

### اللغات
- العربية (افتراضي): `ar`
- الإنجليزية: `en`
- يمكن التحكم عبر Header: `X-Localization`

---

## 🔗 روابط مفيدة

- [Postman Collection](Lujain_API_Collection.postman.json)
- [Documentation](DOCUMENTATION.md)
- [README](README.md)

---

<div align="center">

**تم إنشاء التوثيق بواسطة فريق تطوير لُجين 🍯**

📧 support@lujain.sa | 📱 +966 50 123 4567

**آخر تحديث:** 23 أكتوبر 2025

</div>

