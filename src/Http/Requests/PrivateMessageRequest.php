<?php

namespace drhd\inbox\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;


class PrivateMessageRequest extends FormRequest {

    protected $errorBag = 'form';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'receiver_name'      => 'required',
            'private_message_text' => 'required',
        ];
    }

    public function messages() {
        return [
            'receiver_name.required'      => 'Empfängernamen bitte angeben.',
            'private_message_text.required' => 'Die Nachricht darf nicht leer sein.',
        ];
    }

}