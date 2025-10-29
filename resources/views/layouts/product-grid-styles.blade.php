{{-- Unified Product Grid Styles for All Pages --}}
<style>
/* ============================================
   Unified Product Grid System - Compact & Consistent
   ============================================ */

.product-grid-modern {
    display: grid !important;
    gap: 1.25rem !important;
    width: 100%;
    align-items: stretch !important;
    grid-template-columns: repeat(6, 1fr) !important;
}

/* Desktop Large (> 1400px) - 6 منتجات في الصف */
@media (min-width: 1400px) {
    .product-grid-modern {
        grid-template-columns: repeat(6, 1fr) !important;
        gap: 1.25rem !important;
    }
}

/* Desktop (1200px - 1400px) - 6 منتجات في الصف */
@media (min-width: 1200px) and (max-width: 1399px) {
    .product-grid-modern {
        grid-template-columns: repeat(6, 1fr) !important;
        gap: 1rem !important;
    }
}

/* Desktop Medium (992px - 1199px) - 4 منتجات في الصف */
@media (min-width: 992px) and (max-width: 1199px) {
    .product-grid-modern {
        grid-template-columns: repeat(4, 1fr) !important;
        gap: 0.875rem !important;
    }
}

/* Tablet Large (768px - 991px) - 3 منتجات في الصف */
@media (min-width: 768px) and (max-width: 991px) {
    .product-grid-modern {
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 0.75rem !important;
    }
}

/* Tablet (576px - 767px) - 3 منتجات في الصف */
@media (min-width: 576px) and (max-width: 767px) {
    .product-grid-modern {
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 0.625rem !important;
    }
}

/* Mobile (max-width: 575px) - عمودين */
@media (max-width: 575px) {
    .product-grid-modern {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 0.625rem !important;
    }
}

/* Very Small Mobile (max-width: 375px) - عمودين */
@media (max-width: 375px) {
    .product-grid-modern {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 0.5rem !important;
    }
}

/* ============================================
   Product Card Consistency
   ============================================ */

.product-card-modern {
    width: 100%;
    max-width: 100%;
    margin: 0;
}

/* Ensure all product cards have same height in row */
.product-grid-modern .product-card-modern {
    display: flex;
    flex-direction: column;
}

/* Container Padding Consistency */
.products-container {
    padding: 2rem 0;
}

@media (max-width: 768px) {
    .products-container {
        padding: 1rem 0;
    }
}

/* Grid Alignment */
.product-grid-modern {
    align-items: start;
}

/* Prevent Layout Shift */
.product-image-wrapper {
    aspect-ratio: 1 / 1 !important;
    background: #f9fafb;
    position: relative;
    overflow: hidden;
}

/* Ensure Consistent Card Heights - مثل موقع 3saf */
.product-grid-modern {
    align-items: stretch;
}

.product-card-modern {
    display: flex;
    flex-direction: column;
    min-height: 100%;
    max-width: 100%;
}

/* توحيد أبعاد الصور - إجبار على الشكل المربع */
.product-card-modern .product-image-wrapper {
    aspect-ratio: 1 / 1 !important;
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
}

.product-image-wrapper {
    aspect-ratio: 1 / 1 !important;
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
}

/* ضمان عرض الصور بشكل صحيح */
.product-image-wrapper img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* تحسين المسافات الداخلية */
.product-card-modern .product-info-modern {
    flex-grow: 1;
}
</style>

