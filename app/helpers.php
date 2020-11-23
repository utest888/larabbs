<?php

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return Str::limit($excerpt, $length);
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

function if_query($query, $value)
{
    return request()->query($query) == $value;
}

function active_class($active)
{
    return $active ? 'active' : '';
}


function model_admin_link($title, $model)
{
    return model_link($title, $model, 'admin');
}
function model_link($title, $model, $prefix = '')
{
    // 获取数据模型的复数蛇形命名
    $model_name = model_plural_name($model);
    // 初始化前缀
    $prefix = $prefix ? "/$prefix/" : '/';
    // 使用站点 URL 拼接全量 URL
    $url = config('app.url') . $prefix . $model_name . '/' . $model->id;
    // 拼接 HTML A 标签，并返回
    return '<a href="' . $url . '" target="_blank">' . $title . '</a>';
}
function model_plural_name($model)
{
    // 从实体中获取完整类名，例如：App\Models\User
    $full_class_name = get_class($model);
    // 获取基础类名，例如：传参 `App\Models\User` 会得到 `User`
    $class_name = class_basename($full_class_name);
    // 蛇形命名，例如：传参 `User` 会得到 `user`, `FooBar` 会得到 `foo_bar`
    $snake_case_name = Str::snake($class_name);
    // 获取子串的复数形式，例如：传参 `user` 会得到 `users`
    return Str::plural($snake_case_name);
}
