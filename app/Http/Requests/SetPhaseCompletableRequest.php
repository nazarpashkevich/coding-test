<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetPhaseCompletableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'is_completable' => ['required', 'boolean'],
        ];
    }

    public function isCompletable(): bool
    {
        return $this->boolean('is_completable');
    }
}
