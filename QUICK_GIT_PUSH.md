# ⚡ دليل سريع لرفع المشروع على Git

## 🎯 الخطوات السريعة

### 1️⃣ إعداد Git (مرة واحدة فقط)
```bash
cd lujain
git config user.name "Your Name"
git config user.email "your@email.com"
```

### 2️⃣ إضافة الملفات و Commit
```bash
git add .
git commit -m "Initial commit: Lujain E-Commerce Platform"
```

### 3️⃣ إنشاء مستودع على GitHub
- افتح: https://github.com/new
- اسم: `lujain-ecommerce`
- اختر Private
- **لا** تضيف README أو .gitignore
- انقر "Create repository"

### 4️⃣ ربط المشروع ورفع الكود
```bash
git remote add origin https://github.com/YOUR_USERNAME/lujain-ecommerce.git
git push -u origin main
```

**إذا كان اسم الفرع `master`:**
```bash
git branch -M main
git push -u origin main
```

---

## ✅ بعد الرفع

1. شارك رابط المستودع مع الاستضافة
2. المستضيف سيقوم بـ:
   ```bash
   git clone https://github.com/YOUR_USERNAME/lujain-ecommerce.git
   cd lujain-ecommerce
   composer install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate --seed
   ```

---

**كل شيء جاهز! 🚀**

