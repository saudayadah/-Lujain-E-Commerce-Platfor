@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="pagination-wrapper">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">
                        <i class="fas fa-chevron-right"></i>
                        <span class="page-text">السابق</span>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <i class="fas fa-chevron-right"></i>
                        <span class="page-text">السابق</span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <span class="page-text">التالي</span>
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">
                        <span class="page-text">التالي</span>
                        <i class="fas fa-chevron-left"></i>
                    </span>
                </li>
            @endif
        </ul>

        {{-- Results Info --}}
        <div class="pagination-info">
            <p>
                عرض 
                <span class="font-weight-bold">{{ $paginator->firstItem() }}</span>
                إلى
                <span class="font-weight-bold">{{ $paginator->lastItem() }}</span>
                من
                <span class="font-weight-bold">{{ $paginator->total() }}</span>
                نتيجة
            </p>
        </div>
    </nav>

    <style>
        .pagination-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            margin: 2rem 0;
            padding: 1.5rem;
            background: linear-gradient(135deg, rgba(240, 253, 244, 0.5), rgba(255, 255, 255, 0.8));
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .pagination {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            list-style: none;
            padding: 0;
            margin: 0;
            justify-content: center;
            align-items: center;
        }

        .page-item {
            margin: 0;
        }

        .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            min-width: 44px;
            height: 44px;
            padding: 0.625rem 1rem;
            background: white;
            color: #374151;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9375rem;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            font-family: 'Tajawal', 'IBM Plex Sans Arabic', sans-serif;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .page-link:hover {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border-color: #10b981;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .page-link i {
            font-size: 0.875rem;
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border-color: #10b981;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            transform: scale(1.05);
        }

        .page-item.disabled .page-link {
            background: #f3f4f6;
            color: #9ca3af;
            border-color: #e5e7eb;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .page-item.disabled .page-link:hover {
            background: #f3f4f6;
            color: #9ca3af;
            transform: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        /* تصميم خاص لأزرار السابق والتالي */
        .page-link .page-text {
            font-size: 0.9375rem;
            font-weight: 600;
        }

        /* معلومات النتائج */
        .pagination-info {
            text-align: center;
            color: #6b7280;
            font-size: 0.9375rem;
            font-weight: 500;
        }

        .pagination-info .font-weight-bold {
            color: #10b981;
            font-weight: 700;
            font-size: 1.0625rem;
        }

        /* Responsive للموبايل */
        @media (max-width: 640px) {
            .pagination-wrapper {
                padding: 1rem;
            }

            .page-link {
                min-width: 38px;
                height: 38px;
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
            }

            .page-link .page-text {
                display: none;
            }

            .page-link i {
                font-size: 0.8125rem;
            }

            .pagination {
                gap: 0.375rem;
            }

            .pagination-info {
                font-size: 0.875rem;
            }

            .pagination-info .font-weight-bold {
                font-size: 0.9375rem;
            }
        }

        /* أرقام الصفحات فقط (بدون نص) */
        .page-item:not(:first-child):not(:last-child) .page-link {
            min-width: 44px;
            padding: 0.625rem;
        }

        @media (max-width: 640px) {
            .page-item:not(:first-child):not(:last-child) .page-link {
                min-width: 38px;
                padding: 0.5rem;
            }
        }

        /* تأثير hover احترافي */
        .page-link {
            position: relative;
            overflow: hidden;
        }

        .page-link::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.4s, height 0.4s;
        }

        .page-link:hover::before {
            width: 200%;
            height: 200%;
        }

        .page-link span,
        .page-link i {
            position: relative;
            z-index: 1;
        }

        /* تأثير للصفحة النشطة */
        .page-item.active .page-link {
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3), 
                        0 0 0 4px rgba(16, 185, 129, 0.1);
        }

        @keyframes pulseActive {
            0%, 100% {
                box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3), 
                            0 0 0 4px rgba(16, 185, 129, 0.1);
            }
            50% {
                box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4), 
                            0 0 0 6px rgba(16, 185, 129, 0.15);
            }
        }

        .page-item.active .page-link {
            animation: pulseActive 2s infinite ease-in-out;
        }
    </style>
@endif

