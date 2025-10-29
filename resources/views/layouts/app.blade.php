<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="مؤسسة لُجين الزراعية - متجر متخصص في البذور والأسمدة والمنتجات الزراعية">
    <title>@yield('title', 'لُجين الزراعية - متجرك الموثوق للمنتجات الزراعية')</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- Mobile-First CSS -->
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#059669">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="لُجين">
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    
    <!-- Apple Touch Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">

    <!-- Mobile Compatibility Styles -->
    @include('layouts.mobile-enhancements')

    <style>
        /* Critical CSS - Keep minimal */
        :root {
            --primary: #10b981;
            --primary-dark: #059669;
            --primary-light: #34d399;
            --secondary: #065f46;
            --accent: #fbbf24;
            --dark: #0f172a;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --text: #1f2937;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            --info: #3b82f6;
        }

        /* Critical styles only */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            line-height: 1.6;
            color: var(--text);
            background: #ffffff;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .gradient-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 50%, #f0fdf4 100%);
            z-index: -1;
            opacity: 0.5;
        }

        /* Mobile-first responsive utilities */
        @media (max-width: 768px) {
            .mobile-hidden { display: none !important; }
            .mobile-only { display: block !important; }
            
            /* تحسين الخطوط للجوال */
            body {
                font-size: 14px;
            }
            
            /* تحسين جميع النصوص للجوال */
            * {
                -webkit-tap-highlight-color: rgba(16, 185, 129, 0.1);
            }
            
            /* تحسين العناصر القابلة للنقر */
            a, button, input[type="submit"], input[type="button"] {
                touch-action: manipulation;
                -webkit-tap-highlight-color: rgba(16, 185, 129, 0.1);
            }
            
            /* تحسين حقول الإدخال على iOS */
            input[type="text"],
            input[type="tel"],
            input[type="email"],
            input[type="password"],
            input[type="number"],
            textarea,
            select {
                font-size: 16px; /* يمنع zoom تلقائي في iOS */
                -webkit-appearance: none;
                border-radius: 8px;
            }
            
            /* تحسين الأزرار */
            button, .btn, a.btn {
                min-height: 44px;
                min-width: 44px;
                touch-action: manipulation;
                user-select: none;
                -webkit-user-select: none;
            }
        }

        @media (min-width: 769px) {
            .desktop-only { display: block !important; }
            .mobile-only { display: none !important; }
        }

        /* Gradient Background */
        .gradient-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 50%, #f0fdf4 100%);
            z-index: -1;
            opacity: 0.5;
        }

        /* Floating Elements */
        .floating-element {
            position: absolute;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
            pointer-events: none;
        }

        .floating-element:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            width: 60px;
            height: 60px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .floating-element:nth-child(3) {
            width: 100px;
            height: 100px;
            top: 40%;
            left: 80%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        /* Pulsing Animation */
        .pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }

        /* Glow Effect */
        .glow {
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { box-shadow: 0 0 20px rgba(16, 185, 129, 0.3); }
            to { box-shadow: 0 0 30px rgba(16, 185, 129, 0.5); }
        }

        /* Shimmer Effect */
        .shimmer {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        /* Container */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }
        
        /* Section Styling */
        section {
            margin-bottom: 3rem;
        }
        
        .section-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }
        
        .section-title i {
            color: var(--primary);
            font-size: 1.75rem;
        }

        /* Header - Smart Sticky */
        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border-bottom: 1px solid rgba(16, 185, 129, 0.15);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        /* Header Scrolled State */
        .header.scrolled {
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            transform: translateY(0);
        }
        
        .header.scrolled .header-top {
            max-height: 0;
            padding: 0;
            overflow: hidden;
            transition: all 0.4s ease;
        }
        
        .header.scrolled .header-main {
            padding: 0.5rem 0;
        }
        
        .header.scrolled .nav {
            max-height: 0;
            overflow: hidden;
            padding: 0;
            margin: 0;
            transition: all 0.4s ease;
        }
        
        .header.scrolled .logo {
            font-size: 1.25rem;
            gap: 0.5rem;
        }
        
        .header.scrolled .logo-icon {
            width: 38px;
            height: 38px;
            font-size: 1.25rem;
        }
        
        .header.scrolled .search-input {
            padding: 0.625rem 3rem 0.625rem 1.25rem;
            font-size: 0.875rem;
        }

        .header:hover {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 8px 40px rgba(16, 185, 129, 0.12);
            transform: translateY(-2px);
        }

        .header-top {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 0.375rem 0;
            font-size: 0.75rem;
            position: relative;
            overflow: hidden;
        }

        .header-top::before {
            content: '';
            position: absolute;
            top: 0;
            right: -100%;
            width: 200%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            animation: shimmer 4s infinite ease-in-out;
        }

        .header-top::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 200%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.08), transparent);
            animation: shimmerReverse 5s infinite ease-in-out 1s;
        }

        @keyframes shimmer {
            0% { transform: translateX(0); }
            50% { transform: translateX(50%); }
            100% { transform: translateX(100%); }
        }

        @keyframes shimmerReverse {
            0% { transform: translateX(0); }
            50% { transform: translateX(-50%); }
            100% { transform: translateX(-100%); }
        }

        .header-top .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            position: relative;
            z-index: 1;
        }

        .header-top-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .header-top-links a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            transition: all 0.3s ease;
            font-weight: 400;
            position: relative;
            padding: 0.375rem 0.75rem;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            font-size: 0.75rem;
        }

        .header-top-links a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            transition: left 0.6s ease;
        }

        .header-top-links a:hover::before {
            left: 100%;
        }

        .header-top-links a::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            z-index: -1;
        }

        .header-top-links a:hover::after {
            width: 120%;
            height: 120%;
        }

        .header-top-links a:hover {
            transform: translateY(-4px) scale(1.08);
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }

        .header-top-links a i {
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .header-top-links a span {
            position: relative;
            z-index: 1;
        }

        .header-top-links a:hover i {
            transform: rotate(15deg) scale(1.15);
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }

        /* تأثير نبضي للروابط */
        .header-top-links a:nth-child(1) {
            animation: pulseLink 3s infinite ease-in-out;
        }

        .header-top-links a:nth-child(2) {
            animation: pulseLink 3s infinite ease-in-out 0.5s;
        }

        @keyframes pulseLink {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
            }
            50% {
                box-shadow: 0 0 0 5px rgba(255, 255, 255, 0);
            }
        }

        .header-main {
            padding: 0.625rem 0;
        }

        .header-main .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: var(--dark);
            font-weight: 900;
            font-size: 1.5rem;
            position: relative;
            cursor: pointer;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .logo-icon::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.4), transparent);
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }

        .logo-icon::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent, rgba(255,255,255,0.1));
            border-radius: 18px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .logo:hover .logo-icon::after {
            opacity: 1;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .logo:hover .logo-icon {
            transform: scale(1.1) rotate(8deg);
            box-shadow: 0 16px 45px rgba(16, 185, 129, 0.5);
        }

        .logo-text {
            position: relative;
            background: linear-gradient(135deg, var(--dark), var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: textGradient 3s ease-in-out infinite alternate;
        }

        @keyframes textGradient {
            0% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }

        .search-bar {
            flex: 1;
            max-width: 600px;
            position: relative;
        }

        .search-container {
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 0.875rem 3.5rem 0.875rem 1.5rem;
            border: 2px solid rgba(16, 185, 129, 0.2);
            border-radius: 40px;
            font-size: 0.9375rem;
            transition: all 0.3s ease;
            font-family: 'Tajawal', sans-serif;
            background: #ffffff;
            font-weight: 500;
            box-shadow: 0 2px 12px rgba(16, 185, 129, 0.06);
            position: relative;
            overflow: hidden;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 5px rgba(16, 185, 129, 0.15), 0 8px 30px rgba(16, 185, 129, 0.2);
            background: white;
            transform: translateY(-2px);
        }

        .search-input::placeholder {
            color: var(--gray-500);
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .search-input:focus::placeholder {
            color: var(--gray-400);
        }

        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.2);
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
            margin-top: 8px;
        }

        .search-suggestion {
            padding: 1rem 1.5rem;
            cursor: pointer;
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .search-suggestion:hover {
            background: rgba(16, 185, 129, 0.05);
            padding-left: 2rem;
        }

        .search-suggestion:last-child {
            border-bottom: none;
        }

        .search-suggestion-icon {
            width: 40px;
            height: 40px;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            flex-shrink: 0;
        }

        .search-suggestion-text {
            flex: 1;
        }

        .search-suggestion-name {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .search-suggestion-category {
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .search-filters {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.2);
            padding: 1.5rem;
            z-index: 1000;
            margin-top: 8px;
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .filter-tag {
            padding: 0.5rem 1rem;
            background: rgba(16, 185, 129, 0.1);
            color: var(--primary);
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid rgba(16, 185, 129, 0.2);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-tag:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .search-no-results {
            padding: 2rem;
            text-align: center;
            color: var(--gray-600);
        }

        .search-no-results i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .search-input {
            width: 100%;
            padding: 0.875rem 3.5rem 0.875rem 1.5rem;
            border: 2px solid rgba(16, 185, 129, 0.2);
            border-radius: 40px;
            font-size: 0.9375rem;
            transition: all 0.3s ease;
            font-family: 'Tajawal', sans-serif;
            background: #ffffff;
            font-weight: 500;
            box-shadow: 0 2px 12px rgba(16, 185, 129, 0.06);
            position: relative;
            overflow: hidden;
        }

        .search-input::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(16, 185, 129, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .search-input:focus::before {
            left: 100%;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 5px rgba(16, 185, 129, 0.15), 0 8px 30px rgba(16, 185, 129, 0.2);
            background: white;
            transform: translateY(-2px);
        }

        .search-input::placeholder {
            color: var(--gray-500);
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .search-input:focus::placeholder {
            color: var(--gray-400);
        }

        .search-btn {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            padding: 0.875rem 1.75rem;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            font-weight: 700;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
            position: relative;
            overflow: hidden;
        }

        .search-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .search-btn:hover::before {
            width: 120%;
            height: 120%;
        }

        .search-btn:hover {
            transform: translateY(-50%) scale(1.08);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.4);
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        }

        .search-btn:active {
            transform: translateY(-50%) scale(0.95);
        }

        .search-btn i {
            position: relative;
            z-index: 1;
        }

        .header-actions {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .header-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 1.75rem;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.08));
            border: 2px solid rgba(16, 185, 129, 0.25);
            border-radius: 50px;
            color: var(--dark);
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .header-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(16, 185, 129, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .header-btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            transform: translate(-50%, -50%);
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            z-index: -1;
        }

        .header-btn:hover::before {
            left: 100%;
        }

        .header-btn:hover::after {
            width: 120%;
            height: 120%;
        }

        .header-btn:hover {
            color: white;
            border-color: var(--primary);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 12px 30px rgba(16, 185, 129, 0.4);
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
        }

        .header-btn span {
            position: relative;
            z-index: 1;
        }

        .header-btn i {
            font-size: 1.25rem;
            position: relative;
            z-index: 1;
            transition: transform 0.3s ease;
        }

        .header-btn:hover i {
            transform: rotate(10deg) scale(1.1);
        }

        /* تأثير خاص للسلة */
        .header-actions .header-btn:first-child {
            animation: cartFloat 4s ease-in-out infinite;
        }

        @keyframes cartFloat {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            25% {
                transform: translateY(-3px) rotate(2deg);
            }
            75% {
                transform: translateY(3px) rotate(-2deg);
            }
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            left: -8px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.4);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* Navigation */
        .nav {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98), rgba(248, 250, 252, 0.98));
            border-top: 1px solid rgba(16, 185, 129, 0.15);
            box-shadow: 0 4px 25px rgba(16, 185, 129, 0.08);
            position: relative;
            overflow: hidden;
        }

        .nav::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(16, 185, 129, 0.05), transparent);
            animation: navShine 8s infinite ease-in-out;
        }

        @keyframes navShine {
            0% { left: -100%; }
            50% { left: 100%; }
            100% { left: -100%; }
        }

        .nav .container {
            display: flex;
            gap: 0.5rem;
            overflow-x: auto;
            scrollbar-width: none;
            padding: 0.75rem 0;
            position: relative;
            z-index: 1;
            flex-wrap: wrap;
        }

        .nav::-webkit-scrollbar {
            display: none;
        }

        .nav-link {
            padding: 1rem 1.75rem;
            color: var(--gray-700);
            text-decoration: none;
            font-weight: 600;
            white-space: nowrap;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-radius: 50px;
            position: relative;
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(16, 185, 129, 0.1);
            backdrop-filter: blur(10px);
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            z-index: -1;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            right: 50%;
            width: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            border-radius: 2px;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            box-shadow: 0 2px 10px rgba(16, 185, 129, 0.3);
        }

        .nav-link:hover::before, .nav-link.active::before {
            width: 100%;
            height: 100%;
        }

        .nav-link:hover::after, .nav-link.active::after {
            width: 85%;
            right: 7.5%;
        }

        .nav-link:hover, .nav-link.active {
            color: white;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-color: var(--primary);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        }

        .nav-link:hover i, .nav-link.active i {
            transform: rotate(10deg) scale(1.1);
            color: rgba(255, 255, 255, 0.9);
        }

        .nav-link i {
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }

        .nav-link.admin-link {
            animation: adminPulse 2s infinite;
            position: relative;
            overflow: visible;
        }

        .nav-link.admin-link::after {
            content: '';
            position: absolute;
            top: -5px;
            right: -5px;
            width: 12px;
            height: 12px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            border-radius: 50%;
            animation: adminDot 2s infinite;
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.5);
        }

        @keyframes adminPulse {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(251, 191, 36, 0.7);
            }
            50% {
                box-shadow: 0 0 0 10px rgba(251, 191, 36, 0);
            }
        }

        @keyframes adminDot {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.2);
                opacity: 0.7;
            }
        }


        /* Mobile Menu Styles */
        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 320px;
            height: 100vh;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-left: 1px solid rgba(16, 185, 129, 0.15);
            box-shadow: -10px 0 40px rgba(16, 185, 129, 0.15);
            z-index: 2000;
            transition: right 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            overflow-y: auto;
        }

        .mobile-menu.show {
            right: 0;
        }

        .mobile-menu-content {
            padding: 2rem;
        }

        .mobile-menu-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(16, 185, 129, 0.1);
        }

        .mobile-menu-header h3 {
            margin: 0;
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 800;
        }

        .mobile-menu-close {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 12px;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            transition: all 0.3s ease;
        }

        .mobile-menu-close:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
        }

        .mobile-menu-links {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .mobile-nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.25rem;
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(16, 185, 129, 0.1);
            border-radius: 15px;
            color: var(--gray-700);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .mobile-nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(16, 185, 129, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .mobile-nav-link:hover::before {
            left: 100%;
        }

        .mobile-nav-link:hover,
        .mobile-nav-link.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            border-color: var(--primary);
            transform: translateX(5px);
        }

        .mobile-nav-link i {
            font-size: 1.25rem;
            width: 25px;
            text-align: center;
        }



        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            padding: 0.75rem;
            border-radius: 12px;
            cursor: pointer;
            font-size: 1.25rem;
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        /* Main Content */
        main {
            min-height: 60vh;
            padding: 2rem 0;
            margin-top: 0;
        }
        
        /* Product Grid - Professional Layout */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            padding: 0;
        }
        
        .product-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.15);
        }
        
        .product-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            background: #f3f4f6;
        }
        
        .product-info {
            padding: 1.25rem;
        }
        
        .product-title {
            font-size: 1.0625rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.75rem;
            line-height: 1.4;
            height: 2.8em;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        
        .product-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        
        .product-actions {
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }
        
        .btn-add-cart {
            flex: 1;
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.875rem 1.25rem;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-add-cart:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        /* Hero Section - Compact Design */
        .hero {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 3rem 0;
            border-radius: 24px;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: moveGrid 20s linear infinite;
        }

        @keyframes moveGrid {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            line-height: 1.2;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        }

        .hero p {
            font-size: 1.125rem;
            margin-bottom: 1.5rem;
            opacity: 0.95;
            font-weight: 500;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1.125rem 2.5rem;
            background: white;
            color: var(--primary);
            border: none;
            border-radius: 50px;
            font-weight: 800;
            font-size: 1.125rem;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
            font-family: 'Tajawal', sans-serif;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: var(--primary);
            transform: translate(-50%, -50%);
            transition: width 0.5s, height 0.5s;
        }

        .btn:hover::before {
            width: 400px;
            height: 400px;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            color: white;
        }

        .btn span, .btn i {
            position: relative;
            z-index: 1;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
        }

        /* Section Title */
        .section-title {
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 3rem;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
        }

        .section-title::before {
            content: '';
            width: 6px;
            height: 60px;
            background: linear-gradient(180deg, var(--primary), var(--primary-dark));
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }

        /* Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2.5rem;
            margin-bottom: 4rem;
        }

        /* Category Cards */
        .category-card {
            position: relative;
            overflow: hidden;
            text-decoration: none;
        }

        .category-card-inner {
            position: relative;
            z-index: 1;
        }

        .category-icon {
            position: relative;
        }

        .category-icon img {
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .category-icon:hover img {
            transform: scale(1.1);
        }

        .product-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(16, 185, 129, 0.1);
            transition: all 0.4s ease;
            cursor: pointer;
            position: relative;
        }

        .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.4s;
        }

        .product-card:hover::before {
            opacity: 1;
        }

        .product-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 60px rgba(16, 185, 129, 0.2);
            border-color: var(--primary);
        }

        .product-image {
            width: 100%;
            height: 280px;
            object-fit: cover;
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
            transition: transform 0.4s;
        }

        .product-card:hover .product-image {
            transform: scale(1.1);
        }

        .product-info {
            padding: 1.75rem;
            position: relative;
            z-index: 1;
        }

        .product-category {
            font-size: 0.875rem;
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: right;
            direction: rtl;
        }

        .product-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark);
            line-height: 1.4;
        }

        .product-price {
            font-size: 1.875rem;
            font-weight: 900;
            color: var(--primary);
            margin-bottom: 1.25rem;
            text-shadow: 0 2px 10px rgba(16, 185, 129, 0.2);
        }

        .product-actions {
            display: flex;
            gap: 1rem;
        }

        .btn-add-cart {
            flex: 1;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-add-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
            padding: 4rem 0 2rem;
            margin-top: 5rem;
            position: relative;
            overflow: hidden;
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light), var(--primary));
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-section h3 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            font-weight: 800;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 1rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
        }

        .footer-links a::before {
            content: '→';
            opacity: 0;
            transform: translateX(10px);
            transition: all 0.3s;
        }

        .footer-links a:hover {
            color: white;
            transform: translateX(5px);
        }

        .footer-links a:hover::before {
            opacity: 1;
            transform: translateX(0);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            font-size: 1rem;
            font-weight: 500;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Responsive - Professional Layout */
        @media (max-width: 1200px) {
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1.25rem;
            }
        }
        
        @media (max-width: 1024px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .hero {
                padding: 2.5rem 0;
                border-radius: 20px;
            }
            
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
            }
        }

        @media (max-width: 1024px) {
            .nav .container {
                gap: 0.25rem;
                justify-content: center;
            }

            .nav-link {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }
        }

        /* تحسينات شاملة للهواتف المحمولة */
        @media (max-width: 768px) {
            /* تحسين مسافات الصفحة */
            main {
                padding: 1rem 0 80px 0; /* مسافة للـ bottom nav */
            }
            
            .container {
                padding: 0 0.75rem;
                max-width: 100%;
            }
            
            /* تحسين النصوص للجوال */
            h1 {
                font-size: 1.5rem !important;
                line-height: 1.3 !important;
            }
            
            h2 {
                font-size: 1.25rem !important;
                line-height: 1.3 !important;
            }
            
            h3 {
                font-size: 1.125rem !important;
            }
            
            p {
                font-size: 0.875rem !important;
                line-height: 1.6 !important;
            }
            
            /* تحسين الأزرار للجوال */
            .btn {
                padding: 0.875rem 1.5rem !important;
                font-size: 0.875rem !important;
                min-height: 44px; /* حد أدنى للأزرار على iOS */
                touch-action: manipulation; /* يمنع التأخير في اللمس */
            }
            
            /* تحسين Product Grid للجوال */
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }
            
            .product-card {
                border-radius: 12px;
            }
            
            .product-image {
                height: 180px;
            }
            
            .product-info {
                padding: 1rem;
            }
            
            .product-title {
                font-size: 0.9375rem;
                height: 2.5em;
            }
            
            .product-price {
                font-size: 1.125rem;
            }
            
            .btn-add-cart {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }
            
            /* تحسين الأقسام */
            .section-title {
                font-size: 1.5rem;
                text-align: center;
            }
            
            .hero h1 {
                font-size: 1.75rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
            /* الهيدر والتنقل */
            .header-top {
                padding: 0.5rem 0;
                font-size: 0.75rem;
            }

            .header-top-links {
                font-size: 0.75rem;
                gap: 0.75rem;
                flex-wrap: wrap;
            }

            .header-top-links a {
                padding: 0.375rem 0.625rem;
                font-size: 0.75rem;
                border-radius: 20px;
            }

            .header-main {
                padding: 1rem 0;
            }

            /* تحسين الشعار للهواتف المحمولة */
            .logo {
                font-size: 1.5rem;
            }

            .logo-icon {
                width: 45px;
                height: 45px;
                font-size: 1.5rem;
            }

            /* شريط البحث المحسن للهواتف المحمولة */
            .search-bar {
                order: 3;
                flex: 1 1 100%;
                max-width: 100%;
                margin-top: 1rem;
            }

            .search-container {
                position: relative;
            }

            .search-input {
                padding: 0.875rem 3.5rem 0.875rem 1rem;
                font-size: 0.9375rem;
                border-radius: 25px;
            }

            .search-btn {
                padding: 0.75rem 1rem;
                font-size: 0.8125rem;
                right: 8px;
            }

            /* إخفاء النص في أزرار الهيدر لتوفير المساحة */
            .header-actions .header-btn span {
                display: none;
            }

            .header-btn {
                padding: 0.75rem;
                width: 50px;
                height: 50px;
                border-radius: 50%;
                justify-content: center;
            }

            /* إخفاء التنقل الأفقي وإظهار زر القائمة */
            .nav {
                display: none;
            }

            .mobile-menu-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 50px;
                height: 50px;
                border-radius: 50%;
            }

            /* القائمة الجانبية المحسنة للهواتف المحمولة */
            .mobile-menu {
                width: 300px;
                max-width: 85vw;
            }

            .mobile-menu-content {
                padding: 1.5rem;
            }

            .mobile-nav-link {
                padding: 1rem 1.25rem;
                border-radius: 12px;
                margin-bottom: 0.5rem;
            }

            /* قسم البطل المحسن للهواتف المحمولة */
            .hero {
                padding: 2.5rem 0;
                border-radius: 16px;
                margin: 1rem;
            }

            .hero h1 {
                font-size: 2rem;
                line-height: 1.3;
            }

            .hero p {
                font-size: 1rem;
                margin-bottom: 2rem;
            }

            .btn {
                padding: 1rem 2rem;
                font-size: 1rem;
                border-radius: 12px;
            }

            /* شبكة المنتجات محسنة للهواتف المحمولة */
            .product-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                padding: 0 1rem;
            }

            .product-card {
                border-radius: 16px;
                margin: 0;
            }

            .product-image {
                height: 250px;
            }

            .product-info {
                padding: 1.5rem;
            }

            .product-title {
                font-size: 1.125rem;
                line-height: 1.4;
            }

            .product-price {
                font-size: 1.5rem;
            }

            .product-actions {
                flex-direction: column;
                gap: 0.75rem;
            }

            .btn-add-cart {
                padding: 0.875rem;
                font-size: 0.9375rem;
            }

            /* عناوين الأقسام محسنة للهواتف المحمولة */
            .section-title {
                font-size: 1.75rem;
                margin-bottom: 2rem;
            }

            /* الفوتر محسن للهواتف المحمولة */
            footer {
                margin-top: 3rem;
                padding: 3rem 0 2rem;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
                padding: 0 1rem;
            }

            .footer-section h3 {
                font-size: 1.25rem;
            }

            /* تحسينات خاصة بالفئات للهواتف المحمولة */
            .category-card {
                margin: 0 1rem;
            }

            .category-card-inner {
                padding: 1.5rem !important;
            }

            .category-logo {
                width: 80px !important;
                height: 80px !important;
                margin-bottom: 1rem !important;
            }

            .category-card h3 {
                font-size: 1.125rem !important;
            }

            .category-card p {
                font-size: 0.875rem !important;
            }

            .explore-button {
                font-size: 0.875rem !important;
                padding: 0.5rem 1rem !important;
            }

            /* تحسينات خاصة بالبحث المتقدم للهواتف المحمولة */
            .search-suggestions {
                max-height: 250px;
            }

            .search-filters {
                padding: 1rem;
                gap: 0.5rem;
            }

            .filter-tag {
                padding: 0.375rem 0.75rem;
                font-size: 0.8125rem;
            }

            /* إخفاء عناصر إضافية لتوفير المساحة */
            .nav-link.admin-link {
                display: none;
            }

            /* تحسينات عامة للهواتف المحمولة */
            .container {
                padding: 0 1rem;
            }

            /* تحسينات خاصة بالسلة للهواتف المحمولة */
            .cart-item {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .cart-item-image {
                width: 100px;
                height: 100px;
            }

            /* تحسينات خاصة بعملية الدفع للهواتف المحمولة */
            .checkout-grid {
                grid-template-columns: 1fr !important;
            }

            .shipping-form {
                padding: 1.5rem;
            }

            /* تحسينات خاصة بالمنتجات للهواتف المحمولة */
            .product-details {
                grid-template-columns: 1fr !important;
            }

            .product-images {
                margin-bottom: 2rem;
            }
        }

        /* تحسينات خاصة بالشاشات الصغيرة جداً */
        @media (max-width: 480px) {
            /* تحسينات الهيدر للشاشات الصغيرة */
            .header-top {
                padding: 0.375rem 0;
            }

            .header-top-links {
                gap: 0.25rem;
                font-size: 0.6875rem;
                justify-content: center;
            }

            .header-top-links a {
                padding: 0.25rem 0.5rem;
                font-size: 0.6875rem;
            }

            .header-main {
                padding: 0.75rem 0;
            }

            /* الشعار محسن للشاشات الصغيرة */
            .logo {
                font-size: 1.25rem;
                gap: 0.5rem;
            }

            .logo-icon {
                width: 40px;
                height: 40px;
                font-size: 1.25rem;
            }

            /* شريط البحث محسن للشاشات الصغيرة */
            .search-input {
                padding: 0.75rem 3rem 0.75rem 0.875rem;
                font-size: 0.875rem;
            }

            .search-btn {
                padding: 0.625rem 0.875rem;
                font-size: 0.75rem;
                right: 6px;
            }

            /* أزرار الهيدر محسنة للشاشات الصغيرة */
            .header-btn {
                padding: 0.625rem;
                width: 45px;
                height: 45px;
            }

            .mobile-menu-btn {
                width: 45px;
                height: 45px;
                font-size: 1.125rem;
            }

            /* قسم البطل محسن للشاشات الصغيرة */
            .hero {
                padding: 2rem 0;
                margin: 0.5rem;
            }

            .hero h1 {
                font-size: 1.75rem;
            }

            .hero p {
                font-size: 0.9375rem;
            }

            .btn {
                padding: 0.875rem 1.5rem;
                font-size: 0.9375rem;
            }

            /* شبكة المنتجات محسنة للشاشات الصغيرة */
            .product-grid {
                gap: 1rem;
                padding: 0 0.5rem;
            }

            .product-card {
                border-radius: 12px;
            }

            .product-image {
                height: 200px;
            }

            .product-info {
                padding: 1.25rem;
            }

            .product-title {
                font-size: 1rem;
            }

            .product-price {
                font-size: 1.25rem;
            }

            /* عناوين الأقسام محسنة للشاشات الصغيرة */
            .section-title {
                font-size: 1.5rem;
            }

            /* الفوتر محسن للشاشات الصغيرة */
            footer {
                padding: 2.5rem 0 1.5rem;
            }

            .footer-grid {
                gap: 1.5rem;
            }

            /* تحسينات خاصة بالفئات للشاشات الصغيرة جداً */
            .category-card {
                margin: 0 0.5rem;
            }

            .category-card-inner {
                padding: 1.25rem !important;
            }

            .category-logo {
                width: 70px !important;
                height: 70px !important;
                margin-bottom: 0.75rem !important;
            }

            .category-card h3 {
                font-size: 1rem !important;
                margin-bottom: 0.5rem !important;
            }

            .category-card p {
                font-size: 0.8125rem !important;
                margin-bottom: 0.75rem !important;
            }

            .explore-button {
                font-size: 0.8125rem !important;
                padding: 0.375rem 0.875rem !important;
            }

            /* تحسينات خاصة بالبحث للشاشات الصغيرة */
            .search-suggestions {
                max-height: 200px;
                margin-top: 4px;
            }

            .search-suggestion {
                padding: 0.75rem 1rem;
            }

            .search-filters {
                padding: 0.75rem;
                gap: 0.375rem;
            }

            .filter-tag {
                padding: 0.25rem 0.625rem;
                font-size: 0.75rem;
            }

            /* تحسينات خاصة بالسلة للشاشات الصغيرة */
            .cart-item {
                padding: 1rem;
            }

            .cart-item-info h3 {
                font-size: 1rem;
            }

            .cart-item-actions {
                flex-direction: column;
                gap: 0.5rem;
            }

            /* تحسينات خاصة بعملية الدفع للشاشات الصغيرة */
            .checkout-form-section {
                padding: 1rem;
            }

            .payment-option {
                padding: 1.5rem;
            }

            /* تحسينات خاصة بصفحة المنتج للشاشات الصغيرة */
            .product-details-section {
                padding: 1.5rem;
            }

            .product-title {
                font-size: 1.5rem;
            }

            /* تحسينات عامة للشاشات الصغيرة */
            .container {
                padding: 0 0.75rem;
            }

            /* إخفاء بعض العناصر في الشاشات الصغيرة جداً */
            .floating-element {
                display: none;
            }

            /* تحسينات خاصة بالـ touch devices */
            .btn, .header-btn, .nav-link, .mobile-nav-link, .category-card, .product-card {
                min-height: 44px;
                min-width: 44px;
            }

            /* تحسين الـ scrolling للهواتف المحمولة */
            * {
                -webkit-overflow-scrolling: touch;
            }

            /* تحسين الـ font rendering للهواتف المحمولة */
            body {
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }

            /* تحسين الأداء للهواتف المحمولة */
            .category-bg-animation,
            .floating-element,
            .header-top::before,
            .header-top::after {
                will-change: transform;
            }

            /* تحسين البطاريات للهواتف المحمولة */
            @media (prefers-reduced-motion: reduce) {
                *,
                *::before,
                *::after {
                    animation-duration: 0.01ms !important;
                    animation-iteration-count: 1 !important;
                    transition-duration: 0.01ms !important;
                }
            }
        }

        /* تحسينات عامة للهواتف المحمولة */
        @media (max-width: 768px) {
            /* تحسين الـ viewport للهواتف المحمولة */
            * {
                box-sizing: border-box;
            }

            html {
                scroll-behavior: smooth;
            }

            /* تحسين الـ touch targets */
            a, button, input, select, textarea {
                min-height: 44px;
            }

            /* تحسين الـ focus للهواتف المحمولة */
            *:focus {
                outline: 2px solid var(--primary);
                outline-offset: 2px;
            }

            /* تحسين الـ text selection للهواتف المحمولة */
            ::selection {
                background: var(--primary);
                color: white;
            }

            /* تحسين الـ scrolling للهواتف المحمولة */
            body {
                -webkit-overflow-scrolling: touch;
                overscroll-behavior: none;
            }

            /* تحسين الأداء العام */
            .category-card,
            .product-card,
            .btn {
                will-change: transform;
                backface-visibility: hidden;
            }

            /* تحسينات خاصة بالـ inputs للهواتف المحمولة */
            input, select, textarea {
                font-size: 16px; /* منع التكبير في iOS */
            }

            /* تحسينات خاصة بالـ forms للهواتف المحمولة */
            .form-section {
                margin-bottom: 1.5rem;
            }

            /* تحسينات خاصة بالـ buttons للهواتف المحمولة */
            .btn:active {
                transform: scale(0.98);
            }
        }
    </style>
</head>
<body>
    <div class="gradient-bg"></div>

    <!-- Floating Elements for Visual Appeal -->
    <div class="floating-element"></div>
    <div class="floating-element"></div>
    <div class="floating-element"></div>

    <!-- Header -->
    <!-- Mobile Simple Header -->
    <header class="mobile-header mobile-only">
        <a href="{{ route('home') }}" class="mobile-header-logo">
            <i class="fas fa-leaf" style="margin-left: 6px;"></i>
            لُجَـيِّـن
        </a>
        <div class="mobile-header-icons">
            <a href="{{ route('products.index') }}" class="mobile-header-icon">
                <i class="fas fa-search"></i>
            </a>
            <a href="{{ route('cart.index') }}" class="mobile-header-icon">
                <i class="fas fa-shopping-cart"></i>
                @php
                    $cartCount = 0;
                    if (session()->has('cart')) {
                        $cart = session('cart');
                        foreach ($cart as $item) {
                            $cartCount += $item['quantity'];
                        }
                    }
                @endphp
                @if($cartCount > 0)
                <span class="badge">{{ $cartCount }}</span>
                @endif
            </a>
        </div>
    </header>

    <!-- Desktop Header -->
    <header class="header desktop-only">
        <!-- Top Bar -->
        <div class="header-top">
            <div class="container">
                <div class="header-top-links">
                    <a href="tel:+966537776073">
                        <i class="fas fa-phone"></i>
                        <span>0537776073</span>
                    </a>
                    <a href="https://wa.me/966537776073" target="_blank" title="تواصل واتساب">
                        <i class="fab fa-whatsapp"></i>
                        <span>واتساب</span>
                    </a>
                    <a href="mailto:info@lujaiin.sa">
                        <i class="fas fa-envelope"></i>
                        <span>info@lujaiin.sa</span>
                    </a>
                </div>
                <div class="header-top-links">
                    @auth
                        <a href="{{ route('profile.index') }}">
                            <i class="fas fa-user-circle"></i>
                            <span>{{ auth()->user()->name }}</span>
                        </a>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>تسجيل الخروج</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>تسجيل الدخول</span>
                        </a>
                        <a href="{{ route('register') }}">
                            <i class="fas fa-user-plus"></i>
                            <span>حساب جديد</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Main Header -->
        <div class="header-main">
            <div class="container">
                <a href="{{ route('home') }}" class="logo">
                    <div class="logo-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <span class="logo-text">لُجَـيِّـن</span>
                </a>

                <div class="search-bar">
                    <div class="search-container">
                        <input type="text" class="search-input" placeholder="ابحث عن المنتجات الزراعية..." autocomplete="off" id="searchInput">
                        <button class="search-btn" onclick="performSearch()">
                            <i class="fas fa-search"></i>
                        </button>

                        <!-- قائمة الاقتراحات -->
                        <div class="search-suggestions" id="searchSuggestions" style="display: none;"></div>

                        <!-- فلاتر البحث السريع -->
                        <div class="search-filters" id="searchFilters" style="display: none;">
                            <div class="filter-tag" onclick="setCategoryFilter('بذور')">
                                <i class="fas fa-seedling"></i> بذور
                            </div>
                            <div class="filter-tag" onclick="setCategoryFilter('أسمدة')">
                                <i class="fas fa-flask"></i> أسمدة
                            </div>
                            <div class="filter-tag" onclick="setCategoryFilter('أدوات')">
                                <i class="fas fa-tools"></i> أدوات
                            </div>
                            <div class="filter-tag" onclick="setPriceFilter('0-100')">
                                <i class="fas fa-money-bill"></i> تحت 100 ر.س
                            </div>
                            <div class="filter-tag" onclick="setPriceFilter('100-500')">
                                <i class="fas fa-coins"></i> 100-500 ر.س
                            </div>
                            <div class="filter-tag" onclick="setAvailabilityFilter('متوفر')">
                                <i class="fas fa-check-circle"></i> متوفر
                            </div>
                        </div>
                    </div>
                </div>

                <div class="header-actions">
                    <a href="{{ route('cart.index') }}" class="header-btn" style="position: relative;">
                        <i class="fas fa-shopping-cart"></i>
                        <span>السلة</span>
                        @php
                            $cartCount = 0;
                            if (session()->has('cart')) {
                                $cart = session('cart');
                                foreach ($cart as $item) {
                                    $cartCount += $item['quantity'];
                                }
                            }
                        @endphp
                        <span class="cart-badge" id="cartCount" style="display: {{ $cartCount > 0 ? 'flex' : 'none' }};">{{ $cartCount }}</span>
                    </a>
                    <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>

                <!-- Mobile Menu -->
                <div id="mobile-menu" class="mobile-menu" style="display: none;">
                    <div class="mobile-menu-content">
                        <div class="mobile-menu-header">
                            <h3>القائمة الرئيسية</h3>
                            <button class="mobile-menu-close" onclick="toggleMobileMenu()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <div class="mobile-menu-links">
                            <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                                <i class="fas fa-home"></i>
                                الرئيسية
                            </a>

                            <a href="{{ route('shop.by-categories') }}" class="mobile-nav-link {{ request()->routeIs('shop.by-categories') ? 'active' : '' }}">
                                <i class="fas fa-th-large"></i>
                                تسوق حسب الفئات
                            </a>

                            @php
                            $mobileCategoryIcons = [
                                'carrot', 'apple-alt', 'drumstick-bite', 'egg', 'cheese',
                                'wheat-awn', 'leaf', 'pepper-hot', 'seedling', 'fish', 'cow', 'horse'
                            ];
                            @endphp

                            @if(isset($navCategories))
                                @foreach($navCategories as $index => $category)
                                @php
                                    $icon = $mobileCategoryIcons[$index % count($mobileCategoryIcons)];
                                @endphp
                                <a href="{{ route('products.category', $category->id) }}" class="mobile-nav-link {{ request()->is('category/'.$category->id) ? 'active' : '' }}">
                                    <i class="fas fa-{{ $icon }}"></i>
                                    {{ $category->name_ar }}
                                </a>
                                @endforeach
                            @endif

                            <a href="{{ route('products.index') }}" class="mobile-nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}">
                                <i class="fas fa-box"></i>
                                جميع المنتجات
                            </a>

                            <a href="https://wa.me/966537776073" target="_blank" class="mobile-nav-link">
                                <i class="fab fa-whatsapp"></i>
                                واتساب (0537776073)
                            </a>

                            @auth
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.categories.index') }}" class="mobile-nav-link admin-link">
                                        <i class="fas fa-cog"></i>
                                        إدارة الفئات
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="nav">
            <div class="container">
                <!-- الرئيسية -->
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    الرئيسية
                </a>

                <!-- تسوق حسب الفئات -->
                <a href="{{ route('shop.by-categories') }}" class="nav-link {{ request()->routeIs('shop.by-categories') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i>
                    تسوق حسب الفئات
                </a>

                @php
                $categoryIcons = [
                    'carrot', 'apple-alt', 'drumstick-bite', 'egg', 'cheese',
                    'wheat-awn', 'leaf', 'pepper-hot', 'seedling', 'fish', 'cow', 'horse'
                ];
                @endphp

                @if(isset($navCategories))
                    @foreach($navCategories as $index => $category)
                    @php
                        $icon = $categoryIcons[$index % count($categoryIcons)];
                    @endphp
                    <a href="{{ route('products.category', $category->id) }}" class="nav-link {{ request()->is('category/'.$category->id) ? 'active' : '' }}">
                        <i class="fas fa-{{ $icon }}"></i>
                        {{ $category->name_ar }}
                    </a>
                    @endforeach
                @endif

                <!-- جميع المنتجات -->
                <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}">
                    <i class="fas fa-box"></i>
                    جميع المنتجات
                </a>

                <!-- اتصل بنا -->
                <a href="https://wa.me/966537776073" target="_blank" class="nav-link" title="تواصل معنا عبر واتساب">
                    <i class="fab fa-whatsapp"></i>
                    واتساب
                </a>

                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.categories.index') }}" class="nav-link admin-link" style="background: linear-gradient(135deg, #fbbf24, #f59e0b); color: white; border: 2px solid #f59e0b;" title="إدارة الفئات">
                            <i class="fas fa-cog"></i>
                            إدارة الفئات
                        </a>
                    @endif
                @endauth
            </div>
        </nav>
    </header>

    <!-- Promotional Banner -->
    <section class="promo-banner" style="background: linear-gradient(135deg, var(--gradient-1)); color: white; padding: 1rem 0; position: relative; overflow: hidden;">
        <div style="position: absolute; inset: 0; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent); animation: slide 3s infinite linear;"></div>
        <div class="container" style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; justify-content: center; gap: 2rem; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 0.5rem; background: rgba(255,255,255,0.2); padding: 0.5rem 1rem; border-radius: 25px; backdrop-filter: blur(10px);">
                    <i class="fas fa-star pulse" style="color: #ffd700;"></i>
                    <span style="font-weight: 700;">عروض خاصة تصل إلى 50% خصم</span>
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem; background: rgba(255,255,255,0.2); padding: 0.5rem 1rem; border-radius: 25px; backdrop-filter: blur(10px);">
                    <i class="fas fa-truck glow" style="color: white;"></i>
                    <span style="font-weight: 700;">شحن مجاني للطلبات فوق 200 ر.س</span>
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem; background: rgba(255,255,255,0.2); padding: 0.5rem 1rem; border-radius: 25px; backdrop-filter: blur(10px);">
                    <i class="fas fa-clock" style="color: #00ff88;"></i>
                    <span style="font-weight: 700;">توصيل في نفس اليوم للرياض</span>
                </div>
            </div>
        </div>

        <style>
            @keyframes slide {
                0% { transform: translateX(-100%); }
                100% { transform: translateX(100%); }
            }
        </style>
    </section>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <!-- About Section -->
                <div class="footer-section">
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);">
                            <i class="fas fa-leaf" style="color: white; font-size: 1.75rem;"></i>
                        </div>
                        <h3 style="margin: 0; font-size: 1.5rem;">لُجَـيِّـن</h3>
                    </div>
                    <p style="color: rgba(255, 255, 255, 0.8); line-height: 1.8; font-weight: 500; margin-bottom: 1.5rem;">
                        متجرك الموثوق لأفضل المنتجات الزراعية من بذور وأسمدة وأدوات زراعية بأعلى جودة وأفضل الأسعار.
                    </p>
                    <!-- Social Media -->
                    <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                        <a href="https://twitter.com/lujaiin_sa" target="_blank" title="تابعنا على تويتر @lujaiin_sa" style="width: 45px; height: 45px; background: rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; transition: all 0.3s; border: 1px solid rgba(255,255,255,0.2);" onmouseover="this.style.background='#1DA1F2'; this.style.borderColor='#1DA1F2'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(255,255,255,0.2)'; this.style.transform='translateY(0)'">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://instagram.com/lujaiin_sa" target="_blank" title="تابعنا على إنستقرام @lujaiin_sa" style="width: 45px; height: 45px; background: rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; transition: all 0.3s; border: 1px solid rgba(255,255,255,0.2);" onmouseover="this.style.background='linear-gradient(135deg, #833AB4, #FD1D1D)'; this.style.borderColor='#833AB4'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(255,255,255,0.2)'; this.style.transform='translateY(0)'">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://facebook.com/lujaiin.sa" target="_blank" title="تابعنا على فيسبوك" style="width: 45px; height: 45px; background: rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; transition: all 0.3s; border: 1px solid rgba(255,255,255,0.2);" onmouseover="this.style.background='#1877F2'; this.style.borderColor='#1877F2'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(255,255,255,0.2)'; this.style.transform='translateY(0)'">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://wa.me/966537776073" target="_blank" title="تواصل معنا واتساب 0537776073" style="width: 45px; height: 45px; background: rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; transition: all 0.3s; border: 1px solid rgba(255,255,255,0.2);" onmouseover="this.style.background='#25D366'; this.style.borderColor='#25D366'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(255,255,255,0.2)'; this.style.transform='translateY(0)'">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://snapchat.com/add/lujaiin_sa" target="_blank" title="أضفنا على سناب شات @lujaiin_sa" style="width: 45px; height: 45px; background: rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; transition: all 0.3s; border: 1px solid rgba(255,255,255,0.2);" onmouseover="this.style.background='#FFFC00'; this.style.borderColor='#FFFC00'; this.style.color='#000'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(255,255,255,0.2)'; this.style.color='white'; this.style.transform='translateY(0)'">
                            <i class="fab fa-snapchat-ghost"></i>
                        </a>
                        <a href="https://www.tiktok.com/@lujaiin_sa" target="_blank" title="تابعنا على تيك توك @lujaiin_sa" style="width: 45px; height: 45px; background: rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; transition: all 0.3s; border: 1px solid rgba(255,255,255,0.2);" onmouseover="this.style.background='#000'; this.style.borderColor='#00f2ea'; this.style.transform='translateY(-3px)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(255,255,255,0.2)'; this.style.transform='translateY(0)'">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-section">
                    <h3>روابط سريعة</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}"><i class="fas fa-home" style="color: var(--primary); margin-left: 0.5rem;"></i>الرئيسية</a></li>
                        <li><a href="{{ route('products.index') }}"><i class="fas fa-box" style="color: var(--primary); margin-left: 0.5rem;"></i>المنتجات</a></li>
                        @auth
                        <li><a href="{{ route('profile.orders') }}"><i class="fas fa-shopping-bag" style="color: var(--primary); margin-left: 0.5rem;"></i>طلباتي</a></li>
                        <li><a href="{{ route('profile.index') }}"><i class="fas fa-user-circle" style="color: var(--primary); margin-left: 0.5rem;"></i>حسابي</a></li>
                        @else
                        <li><a href="{{ route('login') }}"><i class="fas fa-sign-in-alt" style="color: var(--primary); margin-left: 0.5rem;"></i>تسجيل الدخول</a></li>
                        <li><a href="{{ route('register') }}"><i class="fas fa-user-plus" style="color: var(--primary); margin-left: 0.5rem;"></i>إنشاء حساب</a></li>
                        @endauth
                        <li><a href="{{ route('cart.index') }}"><i class="fas fa-shopping-cart" style="color: var(--primary); margin-left: 0.5rem;"></i>السلة</a></li>
                    </ul>
                </div>

                <!-- Customer Service -->
                <div class="footer-section">
                    <h3>خدمة العملاء</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('pages.about') }}"><i class="fas fa-info-circle" style="color: var(--primary); margin-left: 0.5rem;"></i>من نحن</a></li>
                        <li><a href="{{ route('pages.contact') }}"><i class="fas fa-phone-alt" style="color: var(--primary); margin-left: 0.5rem;"></i>اتصل بنا</a></li>
                        <li><a href="{{ route('pages.privacy') }}"><i class="fas fa-shield-alt" style="color: var(--primary); margin-left: 0.5rem;"></i>سياسة الخصوصية</a></li>
                        <li><a href="{{ route('pages.terms') }}"><i class="fas fa-file-contract" style="color: var(--primary); margin-left: 0.5rem;"></i>الشروط والأحكام</a></li>
                        <li><a href="{{ route('pages.refund') }}"><i class="fas fa-undo-alt" style="color: var(--primary); margin-left: 0.5rem;"></i>سياسة الاسترجاع</a></li>
                        <li><a href="{{ route('pages.shipping') }}"><i class="fas fa-truck" style="color: var(--primary); margin-left: 0.5rem;"></i>الشحن والتوصيل</a></li>
                        <li><a href="{{ route('pages.faq') }}"><i class="fas fa-question-circle" style="color: var(--primary); margin-left: 0.5rem;"></i>الأسئلة الشائعة</a></li>
                    </ul>
                </div>

                <!-- Contact Us -->
                <div class="footer-section">
                    <h3>تواصل معنا</h3>
                    <ul class="footer-links">
                        <li>
                            <a href="tel:+966537776073" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: rgba(255,255,255,0.05); border-radius: 12px; margin-bottom: 0.75rem; border: 1px solid rgba(255,255,255,0.1); text-decoration: none;" onmouseover="this.style.background='rgba(16,185,129,0.2)'; this.style.borderColor='var(--primary)'" onmouseout="this.style.background='rgba(255,255,255,0.05)'; this.style.borderColor='rgba(255,255,255,0.1)'">
                                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div style="flex: 1;">
                                    <div style="font-size: 0.75rem; color: rgba(255,255,255,0.6); margin-bottom: 0.125rem;">اتصل بنا</div>
                                    <div style="font-weight: 700; color: white; direction: ltr; text-align: right;">+966 53 777 6073</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="https://wa.me/966537776073" target="_blank" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: rgba(255,255,255,0.05); border-radius: 12px; margin-bottom: 0.75rem; border: 1px solid rgba(255,255,255,0.1); text-decoration: none;" onmouseover="this.style.background='rgba(37,211,102,0.2)'; this.style.borderColor='#25D366'" onmouseout="this.style.background='rgba(255,255,255,0.05)'; this.style.borderColor='rgba(255,255,255,0.1)'">
                                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #25D366, #128C7E); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fab fa-whatsapp"></i>
                                </div>
                                <div style="flex: 1;">
                                    <div style="font-size: 0.75rem; color: rgba(255,255,255,0.6); margin-bottom: 0.125rem;">واتساب</div>
                                    <div style="font-weight: 700; color: white; direction: ltr; text-align: right;">+966 53 777 6073</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="mailto:info@lujaiin.sa" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: rgba(255,255,255,0.05); border-radius: 12px; margin-bottom: 0.75rem; border: 1px solid rgba(255,255,255,0.1);" onmouseover="this.style.background='rgba(16,185,129,0.2)'; this.style.borderColor='var(--primary)'" onmouseout="this.style.background='rgba(255,255,255,0.05)'; this.style.borderColor='rgba(255,255,255,0.1)'">
                                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div style="flex: 1;">
                                    <div style="font-size: 0.75rem; color: rgba(255,255,255,0.6); margin-bottom: 0.125rem;">راسلنا</div>
                                    <div style="font-weight: 700; color: white;">info@lujaiin.sa</div>
                                </div>
                            </a>
                        </li>
                        <li style="color: rgba(255,255,255,0.8); font-weight: 500; display: flex; align-items: start; gap: 0.75rem; padding: 0.75rem; background: rgba(255,255,255,0.05); border-radius: 12px; border: 1px solid rgba(255,255,255,0.1);">
                            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="font-size: 0.75rem; color: rgba(255,255,255,0.6); margin-bottom: 0.125rem;">العنوان</div>
                                <div style="font-weight: 700; color: white; line-height: 1.5;">الرياض، المملكة العربية السعودية</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Payment Methods -->
            <div style="border-top: 1px solid rgba(255, 255, 255, 0.1); padding-top: 2rem; margin-top: 2rem;">
                <div style="text-align: center; margin-bottom: 1.5rem;">
                    <h4 style="color: rgba(255, 255, 255, 0.9); font-size: 1.125rem; font-weight: 700; margin-bottom: 1.25rem;">
                        <i class="fas fa-credit-card" style="color: var(--primary); margin-left: 0.5rem;"></i>
                        طرق الدفع المتاحة
                    </h4>
                    <div style="display: flex; justify-content: center; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
                        <!-- Visa -->
                        <div style="width: 70px; height: 50px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; padding: 0.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.2); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                            <i class="fab fa-cc-visa" style="font-size: 2rem; color: #1A1F71;"></i>
                        </div>
                        <!-- Mastercard -->
                        <div style="width: 70px; height: 50px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; padding: 0.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.2); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                            <i class="fab fa-cc-mastercard" style="font-size: 2rem; color: #EB001B;"></i>
                        </div>
                        <!-- Mada -->
                        <div style="width: 70px; height: 50px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; padding: 0.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.2); transition: transform 0.3s; font-weight: 900; color: #7B1FA2; font-size: 1.25rem;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                            مدى
                        </div>
                        <!-- Apple Pay -->
                        <div style="width: 70px; height: 50px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; padding: 0.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.2); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                            <i class="fab fa-apple-pay" style="font-size: 2rem; color: #000;"></i>
                        </div>
                        <!-- COD -->
                        <div style="width: 70px; height: 50px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; padding: 0.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.2); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                            <i class="fas fa-hand-holding-usd" style="font-size: 1.5rem; color: var(--primary);"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; padding-top: 2rem; border-top: 1px solid rgba(255, 255, 255, 0.1);">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-copyright" style="color: var(--primary);"></i>
                    <span>2025 مؤسسة لُجين الزراعية - جميع الحقوق محفوظة</span>
                </div>
                <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" 
                               style="display: flex; align-items: center; gap: 0.5rem; color: rgba(255,255,255,0.7); text-decoration: none; font-size: 0.875rem; font-weight: 600; transition: all 0.3s; padding: 0.5rem 1rem; border-radius: 8px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);" 
                               onmouseover="this.style.background='rgba(255,255,255,0.15)'; this.style.color='white'; this.style.borderColor='rgba(255,255,255,0.3)'" 
                               onmouseout="this.style.background='rgba(255,255,255,0.05)'; this.style.color='rgba(255,255,255,0.7)'; this.style.borderColor='rgba(255,255,255,0.1)'">
                                <i class="fas fa-user-shield"></i>
                                <span>لوحة الإدارة</span>
                            </a>
                        @endif
                    @endauth
                    <div style="display: flex; align-items: center; gap: 0.5rem; color: rgba(255,255,255,0.6); font-size: 0.875rem;">
                        <i class="fas fa-heart" style="color: #ef4444; animation: heartbeat 1.5s infinite;"></i>
                        <span>صُنع بكل حب في المملكة العربية السعودية</span>
                    </div>
                </div>
            </div>
        </div>
        
        <style>
            @keyframes heartbeat {
                0%, 100% { transform: scale(1); }
                25% { transform: scale(1.1); }
                50% { transform: scale(1); }
            }
        </style>
    </footer>

    <!-- Add to Cart Script -->
    <script>
        // Add to Cart Function (Available globally)
        function addToCart(productId, quantity = 1) {
            // Show loading state
            const btn = event?.target?.closest('button');
            const originalText = btn ? btn.innerHTML : '';
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الإضافة...';
            }

            // Send AJAX request
            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                // Update cart count
                updateCartCount();
                
                // Show success message
                showNotification('تم إضافة المنتج للسلة بنجاح!', 'success');
                
                // Reset button
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('حدث خطأ أثناء إضافة المنتج', 'error');
                
                // Reset button
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            });
        }

        function updateCartCount() {
            // Get cart count from server
            fetch('{{ route("cart.count") }}', {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const cartBadge = document.getElementById('cartCount');
                if (cartBadge) {
                    cartBadge.textContent = data.count;
                    cartBadge.style.display = data.count > 0 ? 'flex' : 'none';
                }
            })
            .catch(error => console.error('Error updating cart count:', error));
        }

        function showNotification(message, type = 'success') {
            // Create notification
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 100px;
                left: 50%;
                transform: translateX(-50%);
                background: ${type === 'success' ? 'linear-gradient(135deg, var(--primary), var(--primary-dark))' : 'linear-gradient(135deg, #ef4444, #dc2626)'};
                color: white;
                padding: 1rem 2rem;
                border-radius: 50px;
                font-weight: 700;
                box-shadow: 0 8px 24px rgba(0,0,0,0.2);
                z-index: 10000;
                display: flex;
                align-items: center;
                gap: 0.75rem;
                animation: slideDown 0.3s ease;
            `;
            
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                ${message}
            `;
            
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.animation = 'slideUp 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }


        // Mobile Menu Functions
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('show');

            // Prevent body scroll when menu is open
            if (mobileMenu.classList.contains('show')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'auto';
            }
        }


        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');

            if (mobileMenu && mobileMenu.classList.contains('show') &&
                !mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                toggleMobileMenu();
            }
        });

        // Advanced Search Functionality
        const searchInput = document.getElementById('searchInput');
        const searchSuggestions = document.getElementById('searchSuggestions');
        const searchFilters = document.getElementById('searchFilters');
        let searchTimeout;
        let currentSearchResults = [];

        // Sample product data for autocomplete (in real app, this would come from API)
        const sampleProducts = [
            { id: 1, name: 'بذور الطماطم العضوية', name_en: 'Organic Tomato Seeds', category: 'بذور', price: 25, image: '/images/tomato-seeds.jpg' },
            { id: 2, name: 'سماد عضوي متعدد الاستخدامات', name_en: 'Multi-Purpose Organic Fertilizer', category: 'أسمدة', price: 45, image: '/images/fertilizer.jpg' },
            { id: 3, name: 'أدوات تقليم الأشجار', name_en: 'Tree Pruning Tools', category: 'أدوات', price: 120, image: '/images/pruning-tools.jpg' },
            { id: 4, name: 'بذور الخيار الهجين', name_en: 'Hybrid Cucumber Seeds', category: 'بذور', price: 30, image: '/images/cucumber-seeds.jpg' },
            { id: 5, name: 'مبيد فطري طبيعي', name_en: 'Natural Fungicide', category: 'مبيدات', price: 55, image: '/images/fungicide.jpg' },
            { id: 6, name: 'أدوات ري بالتنقيط', name_en: 'Drip Irrigation Tools', category: 'أدوات', price: 180, image: '/images/drip-irrigation.jpg' },
            { id: 7, name: 'سماد البوتاسيوم العالي', name_en: 'High Potassium Fertilizer', category: 'أسمدة', price: 65, image: '/images/potassium-fertilizer.jpg' },
            { id: 8, name: 'بذور الفلفل الحار', name_en: 'Hot Pepper Seeds', category: 'بذور', price: 20, image: '/images/pepper-seeds.jpg' }
        ];

        // Search input event listeners
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();

                // Clear previous timeout
                clearTimeout(searchTimeout);

                // Hide filters when typing
                if (searchFilters) {
                    searchFilters.style.display = 'none';
                }

                if (query.length >= 2) {
                    // Debounce search
                    searchTimeout = setTimeout(() => {
                        performSearch(query);
                    }, 300);
                } else {
                    hideSearchSuggestions();
                }
            });

            searchInput.addEventListener('focus', function() {
                const query = this.value.trim();
                if (query.length < 2) {
                    showSearchFilters();
                }
            });

            searchInput.addEventListener('blur', function() {
                // Delay hiding to allow clicking on suggestions
                setTimeout(() => {
                    hideSearchSuggestions();
                    if (searchFilters) {
                        searchFilters.style.display = 'none';
                    }
                }, 200);
            });
        }

        // Perform search
        function performSearch(query = null) {
            const searchQuery = query || searchInput.value.trim();

            if (searchQuery.length < 2) {
                hideSearchSuggestions();
                return;
            }

            // Filter products based on search query
            const results = sampleProducts.filter(product => {
                return product.name.includes(searchQuery) ||
                       product.name_en.toLowerCase().includes(searchQuery.toLowerCase()) ||
                       product.category.includes(searchQuery);
            });

            currentSearchResults = results;
            displaySearchResults(results, searchQuery);
        }

        // Display search results
        function displaySearchResults(results, query) {
            if (!searchSuggestions) return;

            if (results.length === 0) {
                searchSuggestions.innerHTML = `
                    <div class="search-no-results">
                        <i class="fas fa-search"></i>
                        <p>لا توجد نتائج لـ "${query}"</p>
                        <small>جرب كلمات مختلفة أو تصفح التصنيفات</small>
                    </div>
                `;
            } else {
                searchSuggestions.innerHTML = results.slice(0, 5).map(product => `
                    <div class="search-suggestion" onclick="selectProduct(${product.id}, '${product.name}')">
                        <div class="search-suggestion-icon">
                            <i class="fas fa-${getCategoryIcon(product.category)}"></i>
                        </div>
                        <div class="search-suggestion-text">
                            <div class="search-suggestion-name">${product.name}</div>
                            <div class="search-suggestion-category">${product.category} • ${product.price} ر.س</div>
                        </div>
                    </div>
                `).join('');
            }

            searchSuggestions.style.display = 'block';
        }

        // Show search filters
        function showSearchFilters() {
            if (searchFilters) {
                searchFilters.style.display = 'flex';
            }
        }

        // Hide search suggestions
        function hideSearchSuggestions() {
            if (searchSuggestions) {
                searchSuggestions.style.display = 'none';
            }
        }

        // Set category filter
        function setCategoryFilter(category) {
            searchInput.value = category;
            searchFilters.style.display = 'none';
            performSearch(category);
        }

        // Set price filter
        function setPriceFilter(priceRange) {
            const [min, max] = priceRange.split('-');
            searchInput.value = `السعر بين ${min} - ${max} ر.س`;
            searchFilters.style.display = 'none';
            // In real app, this would trigger a filtered search
            showNotification(`عرض المنتجات في نطاق السعر ${min}-${max} ر.س`, 'info');
        }

        // Set availability filter
        function setAvailabilityFilter(availability) {
            searchInput.value = availability;
            searchFilters.style.display = 'none';
            showNotification(`عرض المنتجات ${availability}`, 'info');
        }

        // Select product from search results
        function selectProduct(productId, productName) {
            // Redirect to product page
            window.location.href = `/products/${productId}`;
        }

        // Get category icon
        function getCategoryIcon(category) {
            const icons = {
                'بذور': 'seedling',
                'أسمدة': 'flask',
                'أدوات': 'tools',
                'مبيدات': 'bug'
            };
            return icons[category] || 'box';
        }

        // Global search function
        function performGlobalSearch() {
            const query = searchInput.value.trim();
            if (query) {
                window.location.href = `/products?search=${encodeURIComponent(query)}`;
            }
        }

        // Enhanced notification system with different types
        function showNotification(message, type = 'success', duration = 3000) {
            const notification = document.createElement('div');
            const colors = {
                success: { bg: 'var(--primary)', icon: 'check-circle' },
                error: { bg: '#ef4444', icon: 'exclamation-circle' },
                warning: { bg: 'var(--accent)', icon: 'exclamation-triangle' },
                info: { bg: 'var(--info)', icon: 'info-circle' }
            };

            notification.style.cssText = `
                position: fixed;
                top: 120px;
                left: 50%;
                transform: translateX(-50%);
                background: ${colors[type].bg};
                color: white;
                padding: 1rem 2rem;
                border-radius: 50px;
                font-weight: 700;
                box-shadow: 0 8px 24px rgba(0,0,0,0.2);
                z-index: 10000;
                display: flex;
                align-items: center;
                gap: 0.75rem;
                animation: slideDown 0.3s ease;
                max-width: 90vw;
                overflow: hidden;
            `;

            notification.innerHTML = `
                <i class="fas fa-${colors[type].icon}"></i>
                <span>${message}</span>
            `;

            document.body.appendChild(notification);

            // Auto remove after duration
            setTimeout(() => {
                notification.style.animation = 'slideUp 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, duration);
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

            /* Search scrollbar styling */
            .search-suggestions::-webkit-scrollbar {
                width: 6px;
            }
            .search-suggestions::-webkit-scrollbar-track {
                background: rgba(16, 185, 129, 0.1);
                border-radius: 3px;
            }
            .search-suggestions::-webkit-scrollbar-thumb {
                background: var(--primary);
                border-radius: 3px;
            }
            .search-suggestions::-webkit-scrollbar-thumb:hover {
                background: var(--primary-dark);
            }
        `;
        document.head.appendChild(style);
    </script>

    <!-- Mobile Bottom Navigation -->
    <nav class="bottom-nav mobile-only">
        <a href="{{ route('home') }}" class="bottom-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span>الرئيسية</span>
        </a>
        <a href="{{ route('products.index') }}" class="bottom-nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
            <i class="fas fa-th"></i>
            <span>المنتجات</span>
        </a>
        <a href="{{ route('shop.by-categories') }}" class="bottom-nav-item {{ request()->routeIs('shop.by-categories') ? 'active' : '' }}">
            <i class="fas fa-tags"></i>
            <span>التصنيفات</span>
        </a>
        <a href="{{ route('cart.index') }}" class="bottom-nav-item {{ request()->routeIs('cart.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i>
            <span>السلة</span>
        </a>
        <a href="{{ Auth::check() ? route('profile.index') : route('login') }}" class="bottom-nav-item {{ request()->routeIs('profile.*') || request()->routeIs('login') ? 'active' : '' }}">
            <i class="fas fa-user"></i>
            <span>{{ Auth::check() ? 'حسابي' : 'دخول' }}</span>
        </a>
    </nav>

    <script>
    // Smart Header Scroll Effect
    (function() {
        const header = document.querySelector('.header');
        if (!header) return;
        
        let lastScroll = 0;
        const scrollThreshold = 100; // Start hiding after 100px scroll
        
        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
            
            if (currentScroll > scrollThreshold) {
                // User scrolled down - make header compact
                header.classList.add('scrolled');
                lastScroll = currentScroll;
            } else {
                // User at top - show full header
                header.classList.remove('scrolled');
                lastScroll = currentScroll;
            }
        });
    })();
    
    // PWA Service Worker Registration
    (function() {
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('PWA: Service Worker Registered Successfully', registration.scope);
                        
                        // Check for updates every 60 seconds
                        setInterval(() => {
                            registration.update();
                        }, 60000);
                    })
                    .catch(function(error) {
                        console.log('PWA: Service Worker Registration Failed', error);
                    });
            });
        }
        
        // PWA Install Prompt
        let deferredPrompt;
        window.addEventListener('beforeinstallprompt', function(e) {
            console.log('PWA: Install Prompt Available');
            e.preventDefault();
            deferredPrompt = e;
            
            // Show install button
            const installButton = document.createElement('div');
            installButton.id = 'pwa-install-banner';
            installButton.innerHTML = `
                <div style="position: fixed; bottom: 80px; left: 20px; right: 20px; background: linear-gradient(135deg, #10b981, #059669);
                    color: white; padding: 1.25rem; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.2);
                    z-index: 10000; display: flex; align-items: center; gap: 1rem;
                    font-family: 'Tajawal', sans-serif;">
                    <div style="flex: 1;">
                        <div style="font-weight: 700; margin-bottom: 0.5rem;">📱 حمّل تطبيق لُجين</div>
                        <div style="font-size: 0.875rem; opacity: 0.9;">ثبت التطبيق للوصول السريع والاستخدام Offline</div>
                    </div>
                    <button onclick="installPWA()" style="background: white; color: #10b981; border: none;
                        padding: 0.75rem 1.5rem; border-radius: 12px; font-weight: 700; cursor: pointer;
                        font-family: 'Tajawal', sans-serif;">تثبيت</button>
                    <button onclick="dismissInstallBanner()" style="background: transparent; border: none;
                        color: white; font-size: 1.5rem; cursor: pointer; padding: 0 0.5rem;">&times;</button>
                </div>
            `;
            document.body.appendChild(installButton);
        });
        
        // Install PWA function
        window.installPWA = function() {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('PWA: User Accepted Install');
                    } else {
                        console.log('PWA: User Dismissed Install');
                    }
                    deferredPrompt = null;
                    dismissInstallBanner();
                });
            }
        };
        
        // Dismiss banner function
        window.dismissInstallBanner = function() {
            const banner = document.getElementById('pwa-install-banner');
            if (banner) {
                banner.style.animation = 'fadeOut 0.3s ease';
                setTimeout(() => banner.remove(), 300);
            }
        };
        
        // Already installed - hide banner
        window.addEventListener('appinstalled', function() {
            console.log('PWA: App Installed Successfully');
            dismissInstallBanner();
            deferredPrompt = null;
        });
    })();
    </script>
    
    <style>
    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(20px); }
    }

    /* Responsive: Categories Sidebar */
    @media (max-width: 1024px) {
        #categories-layout {
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        #categories-layout {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        #categories-layout > aside {
            position: static !important;
            order: 1;
        }

        #categories-layout > div {
            order: 2;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 1rem;
        }
    }
    </style>

</body>
</html>

