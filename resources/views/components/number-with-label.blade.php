<x-text-with-label
    {{ $attributes }}
    :name="$name"
    :label="$label"
    :type="'number'"
    :value="$value ?? ''"
/>