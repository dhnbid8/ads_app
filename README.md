# Laravel Ads API test
یک API کامل و استاندارد برای مدیریت آگهی‌ها با قابلیت‌های فیلتر 

## پیش‌نیازها 🛠️

قبل از شروع، اطمینان حاصل کنید که موارد زیر روی سیستم شما نصب است:

- PHP >= 8.1
- Composer
- Sqlite
- Git

## نصب و راه‌اندازی 🚀

### 1. کلون کردن پروژه

```bash
https://github.com/dhnbid8/ads_app.git
cd ads_app
```

### 2. نصب Dependencies

```bash
composer install
```

### 3. تنظیمات Environment

```bash
# کپی کردن فایل env
cp .env.example .env


# یا از طریق artisan
php artisan db:create
```

### 6. اجرای Migration ها

```bash
php artisan migrate
```

### 7. اجرای Seeder (اختیاری)

```bash
php artisan db:seed --class=AdSeeder
```

این دستور 65 آگهی نمونه (50 عادی + 10 ویژه + 5 منقضی) ایجاد می‌کند.

### 8. اجرای سرور

```bash
php artisan serve
```

API در آدرس `http://localhost:8000` در دسترس خواهد بود.

## API Endpoints 📡

### Base URL
```
http://localhost:8000/api/v1
```

### لیست آگهی‌ها
```http
GET /ads
```

**پارامترهای Query:**
- `operator` - فیلتر بر اساس اپراتور (mci, irancell, rightel)
- `location` - فیلتر بر اساس مکان
- `is_featured` - فیلتر آگهی‌های ویژه (true/false)
- `min_price` - حداقل قیمت
- `max_price` - حداکثر قیمت
- `active_only` - فقط آگهی‌های فعال (true/false)
- `per_page` - تعداد آیتم در هر صفحه (پیش‌فرض: 15)
- `page` - شماره صفحه

**نمونه درخواست:**
```bash
curl -X GET "http://localhost:8000/api/v1/ads?operator=mci&location=تهران&is_featured=true&per_page=10"
```

**نمونه پاسخ:**
```json
{
  "success": true,
  "message": "آگهی‌ها با موفقیت دریافت شدند",
  "data": [
    {
      "id": 1,
      "title": "بسته اینترنت ۱۰ گیگ",
      "operator": "mci",
      "price": 50000,
      "formatted_price": "50,000 تومان",
      "views": 125,
      "location": "تهران",
      "expires_at": "2025-12-31 23:59:59",
      "expires_at_human": "5 months from now",
      "image_url": "https://example.com/image.jpg",
      "is_featured": true,
      "is_expired": false,
      "created_at": "2025-01-15 10:30:00",
      "updated_at": "2025-01-15 10:30:00"
    }
  ],
  "pagination": {
    "current_page": 1,
    "per_page": 10,
    "total": 25,
    "last_page": 3,
    "has_more": true
  }
}
```

### مشاهده آگهی خاص
```http
GET /ads/{id}
```

**نمونه درخواست:**
```bash
curl -X GET "http://localhost:8000/api/v1/ads/1"
```

### آمار آگهی‌ها
```http
GET /ads/stats
```

**نمونه پاسخ:**
```json
{
  "success": true,
  "message": "آمار با موفقیت دریافت شد",
  "data": {
    "total_ads": 65,
    "active_ads": 60,
    "featured_ads": 10,
    "expired_ads": 5,
    "operators": {
      "mci": 22,
      "irancell": 21,
      "rightel": 22
    },
    "total_views": 15420,
    "avg_price": 125000.50
  }
}
```

## نمونه درخواست‌ها 📝

### فیلتر بر اساس اپراتور
```bash
curl -X GET "http://localhost:8000/api/v1/ads?operator=mci"
```

### فیلتر بر اساس مکان
```bash
curl -X GET "http://localhost:8000/api/v1/ads?location=تهران"
```

### فیلتر آگهی‌های ویژه
```bash
curl -X GET "http://localhost:8000/api/v1/ads?is_featured=true"
```

### فیلتر بر اساس محدوده قیمت
```bash
curl -X GET "http://localhost:8000/api/v1/ads?min_price=50000&max_price=200000"
```

### فیلتر ترکیبی
```bash
curl -X GET "http://localhost:8000/api/v1/ads?operator=irancell&location=اصفهان&is_featured=true&active_only=true"
```

### Pagination
```bash
curl -X GET "http://localhost:8000/api/v1/ads?per_page=5&page=2"
```


## کلاس‌های کلیدی 🔑

### AdFilter
فیلتر کردن داده‌ها بر اساس پارامترهای مختلف:
- `operator` - اپراتور
- `location` - مکان
- `is_featured` - ویژه بودن
- `min_price` / `max_price` - محدوده قیمت
- `active_only` - فقط آگهی‌های فعال
