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

    "accepted" =>  "这  :attribute 必须被接受。",
    "accepted_if" =>  "当:other为:value时，必须接受这 :attribute 。",
    "active_url" =>  "这 :attribute 不是有效的 URL。",
    "after" =>  "这  :attribute 必须是 :date 之后的日期。",
    "after_or_equal" =>  "这 :attribute 的日期必须晚于或等于:date。",
    "alpha" =>  "这  :attribute 必须只包含字母。",
    "alpha_dash" =>  "这  :attribute 只能包含字母、数字、破折号和下划线。",
    "alpha_num" =>  "这  :attribute 必须只包含字母和数字。",
    "array" =>  "这  :attribute 必须是一个数组。",
    "before" =>  "这  :attribute 必须是 :date 之前的日期。",
    "before_or_equal" =>  "这  :attribute 的日期必须早于或等于 :date。",
    "between" =>  [
        "numeric" =>  "这  :attribute 必须介于 :min 和 :max 之间。",
        "file" =>  "这  :attribute 必须介于 :min 和 :max 千字节之间。",
        "string" =>  "这  :attribute 必须介于 :min 和 :max 字符之间。",
        "array" =>  "这  :attribute 必须介于 :min 和 :max 之间。"
    ],
    "boolean" =>  " => attribute 字段必须为 真的 或 错误的。",
    "confirmed" =>  " => attribute 确认不匹配。",
    "current_password" =>  "这密码不正确。",
    "date" =>  "这 :attribute 不是有效日期。",
    "date_equals" =>  "这  :attribute 必须是等于 :date 的日期。",
    "date_format" =>  "这 :attribute 与格式:format不匹配。",
    "declined" =>  "这  :attribute 必须被拒绝。",
    "declined_if" =>  "当:other为:value时，必须拒绝这 :attribute 。",
    "different" =>  "这  :attribute 和 :other 必须不同。",
    "digits" =>  " => attribute 必须是 :digits 个数字。",
    "digits_between" =>  "这  :attribute 必须介于 :min 和 :max 数字之间。",
    "dimensions" =>  "这 :attribute 的图像尺寸无效。",
    "distinct" =>  " => attribute 字段具有重复值。",
    "email" =>  " => attribute 必须是有效的电子邮件地址。",
    "ends_with" =>  "这 :attribute 必须以下列之一结尾：:values。",
    "enum" =>  "这选择的 :attribute 无效。",
    "exists" =>  "这选择的 :attribute 无效。",
    "file" =>  " => attribute 必须是一个文件。",
    "filled" =>  " => attribute 字段必须有一个值。",
    "gt" =>  [
        "numeric" =>  "这  :attribute 必须大于 :value。",
        "file" =>  "这  :attribute 必须大于 :value 千字节。",
        "string" =>  " => attribute 必须大于:value 个字符。",
        "array" =>  "这  :attribute 必须有超过 :value 个项目。"
    ],
    "gte" =>  [
        "numeric" =>  "这  :attribute 必须大于或等于 :value。",
        "file" =>  "这  :attribute 必须大于或等于 :value 千字节。",
        "string" =>  "这  :attribute 必须大于或等于 :value 个字符。",
        "array" =>  "这  :attribute 必须有 :value 项或更多。"
    ],
    "image" =>  "这  :attribute 必须是图像。",
    "in" =>  "这选择的 :attribute 无效。",
    "in_array" =>  " => other中不存在 :attribute 字段。",
    "integer" =>  "这  :attribute 必须是整数。",
    "ip" =>  " => attribute 必须是有效的 IP 地址。",
    "ipv4" =>  " => attribute 必须是有效的 IPv4 地址。",
    "ipv6" =>  " => attribute 必须是有效的 IPv6 地址。",
    "json" =>  "这  :attribute 必须是有效的 JSON 字符串。",
    "lt" =>  [
        "numeric" =>  "这  :attribute 必须小于 :value。",
        "file" =>  "这  :attribute 必须小于 :value 千字节。",
        "string" =>  "这  :attribute 必须少于 :value 个字符。",
        "array" =>  "这  :attribute 必须少于 :value 个项目。"
    ],
    "lte" =>  [
        "numeric" =>  "这  :attribute 必须小于或等于 :value。",
        "file" =>  "这  :attribute 必须小于或等于 :value 千字节。",
        "string" =>  "这  :attribute 必须小于或等于 :value 个字符。",
        "array" =>  "这  :attribute 不能超过 :value 个项目。"
    ],
    "mac_address" =>  " => attribute 必须是有效的 MAC 地址。",
    "max" =>  [
        "numeric" =>  "这  :attribute 不得大于 :max。",
        "file" =>  "这  :attribute 不得大于 :max 千字节。",
        "string" =>  "这  :attribute 不得大于 :max 个字符。",
        "array" =>  "这  :attribute 不能超过 :max 个项目。"
    ],
    "mimes" =>  "这 :attribute 必须是类型为:values的文件。",
    "mimetypes" =>  "这 :attribute 必须是类型为:values的文件。",
    "min" =>  [
        "numeric" =>  "这  :attribute 必须至少为 :min。",
        "file" =>  "这  :attribute 必须至少为 :min 千字节。",
        "string" =>  "这  :attribute 必须至少为 :min 个字符。",
        "array" =>  "这  :attribute 必须至少有 :min 个项目。"
    ],
    "multiple_of" =>  "这  :attribute 必须是 :value 的倍数。",
    "not_in" =>  "这选择的 :attribute 无效。",
    "not_regex" =>  " => attribute 格式无效。",
    "numeric" =>  "这  :attribute 必须是一个数字。",
    "password" =>  "这密码不正确。",
    "present" =>  " => attribute 字段必须存在。",
    "prohibited" =>  " => attribute 字段被禁止。",
    "prohibited_if" =>  "当:other为:value时，这 :attribute 字段被禁止。",
    "prohibited_unless" =>  "除非:other在:values中，否则这 :attribute 字段是被禁止的。",
    "prohibits" =>  " => attribute 字段禁止:other 出现。",
    "regex" =>  " => attribute 格式无效。",
    "required" =>  " => attribute 字段是必需的。",
    "required_array_keys" =>  "这 :attribute 字段必须包含以下条目：:values。",
    "required_if" =>  "当:other为:value时，这 :attribute 字段是必需的。",
    "required_unless" =>  "这 :attribute 字段是必需的，除非:other在:values中。",
    "required_with" =>  "当存在:values时，这 :attribute 字段是必需的。",
    "required_with_all" =>  "当存在:values时，这 :attribute 字段是必需的。",
    "required_without" =>  "当:values不存在时，这 :attribute 字段是必需的。",
    "required_without_all" =>  "当:values都不存在时，这 :attribute 字段是必需的。",
    "same" =>  "这  :attribute 和 :other 必须匹配。",
    "size" =>  [
        "numeric" =>  "这  :attribute 必须是 :size。",
        "file" =>  "这  :attribute 必须是 :size 千字节。",
        "string" =>  "这  :attribute 必须是 :size 个字符。",
        "array" =>  "这 :attribute 必须包含:size项。"
    ],
    "starts_with" =>  "这 :attribute 必须以下列之一开头：:values。",
    "string" =>  "这  :attribute 必须是字符串。",
    "timezone" =>  "这  :attribute 必须是有效的时区。",
    "unique" =>  " => attribute 已被占用。",
    "uploaded" =>  "这 :attribute 上传失败。",
    "url" =>  " => attribute 必须是有效的 URL。",
    "uuid" =>  "这  :attribute 必须是有效的 UUID。",

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
