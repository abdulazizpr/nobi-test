<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Repositories\NetAssetRepository;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Http\FormRequest;

class WithdrawRequest extends FormRequest
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
     * Get current balance
     *
     * @return int
    */
    protected function getBalance()
    {
        $balance = 0;

        $userRepo = app(UserRepository::class);
        $user = $userRepo->find($this->user_id);

        if ($user instanceof User) {
            $netAssetRepo = app(NetAssetRepository::class);
            $netAsset = $netAssetRepo->getLastNetAsset();

            $balance = $user->total_unit * $netAsset->nab;
        }

        return $balance;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
    */
    public function rules()
    {
        $rules = [
            'user_id' => 'required|integer|exists:users,id',
            'amount' => 'required|integer|max:0',
        ];

        $balance = $this->getBalance();

        if ($balance > 0) {
            $rules['amount'] = str_replace('|max:0', '|min:0|max:' . $balance, $rules['amount']);
        }

        return $rules;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
    */
    public function messages()
    {
        $messages = [
            'amount.min' => 'The minimum withdraw is 1',
            'amount.max' => 'The maximum withdraw is 0',
        ];

        $balance = $this->getBalance();

        if ($balance > 0) {
            $messages['amount.max'] = str_replace('is 0', 'is ' . $balance, $messages['amount.max']);
        }

        return $messages;
    }
}