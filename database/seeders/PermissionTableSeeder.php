<?php
namespace Database\Seeders;

use DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate(['permissions']);

        foreach ($this->getData() as $keyName => $name) {
            DB::table('permissions')->insert([
                'key_name'   => $keyName,
                'name'       => $name,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }


    /**
     * Return the data to populate table.
     *
     * @return array
     */
    private function getData()
    {
        return [
             /*
             * Profile
             */
            'update.password' => 'Cambiar contraseña',
            'update.profile'  => 'Cambiar Perfil',

            /*
             * products
             */
            'view.about'   => 'Ver datos de acerca de',
            'create.about' => 'Agregar datos de acerca de',
            'edit.about'   => 'Editar datos de acerca de',
            'delete.about' => 'Eliminar datos de acerca de',

            /*
             * Categories
             */
            'view.directories'   => 'Ver directorios',
            'create.directories' => 'Agregar directorios',
            'edit.directories'   => 'Editar directorios',
            'delete.directories' => 'Eliminar directorios',

            /*
             * payments
             */
            'view.services'   => 'Ver servicios',
            'create.services' => 'Agregar servicios',
            'edit.services'   => 'Editar servicios',
            'delete.services' => 'Eliminar servicios',


            /*
             * payments
             */
            'view.contact'   => 'Ver datos de contacto',
            'create.contact' => 'Agregar datos de contacto',
            'edit.contact'   => 'Editar datos de contacto',
            'delete.contact' => 'Eliminar datos de contacto',


            /*
             * pagos
             */
            'view.banners'   => 'Ver banners',
            'create.banners' => 'Crear banners',
            'edit.banners'   => 'Editar banners',
            'delete.banners' => 'Eliminar banners',

            /*
             * permission
             */
            'view.permissions'   => 'Ver permisos',
            'create.permissions' => 'Agregar permisos',
            'edit.permissions'   => 'Editar permisos',
            'delete.permissions' => 'Eliminar permisos',

            /*
             * roles
             */
            'view.roles'   => 'Ver roles',
            'create.roles' => 'Agregar roles',
            'edit.roles'   => 'Editar roles',
            'delete.roles' => 'Eliminar roles',

            /*
             * Users
             */
            'view.users'   => 'Ver Usuarios',
            'create.users' => 'Agregar usuarios',
            
        ];
    }
}
