<?php

namespace App\Helpers;
use App\Category;

class MenuHelper
{
    /**
     * Get menus
     *
     * @param NULL 
     * @return array
     */
    public static function getMenu () 
    {
        $allMenus = Category::whereNotNull('category_slug')                        
            ->where('parent_category_id', 0)
            ->with(['childrenRecursive' => function($query) {
                    $query->orderBy('category_level', 'ASC');
                }
            ])
            ->orderBy('category_level', 'ASC')
            ->get();
        
        return $allMenus;
    }    
}