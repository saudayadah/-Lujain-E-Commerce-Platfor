# 🍯 متجر لُجين - متجر العسل والعطارة والبهارات

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)

**متجر إلكتروني سعودي متكامل متخصص في العسل الطبيعي والبهارات والعطارة**

[API Documentation](API_DOCUMENTATION.md) • [Install cPanel](INSTALL_CPANEL.md) • [Deploy Guide](DEPLOY.md)

</div>

---

## 📑 جدول المحتويات

- [نظرة عامة](#-نظرة-عامة)
- [المميزات الرئيسية](#-المميزات-الرئيسية)
- [المتطلبات](#-المتطلبات)
- [التثبيت السريع](#-التثبيت-السريع)
- [بيانات الدخول](#-بيانات-الدخول)
- [الهيكل التقني](#-الهيكل-التقني)
- [لقطات الشاشة](#-لقطات-الشاشة)
- [التوثيق](#-التوثيق)
- [الدعم](#-الدعم)

---

## 🎯 نظرة عامة

**متجر لُجين** هو منصة تجارة إلكترونية سعودية متكاملة ومتقدمة، مصممة خصيصاً لبيع:

- 🍯 **العسل الطبيعي** (سدر، طلح، سمر، شوكة، مانوكا)
- 🌶️ **البهارات والتوابل** (كبسة، مندي، كمون، كركم، قرفة)
- 🌿 **العطارة والأعشاب الطبية** (حبة سوداء، حلبة، زعتر، بابونج)
- 🥜 **المكسرات** (لوز، كاجو، فستق، جوز)
- 🌴 **التمور والفواكه المجففة** (سكري، عجوة، مشمش، تين)
- 🫒 **الزيوت الطبيعية** (زيتون، جوز هند، سمن بلدي)

### 🎨 مبني بأحدث التقنيات
- **Laravel 10** - إطار عمل PHP الأفضل
- **Blade Templates** - قوالب ديناميكية سريعة
- **MySQL 8** - قاعدة بيانات قوية وآمنة
- **REST API** - واجهة برمجية للتطبيقات
- **التصميم المتجاوب** - يعمل على جميع الأجهزة

---

## ✨ المميزات الرئيسية

### 🛒 للعملاء
- ✅ تصفح المنتجات حسب الفئات
- ✅ سلة تسوق ذكية (Guest & Authenticated)
- ✅ نظام كوبونات خصم متقدم
- ✅ قائمة الأمنيات (Wishlist)
- ✅ تتبع الطلبات لحظياً
- ✅ دعم متعدد اللغات (عربي/إنجليزي)
- ✅ بوابات دفع سعودية (Moyasar, SaudiPayments)
- ✅ فواتير ZATCA الإلكترونية
- ✅ إشعارات WhatsApp و SMS
- ✅ حساب شخصي متكامل

### 👨‍💼 لوحة التحكم الإدارية
- 📊 **لوحة تحكم شاملة** - إحصائيات لحظية
- 📦 **إدارة المنتجات** - إضافة/تعديل/حذف مع صور متعددة
- 📁 **إدارة الفئات** - فئات رئيسية وفرعية غير محدودة
- 🛍️ **إدارة الطلبات** - تتبع وتحديث الحالات
- 💳 **إدارة المدفوعات** - تقارير وإحصائيات
- 👥 **إدارة العملاء** - تحليلات وتقسيم ذكي
- 🎫 **الكوبونات** - خصومات نسبية ومبالغ ثابتة
- 📱 **حملات SMS/WhatsApp** - تسويق مباشر
- 📊 **تحليلات متقدمة** - Customer Segmentation
- ⚙️ **الإعدادات** - تحكم كامل في الموقع

### 🔒 الأمان والحماية
- 🔐 مصادقة آمنة مع Laravel Sanctum
- 🛡️ حماية CSRF
- 🔑 تشفير كلمات المرور (Bcrypt)
- 📧 تأكيد البريد الإلكتروني
- 📱 التحقق من رقم الجوال (OTP)
- 🚫 حماية من SQL Injection & XSS

### 📱 متوافق مع الموبايل
- ✅ تصميم متجاوب كامل (Responsive)
- ✅ تحسين الأداء للأجهزة المحمولة
- ✅ REST API جاهز للتطبيقات
- ✅ دعم Progressive Web App (PWA)

---

## 📋 المتطلبات

### متطلبات النظام
```
✅ PHP >= 8.1
✅ MySQL >= 8.0 أو MariaDB >= 10.3
✅ Composer
✅ Node.js & NPM (للـ Assets)
✅ Laravel >= 10.x
```

### الإضافات المطلوبة (PHP Extensions)
```
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
- GD أو Imagick (للصور)
```

---

## 🚀 التثبيت السريع

### 1. استنساخ المشروع
```bash
git clone https://github.com/your-repo/lujain.git
cd lujain
```

### 2. تثبيت الاعتماديات
```bash
# تثبيت مكتبات PHP
composer install

# تثبيت مكتبات Node.js (إن وجدت)
npm install && npm run build
```

### 3. إعداد البيئة
```bash
# نسخ ملف البيئة
cp env.example .env

# توليد مفتاح التطبيق
php artisan key:generate
```

### 4. إعداد قاعدة البيانات
```bash
# تحديث .env بمعلومات قاعدة البيانات
DB_DATABASE=lujain_db
DB_USERNAME=root
DB_PASSWORD=your_password

# تشغيل الهجرات وإنشاء حساب الأدمن
php artisan migrate --seed
```

### 5. إعداد التخزين
```bash
# إنشاء الروابط الرمزية للتخزين
php artisan storage:link

# إعطاء الصلاحيات المناسبة
chmod -R 775 storage bootstrap/cache
```

### 6. تشغيل المشروع
```bash
# تشغيل السيرفر المحلي
php artisan serve

# الآن افتح المتصفح على:
# http://localhost:8000
```

---

## 🔑 بيانات الدخول

### لوحة التحكم الإدارية
بعد تشغيل `php artisan migrate --seed`، يتم إنشاء حساب أدمن واحد:

```
الرابط: http://localhost:8000/admin/login
البريد الإلكتروني: admin@lujaiin.sa
كلمة المرور: password
```

> ⚠️ **مهم:** 
> - يتم إنشاء **حساب أدمن واحد فقط** بعد تشغيل Seeders
> - لا توجد بيانات وهمية (منتجات/فئات)
> - تأكد من تغيير كلمة المرور الافتراضية بعد أول تسجيل دخول!

---

## 🏗️ الهيكل التقني

### معمارية المشروع
```
lujain/
├── app/
│   ├── Http/Controllers/      # المتحكمات
│   │   ├── Admin/            # لوحة التحكم
│   │   ├── Api/              # API Controllers
│   │   └── Auth/             # المصادقة
│   ├── Models/               # النماذج (18 Model)
│   ├── Services/             # الخدمات (13 Service)
│   ├── Events/               # الأحداث
│   ├── Listeners/            # المستمعين
│   └── Notifications/        # الإشعارات
├── database/
│   ├── migrations/           # ملفات الهجرة (26 ملف)
│   └── seeders/              # البيانات التجريبية
├── resources/
│   ├── views/                # القوالب (55 ملف)
│   │   ├── admin/           # واجهات الإدارة
│   │   ├── products/        # صفحات المنتجات
│   │   ├── cart/            # السلة
│   │   └── layouts/         # القوالب الأساسية
│   └── lang/                # الترجمات (AR/EN)
├── routes/
│   ├── web.php              # مسارات الويب
│   ├── api.php              # مسارات API
│   └── auth.php             # مسارات المصادقة
└── config/                   # ملفات التكوين
```

### قاعدة البيانات

#### الجداول الرئيسية (26 جدول)
```sql
users                 -- المستخدمين
categories            -- الفئات (رئيسية وفرعية)
products              -- المنتجات
product_variants      -- المتغيرات
orders                -- الطلبات
order_items           -- عناصر الطلبات
payments              -- المدفوعات
invoices              -- الفواتير (ZATCA)
coupons               -- الكوبونات
wishlists             -- قائمة الأمنيات
campaigns             -- الحملات التسويقية
customer_segments     -- تقسيم العملاء
settings              -- الإعدادات
shipping_zones        -- مناطق الشحن
phone_verifications   -- التحقق من الجوال
```

### الخدمات (Services)
```
CartService              -- إدارة السلة
OrderService             -- إدارة الطلبات
CouponService            -- الكوبونات
PaymentGatewayInterface  -- واجهة بوابات الدفع
MoyasarPaymentGateway    -- بوابة Moyasar
SaudiPaymentGateway      -- البوابات السعودية
InvoiceService           -- ZATCA الفواتير
WhatsAppService          -- إشعارات WhatsApp
SmsService               -- إشعارات SMS
CampaignService          -- الحملات التسويقية
CustomerSegmentService   -- تقسيم العملاء
NotificationService      -- الإشعارات
MetaPixelService         -- تتبع Meta Pixel
ZATCAService             -- خدمة ZATCA
```

---

## 🎨 لقطات الشاشة

### الواجهة الأمامية
```
🏠 الصفحة الرئيسية - عرض المنتجات المميزة والفئات
📂 تصفح حسب الفئات - تصميم Grid احترافي
🛍️ صفحة المنتج - صور متعددة + معلومات تفصيلية
🛒 سلة التسوق - إدارة كاملة + كوبونات
💳 الدفع - بوابات دفع سعودية
👤 الحساب الشخصي - الطلبات والإعدادات
```

### لوحة التحكم
```
📊 Dashboard - إحصائيات شاملة
📦 إدارة المنتجات - جدول مع فلاتر متقدمة
📁 إدارة الفئات - شجرة هرمية
🛍️ الطلبات - تتبع وتحديث
💰 المدفوعات - تقارير مفصلة
👥 العملاء - تحليلات وتقسيم
🎫 الكوبونات - خصومات ذكية
📱 الحملات - SMS & WhatsApp
⚙️ الإعدادات - تخصيص كامل
```

---

## 📚 التوثيق

### الملفات التوثيقية
- 📖 **[README.md](README.md)** - هذا الملف - دليل شامل للمشروع
  - دليل المستخدم
  - دليل المطور
  - دليل لوحة التحكم
  - الأمان والحماية
  - النشر والتشغيل

- 📡 **[API_DOCUMENTATION.md](API_DOCUMENTATION.md)** - توثيق API الكامل للربط مع التطبيق
  - جميع Endpoints (246 endpoint)
  - أمثلة الطلبات والردود
  - المصادقة والتفويض
  - رموز الأخطاء

- 📦 **[INSTALL_CPANEL.md](INSTALL_CPANEL.md)** - دليل التثبيت على cPanel
  - خطوات التثبيت الكاملة
  - إعداد قاعدة البيانات
  - إعدادات الأمان

- 🚀 **[DEPLOY.md](DEPLOY.md)** - دليل النشر والتشغيل
  - خطوات النشر على السيرفر
  - تحسين الأداء
  - استكشاف الأخطاء

### روابط مفيدة
- 🌐 [Laravel Documentation](https://laravel.com/docs)
- 💳 [Moyasar API](https://docs.moyasar.com/)
- 📱 [WhatsApp Business API](https://developers.facebook.com/docs/whatsapp)
- 🧾 [ZATCA E-Invoicing](https://zatca.gov.sa/ar/E-Invoicing)

---

## 🔧 الإعدادات المهمة

### ملف `.env`
```env
# معلومات التطبيق
APP_NAME="متجر لُجين"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://lujain.sa

# قاعدة البيانات
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lujain_db
DB_USERNAME=root
DB_PASSWORD=

# البريد الإلكتروني
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=noreply@lujain.sa

# بوابة الدفع Moyasar
MOYASAR_API_KEY=your_api_key
MOYASAR_SECRET_KEY=your_secret_key

# WhatsApp
WHATSAPP_API_URL=https://graph.facebook.com/v17.0
WHATSAPP_ACCESS_TOKEN=your_token
WHATSAPP_PHONE_NUMBER_ID=your_phone_id

# SMS Gateway
SMS_GATEWAY=twilio
TWILIO_ACCOUNT_SID=your_sid
TWILIO_AUTH_TOKEN=your_token
TWILIO_PHONE_NUMBER=+966xxxxxxxxx
```

---

## 🚀 النشر على السيرفر

### 1. متطلبات السيرفر
```
- VPS أو Shared Hosting مع SSH
- PHP 8.1+ مع الإضافات المطلوبة
- MySQL 8.0+
- Composer مثبت
- SSL Certificate (مجاني عبر Let's Encrypt)
```

### 2. خطوات النشر
```bash
# 1. رفع الملفات
scp -r * user@server:/var/www/lujain

# 2. تثبيت الاعتماديات
cd /var/www/lujain
composer install --optimize-autoloader --no-dev

# 3. تكوين البيئة
cp .env.example .env
nano .env  # تحديث المعلومات

# 4. تجهيز التطبيق
php artisan key:generate
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. الصلاحيات
chown -R www-data:www-data /var/www/lujain
chmod -R 755 /var/www/lujain
chmod -R 775 storage bootstrap/cache
```

### 3. إعداد Nginx
```nginx
server {
    listen 80;
    server_name lujain.sa www.lujain.sa;
    root /var/www/lujain/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## 🔍 اختبار المشروع

### اختبارات يدوية
```bash
# 1. اختبار الصفحة الرئيسية
curl http://localhost:8000

# 2. اختبار API
curl http://localhost:8000/api/v1/products

# 3. اختبار لوحة التحكم
# افتح المتصفح: http://localhost:8000/admin
```

### أوامر مفيدة
```bash
# مسح الكاش
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# إعادة بناء قاعدة البيانات
php artisan migrate:fresh --seed

# مراقبة الأخطاء
tail -f storage/logs/laravel.log
```

---

## 🛠️ الصيانة والتطوير

### Git Workflow
```bash
# نسخ المشروع
git clone https://github.com/your-repo/lujain.git

# إنشاء فرع جديد
git checkout -b feature/new-feature

# حفظ التغييرات
git add .
git commit -m "Add new feature"

# دفع التغييرات
git push origin feature/new-feature
```

### نصائح للتطوير
```
✅ استخدم PSR-12 Coding Standards
✅ اكتب تعليقات واضحة بالعربية أو الإنجليزية
✅ اختبر التغييرات محلياً قبل النشر
✅ احتفظ بنسخة احتياطية من قاعدة البيانات
✅ استخدم Git للتحكم في النسخ
```

---

## 🤝 المساهمة

نرحب بمساهماتكم! إذا كنت ترغب في المساهمة:

1. Fork المشروع
2. أنشئ فرع جديد (`git checkout -b feature/AmazingFeature`)
3. Commit التغييرات (`git commit -m 'Add AmazingFeature'`)
4. Push للفرع (`git push origin feature/AmazingFeature`)
5. افتح Pull Request

---

## 📝 الترخيص

هذا المشروع مرخص تحت رخصة **MIT License** - راجع ملف [LICENSE](LICENSE) للتفاصيل.

---

## 📞 التواصل

- 📧 **البريد الإلكتروني:** info@lujain.sa
- 📱 **الهاتف:** +966 50 123 4567
- 🌐 **الموقع:** https://lujain.sa
- 💬 **الدعم الفني:** support@lujain.sa

---

## 🙏 شكر وتقدير

شكراً لاستخدامكم **متجر لُجين**!

بُني بـ ❤️ في المملكة العربية السعودية 🇸🇦

---

<div align="center">

**[⬆ العودة للأعلى](#-متجر-لجين---متجر-العسل-والعطارة-والبهارات)**

Made with ❤️ using Laravel

</div>
