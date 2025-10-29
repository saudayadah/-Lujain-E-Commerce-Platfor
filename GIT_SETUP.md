# 🚀 إعداد Git ورفع المشروع

## ⚙️ 1. إعداد Git (مطلوب أولاً)

قم بتشغيل هذه الأوامر لتحديد هويتك:

```bash
git config --global user.name "Your Name"
git config --global user.email "your.email@example.com"
```

أو محلياً لهذا المشروع فقط:

```bash
cd lujain
git config user.name "Lujain Team"
git config user.email "admin@lujaiin.sa"
```

## 📝 2. إنشاء Commit الأولي

بعد إعداد Git، قم بتشغيل:

```bash
cd lujain
git add .
git commit -m "Initial commit: Lujain E-Commerce Platform - Ready for production"
```

## 🌐 3. إنشاء مستودع على GitHub/GitLab

### GitHub:
1. افتح: https://github.com/new
2. اسم المستودع: `lujain` أو `lujain-ecommerce`
3. اختر Private أو Public
4. **لا** تختر إضافة README أو .gitignore (موجودة بالفعل)
5. انقر "Create repository"

### GitLab:
1. افتح: https://gitlab.com/projects/new
2. نفس الخطوات أعلاه

## 🔗 4. ربط المشروع بالـ Remote

بعد إنشاء المستودع، ستحصل على رابط. استخدمه:

```bash
# للـ HTTPS (موصى به)
git remote add origin https://github.com/YOUR_USERNAME/lujain.git

# أو للـ SSH (إن كنت مكّنت SSH keys)
git remote add origin git@github.com:YOUR_USERNAME/lujain.git
```

## 📤 5. رفع الكود

```bash
# أول مرة
git push -u origin main

# أو إذا كان اسم الفرع master
git push -u origin master
```

## ✅ 6. التحقق

```bash
# التحقق من الـ remote
git remote -v

# عرض آخر commit
git log -1
```

---

## 🆘 استكشاف الأخطاء

### خطأ: "Repository not found"
**الحل:** تأكد من رابط المستودع والص permissions

### خطأ: "Permission denied"
**الحل:**
- للـ HTTPS: ستحتاج إدخال Username و Personal Access Token
- للـ SSH: تأكد من إعداد SSH keys

### خطأ: "Branch main does not exist"
**الحل:** قد يكون اسم الفرع `master`:
```bash
git branch -M main  # تغيير اسم الفرع إلى main
git push -u origin main
```

---

## 📋 قائمة التحقق

- [ ] إعداد Git user.name و user.email
- [ ] إنشاء commit أولي
- [ ] إنشاء مستودع على GitHub/GitLab
- [ ] ربط المشروع بالـ remote
- [ ] رفع الكود
- [ ] التحقق من ظهور الملفات على GitHub/GitLab

---

**بعد الرفع، شارك الرابط مع الاستضافة! 🔗**

