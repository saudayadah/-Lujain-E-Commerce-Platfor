@extends('layouts.app')

@section('title', 'إتمام الطلب')

@push('styles')
<style>
/* Mobile-First Checkout Page */
@media (max-width: 768px) {
    .container {
        padding: 1rem 0.75rem !important;
        padding-top: 1.5rem !important;
    }
    
    .container > div:nth-of-type(1) {
        padding: 1.5rem 1rem !important;
        margin-bottom: 1.5rem !important;
    }
    
    .container > div:nth-of-type(1) h1 {
        font-size: 1.5rem !important;
    }
    
    .container > div:nth-of-type(2) {
        grid-template-columns: 1fr !important;
        gap: 1.5rem !important;
    }
    
    .container > div:nth-of-type(2) > div:first-child {
        order: 2;
    }
    
    .container > div:nth-of-type(2) > div:last-child {
        order: 1;
        position: sticky;
        top: 0;
        background: white;
        z-index: 10;
        padding: 1.5rem !important;
        border-radius: 20px 20px 0 0;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.1);
    }
    
    input[type="text"],
    input[type="tel"],
    input[type="email"],
    textarea,
    select {
        font-size: 16px !important; /* يمنع zoom في iOS */
    }
    
    .payment-methods {
        flex-direction: column !important;
        gap: 1rem !important;
    }
    
    .payment-method-card {
        width: 100% !important;
    }
}

#map {
    width: 100%;
    height: 350px;
    border-radius: 12px;
    border: 2px solid var(--gray-200);
    margin-bottom: 1rem;
}

@media (max-width: 768px) {
    #map {
        height: 250px !important;
    }
}

.map-search-box {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid var(--primary);
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 500;
    margin-bottom: 1rem;
    box-shadow: 0 4px 12px rgba(16,185,129,0.1);
}
</style>
@endpush

@section('content')
<div class="container" style="padding-top: 2rem;">
    <!-- Header -->
    <div style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; padding: 2.5rem; border-radius: 20px; margin-bottom: 3rem; text-align: center; box-shadow: 0 10px 30px rgba(16,185,129,0.2);">
        <h1 style="font-size: 2.5rem; font-weight: 900; margin-bottom: 0.5rem;">
            <i class="fas fa-credit-card"></i> إتمام الطلب
        </h1>
        <p style="font-size: 1rem; opacity: 0.9;">
            أدخل بيانات التوصيل واختر طريقة الدفع
        </p>
    </div>

    <form method="POST" action="{{ route('checkout.process') }}">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 450px; gap: 3rem; align-items: start;">
            <!-- Left Column -->
            <div>
                <!-- Shipping Address -->
                <div style="background: white; padding: 2.5rem; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-bottom: 2rem; border: 1px solid var(--gray-200);">
                    <h3 style="font-size: 1.5rem; font-weight: 900; margin-bottom: 2rem; color: var(--dark); display: flex; align-items: center; gap: 0.75rem; padding-bottom: 1rem; border-bottom: 2px solid var(--primary);">
                        <i class="fas fa-map-marker-alt" style="color: var(--primary);"></i>
                        عنوان التوصيل
                    </h3>
                    
                    <div style="display: grid; gap: 1.5rem;">
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark); font-size: 0.9375rem;">
                                <i class="fas fa-user" style="color: var(--primary); margin-left: 0.25rem;"></i>
                                الاسم الكامل
                                <span style="color: var(--danger);">*</span>
                            </label>
                            <input type="text" 
                                   name="shipping_address[name]" 
                                   value="{{ auth()->user()->name }}"
                                   required 
                                   style="width: 100%; padding: 0.875rem 1rem; border: 2px solid var(--gray-200); border-radius: 12px; font-size: 1rem; font-weight: 500; transition: all 0.3s;"
                                   onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 3px rgba(16,185,129,0.1)'"
                                   onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                            @error('shipping_address.name')
                                <span style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark); font-size: 0.9375rem;">
                                <i class="fas fa-phone" style="color: var(--primary); margin-left: 0.25rem;"></i>
                                رقم الجوال
                                <span style="color: var(--danger);">*</span>
                            </label>
                            <input type="tel" 
                                   name="shipping_address[phone]" 
                                   value="{{ auth()->user()->phone }}"
                                   placeholder="05xxxxxxxx"
                                   required 
                                   style="width: 100%; padding: 0.875rem 1rem; border: 2px solid var(--gray-200); border-radius: 12px; font-size: 1rem; font-weight: 500; direction: ltr; text-align: left; transition: all 0.3s;"
                                   onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 3px rgba(16,185,129,0.1)'"
                                   onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                            @error('shipping_address.phone')
                                <span style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Google Maps Location Picker -->
                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark); font-size: 0.9375rem;">
                                <i class="fas fa-map-marker-alt" style="color: var(--primary); margin-left: 0.25rem;"></i>
                                حدد موقعك على الخريطة
                                <span style="color: var(--danger);">*</span>
                            </label>
                            
                            <!-- Current Location Button -->
                            <button type="button" onclick="getCurrentLocation()" style="width: 100%; padding: 0.875rem; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; border: none; border-radius: 12px; font-weight: 700; margin-bottom: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                                <i class="fas fa-location-arrow"></i>
                                استخدام موقعي الحالي
                            </button>
                            
                            <input id="searchBox" 
                                   class="map-search-box" 
                                   type="text" 
                                   placeholder="أو ابحث عن موقعك... (مثال: الرياض، حي النخيل)">
                            
                            <div id="map" style="min-height: 350px;"></div>
                            
                            <input type="hidden" name="shipping_address[latitude]" id="latitude" value="24.7136">
                            <input type="hidden" name="shipping_address[longitude]" id="longitude" value="46.6753">
                            
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem; padding: 0.75rem; background: rgba(16,185,129,0.05); border-radius: 8px;">
                                <i class="fas fa-info-circle" style="color: var(--primary);"></i>
                                <small style="color: var(--primary-dark); font-weight: 600;" id="locationStatus">
                                    انقر على الخريطة أو اسحب العلامة لتحديد موقعك
                                </small>
                            </div>
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark); font-size: 0.9375rem;">
                                <i class="fas fa-home" style="color: var(--primary); margin-left: 0.25rem;"></i>
                                العنوان التفصيلي
                                <span style="color: var(--danger);">*</span>
                            </label>
                            <textarea name="shipping_address[address]" 
                                      id="addressInput"
                                      required 
                                      rows="3" 
                                      placeholder="اسم الحي، اسم الشارع، رقم المبنى، رقم الشقة..."
                                      style="width: 100%; padding: 0.875rem 1rem; border: 2px solid var(--gray-200); border-radius: 12px; font-size: 1rem; font-weight: 500; resize: vertical; transition: all 0.3s;"
                                      onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 3px rgba(16,185,129,0.1)'"
                                      onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'"></textarea>
                            @error('shipping_address.address')
                                <span style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div>
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark); font-size: 0.9375rem;">
                                    <i class="fas fa-city" style="color: var(--primary); margin-left: 0.25rem;"></i>
                                    المدينة
                                    <span style="color: var(--danger);">*</span>
                                </label>
                                <select name="shipping_address[city]" 
                                        required 
                                        style="width: 100%; padding: 0.875rem 1rem; border: 2px solid var(--gray-200); border-radius: 12px; font-size: 1rem; font-weight: 500; cursor: pointer; transition: all 0.3s;"
                                        onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 3px rgba(16,185,129,0.1)'"
                                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                                    <option value="">اختر المدينة</option>
                                    <option value="الرياض">الرياض</option>
                                    <option value="جدة">جدة</option>
                                    <option value="مكة">مكة المكرمة</option>
                                    <option value="المدينة">المدينة المنورة</option>
                                    <option value="الدمام">الدمام</option>
                                    <option value="الخبر">الخبر</option>
                                    <option value="الظهران">الظهران</option>
                                    <option value="تبوك">تبوك</option>
                                    <option value="أبها">أبها</option>
                                    <option value="نجران">نجران</option>
                                    <option value="جيزان">جيزان</option>
                                    <option value="الطائف">الطائف</option>
                                </select>
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark); font-size: 0.9375rem;">
                                    <i class="fas fa-map" style="color: var(--primary); margin-left: 0.25rem;"></i>
                                    المنطقة
                                    <span style="color: var(--danger);">*</span>
                                </label>
                                <input type="text" 
                                       name="shipping_address[region]" 
                                       placeholder="مثال: الرياض، مكة، الشرقية"
                                       required 
                                       style="width: 100%; padding: 0.875rem 1rem; border: 2px solid var(--gray-200); border-radius: 12px; font-size: 1rem; font-weight: 500; transition: all 0.3s;"
                                       onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 3px rgba(16,185,129,0.1)'"
                                       onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                            </div>
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark); font-size: 0.9375rem;">
                                <i class="fas fa-sticky-note" style="color: var(--primary); margin-left: 0.25rem;"></i>
                                ملاحظات إضافية (اختياري)
                            </label>
                            <textarea name="notes" 
                                      rows="2" 
                                      placeholder="أي ملاحظات خاصة بالتوصيل..."
                                      style="width: 100%; padding: 0.875rem 1rem; border: 2px solid var(--gray-200); border-radius: 12px; font-size: 1rem; font-weight: 500; resize: vertical; transition: all 0.3s;"
                                      onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 3px rgba(16,185,129,0.1)'"
                                      onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'"></textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Method -->
                <div style="background: white; padding: 2.5rem; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid var(--gray-200);">
                    <h3 style="font-size: 1.5rem; font-weight: 900; margin-bottom: 2rem; color: var(--dark); display: flex; align-items: center; gap: 0.75rem; padding-bottom: 1rem; border-bottom: 2px solid var(--primary);">
                        <i class="fas fa-money-bill-wave" style="color: var(--primary);"></i>
                        طريقة الدفع
                    </h3>
                    
                    <div style="display: grid; gap: 1.5rem;">
                        <!-- الدفع عند الاستلام -->
                        <label class="payment-option" data-payment="cod" style="padding: 2rem; border: 3px solid var(--primary); border-radius: 16px; cursor: pointer; transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); display: flex; align-items: center; gap: 1.5rem; background: linear-gradient(135deg, rgba(16,185,129,0.05), rgba(16,185,129,0.02)); position: relative; overflow: hidden;">
                            <input type="radio" name="payment_method" value="cod" required checked style="width: 24px; height: 24px; accent-color: var(--primary); cursor: pointer; position: relative; z-index: 2;">
                            <div style="flex: 1; position: relative; z-index: 2;">
                                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.75rem;">
                                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(16,185,129,0.3);">
                                        <i class="fas fa-hand-holding-usd" style="font-size: 1.75rem; color: white;"></i>
                                    </div>
                                    <div>
                                        <strong style="font-size: 1.25rem; color: var(--dark);">الدفع عند الاستلام</strong>
                                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.25rem;">
                                            <span style="background: var(--primary); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">موصى به</span>
                                            <span style="color: var(--primary); font-size: 0.875rem; font-weight: 600;">
                                                <i class="fas fa-shield-alt"></i> آمن 100%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div style="color: var(--gray-700); font-size: 0.9375rem; line-height: 1.6; padding-left: 76px;">
                                    ادفع نقداً عند استلام الطلب في عنوانك. آمن ومريح لجميع العملاء.
                                    <div style="margin-top: 0.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                                        <span style="display: flex; align-items: center; gap: 0.25rem; color: var(--primary); font-size: 0.8125rem;">
                                            <i class="fas fa-truck"></i> توصيل سريع
                                        </span>
                                        <span style="display: flex; align-items: center; gap: 0.25rem; color: var(--primary); font-size: 0.8125rem;">
                                            <i class="fas fa-undo-alt"></i> إرجاع سهل
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="payment-shine"></div>
                        </label>

                        <!-- الدفع الإلكتروني -->
                        <label class="payment-option" data-payment="online" style="padding: 2rem; border: 2px solid var(--gray-200); border-radius: 16px; cursor: pointer; transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); display: flex; align-items: center; gap: 1.5rem; background: white; position: relative; overflow: hidden;">
                            <input type="radio" name="payment_method" value="online" style="width: 24px; height: 24px; accent-color: var(--primary); cursor: pointer; position: relative; z-index: 2;">
                            <div style="flex: 1; position: relative; z-index: 2;">
                                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.75rem;">
                                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(59,130,246,0.3);">
                                        <i class="fas fa-credit-card" style="font-size: 1.75rem; color: white;"></i>
                                    </div>
                                    <div>
                                        <strong style="font-size: 1.25rem; color: var(--dark);">الدفع الإلكتروني</strong>
                                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.25rem;">
                                            <span style="color: #3b82f6; font-size: 0.875rem; font-weight: 600;">
                                                <i class="fas fa-lock"></i> مشفر وآمن
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div style="color: var(--gray-700); font-size: 0.9375rem; line-height: 1.6; padding-left: 76px;">
                                    ادفع بسرعة وأمان باستخدام مدى، فيزا، ماستركارد، أو أبل باي.
                                    <div style="margin-top: 0.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                                        <!-- بطاقات الدفع -->
                                        <div style="display: flex; gap: 0.5rem;">
                                            <div style="width: 40px; height: 28px; background: linear-gradient(135deg, #1a1f71, #3b4b8c); border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem; font-weight: 700;">VISA</div>
                                            <div style="width: 40px; height: 28px; background: linear-gradient(135deg, #eb001b, #ff5f00); border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem; font-weight: 700;">MC</div>
                                            <div style="width: 40px; height: 28px; background: linear-gradient(135deg, #7b1fa2, #9c27b0); border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem; font-weight: 700;">مدى</div>
                                            <div style="width: 40px; height: 28px; background: linear-gradient(135deg, #000000, #333333); border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem; font-weight: 700;">
                                                <i class="fab fa-apple-pay" style="font-size: 1rem;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="payment-shine"></div>
                        </label>

                        <!-- باي بال (جديد) -->
                        <label class="payment-option" data-payment="paypal" style="padding: 2rem; border: 2px solid var(--gray-200); border-radius: 16px; cursor: pointer; transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); display: flex; align-items: center; gap: 1.5rem; background: white; position: relative; overflow: hidden;">
                            <input type="radio" name="payment_method" value="paypal" style="width: 24px; height: 24px; accent-color: var(--primary); cursor: pointer; position: relative; z-index: 2;">
                            <div style="flex: 1; position: relative; z-index: 2;">
                                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.75rem;">
                                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #0070ba, #003087); border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(0, 112, 186, 0.3);">
                                        <i class="fab fa-paypal" style="font-size: 1.75rem; color: white;"></i>
                                    </div>
                                    <div>
                                        <strong style="font-size: 1.25rem; color: var(--dark);">باي بال</strong>
                                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.25rem;">
                                            <span style="color: #0070ba; font-size: 0.875rem; font-weight: 600;">
                                                <i class="fas fa-globe"></i> دولي وآمن
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div style="color: var(--gray-700); font-size: 0.9375rem; line-height: 1.6; padding-left: 76px;">
                                    ادفع بسهولة عبر باي بال مع حماية المشتريات وحماية من الاحتيال.
                                    <div style="margin-top: 0.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                                        <span style="display: flex; align-items: center; gap: 0.25rem; color: var(--primary); font-size: 0.8125rem;">
                                            <i class="fas fa-shield-alt"></i> حماية المشتري
                                        </span>
                                        <span style="display: flex; align-items: center; gap: 0.25rem; color: var(--primary); font-size: 0.8125rem;">
                                            <i class="fas fa-undo-alt"></i> إرجاع سهل
                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="payment-shine"></div>
                        </label>
                        
                        <!-- تحويل بنكي (جديد) -->
                        <label class="payment-option" data-payment="bank" style="padding: 2rem; border: 2px solid var(--gray-200); border-radius: 16px; cursor: pointer; transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); display: flex; align-items: center; gap: 1.5rem; background: white; position: relative; overflow: hidden;">
                            <input type="radio" name="payment_method" value="bank_transfer" style="width: 24px; height: 24px; accent-color: var(--primary); cursor: pointer; position: relative; z-index: 2;">
                            <div style="flex: 1; position: relative; z-index: 2;">
                                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.75rem;">
                                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #059669, #047857); border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(5, 150, 105, 0.3);">
                                        <i class="fas fa-university" style="font-size: 1.75rem; color: white;"></i>
                                    </div>
                                    <div>
                                        <strong style="font-size: 1.25rem; color: var(--dark);">تحويل بنكي</strong>
                                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.25rem;">
                                            <span style="color: #059669; font-size: 0.875rem; font-weight: 600;">
                                                <i class="fas fa-clock"></i> تأكيد يدوي
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div style="color: var(--gray-700); font-size: 0.9375rem; line-height: 1.6; padding-left: 76px;">
                                    حوّل المبلغ مباشرة لحسابنا البنكي. سيتم تأكيد الطلب بعد استلام المبلغ.
                                    <div style="margin-top: 0.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                                        <span style="display: flex; align-items: center; gap: 0.25rem; color: var(--primary); font-size: 0.8125rem;">
                                            <i class="fas fa-file-invoice-dollar"></i> فاتورة رسمية
                                        </span>
                                        <span style="display: flex; align-items: center; gap: 0.25rem; color: var(--primary); font-size: 0.8125rem;">
                                            <i class="fas fa-phone"></i> دعم فني
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="payment-shine"></div>
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Order Summary -->
            <div style="position: sticky; top: 100px;">
                <div style="background: linear-gradient(135deg, white, #f0fdf4); padding: 2.5rem; border-radius: 20px; box-shadow: 0 8px 24px rgba(16,185,129,0.15); border: 2px solid var(--primary-light);">
                    <h3 style="font-size: 1.5rem; font-weight: 900; margin-bottom: 2rem; color: var(--dark); display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-shopping-cart" style="color: var(--primary);"></i>
                        ملخص الطلب
                    </h3>
                    
                    <!-- Items -->
                    <div style="margin-bottom: 2rem; max-height: 300px; overflow-y: auto; padding-left: 0.5rem;">
                        @foreach($cart['items'] as $item)
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid rgba(16,185,129,0.1);">
                            <div style="flex: 1;">
                                <strong style="display: block; color: var(--dark); font-size: 0.9375rem; margin-bottom: 0.25rem;">{{ $item['product']->name_ar }}</strong>
                                <small style="display: block; color: var(--gray-600);">
                                    <i class="fas fa-times" style="font-size: 0.625rem;"></i> {{ $item['quantity'] }} × {{ number_format($item['price'], 2) }} ر.س
                                </small>
                            </div>
                            <span style="font-weight: 700; color: var(--primary); white-space: nowrap; margin-right: 1rem;">{{ number_format($item['line_total'], 2) }} ر.س</span>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Totals -->
                    <div style="background: white; padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem; color: var(--gray-700);">
                            <span>المجموع الفرعي:</span>
                            <span style="font-weight: 700;">{{ number_format($cart['subtotal'], 2) }} ر.س</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px dashed var(--gray-300); color: var(--gray-700);">
                            <span>الضريبة (15%):</span>
                            <span style="font-weight: 700;">{{ number_format($cart['tax'], 2) }} ر.س</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 1.25rem; font-weight: 900; color: var(--primary);">
                            <span>الإجمالي:</span>
                            <span>{{ number_format($cart['total'], 2) }} ر.س</span>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                                    <button type="submit" class="btn btn-confirm-order" style="width: 100%; padding: 1.5rem; font-size: 1.25rem; justify-content: center; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); box-shadow: 0 10px 30px rgba(16,185,129,0.4); font-weight: 800; position: relative; overflow: hidden; border-radius: 16px;" onclick="confirmOrder(this)">
                        <i class="fas fa-check-circle"></i>
                        <span>تأكيد الطلب والدفع</span>
                        <div class="confirm-ripple"></div>
                        <div class="order-success" id="orderSuccess" style="display: none;">
                            <i class="fas fa-check"></i>
                            <span>تم بنجاح!</span>
                        </div>
                    </button>

                    <!-- Security Note -->
                    <div style="text-align: center; margin-top: 1.5rem; padding: 1rem; background: rgba(16,185,129,0.1); border-radius: 8px;">
                        <p style="font-size: 0.8125rem; color: var(--primary-dark); margin: 0; font-weight: 600;">
                            <i class="fas fa-shield-alt" style="margin-left: 0.25rem;"></i>
                            عملية دفع آمنة ومشفرة 100%
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Google Maps API -->
<script>
let map, marker, geocoder, searchBox;
let selectedLat = 24.7136; // Riyadh default
let selectedLng = 46.6753;

// Initialize map when page loads
window.addEventListener('load', function() {
    initMap();
});

function initMap() {
    console.log('Initializing Google Maps...');
    
    // Check if Google Maps is loaded
    if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
        console.error('Google Maps not loaded!');
        document.getElementById('locationStatus').innerHTML = '<i class="fas fa-exclamation-triangle"></i> خطأ في تحميل الخريطة';
        document.getElementById('locationStatus').style.color = '#ef4444';
        return;
    }
    
    // Initialize map
    const mapElement = document.getElementById('map');
    if (!mapElement) {
        console.error('Map element not found!');
        return;
    }
    
    try {
        map = new google.maps.Map(mapElement, {
            center: { lat: selectedLat, lng: selectedLng },
            zoom: 13,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: true,
            zoomControl: true,
            gestureHandling: 'greedy'
        });
        
        console.log('Map initialized successfully');

        // Initialize marker
        marker = new google.maps.Marker({
            position: { lat: selectedLat, lng: selectedLng },
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP,
            title: 'موقعك'
        });

        // Initialize geocoder
        geocoder = new google.maps.Geocoder();
        
        console.log('Marker and geocoder initialized');

        // Add click listener to map
        map.addListener('click', function(e) {
            placeMarker(e.latLng);
        });

        // Add drag listener to marker
        marker.addListener('dragend', function(e) {
            placeMarker(e.latLng);
        });

        // Initialize search box
        const searchBoxElement = document.getElementById('searchBox');
        if (searchBoxElement && google.maps.places) {
            searchBox = new google.maps.places.SearchBox(searchBoxElement);
            
            // Bias search results to map viewport
            map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
            });

            // Listen for search box selection
            searchBox.addListener('places_changed', function() {
                const places = searchBox.getPlaces();
                if (places.length == 0) return;

                const place = places[0];
                if (!place.geometry || !place.geometry.location) return;

                // Move map to selected place
                map.setCenter(place.geometry.location);
                map.setZoom(15);
                
                // Place marker
                placeMarker(place.geometry.location);
                
                // Update address field
                if (place.formatted_address) {
                    document.getElementById('addressInput').value = place.formatted_address;
                }
            });
            
            console.log('Search box initialized');
        }
        
        document.getElementById('locationStatus').innerHTML = '<i class="fas fa-check-circle"></i> الخريطة جاهزة! انقر لتحديد موقعك';
        document.getElementById('locationStatus').style.color = 'var(--primary)';
        
    } catch (error) {
        console.error('Error initializing map:', error);
        document.getElementById('locationStatus').innerHTML = '<i class="fas fa-exclamation-triangle"></i> خطأ في تحميل الخريطة: ' + error.message;
        document.getElementById('locationStatus').style.color = '#ef4444';
    }
}

function getCurrentLocation() {
    if (!navigator.geolocation) {
        alert('المتصفح لا يدعم تحديد الموقع');
        return;
    }
    
    document.getElementById('locationStatus').innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري تحديد موقعك...';
    
    navigator.geolocation.getCurrentPosition(
        function(position) {
            const pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            
            if (map && marker) {
                map.setCenter(pos);
                map.setZoom(16);
                marker.setPosition(pos);
                updateLocationInputs(pos.lat, pos.lng);
                getAddressFromLatLng(pos.lat, pos.lng);
                document.getElementById('locationStatus').innerHTML = '<i class="fas fa-check-circle"></i> تم تحديد موقعك الحالي بنجاح!';
                document.getElementById('locationStatus').style.color = 'var(--primary)';
            }
        },
        function(error) {
            console.error('Geolocation error:', error);
            let errorMsg = 'تعذر تحديد موقعك. ';
            if (error.code === 1) {
                errorMsg += 'الرجاء السماح بالوصول للموقع.';
            } else if (error.code === 2) {
                errorMsg += 'الموقع غير متوفر.';
            } else {
                errorMsg += 'حدث خطأ.';
            }
            document.getElementById('locationStatus').innerHTML = '<i class="fas fa-exclamation-triangle"></i> ' + errorMsg;
            document.getElementById('locationStatus').style.color = '#f59e0b';
            alert(errorMsg);
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        }
    );
}

function placeMarker(location) {
    marker.setPosition(location);
    map.panTo(location);
    updateLocationInputs(location.lat(), location.lng());
    getAddressFromLatLng(location.lat(), location.lng());
    document.getElementById('locationStatus').innerHTML = '<i class="fas fa-check-circle"></i> تم تحديد الموقع بنجاح';
    document.getElementById('locationStatus').style.color = 'var(--primary)';
}

function updateLocationInputs(lat, lng) {
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;
}

function getAddressFromLatLng(lat, lng) {
    geocoder.geocode({ location: { lat: lat, lng: lng } }, function(results, status) {
        if (status === 'OK' && results[0]) {
            // Auto-fill address if empty
            const addressInput = document.getElementById('addressInput');
            if (!addressInput.value) {
                addressInput.value = results[0].formatted_address;
            }
            
            // Extract city if available
            const cityInput = document.querySelector('select[name="shipping_address[city]"]');
            for (let component of results[0].address_components) {
                if (component.types.includes('locality')) {
                    // Try to match with our city options
                    const cityOptions = cityInput.options;
                    for (let option of cityOptions) {
                        if (option.value.includes(component.long_name) || component.long_name.includes(option.value)) {
                            cityInput.value = option.value;
                            break;
                        }
                    }
                }
            }
        }
    });
}

// Enhanced payment options interactions
document.addEventListener('DOMContentLoaded', function() {
    // Payment option selection with animations
    document.querySelectorAll('.payment-option').forEach(option => {
        const radio = option.querySelector('input[type="radio"]');

        option.addEventListener('click', function() {
            // Remove selected state from all options
            document.querySelectorAll('.payment-option').forEach(opt => {
                opt.style.borderColor = 'var(--gray-200)';
                opt.style.background = 'white';
                opt.style.transform = 'scale(1)';
            });

            // Add selected state to clicked option
            this.style.borderColor = 'var(--primary)';
            this.style.background = 'linear-gradient(135deg, rgba(16,185,129,0.05), rgba(16,185,129,0.02))';
            this.style.transform = 'scale(1.02)';

            // Animate payment shine effect
            const shine = this.querySelector('.payment-shine');
            if (shine) {
                shine.style.animation = 'paymentShine 1s ease-in-out';
            }
        });
    });

    // Animate form sections on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.payment-option, .btn-confirm-order').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s ease';
        observer.observe(el);
    });
});

// Confirm order with enhanced animation
function confirmOrder(button) {
    const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
    if (!selectedPayment) {
        showNotification('يرجى اختيار طريقة الدفع', 'error');
        return;
    }

    // Show processing state
    const originalContent = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري معالجة الطلب...';
    button.disabled = true;
    button.style.opacity = '0.8';

    // Create ripple effect
    const ripple = button.querySelector('.confirm-ripple');
    if (ripple) {
        ripple.style.animation = 'confirmRipple 1s ease-out';
    }

    // Simulate payment processing
    setTimeout(() => {
        // Show success state based on payment method
        const successDiv = document.getElementById('orderSuccess');
        if (successDiv) {
            successDiv.style.display = 'flex';
        }

        if (selectedPayment.value === 'cod') {
            button.innerHTML = '<i class="fas fa-hand-holding-usd"></i> سيتم الدفع عند الاستلام';
            button.style.background = 'linear-gradient(135deg, #10b981, #059669)';
        } else if (selectedPayment.value === 'online') {
            button.innerHTML = '<i class="fas fa-credit-card"></i> سيتم التوجيه للدفع الإلكتروني';
            button.style.background = 'linear-gradient(135deg, #3b82f6, #2563eb)';
        } else if (selectedPayment.value === 'paypal') {
            button.innerHTML = '<i class="fab fa-paypal"></i> سيتم التوجيه إلى باي بال';
            button.style.background = 'linear-gradient(135deg, #0070ba, #003087)';
        } else {
            button.innerHTML = '<i class="fas fa-university"></i> سيتم تأكيد التحويل البنكي';
            button.style.background = 'linear-gradient(135deg, #059669, #047857)';
        }

        // Show success notification
        setTimeout(() => {
            showNotification('تم تأكيد الطلب بنجاح! سيتم التواصل معك قريباً', 'success');
        }, 500);

        // Reset after delay (in real app, this would redirect)
        setTimeout(() => {
            button.innerHTML = originalContent;
            button.disabled = false;
            button.style.opacity = '1';
            if (successDiv) {
                successDiv.style.display = 'none';
            }
        }, 3000);

    }, 2000);
}

// Enhanced notification system for checkout
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        left: 50%;
        transform: translateX(-50%);
        background: ${type === 'success' ? 'linear-gradient(135deg, var(--primary), var(--primary-dark))' : type === 'error' ? 'linear-gradient(135deg, #ef4444, #dc2626)' : 'linear-gradient(135deg, var(--accent), #f59e0b)'};
        color: white;
        padding: 1.25rem 2rem;
        border-radius: 16px;
        font-weight: 700;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        z-index: 10000;
        display: flex;
        align-items: center;
        gap: 1rem;
        animation: slideDown 0.3s ease;
        max-width: 90vw;
        backdrop-filter: blur(10px);
    `;

    notification.innerHTML = `
        <div style="width: 24px; height: 24px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'exclamation' : 'info'}" style="font-size: 12px;"></i>
        </div>
        <span>${message}</span>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideUp 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 4000);
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideDown {
        from {
            transform: translateX(-50%) translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }
        to {
            transform: translateX(-50%) translateY(-100%);
            opacity: 0;
        }
    }

    @keyframes paymentShine {
        0% {
            transform: translateX(-100%);
            opacity: 0;
        }
        50% {
            opacity: 1;
        }
        100% {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    @keyframes confirmRipple {
        0% {
            transform: scale(0);
            opacity: 1;
        }
        100% {
            transform: scale(4);
            opacity: 0;
        }
    }

    .payment-shine {
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(16,185,129,0.2), transparent);
        pointer-events: none;
    }

    .confirm-ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.3);
        transform: scale(0);
        animation: confirmRipple 1s ease-out;
        pointer-events: none;
    }

    .order-success {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #10b981;
        color: white;
        padding: 1rem 2rem;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 700;
        animation: orderSuccessPulse 0.6s ease;
    }

    @keyframes orderSuccessPulse {
        0% {
            transform: translate(-50%, -50%) scale(0);
            opacity: 0;
        }
        50% {
            transform: translate(-50%, -50%) scale(1.2);
            opacity: 1;
        }
        100% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }
    }

    /* Enhanced form styling */
    .form-section {
        background: rgba(16,185,129,0.02);
        border: 1px solid rgba(16,185,129,0.1);
        position: relative;
        overflow: hidden;
    }

    .form-section::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, var(--primary), var(--primary-light));
    }
`;
document.head.appendChild(style);

// Add Google Maps styling enhancement
const mapStyle = document.createElement('style');
mapStyle.textContent = `
    .map-container {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        border: 2px solid rgba(16,185,129,0.2);
    }

    .map-search-box {
        border: 2px solid rgba(16,185,129,0.2) !important;
        box-shadow: 0 4px 15px rgba(16,185,129,0.1) !important;
    }

    .map-search-box:focus {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px rgba(16,185,129,0.2) !important;
    }
`;
document.head.appendChild(mapStyle);

</script>

<!-- Load Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8&libraries=places&language=ar" async defer></script>
@endsection
