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

    "accepted" => "Das :attribute muss akzeptiert werden.",
    "accepted_if" => "Das :attribute muss akzeptiert werden, wenn :other :value ist.",
    "active_url" => "Der :attribute ist keine gültige URL.",
    "after" => "Das :attribute muss ein Datum nach :date sein.",
    "after_or_equal" => "Das :attribute muss ein Datum nach oder gleich :date sein.",
    "alpha" => "Das :attribute darf nur Buchstaben enthalten.",
    "alpha_dash" => "Das :attribute darf nur Buchstaben, Ziffern, Bindestriche und Unterstriche enthalten.",
    "alpha_num" => "Das :attribute darf nur Buchstaben und Zahlen enthalten.",
    "array" => "Das :attribute muss ein Array sein.",
    "before" => "Das :attribute muss ein Datum vor :date sein.",
    "before_or_equal" => "Das :attribute muss ein Datum vor oder gleich :date sein.",
    "between" => [
        "numeric" => "Der :attribute muss zwischen :min und :max liegen.",
        "file" => "Der :attribute muss zwischen :min und :max Kilobyte liegen.",
        "string" => "Das :attribute muss zwischen den Zeichen :min und :max liegen.",
        "array" => "Das :attribute muss zwischen :min und :max Elemente haben."
    ],
    "boolean" => "Das :attribute Feld muss wahr oder falsch sein.",
    "confirmed" => "'Die' :attribute Bestätigung stimmt nicht überein.",
    "current_password" => "'Das Passwort ist inkorrekt.",
    "date" => "Das :attribute ist kein gültiges Datum.",
    "date_equals" => "Das :attribute muss ein Datum gleich :date sein.",
    "date_format" => "Das :attribute stimmt nicht mit dem Format :format überein.",
    "declined" => "Das :attribute muss abgelehnt werden.",
    "declined_if" => "'The' :attribute muss abgelehnt werden, wenn :other :value ist.",
    "different" => "'The' :attribute und :other müssen unterschiedlich sein.",
    "digits" => "'Die' :attribute müssen :digits Ziffern sein.",
    "digits_between" => "'Die' :attribute muss zwischen den Ziffern :min und :max liegen.",
    "dimensions" => "Das :attribute hat ungültige Bildabmessungen.",
    "distinct" => "Das Feld :attribute hat einen doppelten Wert.",
    "email" => "Das :attribute muss eine gültige E-Mail-Adresse sein.",
    "ends_with" => "Das :attribute muss mit einem der folgenden enden: :values.",
    "enum" => "Das ausgewählte :attribute ist ungültig.",
    "exists" => "Das ausgewählte :attribute ist ungültig.",
    "file" => "Das :attribute muss eine Datei sein.",
    "filled" => "Das :attribute Feld muss einen Wert haben.",
    "gt" => [
        "numeric" => "Der :attribute muss größer als :value sein.",
        "file" => "Der :attribute muss größer als :value Kilobyte sein.",
        "string" => "'Die' :attribute müssen größer als :value Zeichen sein.",
        "array" => "Das :attribute muss mehr als :value Elemente haben."
    ],
    "gte" => [
        "numeric" => "Der :attribute muss größer oder gleich :value sein.",
        "file" => "Der :attribute muss größer oder gleich :value Kilobyte sein.",
        "string" => "Das :attribute muss größer oder gleich :value Zeichen sein.",
        "array" => "Das :attribute muss :value Elemente oder mehr haben."
    ],
    "image" => "Das :attribute muss ein Bild sein.",
    "in" => "Das ausgewählte :attribute ist ungültig.",
    "in_array" => "Das Feld :attribute existiert nicht in :other.",
    "integer" => "Das :attribute muss eine Ganzzahl sein.",
    "ip" => "Das :attribute muss eine gültige IP-Adresse sein.",
    "ipv4" => "Das :attribute muss eine gültige IPv4-Adresse sein.",
    "ipv6" => "Das :attribute muss eine gültige IPv6-Adresse sein.",
    "json" => "„Der“ „_attr1_“ muss eine gültige JSON-Zeichenfolge sein.",
    "lt" => [
        "numeric" => "Der :attribute muss kleiner als :value sein.",
        "file" => "Der :attribute muss kleiner als :value Kilobyte sein.",
        "string" => "'Die' :attribute müssen weniger als :value Zeichen sein.",
        "array" => "Das :attribute muss weniger als :value Elemente haben."
    ],
    "lte" => [
        "numeric" => "Der :attribute muss kleiner oder gleich :value sein.",
        "file" => "Der :attribute muss kleiner oder gleich :value Kilobyte sein.",
        "string" => "Das :attribute muss kleiner oder gleich :value Zeichen sein.",
        "array" => "Das :attribute darf nicht mehr als :value Elemente haben."
    ],
    "mac_address" => "Das :attribute muss eine gültige MAC-Adresse sein.",
    "max" => [
        "numeric" => "Der :attribute darf nicht größer als :max sein.",
        "file" => "Der :attribute darf nicht größer als :max Kilobyte sein.",
        "string" => "Das :attribute darf nicht größer als :max Zeichen sein.",
        "array" => "Das :attribute darf nicht mehr als :max Elemente haben."
    ],
    "mimes" => "Das :attribute muss eine Datei des Typs sein: :values.",
    "mimetypes" => "Das :attribute muss eine Datei des Typs sein: :values.",
    "min" => [
        "numeric" => "Der :attribute muss mindestens :min sein.",
        "file" => "Das :attribute muss mindestens :min Kilobyte groß sein.",
        "string" => "Das :attribute muss mindestens :min Zeichen lang sein.",
        "array" => "Das :attribute muss mindestens :min Elemente haben."
    ],
    "multiple_of" => "Das :attribute muss ein Vielfaches von :value sein.",
    "not_in" => "Das ausgewählte :attribute ist ungültig.",
    "not_regex" => "Das :attribute-Format ist ungültig.",
    "numeric" => "Das :attribute muss eine Zahl sein.",
    "password" => "'Das Passwort ist inkorrekt.",
    "present" => "Das :attribute Feld muss vorhanden sein.",
    "prohibited" => "Das :attribute Feld ist verboten.",
    "prohibited_if" => "Das :attribute-Feld ist verboten, wenn :other :value ist.",
    "prohibited_unless" => "Das :attribute-Feld ist verboten, es sei denn, :other ist in :values enthalten.",
    "prohibits" => "Das :attribute-Feld verhindert, dass :other vorhanden ist.",
    "regex" => "Das :attribute-Format ist ungültig.",
    "required" => "Das :attribute Feld ist erforderlich.",
    "required_array_keys" => "Das Feld :attribute muss Einträge enthalten für: :values.",
    "required_if" => "Das :attribute-Feld ist erforderlich, wenn :other :value ist.",
    "required_unless" => "Das :attribute-Feld ist erforderlich, es sei denn, :other ist in :values enthalten.",
    "required_with" => "Das Feld :attribute ist erforderlich, wenn :values vorhanden ist.",
    "required_with_all" => "Das :attribute-Feld ist erforderlich, wenn :values vorhanden sind.",
    "required_without" => "Das :attribute-Feld ist erforderlich, wenn :values nicht vorhanden ist.",
    "required_without_all" => "Das :attribute-Feld ist erforderlich, wenn keiner der :values vorhanden ist.",
    "same" => "'The' :attribute und :other müssen übereinstimmen.",
    "size" => [
        "numeric" => "Das :attribute muss :size sein.",
        "file" => "Das :attribute muss :size Kilobyte sein.",
        "string" => "'Die' :attribute müssen :size Zeichen sein.",
        "array" => "Das :attribute muss :size Elemente enthalten."
    ],
    "starts_with" => "Das :attribute muss mit einem der folgenden beginnen: :values.",
    "string" => "Das :attribute muss eine Zeichenkette sein.",
    "timezone" => "Das :attribute muss eine gültige Zeitzone sein.",
    "unique" => "Das :attribute wurde bereits vergeben.",
    "uploaded" => "Das :attribute konnte nicht hochgeladen werden.",
    "url" => "Der :attribute muss eine gültige URL sein.",
    "uuid" => "Das :attribute muss eine gültige UUID sein.",

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
