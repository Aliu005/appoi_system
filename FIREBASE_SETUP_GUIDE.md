# 🔥 دليل إعداد Firebase مع GitHub Pages
## نظام حجز مواعيد أمانة الأحساء

### المتطلبات الأساسية
- حساب Google/Gmail
- حساب GitHub
- متصفح ويب حديث

---

## الخطوة 1: إنشاء مشروع Firebase

### 1.1 الذهاب إلى Firebase Console
```
https://console.firebase.google.com/
```

### 1.2 إنشاء مشروع جديد
1. اضغط على "Create a project" أو "إنشاء مشروع"
2. اكتب اسم المشروع: `alahsa-appointments`
3. (اختياري) فعل Google Analytics
4. اختر منطقة: `us-central1` أو الأقرب لك
5. اضغط "Create project"

### 1.3 إعداد قاعدة البيانات Firestore
1. من القائمة الجانبية، اختر "Firestore Database"
2. اضغط "Create database"
3. اختر "Start in test mode" (للبداية)
4. اختر المنطقة الجغرافية المناسبة
5. اضغط "Enable"

---

## الخطوة 2: إعداد التطبيق Web

### 2.1 إضافة Web App
1. من نظرة عامة المشروع، اضغط رمز `</>`
2. اكتب اسم التطبيق: `alahsa-web-app`
3. ✅ فعل "Firebase Hosting"
4. اضغط "Register app"

### 2.2 نسخ إعدادات Firebase
ستظهر لك إعدادات مشابهة لهذه:
```javascript
const firebaseConfig = {
  apiKey: "AIzaSyXXXXXXXXXXXXXXXXXXXXXXXXXXXXX",
  authDomain: "alahsa-appointments.firebaseapp.com",
  projectId: "alahsa-appointments",
  storageBucket: "alahsa-appointments.appspot.com",
  messagingSenderId: "123456789012",
  appId: "1:123456789012:web:abcdef1234567890"
};
```

**⚠️ احفظ هذه الإعدادات - ستحتاجها في الخطوة التالية!**

---

## الخطوة 3: تحديث ملفات النظام

### 3.1 تحديث firebase-config.js
افتح الملف `firebase-config.js` وضع إعداداتك:

```javascript
// 🔥 إعدادات Firebase - ضع إعداداتك هنا
const firebaseConfig = {
  apiKey: "ضع_مفتاح_API_هنا",
  authDomain: "اسم_مشروعك.firebaseapp.com",
  projectId: "اسم_مشروعك",
  storageBucket: "اسم_مشروعك.appspot.com",
  messagingSenderId: "رقم_المرسل",
  appId: "معرف_التطبيق"
};
```

### 3.2 تحديث جميع ملفات HTML
في كل ملف من الملفات التالية، ابحث عن:
- `index-firebase.html`
- `admin-dashboard-firebase.html`  
- `booking-firebase.html`
- `admin-login-firebase.html`

واستبدل السطر:
```javascript
const firebaseConfig = {
  apiKey: "YOUR_API_KEY_HERE",
  // ...
};
```

بإعداداتك الحقيقية.

---

## الخطوة 4: إعداد قاعدة البيانات

### 4.1 إنشاء المجموعات (Collections)

في Firestore Console، قم بإنشاء:

#### مجموعة `appointments`
```json
{
  "national_id": "1234567890",
  "full_name": "أحمد محمد علي",
  "phone_number": "0501234567",
  "appointment_date": "2024-01-15",
  "appointment_reason": "استخراج رخصة بناء",
  "reason_description": "طلب رخصة بناء منزل سكني",
  "status": "pending",
  "created_at": "2024-01-10T10:30:00.000Z",
  "admin_notes": null
}
```

#### مجموعة `admins`
```json
{
  "username": "admin",
  "password": "admin123",
  "name": "المدير العام",
  "role": "admin",
  "active": true,
  "created_at": "2024-01-01T00:00:00.000Z"
}
```

#### مجموعة `statistics`
```json
{
  "total_appointments": 0,
  "pending_appointments": 0,
  "approved_appointments": 0,
  "rejected_appointments": 0,
  "last_updated": "2024-01-10T00:00:00.000Z"
}
```

### 4.2 إعداد قواعد الأمان (Security Rules)
في Firestore، اذهب إلى "Rules" وضع:

```javascript
rules_version = '2';
service cloud.firestore {
  match /databases/{database}/documents {
    // السماح بالقراءة والكتابة للجميع (للتطوير فقط)
    match /{document=**} {
      allow read, write: if true;
    }
  }
}
```

**⚠️ هذه قواعد للتطوير فقط! للإنتاج، استخدم قواعد أكثر أماناً.**

---

## الخطوة 5: رفع الموقع على GitHub Pages

### 5.1 إنشاء مستودع GitHub
1. اذهب إلى https://github.com
2. اضغط "New repository"
3. اسم المستودع: `alahsa-appointment-system`
4. ✅ اجعله Public
5. ✅ أضف README
6. اضغط "Create repository"

### 5.2 رفع الملفات
```bash
# في PowerShell أو Command Prompt
cd "d:\Coop Training\Task 5\appoi_system"

# تهيئة Git (إذا لم يكن مهيأ)
git init
git add .
git commit -m "Initial commit - Firebase version"

# ربط المستودع
git remote add origin https://github.com/USERNAME/alahsa-appointment-system.git
git branch -M main
git push -u origin main
```

### 5.3 تفعيل GitHub Pages
1. في مستودع GitHub، اذهب إلى "Settings"
2. انزل إلى "Pages"
3. في "Source"، اختر "Deploy from a branch"
4. اختر "main" branch و "/ (root)"
5. اضغط "Save"

سيكون موقعك متاح على:
```
https://USERNAME.github.io/alahsa-appointment-system/
```

---

## الخطوة 6: الاختبار والتشغيل

### 6.1 اختبار الصفحات
- **الصفحة الرئيسية:** `index-firebase.html`
- **حجز موعد:** `booking-firebase.html`  
- **تسجيل دخول الإدارة:** `admin-login-firebase.html`
- **لوحة التحكم:** `admin-dashboard-firebase.html`

### 6.2 بيانات تسجيل الدخول الافتراضية
```
اسم المستخدم: admin
كلمة المرور: admin123
```

---

## الصيانة والتحديث

### تحديث الملفات
```bash
git add .
git commit -m "Update description"
git push
```

### مراقبة الاستخدام
- Firebase Console > Usage
- تحقق من حدود الاستخدام المجاني

### النسخ الاحتياطي
- Firestore > Export data
- احفظ نسخة احتياطية شهرياً

---

## 🎯 الخطوات السريعة

1. **Firebase:** إنشاء مشروع + Firestore + Web App
2. **الكود:** تحديث firebase-config.js بإعداداتك
3. **البيانات:** إنشاء collections مع أمثلة
4. **GitHub:** رفع الملفات + تفعيل Pages
5. **الاختبار:** زيارة الموقع والتأكد من العمل

**الموقع سيعمل مجاناً على GitHub Pages مع قاعدة بيانات Firebase! 🚀**

---

## المساعدة والدعم

### مشاكل شائعة
- **Firebase not defined:** تحقق من تحديث firebase-config.js
- **CORS errors:** تأكد من رفع الملفات على GitHub Pages
- **Database errors:** تحقق من Security Rules في Firestore

### موارد مفيدة
- [Firebase Documentation](https://firebase.google.com/docs)
- [GitHub Pages Guide](https://pages.github.com/)
- [Firestore Guide](https://firebase.google.com/docs/firestore)

**نظامك جاهز للاستخدام! 🎉**