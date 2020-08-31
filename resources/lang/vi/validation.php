<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute phải được chấp nhận.',
    'active_url'           => ':attribute đường dẫn URL không hợp lệ.',
    'after'                => ':attribute phải là một ngày sau :date.',
    'after_or_equal'       => ':attribute phải là một ngày sau hoặc bằng với :date.',
    'alpha'                => ':attribute chỉ chứa những chữ.',
    'alpha_dash'           => ':attribute chỉ chứa những chữ, số, và dấu gạch ngang.',
    'alpha_num'            => ':attribute chỉ chứa những chữ và số.',
    'array'                => ':attribute phải là một mảng.',
    'before'               => ':attribute phải là một ngày sau :date.',
    'before_or_equal'      => ':attribute phải là một ngày trước hoặc bằng với :date.',
    'between'              => [
        'numeric' => ':attribute phải giữa :min và :max.',
        'file'    => ':attribute phải giữa :min và :max kilobytes.',
        'string'  => ':attribute phải giữa :min và :max characters.',
        'array'   => ':attribute phải giữa :min và :max phần.',
    ],
    'boolean'              => ':attribute phải là có hoặc không.',
    'confirmed'            => ':attribute xác nhận không đúng.',
    'date'                 => ':attribute ngày không hợp lệ.',
    'date_format'          => ':attribute không đúng đinh dạng :format.',
    'different'            => ':attribute và :other phải khách nhau.',
    'digits'               => ':attribute phải là :digits số.',
    'digits_between'       => ':attribute phải giữa :min và :max số.',
    'dimensions'           => ':attribute khích thước hình ảnh không hợp lệ.',
    'distinct'             => ':attribute có một giá trị trùng.',
    'email'                => ':attribute phải là địa chỉ emal hợp lệ.',
    'exists'               => 'phần chọn :attribute không hợp lệ.',
    'file'                 => ':attribute phải là dạng tệp.',
    'filled'               => ':attribute phải có một giá trị.',
    'image'                => ':attribute phải là hình ảnh.',
    'in'                   => 'phần chọn :attribute không hợp lệ.',
    'in_array'             => ':attribute không tồn tại trong :other.',
    'integer'              => ':attribute phải là một số.',
    'ip'                   => ':attribute phải là địa chỉ IP hợp lệ.',
    'ipv4'                 => ':attribute phải là địa chỉ IPv4 hợp lệ.',
    'ipv6'                 => ':attribute phải là địa chỉ IPv6 hợp lệ.',
    'json'                 => ':attribute phải là dạng JSON.',
    'max'                  => [
        'numeric' => 'The :attribute không được nhiều hơn :max.',
        'file'    => 'The :attribute không được nhiều hơn :max kilobytes.',
        'string'  => 'The :attribute không được nhiều hơn :max ký tự.',
        'array'   => ':attribute không được nhiều hơn :max phần.',
    ],
    'mimes'                => ':attribute phải lài loại tệp: :values.',
    'mimetypes'            => ':attribute phải là loại tệp: :values.',
    'min'                  => [
        'numeric' => ':attribute ít nhất là :min.',
        'file'    => ':attribute ít nhất là :min kilobytes.',
        'string'  => ':attribute ít nhất :min ký tự.',
        'array'   => ':attribute ít nhất là :min phần.',
    ],
    'not_in'               => 'phần chọn :attribute không hợp lệ.',
    'numeric'              => ':attribute phải là một số.',
    'present'              => ':attribute phải có.',
    'regex'                => ':attribute định dạng không hợp lệ.',
    'required'             => ':attribute là bắt buộc.',
    'required_if'          => ':attribute bắt buộc khi :other là :value.',
    'required_unless'      => ':attribute bắt buộc trừ khi :other trong :values.',
    'required_with'        => ':attribute bắt buộc khi :values là đại diện.',
    'required_with_all'    => ':attribute bắt buộc khi :values là đại diện.',
    'required_without'     => ':attribute bắt buộc khi :values không là đại diện.',
    'required_without_all' => ':attribute bắt buộc khi không có :values là đại diện.',
    'same'                 => ':attribute và :other phải trùng nhau.',
    'size'                 => [
        'numeric' => ':attribute phải là :size.',
        'file'    => ':attribute phải là :size kilobytes.',
        'string'  => ':attribute phải có :size ký tự.',
        'array'   => ':attribute phải chứa :size phần.',
    ],
    'string'               => ':attribute phải là dạng chữ.',
    'timezone'             => ':attribute phải là vùng hợp lệ.',
    'unique'               => ':attribute đã tồn tại.',
    'uploaded'             => ':attribute tải lên thất bại.',
    'url'                  => ':attribute không đúng định dạng.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
    ],

];
