<?php

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Route;

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function is_topic_index()
{
    if (Route::currentRouteName() == 'topics.index') {
        return 'active';
    }

    return '';
}

function category_nav_active($category_id)
{
    if (Route::currentRouteName() == 'categories.show' &&  request('category')->id == $category_id) {
        return 'active';
    }
    return '';
}

function is_order_by($arg)
{
    if (request()->query('order') == 'recent') {
        if ($arg == 0) {
            return 'active';
        }
    } else {
        if ($arg == 1) {
            return 'active';
        }
    }
    return '';
}
