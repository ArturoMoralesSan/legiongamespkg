<?php

namespace Database\Seeders;

use App\Models\Permission;
use DB;

class DashboardTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate(['dashboard_sections', 'dashboard_submenus', 'dashboard_links']);

        $permissions = Permission::all('id', 'key_name')->pluck('id', 'key_name');

        foreach ($this->getData() as $i => $section) {
            $sectionId = DB::table('dashboard_sections')->insertGetId([
                'name'       => $section['name'],
                'tile'       => $section['tile'],
                'order'      => $i + 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            foreach ($section['submenus'] as $j => $submenu) {
                $submenuId = DB::table('dashboard_submenus')->insertGetId([
                    'name'       => $submenu['name'],
                    'icon'       => $submenu['icon'],
                    'order'      => $j + 1,
                    'section_id' => $sectionId,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                foreach ($submenu['links'] as $k => $link) {
                    DB::table('dashboard_links')->insert([
                        'name'          => $link['name'],
                        'route'         => $link['route'],
                        'order'         => $k + 1,
                        'submenu_id'    => $submenuId,
                        'permission_id' => $permissions[$link['permission']],
                        'created_at'    => date('Y-m-d H:i:s'),
                        'updated_at'    => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }
    }



    /**
     * Return the data to populate tables.
     *
     * @return array
     */
    private function getData()
    {
        return [
            [
                'name' => 'ACL',
                'tile' => 'lock.svg',
                'submenus' => [
                    [
                        'name' => 'Permisos',
                        'icon' => 'permissions.svg',
                        'links' => [
                            [
                                'name'       => 'Agregar permisos',
                                'route'      => 'agregar-permisos',
                                'permission' => 'create.permissions'
                            ],
                            [
                                'name'       => 'Lista de permisos',
                                'route'      => 'permisos',
                                'permission' => 'view.permissions'
                            ]
                        ]
                    ],
                    [
                        'name' => 'Roles',
                        'icon' => 'role.svg',
                        'links' => [
                            [
                                'name'       => 'Agregar roles',
                                'route'      => 'agregar-roles',
                                'permission' => 'create.roles'
                            ],
                            [
                                'name'       => 'Lista de roles',
                                'route'      => 'roles',
                                'permission' => 'view.roles'
                            ]
                        ]
                    ],
                    [
                        'name' => 'Usuarios',
                        'icon' => 'users.svg',
                        'links' => [
                            [
                                'name'       => 'Lista de usuarios',
                                'route'      => 'usuarios',
                                'permission' => 'view.users'
                            ]
                        ],
                    ],
                    
                ]
            ],
            [
                'name' => 'Cluster',
                'tile' => 'Cluster.svg',
                'submenus' => [
                    
                    [
                        'name' => 'Directorio',
                        'icon' => 'directorio.svg',
                        'links' => [
                            [
                                'name'       => 'Agregar al directorio',
                                'route'      => 'agregar-directorio',
                                'permission' => 'create.directories'
                            ],
                            [
                                'name'       => 'Directorio',
                                'route'      => 'directorio',
                                'permission' => 'view.directories'
                            ],
                        ]
                    ],
                    [
                        'name' => 'Acerca',
                        'icon' => 'about.svg',
                        'links' => [
                            [
                                'name'       => 'Agregar datos en acerca',
                                'route'      => 'agregar-acerca',
                                'permission' => 'create.about'
                            ],
                            [
                                'name'       => 'Lista de datos generales',
                                'route'      => 'acerca',
                                'permission' => 'view.about'
                            ],
                        ]
                    ],
                    [
                        'name' => 'Servicios',
                        'icon' => 'about.svg',
                        'links' => [
                            [
                                'name'       => 'Agregar datos en servicios',
                                'route'      => 'agregar-servicios',
                                'permission' => 'create.services'
                            ],
                            [
                                'name'       => 'Lista de servicios',
                                'route'      => 'servicios',
                                'permission' => 'view.services'
                            ],
                        ]
                    ],
                    [
                        'name' => 'Contacto',
                        'icon' => 'about.svg',
                        'links' => [
                            [
                                'name'       => 'Agregar datos de contacto',
                                'route'      => 'agregar-contacto',
                                'permission' => 'create.contact'
                            ],
                            [
                                'name'       => 'Lista de datos contacto',
                                'route'      => 'contacto',
                                'permission' => 'view.contact'
                            ],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'Banners',
                'tile' => 'sliders.svg',
                'submenus' => [
                    [
                        'name' => 'Banners',
                        'icon' => 'sliders.svg',
                        'links' => [
                            [
                                'name'       => 'Agregar banner',
                                'route'      => 'agregar-banner',
                                'permission' => 'create.banners'
                            ],
                            [
                                'name'       => 'Lista de banners',
                                'route'      => 'banners',
                                'permission' => 'view.banners'
                            ],
                        ]
                    ],
                ]
            ],
            
        ];
    }
}

