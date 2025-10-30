# 🚀 دليل Git الشامل - Dexter CRM

## الإعداد السريع

### 1. تنصيب Git
```bash
# تحقق من التنصيب
git --version
```

### 2. الإعداد الأولي
```bash
git config --global user.name "اسمك"
git config --global user.email "your-email@example.com"
```

### 3. ربط المشروع بـ GitHub
```bash
# إنشاء repository محلي
git init

# ربط بـ GitHub
git remote add origin https://github.com/username/dexter-crm.git

# أول commit
git add .
git commit -m "Initial commit"
git push -u origin master
```

---

## الأوامر اليومية

### حفظ التغييرات
```bash
# 1. رؤية التغييرات
git status

# 2. إضافة الملفات
git add .                    # كل الملفات
git add filename.php         # ملف محدد

# 3. عمل commit
git commit -m "وصف التغيير"

# 4. رفع للـ GitHub
git push origin master
```

### سحب التحديثات
```bash
git pull origin master
```

### التراجع عن التغييرات
```bash
# التراجع عن ملف معدل (قبل add)
git restore filename.php

# التراجع عن جميع الملفات
git restore .

# التراجع عن add (بعد add وقبل commit)
git restore --staged filename.php
```

---

## سيناريوهات شائعة

### رفع تحديث سريع
```bash
git add .
git commit -m "تحديثات: [وصف مختصر]"
git push
```

### إنشاء branch جديد
```bash
# إنشاء والانتقال
git checkout -b feature-name

# العمل والـ commit
git add .
git commit -m "الميزة الجديدة"

# دمج في master
git checkout master
git merge feature-name

# حذف الـ branch
git branch -d feature-name
```

### حل التعارضات (Conflicts)
```bash
# 1. سحب التحديثات
git pull

# 2. إذا حدث conflict:
# افتح الملف وحل التعارض
# ابحث عن:
# <<<<<<< HEAD
# كودك
# =======
# كود الآخرين
# >>>>>>> branch-name

# 3. بعد الحل
git add .
git commit -m "حل التعارضات"
git push
```

---

## ملف .gitignore

```gitignore
# Laravel
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.phpunit.result.cache
Homestead.json
Homestead.yaml
npm-debug.log
yarn-error.log

# IDE
.idea
.vscode
*.swp
*.swo
*~

# OS
.DS_Store
Thumbs.db

# Custom
/storage/app/public/*
!/storage/app/public/.gitkeep
```

---

## نصائح مهمة

### ✅ افعل:
- ✅ commit بشكل متكرر
- ✅ رسائل commit واضحة
- ✅ pull قبل push
- ✅ استخدم branches للميزات الكبيرة

### ❌ لا تفعل:
- ❌ لا ترفع ملف .env
- ❌ لا تعمل force push للـ master
- ❌ لا ترفع ملفات كبيرة
- ❌ لا تنسى pull قبل البدء بالعمل

---

## أوامر إضافية مفيدة

```bash
# رؤية السجل
git log --oneline

# رؤية الفروق
git diff

# رؤية الـ branches
git branch -a

# حذف branch محلي
git branch -d branch-name

# تنظيف الملفات غير المتتبعة
git clean -fd

# stash (حفظ مؤقت)
git stash              # حفظ
git stash pop          # استرجاع
git stash list         # عرض القائمة
```

---

**✨ بالتوفيق!**

