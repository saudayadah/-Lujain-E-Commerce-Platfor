{{-- Mobile Compatibility Enhancements - Global --}}
<style>
/* ============================================
   📱 Mobile Compatibility - Global Enhancements
   ============================================ */

/* Base Mobile Improvements */
@media (max-width: 768px) {
    /* تحسين الخطوط والقراءة */
    body {
        font-size: 14px;
        -webkit-text-size-adjust: 100%;
        -moz-text-size-adjust: 100%;
        text-size-adjust: 100%;
    }
    
    /* منع التكبير التلقائي في حقول الإدخال (iOS) */
    input[type="text"],
    input[type="tel"],
    input[type="email"],
    input[type="password"],
    input[type="number"],
    input[type="search"],
    textarea,
    select {
        font-size: 16px !important;
        -webkit-appearance: none;
        appearance: none;
    }
    
    /* تحسين الأزرار للجوال */
    button,
    .btn,
    a.btn,
    input[type="submit"],
    input[type="button"] {
        min-height: 44px;
        min-width: 44px;
        touch-action: manipulation;
        -webkit-tap-highlight-color: rgba(16, 185, 129, 0.2);
        cursor: pointer;
    }
    
    /* تحسين الروابط */
    a {
        -webkit-tap-highlight-color: rgba(16, 185, 129, 0.1);
        touch-action: manipulation;
    }
    
    /* تحسين الصور */
    img {
        max-width: 100%;
        height: auto;
        display: block;
    }
    
    /* منع التمرير الأفقي */
    body, html {
        overflow-x: hidden;
        width: 100%;
    }
    
    /* تحسين الجداول */
    table {
        width: 100%;
        display: block;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    /* تحسين النماذج */
    form {
        width: 100%;
    }
    
    /* تحسين الحاويات */
    .container {
        width: 100%;
        max-width: 100%;
        padding-left: 0.75rem;
        padding-right: 0.75rem;
        box-sizing: border-box;
    }
    
    /* تحسين العناوين */
    h1 {
        font-size: 1.5rem;
        line-height: 1.3;
        word-wrap: break-word;
    }
    
    h2 {
        font-size: 1.25rem;
        line-height: 1.3;
        word-wrap: break-word;
    }
    
    h3 {
        font-size: 1.125rem;
        line-height: 1.4;
        word-wrap: break-word;
    }
    
    /* تحسين النصوص الطويلة */
    p {
        word-wrap: break-word;
        hyphens: auto;
        -webkit-hyphens: auto;
        -moz-hyphens: auto;
    }
    
    /* تحسين القوائم */
    ul, ol {
        padding-right: 1.25rem;
    }
    
    /* تحسين Cards */
    .card {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }
    
    /* تحسين Grids */
    .grid,
    .product-grid-modern {
        width: 100%;
        box-sizing: border-box;
    }
}

/* Very Small Mobile (iPhone SE, etc.) */
@media (max-width: 375px) {
    .container {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    
    h1 {
        font-size: 1.25rem;
    }
    
    h2 {
        font-size: 1.125rem;
    }
    
    .btn {
        font-size: 0.8125rem;
        padding: 0.75rem 1rem;
    }
}

/* Landscape Mobile */
@media (max-width: 768px) and (orientation: landscape) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .product-grid-modern {
        grid-template-columns: repeat(3, 1fr) !important;
    }
}

/* تحسين الأداء للجوال */
@media (max-width: 768px) {
    * {
        -webkit-tap-highlight-color: rgba(16, 185, 129, 0.1);
        -webkit-touch-callout: none;
    }
    
    /* تحسين التمرير */
    * {
        -webkit-overflow-scrolling: touch;
    }
    
    /* تحسين الصور */
    img {
        image-rendering: -webkit-optimize-contrast;
        image-rendering: crisp-edges;
    }
    
    /* منع اختيار النص في العناصر التفاعلية */
    button,
    .btn,
    a.btn {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
}
</style>

