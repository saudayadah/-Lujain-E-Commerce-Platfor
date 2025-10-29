# 🔄 دليل العمل مع Git - تحديث الكود ومقارنة النسخ

## 📝 1. معرفة ما تم تعديله

### ✅ عرض الملفات المعدلة:
```bash
cd C:\Users\LENOVO\Desktop\lujain\lujain
git status
```

**ماذا سترى:**
```
modified:   app/Models/Product.php       # ملف معدل
new file:   app/NewFile.php             # ملف جديد
deleted:    app/OldFile.php             # ملف محذوف
```

### ✅ عرض الفروقات في الملفات:
```bash
# عرض الفروقات في ملف محدد
git diff app/Models/Product.php

# عرض جميع الفروقات
git diff

# عرض الفروقات مع الألوان (أوضح)
git diff --color
```

### ✅ عرض ملخص سريع للتغييرات:
```bash
git status --short
```

---

## 📤 2. تحديث الكود على GitHub

### الخطوة 1: إضافة الملفات المعدلة
```bash
# إضافة ملف محدد
git add app/Models/Product.php

# إضافة جميع الملفات المعدلة
git add .

# إضافة الملفات المعدلة فقط (ليس الجديدة)
git add -u
```

### الخطوة 2: إنشاء Commit
```bash
# Commit بسيط
git commit -m "Fix: إصلاح مشكلة في Product model"

# Commit مفصل
git commit -m "Add: إضافة خاصية جديدة للمنتجات" -m "تفاصيل إضافية..."
```

### الخطوة 3: رفع التغييرات
```bash
git push origin master
```

---

## 📊 3. مقارنة النسخ والفروقات

### ✅ مقارنة مع آخر Commit:
```bash
# عرض آخر تغييرات
git diff HEAD

# مقارنة ملف محدد
git diff HEAD app/Models/Product.php
```

### ✅ مقارنة بين Commit محدد:
```bash
# عرض قائمة جميع Commits
git log --oneline

# مقارنة بين commit محدد والآخر
git diff 621a411 fa2ad60

# مقارنة بين commit محدد وآخر commit
git diff 621a411 HEAD
```

### ✅ عرض تفاصيل Commit محدد:
```bash
# عرض تفاصيل commit
git show fa2ad60

# عرض ملفات التي تغيرت في commit
git show --name-only fa2ad60

# عرض الفروقات في commit
git show fa2ad60
```

### ✅ عرض سجل التغييرات:
```bash
# عرض جميع Commits
git log

# عرض Commits بشكل مختصر
git log --oneline

# عرض Commits مع رسوم بيانية
git log --oneline --graph --all

# عرض آخر 5 commits
git log --oneline -5

# عرض Commits لملف محدد
git log --oneline app/Models/Product.php
```

---

## 🔍 4. أمثلة عملية

### مثال 1: تعديل ملف واحد ورفعه
```bash
# 1. تعديل الملف (مثلاً: app/Models/Product.php)

# 2. عرض التغييرات
git diff app/Models/Product.php

# 3. إضافة الملف
git add app/Models/Product.php

# 4. إنشاء commit
git commit -m "Fix: إصلاح مشكلة في Product model"

# 5. رفع التغييرات
git push origin master
```

### مثال 2: تعديل عدة ملفات
```bash
# 1. تعديل عدة ملفات

# 2. عرض جميع التغييرات
git status

# 3. إضافة جميع التغييرات
git add .

# 4. إنشاء commit
git commit -m "Update: تحديث عدة ملفات في المنتجات"

# 5. رفع التغييرات
git push origin master
```

### مثال 3: إضافة ملف جديد وحذف آخر
```bash
# 1. إضافة ملف جديد وحذف آخر

# 2. عرض التغييرات
git status

# 3. إضافة جميع التغييرات
git add .

# 4. إنشاء commit
git commit -m "Refactor: إعادة هيكلة الملفات"

# 5. رفع التغييرات
git push origin master
```

---

## 📋 5. أنواع Commit Messages (أفضل الممارسات)

```bash
# إضافة ميزة جديدة
git commit -m "Add: إضافة نظام التقييمات"

# إصلاح خطأ
git commit -m "Fix: إصلاح مشكلة تسجيل الدخول"

# تحديث/تحسين
git commit -m "Update: تحديث تصميم لوحة التحكم"

# إزالة كود
git commit -m "Remove: حذف ملفات غير مستخدمة"

# إعادة هيكلة
git commit -m "Refactor: تحسين كود AdminProductController"

# توثيق
git commit -m "Docs: تحديث README.md"
```

---

## 🔄 6. التراجع عن التغييرات (إن أخطأت)

### ❌ إلغاء التغييرات في ملف (قبل git add):
```bash
git checkout -- app/Models/Product.php
```

### ❌ إلغاء جميع التغييرات:
```bash
git checkout .
```

### ❌ إلغاء إضافة ملف (بعد git add، قبل commit):
```bash
git reset HEAD app/Models/Product.php
```

### ❌ تعديل آخر commit (قبل push):
```bash
# تعديل رسالة Commit
git commit --amend -m "رسالة جديدة"

# إضافة ملف نسيت إضافته
git add forgotten_file.php
git commit --amend --no-edit
```

---

## 📦 7. العمل مع الأفرع (Branches) - اختياري

### إنشاء فرع جديد للتجربة:
```bash
# إنشاء فرع جديد
git checkout -b feature/new-feature

# العمل على الفرع
# ... تعديلات ...

# رفع الفرع
git push origin feature/new-feature

# العودة للفرع الرئيسي
git checkout master

# دمج الفرع
git merge feature/new-feature
```

---

## 📝 8. قائمة أوامر سريعة

```bash
# عرض الحالة
git status

# عرض التغييرات
git diff

# إضافة جميع الملفات
git add .

# Commit
git commit -m "وصف التغييرات"

# رفع
git push origin master

# عرض سجل Commits
git log --oneline

# عرض تفاصيل Commit
git show COMMIT_ID
```

---

## ✅ 9. مثال كامل عملي

```bash
# 1. عرض ما تم تعديله
cd C:\Users\LENOVO\Desktop\lujain\lujain
git status

# 2. عرض الفروقات
git diff

# 3. إضافة التغييرات
git add .

# 4. التحقق من ما تم إضافته
git status

# 5. إنشاء Commit
git commit -m "Add: إضافة خاصية جديدة للمنتجات"

# 6. عرض آخر commit
git log -1

# 7. رفع التغييرات
git push origin master
```

---

## 🆘 10. حل المشاكل الشائعة

### مشكلة: "Your branch is ahead of origin/master"
**الحل:** ببساطة ارفع التغييرات:
```bash
git push origin master
```

### مشكلة: "Updates were rejected"
**الحل:** شخص آخر رفع تغييرات. اسحب التحديثات أولاً:
```bash
git pull origin master
git push origin master
```

### مشكلة: "Merge conflict"
**الحل:** Git سيعلمك بالملفات المتضاربة. حلها يدوياً ثم:
```bash
git add .
git commit -m "Fix: حل تضارب الملفات"
git push origin master
```

---

**✅ الآن تعرف كيف تتعامل مع Git! جربها بنفسك! 🚀**

