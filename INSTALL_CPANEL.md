# 📦 دليل التثبيت على cPanel - متجر لُجين

## ✅ المتطلبات

- cPanel hosting مع PHP 8.1 أو أعلى
- MySQL 5.7 أو أعلى
- Composer
- SSH Access (اختياري لكن موصى به)

## 🚀 خطوات التثبيت

### 1. رفع الملفات

```bash
# رفع جميع الملفات عبر FTP أو File Manager إلى:
/home/username/public_html/
```

**ملاحظة:** تأكد من رفع الملفات بما فيها مجلد `vendor` (أو قم بتشغيل `composer install` على السيرفر)

### 2. إعداد قاعدة البيانات

1. افتح **cPanel > MySQL Databases**
2. أنشئ قاعدة بيانات جديدة: `username_lujain`
3. أنشئ مستخدم قاعدة بيانات
4. امنح المستخدم صلاحيات كاملة على قاعدة البيانات

### 3. إعداد ملف .env

1. في **cPanel > File Manager**، افتح ملف `.env`
2. عدّل الإعدادات التالية:

```env
APP_NAME="لُجين"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=username_lujain
DB_USERNAME=username_dbuser
DB_PASSWORD=your_password

# إعدادات أخرى
ADMIN_EMAIL=admin@lujaiin.sa
ADMIN_PASSWORD=password
```

### 4. تثبيت عبر SSH (موصى به)

```bash
# الاتصال بالسيرفر
ssh username@yourdomain.com

# الانتقال للمجلد
cd ~/public_html

# تثبيت الاعتماديات
composer install --optimize-autoloader --no-dev

# توليد مفتاح التطبيق
php artisan key:generate

# ربط التخزين
php artisan storage:link

# تشغيل الهجرات
php artisan migrate --force

# إنشاء حساب الأدمن
php artisan db:seed --class=PermissionSeeder
php artisan db:seed --class=AdminUserSeeder
php artisan db:seed --class=SettingSeeder

# تنظيف الذاكرة
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 5. إعداد الصلاحيات

```bash
# تعيين الصلاحيات الصحيحة
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage
```

### 6. إعدادات cPanel إضافية

#### تحديث PHP Version
1. **cPanel > Select PHP Version**
2. اختر PHP 8.1 أو أعلى

#### إعدادات Apache (.htaccess موجود تلقائياً)

إذا لم يظهر .htaccess في مجلد `public`، أنشئه:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

#### إعداد Cron Jobs
1. **cPanel > Cron Jobs**
2. أضف المهام التالية:

```bash
# تنظيف الطلبات القديمة (يومياً)
0 2 * * * /usr/local/bin/php /home/username/public_html/artisan schedule:run >> /dev/null 2>&1
```

### 7. التحقق من التثبيت

1. افتح الموقع: `https://yourdomain.com`
2. تحقق من صفحة API: `https://yourdomain.com/api/v1/products`
3. سجل دخول كأدمن من: `https://yourdomain.com/admin/login`

## 🔐 بيانات الدخول الافتراضية

بعد التثبيت، استخدم:

- **البريد الإلكتروني:** القيمة من `ADMIN_EMAIL` في `.env`
- **كلمة المرور:** القيمة من `ADMIN_PASSWORD` في `.env`

**⚠️ مهم:** غير كلمة المرور مباشرة بعد أول تسجيل دخول!

## 📱 الربط مع التطبيق

استخدم التوثيق الكامل في: `API_DOCUMENTATION.md`

**Base URL:** `https://yourdomain.com/api/v1`

## 🆘 استكشاف الأخطاء

### خطأ 500
- تحقق من ملف `.env` وصحته
- تحقق من صلاحيات المجلدات `storage` و `bootstrap/cache`
- راجع ملف `storage/logs/laravel.log`

### خطأ في قاعدة البيانات
- تأكد من بيانات الاتصال في `.env`
- تأكد من أن قاعدة البيانات موجودة ومستخدمها له صلاحيات

### مشاكل في الصور
- تأكد من وجود symlink: `php artisan storage:link`
- تحقق من صلاحيات `storage/app/public`

## ✅ قائمة التحقق النهائية

- [ ] جميع الملفات مرفوعة
- [ ] قاعدة البيانات منشأة ومتصلة
- [ ] ملف `.env` معدّل بشكل صحيح
- [ ] الاعتماديات مثبتة (`composer install`)
- [ ] الهجرات تم تشغيلها
- [ ] حساب الأدمن منشأ
- [ ] الصلاحيات مضبوطة
- [ ] الموقع يعمل بشكل صحيح
- [ ] API يعمل بشكل صحيح

---

**تم التثبيت بنجاح! 🎉**

