<?php
if (!function_exists('moodColor')) {
    function moodColor($mood)
    {
        $colors = [
            'Happy' => '#94FB1D',
            'Sad'     => '#001A57',
            'Angry'   => '#A61C33',
            'Disappointed'    => '#708090',
            'Excited' => '#FF5A77',
            'In Love' => '#ff62c5'

        ];
        return $colors[$mood] ?? '#ccc';
    }
}
