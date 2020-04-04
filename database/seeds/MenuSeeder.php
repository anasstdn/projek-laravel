<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Menu;
use App\Permission;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    	$this->command->info('Delete semua tabel menu');
    	Model::unguard();
    	Menu::truncate();
    	$this->menuHome();
    	$this->menuAcl();
    	$this->menuTools();
    	$this->menuPenjualan();
    	$this->menuPeramalan();
    }

    private function menuHome()
    {
    	$this->command->info('Menu Home Seeder');
    	$permission = Permission::firstOrNew(array(
    		'name'=>'read-home-menu'
    	));
    	$permission->display_name = 'Read Home Menus';
    	$permission->save();
    	$menu = Menu::firstOrNew(array(
    		'name'=>'Halaman Utama',
    		'permission_id'=>$permission->id,
    		'ordinal'=>1,
    		'parent_status'=>'N',
    		'url'=>'home',
    	));
    	$menu->icon = 'si-home';
    	$menu->save();
    }

    private function menuAcl(){
    	$this->command->info('Menu ACL Seeder');
    	$permission = Permission::firstOrNew(array(
    		'name'=>'read-acl-menu'
    	));
    	$permission->display_name = 'Read ACL Menus';
    	$permission->save();
    	$menu = Menu::firstOrNew(array(
    		'name'=>'Pengaturan ACL',
    		'permission_id'=>$permission->id,
    		'ordinal'=>1,
    		'parent_status'=>'Y'
    	));
    	$menu->icon = 'si-settings';
    	$menu->save();

          //create SUBMENU master
    	$permission = Permission::firstOrNew(array(
    		'name'=>'read-user',
    	));
    	$permission->display_name = 'Read Users';
    	$permission->save();

    	$submenu = Menu::firstOrNew(array(
    		'name'=>'Manajemen Pengguna',
    		'parent_id'=>$menu->id,
    		'permission_id'=>$permission->id,
    		'ordinal'=>2,
    		'parent_status'=>'N',
    		'url'=>'user',
    	)
    );
    	$submenu->save();

    	$permission = Permission::firstOrNew(array(
    		'name'=>'read-permission',
    	));
    	$permission->display_name = 'Read Permissions';
    	$permission->save();

    	$submenu = Menu::firstOrNew(array(
    		'name'=>'Manajemen Permissions',
    		'parent_id'=>$menu->id,
    		'permission_id'=>$permission->id,
    		'ordinal'=>2,
    		'parent_status'=>'N',
    		'url'=>'permission',
    	)
    );
    	$submenu->save();

    	$permission = Permission::firstOrNew(array(
    		'name'=>'read-menus',
    	));
    	$permission->display_name = 'Read Menus';
    	$permission->save();

    	$submenu = Menu::firstOrNew(array(
    		'name'=>'Manejemen Menu',
    		'parent_id'=>$menu->id,
    		'permission_id'=>$permission->id,
    		'ordinal'=>2,
    		'parent_status'=>'N',
    		'url'=>'menu',
    	)
    );
    	$submenu->save();

    	$permission = Permission::firstOrNew(array(
    		'name' => 'read-role',
    	));
    	$permission->display_name = 'Read Roles';
    	$permission->save();

    	$submenu = Menu::firstOrNew(array(
    		'name' => 'Manajemen Roles',
    		'parent_id' => $menu->id,
    		'permission_id' => $permission->id,
    		'ordinal' => 2,
    		'parent_status' => 'N',
    		'url' => 'role',
    	)
    );
    	$submenu->save();
    }

     private function menuTools(){
    	$this->command->info('Menu Tools Seeder');
    	$permission = Permission::firstOrNew(array(
    		'name'=>'read-data-menu'
    	));
    	$permission->display_name = 'Read Data Menus';
    	$permission->save();
    	$menu = Menu::firstOrNew(array(
    		'name'=>'Alat',
    		'permission_id'=>$permission->id,
    		'ordinal'=>1,
    		'parent_status'=>'Y'
    	));
    	$menu->icon = 'si-wrench';
    	$menu->save();

          //create SUBMENU master
    	$permission = Permission::firstOrNew(array(
    		'name'=>'read-data',
    	));
    	$permission->display_name = 'Read Data';
    	$permission->save();

    	$submenu = Menu::firstOrNew(array(
    		'name'=>'Import ke DB',
    		'parent_id'=>$menu->id,
    		'permission_id'=>$permission->id,
    		'ordinal'=>2,
    		'parent_status'=>'N',
    		'url'=>'data',
    	)
    );
    	$submenu->save();

        $permission = Permission::firstOrNew(array(
            'name'=>'read-activity',
        ));
        $permission->display_name = 'Read Activity';
        $permission->save();

        $submenu = Menu::firstOrNew(array(
            'name'=>'User Activity Log',
            'parent_id'=>$menu->id,
            'permission_id'=>$permission->id,
            'ordinal'=>2,
            'parent_status'=>'N',
            'url'=>'activity',
        )
    );
        $submenu->save();

        $permission = Permission::firstOrNew(array(
            'name'=>'read-barang-menu',
          ));
             $permission->display_name = 'Read Menu Wilayah';
             $permission->save();

             $submenu = Menu::firstOrNew(
               array(
              'name'=>'Barang',
              'parent_id'=>$menu->id,
              'permission_id'=>$permission->id,
              'ordinal'=>2,
              'parent_status'=>'Y',
            )
          );
             $submenu->save();
            
             $permission = Permission::firstOrNew(array(
              'name'=>'read-barang-golongan',
            ));
             $permission->display_name = 'Read Barang Golongan';
             $permission->save();

             $subsubmenu = Menu::firstOrNew(
               array(
              'name'=>'Golongan Barang',
              'parent_id'=>$submenu->id,
              'permission_id'=>$permission->id,
              'ordinal'=>3,
              'parent_status'=>'N',
              'url'=>'barang-golongan',
            )
          );
             $subsubmenu->save();

          //    $permission = Permission::firstOrNew(array(
          //   'name'=>'read-kabupaten',
          // ));
          //    $permission->display_name = 'Read Kabupaten';
          //    $permission->save();

          //    $subsubmenu = Menu::firstOrNew(
          //      array(
          //     'name'=>'Kabupaten',
          //     'parent_id'=>$submenu->id,
          //     'permission_id'=>$permission->id,
          //     'ordinal'=>3,
          //     'parent_status'=>'N',
          //     'url'=>'kabupaten',
          //   )
          // );
          //    $subsubmenu->save();

          //    $permission = Permission::firstOrNew(array(
          //   'name'=>'read-kecamatan',
          // ));
          //    $permission->display_name = 'Read Kecamatan';
          //    $permission->save();

          //    $subsubmenu = Menu::firstOrNew(
          //      array(
          //     'name'=>'Kecamatan',
          //     'parent_id'=>$submenu->id,
          //     'permission_id'=>$permission->id,
          //     'ordinal'=>3,
          //     'parent_status'=>'N',
          //     'url'=>'kecamatan',
          //   )
          // );
          //    $subsubmenu->save();

          //    $permission = Permission::firstOrNew(array(
          //   'name'=>'read-kelurahan',
          // ));
          //    $permission->display_name = 'Read Kelurahan';
          //    $permission->save();

          //    $subsubmenu = Menu::firstOrNew(
          //      array(
          //     'name'=>'Kelurahan',
          //     'parent_id'=>$submenu->id,
          //     'permission_id'=>$permission->id,
          //     'ordinal'=>3,
          //     'parent_status'=>'N',
          //     'url'=>'kelurahan',
          //   )
          // );
          // $subsubmenu->save();
    }

     private function menuPenjualan(){
    	$this->command->info('Menu Penjualan Seeder');
    	$permission = Permission::firstOrNew(array(
    		'name'=>'read-penjualan-menu'
    	));
    	$permission->display_name = 'Read Penjualan Menus';
    	$permission->save();
    	$menu = Menu::firstOrNew(array(
    		'name'=>'Transaksi',
    		'permission_id'=>$permission->id,
    		'ordinal'=>1,
    		'parent_status'=>'Y'
    	));
    	$menu->icon = 'si-basket';
    	$menu->save();

          //create SUBMENU master
    	$permission = Permission::firstOrNew(array(
    		'name'=>'read-penjualan',
    	));
    	$permission->display_name = 'Read Penjualan';
    	$permission->save();

    	$submenu = Menu::firstOrNew(array(
    		'name'=>'Laporan Penjualan',
    		'parent_id'=>$menu->id,
    		'permission_id'=>$permission->id,
    		'ordinal'=>2,
    		'parent_status'=>'N',
    		'url'=>'penjualan',
    	)
    );
    	$submenu->save();

    	$permission = Permission::firstOrNew(array(
    		'name'=>'read-chart',
    	));
    	$permission->display_name = 'Read Chart';
    	$permission->save();

    	$submenu = Menu::firstOrNew(array(
    		'name'=>'Grafik Penjualan',
    		'parent_id'=>$menu->id,
    		'permission_id'=>$permission->id,
    		'ordinal'=>2,
    		'parent_status'=>'N',
    		'url'=>'penjualan/chart',
    	)
    );
    	$submenu->save();
    }

    private function menuPeramalan()
    {
    	$this->command->info('Menu Peramalan Seeder');
    	$permission = Permission::firstOrNew(array(
    		'name'=>'read-peramalan-menu'
    	));
    	$permission->display_name = 'Read Peramalan Menus';
    	$permission->save();
    	$menu = Menu::firstOrNew(array(
    		'name'=>'Peramalan',
    		'permission_id'=>$permission->id,
    		'ordinal'=>1,
    		'parent_status'=>'N',
    		'url'=>'peramalan',
    	));
    	$menu->icon = 'si-graph';
    	$menu->save();
    }
}
