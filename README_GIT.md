# 📦 دليل رفع المشروع على Git

## 🚀 خطوات رفع المشروع على GitHub/GitLab

### 1. تهيئة Git (إذا لم يكن موجود)

```bash
cd lujain
git init
```

### 2. إضافة جميع الملفات

```bash
git add .
```

### 3. إنشاء Commit أولي

```bash
git commit -m "Initial commit: Lujain E-Commerce Platform"
```

### 4. ربط المشروع بـ Remote Repository

#### إذا كان لديك مستودع على GitHub:

```bash
# إنشاء مستودع جديد على GitHub أولاً من الموقع
# ثم ربطه:
git remote add origin https://github.com/YOUR_USERNAME/lujain.git
```

#### أو إذا كان على GitLab:

```bash
git remote add origin https://gitlab.com/YOUR_USERNAME/lujain.git
```

### 5. رفع الكود

```bash
# أول مرة
git push -u origin main

# أو إذا كان اسم الفرع master
git push -u origin master
```

### 6. التحقق

```bash
# التحقق من الـ remote
git remote -v

# التحقق من الحالة
git status
```

## 📋 ملاحظات مهمة

### ✅ ما سيتم رفعه:
- ✅ جميع ملفات الكود
- ✅ ملفات التكوين (config/)
- ✅ ملفات الهجرة (migrations/)
- ✅ ملفات Seeder
- ✅ ملفات Views
- ✅ ملفات Routes
- ✅ ملفات التوثيق (.md)
- ✅ composer.json و composer.lock

### ❌ ما لن يتم رفعه (في .gitignore):
- ❌ ملف `.env` (ملف البيئة - حساس!)
- ❌ مجلد `vendor/` (سيتم تثبيته على السيرفر)
- ❌ مجلد `node_modules/` (إن وجد)
- ❌ ملفات الـ cache
- ❌ ملفات الـ logs
- ❌ الصور المرفوعة (في storage/)

## 🔐 أمان مهم جداً!

### قبل الرفع:
1. ✅ تأكد من أن `.env` في `.gitignore`
2. ✅ تأكد من عدم وجود بيانات حساسة في الكود
3. ✅ استخدم `env.example` فقط

### على السيرفر بعد الرفع:
1. إنشاء ملف `.env` من `env.example`
2. تحديث البيانات الحساسة:
   - `APP_KEY`
   - `DB_PASSWORD`
   - `MOYASAR_SECRET_KEY`
   - أي مفاتيح API أخرى

## 🛠️ أوامر مفيدة

### عرض الملفات التي سيتم رفعها:
```bash
git status
```

### عرض الملفات التي ستُتجاهل:
```bash
git status --ignored
```

### إضافة ملف محدد:
```bash
git add filename.php
```

### إزالة ملف من الـ staging:
```bash
git reset HEAD filename.php
```

### عرض التغييرات:
```bash
git diff
```

## 📝 Commit Messages جيدة

```bash
git commit -m "Add: إضافة نظام إدارة المنتجات"
git commit -m "Fix: إصلاح مشكلة تسجيل الدخول"
git commit -m "Update: تحديث التوثيق"
git commit -m "Remove: حذف الملفات المؤقتة"
```

## 🔄 العمل مع فرعين (Branches)

### إنشاء فرع جديد:
```bash
git checkout -b develop
```

### تبديل الفرع:
```bash
git checkout main
git checkout develop
```

### دمج الفرع:
```bash
git checkout main
git merge develop
```

## 📤 مشاركة مع الاستضافة

بعد رفع الكود على GitHub/GitLab:

1. أعط المستضيف رابط المستودع
2. المستضيف سيقوم بـ:
   ```bash
   git clone https://github.com/YOUR_USERNAME/lujain.git
   cd lujain
   composer install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate --seed
   ```

---

**✅ جاهز للرفع! 🚀**

