<?php

namespace App\Traits;

trait HandlesApiResponse
{
    /**
     * إرجاع استجابة JSON موحدة
     */
    protected function successResponse($data = null, string $message = 'تمت العملية بنجاح', int $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * إرجاع استجابة خطأ موحدة
     */
    protected function errorResponse(string $message = 'حدث خطأ', $errors = null, int $status = 400)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }

    /**
     * معالجة الأخطاء بشكل موحد
     */
    protected function handleException(\Exception $e, string $defaultMessage = 'حدث خطأ غير متوقع')
    {
        \Log::error($e->getMessage(), [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);

        if (request()->expectsJson()) {
            return $this->errorResponse($defaultMessage, null, 500);
        }

        return back()->with('error', $defaultMessage);
    }
}

