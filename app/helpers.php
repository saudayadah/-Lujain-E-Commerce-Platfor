<?php

if (!function_exists('getDefaultProductImage')) {
    /**
     * Get default product image based on product name or category
     *
     * @param string $productName
     * @param string|null $categoryName
     * @return string
     */
    function getDefaultProductImage($productName = '', $categoryName = '')
    {
        // صور افتراضية احترافية للمنتجات
        $defaultImages = [
            // اللحوم والمواشي
            'تيس' => 'https://images.unsplash.com/photo-1589992693983-18628e8a7b48?w=800&h=800&fit=crop&q=80',
            'ماعز' => 'https://images.unsplash.com/photo-1589992693983-18628e8a7b48?w=800&h=800&fit=crop&q=80',
            'خروف' => 'https://images.unsplash.com/photo-1581093588401-fbb62a02f120?w=800&h=800&fit=crop&q=80',
            'خرفان' => 'https://images.unsplash.com/photo-1581093588401-fbb62a02f120?w=800&h=800&fit=crop&q=80',
            'عجل' => 'https://images.unsplash.com/photo-1560493676-04071c5f467b?w=800&h=800&fit=crop&q=80',
            'جمل' => 'https://images.unsplash.com/photo-1591825349588-3e0e4de8d9aa?w=800&h=800&fit=crop&q=80',
            'حاشي' => 'https://images.unsplash.com/photo-1591825349588-3e0e4de8d9aa?w=800&h=800&fit=crop&q=80',
            'لحم' => 'https://images.unsplash.com/photo-1607623488235-e2e0c5c2e8e3?w=800&h=800&fit=crop&q=80',
            'دجاج' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?w=800&h=800&fit=crop&q=80',
            
            // العسل ومنتجات النحل
            'عسل' => 'https://images.unsplash.com/photo-1587049352846-4a222e784794?w=800&h=800&fit=crop&q=80',
            'عسل سدر' => 'https://images.unsplash.com/photo-1558642891-54be180ea339?w=800&h=800&fit=crop&q=80',
            'عسل طبيعي' => 'https://images.unsplash.com/photo-1604340848067-5ac3f1ba62df?w=800&h=800&fit=crop&q=80',
            'عسل أبيض' => 'https://images.unsplash.com/photo-1550062913-14e78dd5e7f7?w=800&h=800&fit=crop&q=80',
            'شمع عسل' => 'https://images.unsplash.com/photo-1568564321589-3e581d074f9b?w=800&h=800&fit=crop&q=80',
            
            // منتجات عضوية
            'عضوي' => 'https://images.unsplash.com/photo-1488459716781-31db52582fe9?w=800&h=800&fit=crop&q=80',
            'طبيعي' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=800&h=800&fit=crop&q=80',
            
            // الخضروات
            'خضروات' => 'https://images.unsplash.com/photo-1597362925123-77861d3fbac7?w=800&h=800&fit=crop&q=80',
            'طماطم' => 'https://images.unsplash.com/photo-1546094096-0df4bcaaa337?w=800&h=800&fit=crop&q=80',
            'خيار' => 'https://images.unsplash.com/photo-1589927986089-35812388d1f4?w=800&h=800&fit=crop&q=80',
            'خس' => 'https://images.unsplash.com/photo-1622206151226-18ca2c9ab4a1?w=800&h=800&fit=crop&q=80',
            'جزر' => 'https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=800&h=800&fit=crop&q=80',
            'بطاطس' => 'https://images.unsplash.com/photo-1518977676601-b53f82aba655?w=800&h=800&fit=crop&q=80',
            'بصل' => 'https://images.unsplash.com/photo-1618512496248-a07fe83aa8cb?w=800&h=800&fit=crop&q=80',
            
            // الفواكه
            'فواكه' => 'https://images.unsplash.com/photo-1610832958506-aa56368176cf?w=800&h=800&fit=crop&q=80',
            'تفاح' => 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?w=800&h=800&fit=crop&q=80',
            'برتقال' => 'https://images.unsplash.com/photo-1547514701-42782101795e?w=800&h=800&fit=crop&q=80',
            'موز' => 'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?w=800&h=800&fit=crop&q=80',
            'عنب' => 'https://images.unsplash.com/photo-1596363505729-4190a9506133?w=800&h=800&fit=crop&q=80',
            'تمر' => 'https://images.unsplash.com/photo-1577003833154-a2e07e90a8b3?w=800&h=800&fit=crop&q=80',
            'رمان' => 'https://images.unsplash.com/photo-1584158825733-5516c1b77a3d?w=800&h=800&fit=crop&q=80',
            
            // البذور
            'بذور' => 'https://images.unsplash.com/photo-1592419044706-39796d40f98c?w=800&h=800&fit=crop&q=80',
            'بذور طماطم' => 'https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=800&h=800&fit=crop&q=80',
            'بذور خيار' => 'https://images.unsplash.com/photo-1523348837708-15d4a09cfac2?w=800&h=800&fit=crop&q=80',
            
            // التوابل والبهارات
            'بهارات' => 'https://images.unsplash.com/photo-1596040033229-a0b7e446fd27?w=800&h=800&fit=crop&q=80',
            'كبسة' => 'https://images.unsplash.com/photo-1599909533947-e6c8e8e4de93?w=800&h=800&fit=crop&q=80',
            'فلفل' => 'https://images.unsplash.com/photo-1518462843371-c9770e37ea12?w=800&h=800&fit=crop&q=80',
            'كركم' => 'https://images.unsplash.com/photo-1615485290382-441e4d049cb5?w=800&h=800&fit=crop&q=80',
            'زعفران' => 'https://images.unsplash.com/photo-1608797178974-15b35a64ede9?w=800&h=800&fit=crop&q=80',
            
            // منتجات الألبان
            'سمن' => 'https://images.unsplash.com/photo-1628088062854-d1870b4553da?w=800&h=800&fit=crop&q=80',
            'لبن' => 'https://images.unsplash.com/photo-1550583724-b2692b85b150?w=800&h=800&fit=crop&q=80',
            'جبن' => 'https://images.unsplash.com/photo-1452195100486-9cc805987862?w=800&h=800&fit=crop&q=80',
            'حليب' => 'https://images.unsplash.com/photo-1563636619-e9143da7973b?w=800&h=800&fit=crop&q=80',
            
            // الزيوت
            'زيت' => 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=800&h=800&fit=crop&q=80',
            'زيت زيتون' => 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=800&h=800&fit=crop&q=80',
            
            // الحبوب
            'قمح' => 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=800&h=800&fit=crop&q=80',
            'أرز' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=800&h=800&fit=crop&q=80',
            'شعير' => 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=800&h=800&fit=crop&q=80',
            
            // منتجات أخرى
            'سماد' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=800&h=800&fit=crop&q=80',
            'أدوات' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=800&h=800&fit=crop&q=80',
        ];

        // البحث عن أقرب تطابق في اسم المنتج
        foreach ($defaultImages as $keyword => $image) {
            if (str_contains($productName, $keyword)) {
                return $image;
            }
        }

        // البحث في اسم الفئة
        if ($categoryName) {
            foreach ($defaultImages as $keyword => $image) {
                if (str_contains($categoryName, $keyword)) {
                    return $image;
                }
            }
        }

        // صورة افتراضية عامة للمنتجات الزراعية
        return 'https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=800&h=800&fit=crop&q=80';
    }
}

