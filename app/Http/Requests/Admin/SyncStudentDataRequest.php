<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class SyncStudentDataRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sync_type' => 'required',
            'local_to_center_specific_username' => 'required_if:sync_type,local_to_center_specific',
            'center_to_local_specific_username' => 'required_if:sync_type,center_to_local_specific',
            'g-recaptcha-response' => 'required|recaptcha',
        ];
    }

    /**
     * Set custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'sync_type.required' => 'The sync type field is required.',
            'local_to_center_specific_username.required_if' => 'The username field is required.',
            'center_to_local_specific_username.required_if' => 'The username type field is required.',
            'g-recaptcha-response.required' => 'Please ensure that you are a human!',
        ];
    }

}