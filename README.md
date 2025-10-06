# نظام المواعيد - أمانة الأحساء
## Appointments System - Al-Ahsa Municipality

نظام إلكتروني متكامل لإدارة المواعيد بين المواطنين وأمانة الأحساء، مصمم بألوان وتدرجات مستلهمة من موقع فرص.

## 🌟 المميزات

### للمواطنين:
- ✅ واجهة مستخدم عربية بسيطة وجذابة
- ✅ حجز المواعيد بسهولة ويسر
- ✅ تأكيد الهوية عبر رمز SMS (محاكاة)
- ✅ عرض الإحصائيات العامة
- ✅ تصميم متجاوب يعمل على جميع الأجهزة

### للإدارة:
- ✅ لوحة تحكم شاملة للإدارة
- ✅ عرض إحصائيات تفصيلية
- ✅ فلاتر بحث متقدمة
- ✅ إدارة المواعيد (موافقة/رفض)
- ✅ إضافة ملاحظات إدارية
- ✅ نظام تسجيل دخول آمن

## 📁 هيكل المشروع

```
appoi_system/
├── api/                     # Backend API
│   ├── config/
│   │   └── database.php     # إعدادات قاعدة البيانات
│   └── index.php           # نقطة دخول الـ API
├── index.html              # الصفحة الرئيسية
├── booking.html            # صفحة حجز المواعيد
├── admin-login.html        # صفحة دخول الإدارة
├── admin-dashboard.html    # لوحة تحكم الإدارة
├── database.sql           # قاعدة البيانات
└── README.md              # هذا الملف
```

## 🚀 طريقة التشغيل

### 1. إعداد قاعدة البيانات
```sql
-- قم بتشغيل محتوى ملف database.sql في phpMyAdmin أو MySQL
-- أو استخدم الأمر التالي:
mysql -u root -p < database.sql
```

### 2. إعداد الخادم المحلي
```bash
# ضع الملفات في مجلد htdocs في XAMPP
# أو استخدم PHP built-in server
cd /path/to/appoi_system
php -S localhost:8000
```

### 3. الوصول للنظام
- **الصفحة الرئيسية**: `http://localhost:8000/index.html`
- **حجز موعد**: `http://localhost:8000/booking.html`
- **دخول الإدارة**: `http://localhost:8000/admin-login.html`

## 🔐 بيانات الدخول للإدارة

```
اسم المستخدم: admin
كلمة المرور: admin123
```

## 🎨 التصميم والألوان

التصميم مستلهم من موقع فرص (https://furas.momah.gov.sa/ar) ويتضمن:

### الألوان الأساسية:
- **الأزرق الأساسي**: `#1e3a8a` - `#3b82f6`
- **الأخضر المميز**: `#10b981` - `#059669`
- **الأصفر التحذيري**: `#f59e0b`
- **الأحمر للتحذيرات**: `#ef4444`

### المميزات التصميمية:
- تدرجات لونية جذابة
- ظلال ناعمة وانتقالات سلسة
- رموز Font Awesome
- خط Cairo للنصوص العربية
- تصميم متجاوب باستخدام Bootstrap 5

## 📱 صفحات النظام

### 1. الصفحة الرئيسية (`index.html`)
- **هيدر**: شعار النظام وروابط التنقل
- **هيرو سكشن**: عنوان ترحيبي ووصف النظام
- **إحصائيات**: عدد المستفيدين والمواعيد
- **عن المنصة**: مقدمة ترحيبية
- **خدماتنا**: عرض الخدمات المتاحة
- **فوتر**: معلومات التواصل وروابط مهمة

### 2. صفحة حجز الموعد (`booking.html`)
- نموذج تفاعلي لحجز المواعيد
- تحقق من صحة البيانات المدخلة
- محاكاة رمز SMS للتأكيد (123456)
- رسائل تأكيد وأخطاء تفاعلية
- تصميم responsive للجوال

### 3. صفحة دخول الإدارة (`admin-login.html`)
- واجهة دخول أنيقة ومحمية
- بيانات تجريبية: admin / admin123
- رسائل خطأ تفاعلية
- تأمين الجلسة باستخدام localStorage

### 4. لوحة تحكم الإدارة (`admin-dashboard.html`)
- إحصائيات شاملة للمواعيد
- جدول تفاعلي للمواعيد
- فلاتر بحث متقدمة:
  - البحث برقم الهوية
  - ترتيب حسب التاريخ
  - فلترة حسب الحالة
- إجراءات الموافقة والرفض
- إضافة ملاحظات إدارية
- عرض تفاصيل كاملة للمواعيد

## 🔧 الـ APIs المتاحة

### GET `/api/statistics`
```json
{
  "data": {
    "total_users": 5,
    "total_appointments": 15,
    "pending_appointments": 8,
    "approved_appointments": 5,
    "rejected_appointments": 2
  }
}
```

### GET `/api/appointments`
```json
{
  "data": [
    {
      "id": 1,
      "national_id": "1234567890",
      "full_name": "أحمد محمد علي",
      "phone_number": "0501234567",
      "appointment_date": "2025-10-10",
      "appointment_reason": "استخراج رخصة بناء",
      "reason_description": "وصف تفصيلي...",
      "status": "pending",
      "admin_notes": null,
      "sms_code": "123456",
      "is_verified": false,
      "created_at": "2025-10-05 10:30:00",
      "updated_at": "2025-10-05 10:30:00"
    }
  ]
}
```

### POST `/api/appointments`
```json
{
  "national_id": "1234567890",
  "full_name": "أحمد محمد علي",
  "phone_number": "0501234567",
  "appointment_date": "2025-10-10",
  "appointment_reason": "استخراج رخصة بناء",
  "reason_description": "وصف تفصيلي للطلب"
}
```

### PUT `/api/appointments/{id}`
```json
{
  "status": "approved",
  "admin_notes": "تم الموافقة على الطلب"
}
```

## 📊 قاعدة البيانات

### جدول المواعيد (`appointments`)
- `id`: معرف فريد
- `national_id`: رقم الهوية الوطنية
- `full_name`: الاسم الكامل
- `phone_number`: رقم الجوال
- `appointment_date`: تاريخ الموعد المطلوب
- `appointment_reason`: سبب الموعد
- `reason_description`: وصف تفصيلي
- `status`: الحالة (pending/approved/rejected)
- `admin_notes`: ملاحظات الإدارة
- `sms_code`: رمز التحقق
- `is_verified`: حالة التحقق
- `created_at`: تاريخ الإنشاء
- `updated_at`: تاريخ آخر تحديث

### جدول الإحصائيات (`statistics`)
- `total_users`: إجمالي المستخدمين
- `total_appointments`: إجمالي المواعيد
- `pending_appointments`: المواعيد في الانتظار
- `approved_appointments`: المواعيد المقبولة
- `rejected_appointments`: المواعيد المرفوضة

## 🎯 المميزات التقنية

### Frontend:
- **HTML5 & CSS3**: هيكل ومظهر حديث
- **Bootstrap 5**: تصميم متجاوب
- **Font Awesome**: رموز احترافية
- **Google Fonts (Cairo)**: خط عربي جميل
- **Vanilla JavaScript**: تفاعل بدون مكتبات إضافية

### Backend:
- **PHP 7.4+**: لغة البرمجة الخلفية
- **PDO**: تعامل آمن مع قاعدة البيانات
- **RESTful API**: تصميم API احترافي
- **JSON Response**: استجابات منسقة

### Database:
- **MySQL**: قاعدة بيانات موثوقة
- **UTF-8**: دعم النصوص العربية
- **Prepared Statements**: حماية من SQL Injection
- **Triggers**: تحديث الإحصائيات تلقائياً

## 🔒 الأمان

- حماية من SQL Injection باستخدام PDO
- تحقق من صحة البيانات في Frontend و Backend
- تسجيل دخول آمن للإدارة
- رسائل خطأ واضحة دون كشف معلومات حساسة

## 📱 الاستجابة (Responsive)

النظام مصمم ليعمل بكفاءة على:
- 💻 أجهزة الكمبيوتر المكتبية
- 💻 أجهزة الكمبيوتر المحمولة
- 📱 الأجهزة اللوحية
- 📱 الهواتف الذكية

## 🎮 كيفية التجربة

1. **للمواطنين**:
   - ادخل إلى الصفحة الرئيسية
   - اضغط "حجز موعد"
   - املأ البيانات المطلوبة
   - استخدم رمز التحقق: `123456`

2. **للإدارة**:
   - ادخل إلى صفحة دخول الإدارة
   - اسم المستخدم: `admin`
   - كلمة المرور: `admin123`
   - استكشف لوحة التحكم والمواعيد

## 🚀 التطوير المستقبلي

- إضافة نظام إشعارات حقيقي
- ربط مع خدمات SMS حقيقية
- إضافة نظام مصادقة ثنائية
- تطوير تطبيق جوال
- إضافة تقارير مفصلة
- نظام حجز مواعيد بتوقيت محدد

## 📞 التواصل والدعم

لأي استفسارات أو مشاكل تقنية:
- 📧 Email: support@alahsa.gov.sa
- 📞 Phone: 013-580-0000
- 🌐 Website: https://alahsa.gov.sa

---

**تم تطوير هذا النظام باستخدام أحدث التقنيات وأفضل الممارسات في البرمجة والتصميم.**

© 2025 أمانة الأحساء - جميع الحقوق محفوظة

```bash
curl -X PUT http://localhost/GroupTask/api/appointments/1 \
  -H "Content-Type: application/json" \
  -d '{ "appointment_date": "2025-10-01", "appointment_reason": "استفسار" }'
```

Response 200:

```json
{ "message": "Appointment updated" }
```

### Database

Expected table `appointments` with columns:
- `id` INT AUTO_INCREMENT PRIMARY KEY
- `national_id` VARCHAR(32)
- `full_name` VARCHAR(255)
- `phone_number` VARCHAR(32)
- `appointment_date` DATE
- `appointment_reason` VARCHAR(255)
- `reason_description` TEXT
- `created_at` DATETIME

Update database credentials in `api/config/database.php` if needed.


