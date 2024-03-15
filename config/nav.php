<?php

return[
    [
        'icon' => 'nav-icon fa-solid fa-house',
        'route' => 'dashboard.dashboard',
        'title' => 'Dashboard',
        'active' => 'dashboard.dashboard'
    ],
    [
        'icon' => 'nav-icon fa-solid fa-layer-group',
        'route' => 'dashboard.categories.index',
        'title' => 'Categories',
        'badge' => 'New',
        'active' => 'dashboard.categories.*'
    ],
    [
        'icon' => 'nav-icon fa-solid fa-box-open',
        'route' => 'dashboard.products.index',
        'title' => 'Products',
        'active' => 'dashboard.products.*'
    ],
    [
        'icon' => 'nav-icon fa-sharp fa-solid fa-truck',
        'route' => 'dashboard.categories.index',
        'title' => 'Orders',
        'active' => 'dashboard.orders.*'
    ]
];
