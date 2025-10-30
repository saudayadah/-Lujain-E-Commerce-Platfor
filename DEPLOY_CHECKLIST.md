# 🚀 دليل نشر Dexter CRM - Production Deployment Checklist
**آخر تحديث:** 2025-10-30  
**الإصدار:** 1.0.0  
**النظام:** Dexter - نظام إدارة علاقات العملاء

---

## 📋 جدول المحتويات

1. [قبل النشر - Pre-Deployment](#قبل-النشر---pre-deployment)
2. [تكوينات البيئة - Environment Configuration](#تكوينات-البيئة---environment-configuration)
3. [قاعدة البيانات - Database](#قاعدة-البيانات---database)
4. [الملفات والأذونات - Files & Permissions](#الملفات-والأذونات---files--permissions)
5. [الأمان - Security](#الأمان---security)
6. [الأداء - Performance](#الأداء---performance)
7. [خدمات خارجية - External Services](#خدمات-خارجية---external-services)
8. [اختبار ما بعد النشر - Post-Deployment Testing](#اختبار-ما-بعد-النشر---post-deployment-testing)
9. [المراقبة - Monitoring](#المراقبة---monitoring)
10. [Rollback Plan](#rollback-plan)

---

## قبل النشر - Pre-Deployment

### ✅ كود المصدر

- [ ] **Git Status:** تأكد من commit جميع التغييرات
  ```bash
  git status
  git log --oneline -5
  ```

- [ ] **Branch:** تأكد أنك على الـ branch الصحيح (main/master)
  ```bash
  git branch
  ```

- [ ] **Tests:** تشغيل جميع الاختبارات
  ```bash
  php artisan test
  # أو
  ./vendor/bin/phpunit
  ```

- [ ] **Linting:** فحص الكود
  ```bash
  ./vendor/bin/phpstan analyse
  # أو
  composer check-style
  ```

### ✅ Dependencies

- [ ] **Composer:** تحديث dependencies
  ```bash
  composer install --no-dev --optimize-autoloader
  ```

- [ ] **NPM:** تحديث frontend assets (إذا لزم)
  ```bash
  npm install --production
  npm run production
  ```

---

## تكوينات البيئة - Environment Configuration

### ✅ ملف .env

#### 1. App Configuration

```env
APP_NAME="لُجين"
APP_ENV=production          # ⚠️ يجب أن يكون production
APP_KEY=base64:...          # ⚠️ يجب توليد key جديد
APP_DEBUG=false             # ⚠️ يجب أن يكون false
APP_URL=https://yourdomain.com  # ⚠️ استخدم HTTPS
```

**التحقق:**
- [ ] `APP_ENV` = production
- [ ] `APP_DEBUG` = false
- [ ] `APP_URL` يحتوي على HTTPS
- [ ] `APP_KEY` موجود ومُولّد

**توليد APP_KEY:**
```bash
php artisan key:generate
```

---

#### 2. CORS Configuration

```env
# 🔒 Security: حدد domains المسموح لها فقط
CORS_ALLOWED_ORIGINS=https://lujaiin.sa,https://www.lujaiin.sa
```

**التحقق:**
- [ ] `CORS_ALLOWED_ORIGINS` محدد (لا يحتوي على `*`)
- [ ] جميع الـ domains الرسمية مدرجة

---

#### 3. Database Configuration

```env
DB_CONNECTION=mysql
DB_HOST=localhost           # أو IP الخاص بـ database server
DB_PORT=3306
DB_DATABASE=production_db_name
DB_USERNAME=production_db_user
DB_PASSWORD=strong_password_here
```

**التحقق:**
- [ ] معلومات الاتصال صحيحة
- [ ] كلمة مرور قوية للـ database user
- [ ] تم اختبار الاتصال:
  ```bash
  php artisan db:show
  ```

---

#### 4. Cache & Queue

```env
CACHE_DRIVER=redis          # أو file إذا لم يكن redis متاحًا
QUEUE_CONNECTION=database   # أو redis للأداء الأفضل
SESSION_DRIVER=database
```

**التحقق:**
- [ ] `CACHE_DRIVER` مُكوّن بشكل صحيح
- [ ] `QUEUE_CONNECTION` = database أو redis
- [ ] Redis يعمل (إذا تم استخدامه):
  ```bash
  redis-cli ping
  # يجب أن يرجع: PONG
  ```

---

#### 5. Mail Configuration

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.yourdomain.com
MAIL_PORT=587
MAIL_USERNAME=noreply@yourdomain.com
MAIL_PASSWORD=your_mail_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

**التحقق:**
- [ ] معلومات SMTP صحيحة
- [ ] اختبار إرسال بريد:
  ```bash
  php artisan tinker
  Mail::raw('Test email', function($msg) {
      $msg->to('your-email@example.com')->subject('Test');
  });
  ```

---

#### 6. Payment Gateway (Moyasar)

```env
PAYMENT_GATEWAY_ENABLED=true
PAYMENT_GATEWAY_MODE=live   # ⚠️ يجب أن يكون live في production
PAYMENT_GATEWAY=moyasar

MOYASAR_ENABLED=true
MOYASAR_MODE=live           # ⚠️ يجب أن يكون live في production
MOYASAR_PUBLISHABLE_KEY=pk_live_...
MOYASAR_SECRET_KEY=sk_live_...
MOYASAR_WEBHOOK_SECRET=whsec_...
```

**التحقق:**
- [ ] `MOYASAR_MODE` = live
- [ ] Live keys موجودة (وليست test keys)
- [ ] `MOYASAR_WEBHOOK_SECRET` موجود
- [ ] اختبار الاتصال بـ Moyasar API

---

#### 7. SMS Configuration (Taqnyat)

```env
SMS_PROVIDER=taqnyat
SMS_ENABLED=true

TAQNYAT_API_KEY=your_taqnyat_api_key
TAQNYAT_SENDER=YourBrand
```

**التحقق:**
- [ ] `SMS_ENABLED` = true
- [ ] `TAQNYAT_API_KEY` صحيح
- [ ] `TAQNYAT_SENDER` مُعتمد
- [ ] اختبار إرسال SMS

---

#### 8. Logging

```env
LOG_CHANNEL=stack
LOG_LEVEL=error             # ⚠️ في production: error أو warning
```

**التحقق:**
- [ ] `LOG_LEVEL` = error (أو warning حسب الحاجة)
- [ ] لا نستخدم `debug` في production

---

### ✅ Config Cache

بعد تحديث `.env`، قم بتنظيف وتحديث الـ cache:

```bash
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**التحقق:**
- [ ] تم تنفيذ جميع الأوامر بنجاح
- [ ] لا توجد أخطاء

---

## قاعدة البيانات - Database

### ✅ Migrations

```bash
# 1. عمل backup للـ database الحالية (إذا كان upgrade)
mysqldump -u username -p database_name > backup_$(date +%Y%m%d_%H%M%S).sql

# 2. تشغيل migrations
php artisan migrate --force

# 3. التحقق من النتائج
php artisan migrate:status
```

**التحقق:**
- [ ] تم عمل backup قبل migrations
- [ ] جميع migrations تم تشغيلها بنجاح
- [ ] لا توجد migrations pending

---

### ✅ Seeders

```bash
# فقط في التنصيب الأول
php artisan db:seed --class=AdminUserSeeder
php artisan db:seed --class=SettingSeeder
php artisan db:seed --class=PermissionSeeder
```

**التحقق:**
- [ ] Admin user موجود
- [ ] Settings الافتراضية موجودة
- [ ] Permissions موجودة

---

### ✅ Database Indexes

تحقق من وجود indexes على الجداول الحرجة:

```sql
-- Products
SHOW INDEX FROM products;
-- يجب أن يحتوي على: slug, category_id, is_active, stock

-- Orders
SHOW INDEX FROM orders;
-- يجب أن يحتوي على: user_id, status, payment_status, order_number

-- Categories
SHOW INDEX FROM categories;
-- يجب أن يحتوي على: slug, parent_id, is_active
```

**التحقق:**
- [ ] indexes موجودة على الجداول الرئيسية

---

## الملفات والأذونات - Files & Permissions

### ✅ Storage Symlink

```bash
php artisan storage:link
```

**التحقق:**
- [ ] `public/storage` يشير إلى `storage/app/public`
- [ ] أو (في Windows): الصور تُنسخ تلقائيًا (ImageUploadService)

---

### ✅ File Permissions

```bash
# Laravel directories
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# إذا كنت على cPanel:
chown -R username:username storage bootstrap/cache
```

**التحقق:**
- [ ] `storage/` قابل للكتابة
- [ ] `bootstrap/cache/` قابل للكتابة
- [ ] `public/storage/` قابل للوصول

---

### ✅ .htaccess & Web Server

**للـ Apache (cPanel):**
تأكد من وجود `.htaccess` في `public/`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

**للـ Nginx:**
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

**التحقق:**
- [ ] URL rewriting يعمل
- [ ] الصفحة الرئيسية تفتح بشكل صحيح

---

## الأمان - Security

### ✅ HTTPS

**cPanel:**
- [ ] SSL certificate مُفعّل (Let's Encrypt أو مدفوع)
- [ ] Force HTTPS redirect مُفعّل

**التحقق:**
```bash
curl -I https://yourdomain.com
# يجب أن يرجع 200 OK
```

- [ ] `http://` يُعيد التوجيه إلى `https://`
- [ ] SSL certificate صالح

---

### ✅ Environment Files

```bash
# تأكد من أن .env غير قابل للوصول من المتصفح
chmod 600 .env
```

**التحقق:**
- [ ] `.env` غير قابل للوصول من الويب
- [ ] `.env.example` غير قابل للوصول (أو تم حذفه)
- [ ] لا توجد ملفات backup `.env.backup` في public

---

### ✅ Security Headers

أضف في `.htaccess` (Apache) أو nginx config:

```apache
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-XSS-Protection "1; mode=block"
    Header set Referrer-Policy "no-referrer-when-downgrade"
</IfModule>
```

**التحقق:**
```bash
curl -I https://yourdomain.com | grep -E "X-Content-Type|X-Frame|X-XSS"
```

- [ ] Security headers موجودة

---

### ✅ Rate Limiting

تحقق من أن rate limiting مُفعّل في `routes/api.php`:

```php
Route::post('/register')->middleware('throttle:auth'); // 5/minute
Route::post('/login')->middleware('throttle:auth');    // 5/minute
```

**التحقق:**
- [ ] `/api/v1/register` محمي بـ `throttle:auth`
- [ ] `/api/v1/login` محمي بـ `throttle:auth`
- [ ] اختبار rate limiting:
  ```bash
  for i in {1..10}; do curl -X POST https://yourdomain.com/api/v1/login; done
  # يجب أن يُرجع 429 بعد 5 محاولات
  ```

---

### ✅ CORS Configuration

تحقق من `config/cors.php`:

```php
'allowed_origins' => env('APP_ENV') === 'local' 
    ? ['*'] 
    : array_filter(explode(',', env('CORS_ALLOWED_ORIGINS', ''))),
```

**التحقق:**
- [ ] `CORS_ALLOWED_ORIGINS` في `.env` محدد
- [ ] لا يحتوي على `*` في production
- [ ] اختبار CORS:
  ```bash
  curl -H "Origin: https://unauthorized-domain.com" \
       -H "Access-Control-Request-Method: POST" \
       -X OPTIONS https://yourdomain.com/api/v1/products
  # يجب ألا يُرجع Access-Control-Allow-Origin
  ```

---

## الأداء - Performance

### ✅ Optimization Commands

```bash
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

**التحقق:**
- [ ] جميع الأوامر نُفذت بنجاح
- [ ] لا أخطاء

---

### ✅ Queue Worker

**تشغيل Queue Worker:**

**Option 1: Supervisor (Recommended for VPS)**
إنشاء ملف `/etc/supervisor/conf.d/laravel-worker.conf`:

```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/app/artisan queue:work database --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/your/app/storage/logs/worker.log
stopwaitsecs=3600
```

ثم:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

**Option 2: Cron Job (cPanel)**
أضف في crontab:

```bash
* * * * * cd /home/username/public_html && php artisan schedule:run >> /dev/null 2>&1
* * * * * cd /home/username/public_html && php artisan queue:work --stop-when-empty --tries=3 >> /dev/null 2>&1
```

**التحقق:**
- [ ] Queue worker يعمل
- [ ] اختبار queue:
  ```bash
  php artisan tinker
  dispatch(function() { \Log::info('Queue test'); });
  # تحقق من logs
  ```

---

### ✅ Database Query Optimization

**تحقق من N+1 queries:**
- [ ] المنتجات: `Product::with('category')`
- [ ] الطلبات: `Order::with(['user', 'items.product', 'payments'])`
- [ ] التصنيفات: `Category::with('children')`

**التحقق:**
```bash
# في development:
php artisan debugbar:publish
# افحص عدد الـ queries في كل صفحة
```

---

### ✅ Caching

**تفعيل caching للبيانات الثابتة:**

```php
// مثال: Categories
$categories = Cache::remember('categories.all', 3600, function() {
    return Category::active()->with('children')->get();
});
```

**التحقق:**
- [ ] التصنيفات مُخزنة في cache
- [ ] Settings مُخزنة في cache
- [ ] اختبار cache:
  ```bash
  php artisan tinker
  Cache::put('test', 'value', 60);
  Cache::get('test'); // يجب أن يرجع 'value'
  ```

---

## خدمات خارجية - External Services

### ✅ Moyasar Payment Gateway

**التحقق:**
- [ ] Live API keys موجودة في `.env`
- [ ] Webhook URL مُسجّل في Moyasar Dashboard:
  ```
  https://yourdomain.com/webhooks/saudi-payments
  ```
- [ ] Webhook Secret موجود في `.env`
- [ ] اختبار webhook signature verification

**اختبار Payment Flow:**
1. [ ] إنشاء طلب جديد
2. [ ] الذهاب لصفحة الدفع
3. [ ] إدخال بطاقة اختبار (في sandbox) أو حقيقية (في live)
4. [ ] التحقق من نجاح الدفع
5. [ ] التحقق من تحديث حالة الطلب في DB
6. [ ] التحقق من استلام webhook

---

### ✅ SMS Service (Taqnyat)

**التحقق:**
- [ ] API key صحيح
- [ ] Sender name مُعتمد
- [ ] اختبار إرسال SMS:
  ```bash
  php artisan tinker
  app(\App\Services\SmsService::class)->send('966XXXXXXXXX', 'Test message');
  ```
- [ ] التحقق من استلام الرسالة

---

### ✅ Meta Pixel (Facebook/Instagram)

**التحقق:**
- [ ] Meta Pixel ID موجود في `.env`
- [ ] Pixel مُثبّت في layout
- [ ] Events تُرسل بشكل صحيح:
  - `PageView`
  - `ViewContent` (Product page)
  - `AddToCart`
  - `InitiateCheckout`
  - `Purchase`
- [ ] اختبار باستخدام Facebook Pixel Helper extension

---

## اختبار ما بعد النشر - Post-Deployment Testing

### ✅ Smoke Tests

#### 1. الصفحة الرئيسية
- [ ] الصفحة تفتح بدون أخطاء
- [ ] التصنيفات تظهر
- [ ] المنتجات تظهر
- [ ] الصور تظهر

#### 2. تصفح المنتجات
- [ ] صفحة المنتجات تفتح
- [ ] الفلترة تعمل (حسب التصنيف، السعر)
- [ ] الترتيب يعمل
- [ ] Pagination يعمل
- [ ] صفحة المنتج الفردي تفتح
- [ ] الصور تعرض بشكل صحيح

#### 3. السلة
- [ ] إضافة منتج للسلة
- [ ] تحديث الكمية
- [ ] حذف منتج
- [ ] عداد السلة يتحدث
- [ ] تطبيق coupon
- [ ] إزالة coupon

#### 4. عملية الشراء (Checkout)
- [ ] الانتقال إلى صفحة checkout
- [ ] ملء بيانات الشحن
- [ ] اختيار طريقة الدفع (COD)
- [ ] إنشاء طلب COD بنجاح
- [ ] اختيار طريقة الدفع (Online)
- [ ] التوجيه إلى صفحة الدفع (Moyasar)
- [ ] إتمام الدفع
- [ ] Webhook يُستقبل
- [ ] حالة الطلب تتحدث
- [ ] إشعار يُرسل للعميل

#### 5. لوحة التحكم (Admin)
- [ ] تسجيل دخول Admin
- [ ] عرض Dashboard
- [ ] إضافة منتج جديد
- [ ] رفع صورة للمنتج
- [ ] تعديل منتج
- [ ] حذف منتج
- [ ] إضافة تصنيف جديد
- [ ] عرض الطلبات
- [ ] تحديث حالة طلب
- [ ] عرض العملاء
- [ ] إضافة/تعديل coupon

#### 6. API Endpoints
- [ ] `GET /api/v1/products` - يرجع منتجات
- [ ] `GET /api/v1/categories` - يرجع تصنيفات
- [ ] `POST /api/v1/register` - تسجيل مستخدم
- [ ] `POST /api/v1/login` - تسجيل دخول
- [ ] `POST /api/v1/cart/add` - إضافة للسلة
- [ ] `POST /api/v1/checkout` - إنشاء طلب
- [ ] Rate limiting يعمل (5 محاولات login)

---

### ✅ Error Handling

اختبار الأخطاء:

1. [ ] صفحة 404 تظهر بشكل صحيح
2. [ ] صفحة 500 تظهر بشكل صحيح (بدون كشف تفاصيل حساسة)
3. [ ] Form validation errors تظهر بشكل واضح
4. [ ] API errors ترجع بصيغة JSON صحيحة
5. [ ] Database connection error يُعالج

---

## المراقبة - Monitoring

### ✅ Logging

**التحقق من Logs:**
```bash
tail -f storage/logs/laravel.log
```

- [ ] Logs تُكتب بشكل صحيح
- [ ] لا أخطاء حرجة
- [ ] مستوى الـ log صحيح (error/warning)

---

### ✅ Failed Jobs

**التحقق من Failed Jobs:**
```bash
php artisan queue:failed
```

- [ ] لا توجد failed jobs
- [ ] إذا وجدت، تحليلها وإصلاحها

**إعادة محاولة failed jobs:**
```bash
php artisan queue:retry all
```

---

### ✅ Database Backup

**تفعيل Automatic Backups:**

**cPanel:**
- [ ] تفعيل automatic backups في cPanel

**VPS:**
إضافة cron job:
```bash
0 2 * * * mysqldump -u username -p'password' database > /backups/db_$(date +\%Y\%m\%d).sql
```

**التحقق:**
- [ ] Backup يعمل تلقائيًا
- [ ] Backups تُخزن في مكان آمن

---

### ✅ Health Checks

**إنشاء Health Check Endpoint:**

`routes/web.php`:
```php
Route::get('/health', function() {
    return response()->json([
        'status' => 'ok',
        'database' => DB::connection()->getPdo() ? 'connected' : 'disconnected',
        'cache' => Cache::has('health_check') ? 'working' : 'not_working',
        'queue' => Queue::size() !== null ? 'working' : 'not_working',
    ]);
});
```

**التحقق:**
```bash
curl https://yourdomain.com/health
```

- [ ] Status = ok
- [ ] Database = connected
- [ ] Cache = working
- [ ] Queue = working

---

### ✅ Uptime Monitoring

**استخدام خدمات خارجية:**
- [ ] UptimeRobot (مجاني)
- [ ] Pingdom
- [ ] StatusCake

**التكوين:**
- [ ] مراقبة `https://yourdomain.com/health`
- [ ] تنبيهات عبر البريد/SMS عند التوقف

---

## Rollback Plan

### ✅ خطة العودة للإصدار السابق

**إذا حدث خطأ خطير بعد النشر:**

#### 1. Database Rollback
```bash
# استعادة backup
mysql -u username -p database_name < backup_YYYYMMDD_HHMMSS.sql
```

#### 2. Code Rollback
```bash
# إذا كنت تستخدم Git deployment
git reset --hard <previous_commit_hash>
git push origin main --force  # ⚠️ احذر من force push

# أو
git revert <bad_commit_hash>
git push origin main
```

#### 3. Clear Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

#### 4. Restart Services
```bash
# Queue worker
sudo supervisorctl restart laravel-worker:*

# Web server (إذا لزم)
sudo service nginx restart
# أو
sudo service apache2 restart
```

**التحقق:**
- [ ] الموقع يعمل بشكل طبيعي
- [ ] لا أخطاء في logs
- [ ] جميع الوظائف تعمل

---

## 🎯 الملخص النهائي

### قبل الضغط على "Deploy":

- [ ] ✅ جميع الاختبارات نجحت
- [ ] ✅ `.env` مُكوّن بشكل صحيح لـ production
- [ ] ✅ `APP_DEBUG` = false
- [ ] ✅ HTTPS مُفعّل
- [ ] ✅ CORS محدد (لا `*`)
- [ ] ✅ Rate limiting مُفعّل
- [ ] ✅ Database backup موجود
- [ ] ✅ Queue worker يعمل
- [ ] ✅ Payment gateway (Moyasar) مُكوّن في Live mode
- [ ] ✅ SMS service مُكوّن
- [ ] ✅ Monitoring مُفعّل

### بعد النشر:

- [ ] ✅ Smoke tests نجحت
- [ ] ✅ Checkout flow يعمل (COD + Online)
- [ ] ✅ Admin panel يعمل
- [ ] ✅ API endpoints تعمل
- [ ] ✅ Logs نظيفة (لا أخطاء)
- [ ] ✅ Failed jobs فارغة
- [ ] ✅ Health check يرجع "ok"

---

## 📞 جهات الاتصال للدعم

| الخدمة | الدعم |
|--------|-------|
| Moyasar Payment Gateway | support@moyasar.com |
| Taqnyat SMS | support@taqnyat.sa |
| Hosting (cPanel) | hosting provider support |
| Laravel Issues | https://github.com/laravel/laravel/issues |

---

## 📝 ملاحظات إضافية

### بعد النشر الأول:

1. [ ] مراقبة الموقع لمدة 24 ساعة
2. [ ] فحص logs بشكل دوري
3. [ ] مراقبة failed jobs
4. [ ] تحليل performance (response times)
5. [ ] جمع feedback من المستخدمين

### صيانة دورية:

- **يوميًا:**
  - فحص logs
  - مراقبة failed jobs
  - التحقق من uptime

- **أسبوعيًا:**
  - مراجعة database backups
  - تحديث dependencies (composer update)
  - فحص security patches

- **شهريًا:**
  - تحليل performance
  - مراجعة failed jobs patterns
  - تنظيف old logs

---

**🎉 مبروك! نظام Dexter CRM جاهز للإنتاج!**

**آخر تحديث:** 2025-10-30  
**المدقق:** AI Code Auditor

