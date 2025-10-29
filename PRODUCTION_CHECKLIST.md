# ✅ قائمة التحقق قبل النشر على الاستضافة

## 🔐 1. الأمان والإعدادات

### ملف .env
- [ ] إنشاء ملف `.env` من `env.example`
- [ ] تعيين `APP_ENV=production`
- [ ] تعيين `APP_DEBUG=false`
- [ ] تعيين `APP_URL=https://yourdomain.com` (رابط الاستضافة الحقيقي)
- [ ] توليد `APP_KEY`:
  ```bash
  php artisan key:generate
  ```
- [ ] تحديث بيانات قاعدة البيانات:
  ```env
  DB_CONNECTION=mysql
  DB_HOST=localhost
  DB_PORT=3306
  DB_DATABASE=اسم_قاعدة_البيانات
  DB_USERNAME=اسم_المستخدم
  DB_PASSWORD=كلمة_المرور
  ```
- [ ] تحديث بيانات الأدمن:
  ```env
  ADMIN_EMAIL=admin@lujaiin.sa
  ADMIN_PASSWORD=كلمة_مرور_قوية
  ```
- [ ] إعدادات البريد الإلكتروني (SMTP)
- [ ] إعدادات بوابات الدفع (Moyasar)

## 📁 2. قاعدة البيانات

- [ ] إنشاء قاعدة بيانات جديدة
- [ ] تشغيل Migrations:
  ```bash
  php artisan migrate
  ```
- [ ] تشغيل Seeders:
  ```bash
  php artisan db:seed
  ```
- [ ] التحقق من وجود حساب الأدمن:
  - البريد: `admin@lujaiin.sa`
  - كلمة المرور: حسب `ADMIN_PASSWORD` في `.env`

## 📂 3. الملفات والمجلدات

### الصلاحيات
- [ ] صلاحيات `storage/` و `bootstrap/cache/` (775):
  ```bash
  chmod -R 775 storage bootstrap/cache
  ```

### الروابط الرمزية
- [ ] ربط Storage:
  ```bash
  php artisan storage:link
  ```

### التأكد من حذف
- [ ] حذف الملفات المؤقتة:
  - `fix-admin-final.php` ✅ (تم الحذف)
  - `check-admin.php` ✅ (تم الحذف)
  - `create-admin.php` ✅ (تم الحذف)
  - `FIX_ADMIN_LOGIN.md` ✅ (تم الحذف)

## 🚀 4. التحسينات

### Cache
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### تنظيف
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 🌐 5. إعدادات السيرفر

### Apache (.htaccess)
- [ ] وجود ملف `.htaccess` في مجلد `public/`
- [ ] إعدادات mod_rewrite مفعلة

### Nginx
- [ ] إعدادات Server Block صحيحة
- [ ] Root directory يشير إلى `public/`

### PHP
- [ ] PHP Version >= 8.1
- [ ] Extensions المطلوبة مثبتة:
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer
  - XML
  - Ctype
  - JSON
  - Fileinfo

## 📱 6. API والتطبيق

- [ ] التحقق من عمل API:
  - `/api/v1/products`
  - `/api/v1/categories`
- [ ] التحقق من المصادقة:
  - `/api/v1/login`
  - `/api/v1/register`

## 🔒 7. الأمان النهائي

- [ ] HTTPS مفعل (SSL Certificate)
- [ ] تغيير كلمة مرور الأدمن بعد أول تسجيل دخول
- [ ] التأكد من أن `.env` غير قابل للوصول من الويب
- [ ] إعدادات CORS صحيحة في `config/cors.php`

## 📋 8. الاختبارات النهائية

- [ ] تسجيل الدخول كأدمن يعمل ✅
- [ ] لوحة التحكم `/admin` تعمل
- [ ] الصفحة الرئيسية `/` تعمل
- [ ] صفحة المنتجات `/products` تعمل
- [ ] السلة `/cart` تعمل
- [ ] API يعمل
- [ ] رفع الصور يعمل
- [ ] البريد الإلكتروني يعمل (إن كان مفعل)

## 📝 9. التوثيق

- [ ] `README.md` موجود ومحدث ✅
- [ ] `API_DOCUMENTATION.md` موجود ✅
- [ ] `INSTALL_CPANEL.md` موجود ✅
- [ ] `DEPLOY.md` موجود ✅

## ⚠️ 10. ملاحظات مهمة

### بعد النشر مباشرة:
1. ✅ سجل دخول كأدمن وغيّر كلمة المرور
2. ✅ راجع جميع الإعدادات في لوحة التحكم
3. ✅ اختبر العملية الكاملة (إضافة منتج، طلب، دفع)
4. ✅ تأكد من عمل الإشعارات (إن كانت مفعلة)

### ملفات يجب عدم رفعها:
- `.env` (يجب إنشاؤه على السيرفر)
- `vendor/` (يجب تشغيل `composer install` على السيرفر)
- `node_modules/` (إن وجد)

---

**✅ بعد اكتمال جميع النقاط، المشروع جاهز للنشر! 🎉**

