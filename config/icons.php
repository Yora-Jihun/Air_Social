<?php

return [

    /*
    |--------------------------------------------------------------------------
    | UI Icons
    |--------------------------------------------------------------------------
    |
    | Every SVG used across inputs, buttons and small UI accents lives here so
    | they can be reviewed and updated in one place. Rendered via <x-icon name="..." />.
    | Inner markup only; the <svg> wrapper (viewBox, stroke, etc.) is added by
    | the icon component and can be overridden per usage through attributes.
    |
    */

    // Inputs
    'envelope' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L4.32 8.909A2.25 2.25 0 0 1 3.25 6.993V6.75"/>',
    'lock' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V7.5a4.5 4.5 0 1 0-9 0v3m-1.5 0h12a1.5 1.5 0 0 1 1.5 1.5v6a1.5 1.5 0 0 1-1.5 1.5h-12A1.5 1.5 0 0 1 4.5 18v-6A1.5 1.5 0 0 1 6 10.5Z"/>',
    'user' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5a4.5 4.5 0 1 0-4.5-4.5A4.5 4.5 0 0 0 12 10.5Zm-8.25 9a8.25 8.25 0 0 1 16.5 0"/>',    'eye' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.75 7.5-9.75 7.5S2.25 12 2.25 12Z"/><circle cx="12" cy="12" r="3" stroke-linecap="round" stroke-linejoin="round"/>',
    'eye-off' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.22A10.6 10.6 0 0 0 2.25 12s3.75 7.5 9.75 7.5c1.9 0 3.66-.54 5.13-1.46M6.3 6.3A10.6 10.6 0 0 1 12 4.5c6 0 9.75 7.5 9.75 7.5a10.6 10.6 0 0 1-2.13 3.02M3 3l18 18"/>',

    // Buttons / actions
    'arrow-right' => '<path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>',
    'arrow-left' => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>',
    'check' => '<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>',
    'clock' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z"/>',
    'x' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>',
    'info' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-4m0-4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>',

    // Brand / marketing
    'trending-up' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5l6-6 4 4 8-8"/><path stroke-linecap="round" stroke-linejoin="round" d="M14 6h7v7"/>',

];
