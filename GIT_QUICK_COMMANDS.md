# ⚡ أوامر Git السريعة

## 🔍 عرض التغييرات

```bash
# عرض الملفات المعدلة
git status

# عرض الفروقات في ملف محدد
git diff app/Models/Product.php

# عرض جميع الفروقات
git diff

# عرض آخر 5 commits
git log --oneline -5
```

## 📤 رفع التغييرات (3 خطوات)

```bash
# 1. إضافة
git add .

# 2. Commit
git commit -m "وصف التغييرات"

# 3. رفع
git push origin master
```

## 📊 مقارنة النسخ

```bash
# مقارنة مع آخر commit
git diff HEAD

# مقارنة بين commit محدد
git diff COMMIT1 COMMIT2

# عرض تفاصيل commit
git show COMMIT_ID

# عرض ملفات التي تغيرت في commit
git show --name-only COMMIT_ID
```

## 🔄 التراجع (Undo)

```bash
# إلغاء تعديلات في ملف (قبل git add)
git checkout -- filename.php

# إلغاء إضافة ملف (بعد git add)
git reset HEAD filename.php

# تعديل آخر commit (قبل push)
git commit --amend -m "رسالة جديدة"
```

---

**💡 نصيحة:** استخدم `git status` دائماً قبل `git add` لرؤية ما تم تعديله!

