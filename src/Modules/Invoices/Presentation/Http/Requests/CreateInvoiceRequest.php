<?php

namespace Modules\Invoices\Presentation\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\Invoices\Domain\Enums\StatusEnum;

class CreateInvoiceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_name'     => 'required|string|max:255',
            'customer_email'    => 'required|email',
            'status'            => 'required', Rule::enum(StatusEnum::class), Rule::in([StatusEnum::Draft->value]),
            'product_lines'     => 'nullable|string'
        ]; 
    }

    public function withValidator($validator) : void
    {
        $validator->after(function ($validator) {
            $productLinesJson = $this->input('product_lines');
            
            if (!empty($productLinesJson)) {
                // confirm if the json string is formatted properly
                if(!json_validate($productLinesJson)) {
                    $validator->errors()->add('product_lines', 'The product_lines field must be a valid JSON string');
                    return;
                }
                // confirm if the json has decoded properly
                $productLines = json_decode($productLinesJson, true);
                if (!is_array($productLines)) {
                    $validator->errors()->add('product_lines', 'The product_lines field must be a valid JSON array');
                    return;
                }

                // check each product value
                foreach ($productLines as $index => $value) {
                    if (!isset($value['quantity']) || $value['quantity'] < 0) {
                        $validator->errors()->add("product_lines[{$index}].quantity", 'Each product must have a quantity of over 0');
                    }

                    if (!isset($value['price']) || !is_numeric($value['price'])) {
                        $validator->errors()->add("product_lines[{$index}].price", 'Each product must have a valid price');
                    }

                    if($value['total_unit_price'] != $value['price'] * $value['quantity']) {
                        $validator->errors()->add("product_lines[{$index}].total_unit_price", 'Each product must have a valid total price');
                    }
                }

                // sum all product lines
                $totalSum = array_sum(array_column($productLines, 'price') ?? []);

                if ($totalSum <= 0) {
                    $validator->errors()->add('product_lines', 'The sum of all product value totals must be greater than 0');
                }
            }

            return;
        });
    }

    public function failedValidation($validator) : never
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422));
    }
}
