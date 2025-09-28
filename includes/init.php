<?php

    session_start();

    $accessed_page = $_SERVER['REQUEST_URI'];
    $is_accessed_page_auth = str_contains($accessed_page, 'auth.php');
    $is_accessed_page_index = str_contains($accessed_page, 'index.php');
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $is_user_set = $user_id;

    if (!$is_user_set && !$is_accessed_page_auth && !$is_accessed_page_index) {
            header("Location: ../public/auth.php"); // non-registered users can only visit Auth & Index pages
            exit();
    }

    if ($is_user_set && $is_accessed_page_auth) {
        header("Location: ../public/vocabulary.php");
    }


    $languages = [
        "english" => '🇬🇧 English',
        "french" => '🇫🇷 French',
        "spanish" => '🇪🇸 Spanish',
        "chinese" => '🇨🇳 Chinese',
        "german" => '🇩🇪 German',
        "japanese" => '🇯🇵 Japanese',
        "russian" => '🇷🇺 Russian',
        "arabic" => '🇸🇦 Arabic',
        "italian" => '🇮🇹 Italian',
        "portuguese" => '🇵🇹 Portuguese',
    ];
    
    $categories = [
        "food_drink" => 'Food & Drink',
        "travel_transportation" => 'Travel & Transportation',
        "family_relationships" => 'Family & Relationships',
        "work_professions" => 'Work & Professions',
        "education_school" => 'Education & School',
        "health_body" => 'Health & Body',
        "shopping_money" => 'Shopping & Money',
        "nature_environment" => 'Nature & Environment',
        "sports_hobbies" => 'Sports & Hobbies',
        "weather_seasons" => 'Weather & Seasons',
        "technology_computers" => 'Technology & Computers',
        "daily_routines" => 'Daily Routines</',
        "clothing_fashion" => 'Clothing & Fashion',
        "entertainment_media" => 'Entertainment & Media',
        "culture_holidays" => 'Culture & Holidays',
        "other" => 'Other',
    ];

    $strengths = [
        0 => 'Untested',
        1 => 'Weak',
        2 => 'Medium',
        3 => 'Strong',
        4 => 'Mastered',
    ];

    $big_title_styles = "text-center my-8 text-5xl text-green-600 font-mono";

    function get_time_interval ($timestamp, $flag = 'next_review') {
        date_default_timezone_set('Etc/GMT-4');
        $now = time();
        $then = strtotime($timestamp);
        $diff = floor(($then - $now)/60/60); // in hrs

        if ($diff > 23) {
            $diff = floor($diff / 24); // in days
            if ($diff == 1) $diff = '~' . $diff . ' day';  // "1 day"
            else $diff = '~' . $diff . ' days'; // "2+ days"
        } elseif ($diff < 0 && $flag === 'next_review') {
            $diff = 'Due';
        } elseif ($diff < 0 && $flag !== 'next_review') {
            if ($diff == -1) $diff = '~' . abs($diff) . ' day';  // "1 day"
            else $diff = '~' . abs($diff) . ' days'; // "2+ days"
        }
        else {
            $diff = '~' . $diff . ' hrs';
        }
        return $diff;
    }