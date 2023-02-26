<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StolenCarRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * if it is a POST request, then the name, number, color, and vin fields must be required.
     *
     * @return string[]
     */
    public function rules():array
    {
        $regexLettersSpacesHyphens = 'regex:/^[a-zA-Zа-яґєіїА-ЯҐЄІЇ\s\-]+$/u';
        $regexLetterNumber = 'regex:/^[A-ZА-ЯІ0-9]+$/u';
        $regexLetterNumber17 = 'regex:/^[A-Z0-9]{17}$/u';
        $regexLettersHyphens = 'regex:/^[a-zA-Zа-яґєіїА-ЯҐЄІЇ-]*$/';

        if ($this->isMethod('post')) {
            return [
                'name'   => ['required', $regexLettersSpacesHyphens],
                'number' => ['required', $regexLetterNumber],
                'color'  => ['required', $regexLettersHyphens],
                'vin'    => ['required', $regexLetterNumber17],
            ];
        }

        if ($this->isMethod('put')) {
            return [
                'name'   => ['sometimes', 'required', $regexLettersSpacesHyphens],
                'number' => ['sometimes', 'required', $regexLetterNumber],
                'color'  => ['sometimes', 'required', $regexLettersHyphens],
            ];
        }

        return [
            'name'   => ['sometimes', 'required', $regexLettersSpacesHyphens],
            'number' => ['sometimes', 'required', $regexLetterNumber, 'unique:stolen_cars,number'],
            'color'  => ['sometimes', 'required', $regexLettersHyphens],
            'vin'    => ['sometimes', 'required', $regexLetterNumber17],
        ];
    }

    /**
     * @return string[]
     */
    public function messages():array
    {
        return [
            'name.required'   => 'Enter the name of the stolen car',
            'name.regex'      => 'The name field may only contain letters, spaces, and hyphens',
            'number.required' => 'Enter the number of the stolen car',
            'number.regex'    => 'The number field may only contain upper case letters and numbers',
            'number.unique'   => 'This number is already registered',
            'color.required'  => 'Specify the color of the stolen car',
            'color.regex'     => 'The color field may only contain letters and hyphens',
            'vin.required'    => 'Enter the VIN of the stolen car',
            'vin.regex'       => 'The VIN field may only upper case letters and numbers',
            'vin.unique'      => 'This VIN is already registered',
        ];
    }

}
