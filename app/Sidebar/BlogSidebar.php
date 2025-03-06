<?php
namespace App\Sidebar;

use Shopper\Sidebar\Contracts\Builder\Group;
use Shopper\Sidebar\Contracts\Builder\Item;
use Shopper\Sidebar\Contracts\Builder\Menu;
use Shopper\Sidebar\AbstractAdminSidebar;

class BlogSidebar extends AbstractAdminSidebar
{
    /**
     * Method used to define your sidebar menu groups and items.
     *
     * @param  Menu  $menu
     * @return Menu
     */
    public function extendWith(Menu $menu): Menu
    {
        $menu->group(__('Blog'), function (Group $group): void {
            $group->weight(10);
            $group->setAuthorized();
            $group->setGroupItemsClass('space-y-1');
            $group->setHeadingClass('sh-heading');

            $group->item(__('Posts'), function (Item $item): void {
                $item->weight(2);
                // $group->setAuthorized();
                $item->setItemClass('sh-sidebar-item group');
                $item->setActiveClass('sh-sidebar-item-active');
                $item->setInactiveClass('sh-sidebar-item-inactive');
                $item->useSpa();
                $item->route('posts');
                $item->setIcon(
                    icon: 'untitledui-tag',
                    iconClass: 'size-5 ' . ($item->isActive() ? 'text-primary-600' : 'text-gray-400 dark:text-gray-500'),
                    attributes: [
                        'stroke-width' => '1.5',
                    ],
                );
            });
        });

        return $menu;
    }
}