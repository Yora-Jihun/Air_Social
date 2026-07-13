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
    'check'       => '<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>',
    'clock' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z"/>',
    'x' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>',
    'info' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-4m0-4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>',

    // Brand / marketing
    'trending-up' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5l6-6 4 4 8-8"/><path stroke-linecap="round" stroke-linejoin="round" d="M14 6h7v7"/>',

    // Marketing feature bullets
    'users'       => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>',
    'shield-check' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>',
    'blocks'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/>',

];
