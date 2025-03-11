<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApprovalStageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'approver_id' => 'required|exists:approvers,id|unique:approval_stages,approver_id',
        ];
    }
}
