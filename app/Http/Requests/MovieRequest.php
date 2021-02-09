<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'path' => 'required|mimetypes:video/avi,video/mpeg,video/quicktime,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/x-msvideo,video/x-ms-wmv',
        ];

    }
}
