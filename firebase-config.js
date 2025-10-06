// 🔥 إعدادات Firebase - نظام حجز مواعيد أمانة الأحساء
// للحصول على هذه الإعدادات: https://console.firebase.google.com/

import { initializeApp } from 'firebase/app';
import { getFirestore } from 'firebase/firestore';

// ⚠️ يجب تحديث هذه القيم بإعداداتك الحقيقية من Firebase Console
const firebaseConfig = {
  apiKey: "AIzaSyCmv3l8_CKMjP1Wo3G7FpM4f6ox59gQb7g",
  authDomain: "test-one-6c755.firebaseapp.com",
  projectId: "test-one-6c755",
  storageBucket: "test-one-6c755.firebasestorage.app",
  messagingSenderId: "103909985339",
  appId: "1:103909985339:web:e827353eab071a76cca01e",
  measurementId: "G-41VG1LCE5L"
};

// مثال على الإعدادات الصحيحة:
// const firebaseConfig = {
//   apiKey: "AIzaSyAbCdEfGhIjKlMnOpQrStUvWxYz1234567",
//   authDomain: "alahsa-appointments.firebaseapp.com",
//   projectId: "alahsa-appointments", 
//   storageBucket: "alahsa-appointments.appspot.com",
//   messagingSenderId: "123456789012",
//   appId: "1:123456789012:web:abcdef1234567890123456"
// };

// تهيئة Firebase
const app = initializeApp(firebaseConfig);
const db = getFirestore(app);

// تصدير قاعدة البيانات للاستخدام في الصفحات
export { db };