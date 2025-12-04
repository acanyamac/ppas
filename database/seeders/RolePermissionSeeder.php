<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Role::updateOrCreate([
            'name' => 'Admin',

        ]);

       

        Role::updateOrCreate([
            'name' => 'Denetim Koordinatoru',
            
        ]);

        $role= Role::findByName('Denetim Koordinatoru');

        $auditCoordinatorPermissions=[
            ['name'=>'Varlık Grubu İşlemleri'],
            ['name'=>'Varlık İşlemleri'],
            ['name'=>'Anket İşlemleri'],
            ['name'=>'Uygulanabilirlik Bildirgesi'],
            ['name'=>'Boşluk Analizi'],
            ['name'=>'Telafi Edici Kontrol Formları'],
          
            ['name'=>'Tedbir Ana Başlıkları'],
            ['name'=>'Tedbir Alt Başlıkları'],
            ['name'=>'Tedbirler'],

            ['name'=>'Denetçi İşlemleri'],
            ['name'=>'Bilgi Alınan Personel'],
            ['name'=>'Denetim Oluştur'],
            ['name'=>'Denetime Denetçi Ata'],
            ['name'=>'Denetime Personel Ata'],
            ['name'=>'Denetime Varlık Ata'],
            ['name'=>'Denetim Programı'],
            ['name'=>'Uygulama Süreci Değerlendir'],
            ['name'=>'Tedbir Etkinlik Durumu'],
            ['name'=>'Bulgular'],
            

            ['name'=>'Raporlar'],
            ['name'=>'Çalışma Formları'],
            ['name'=>'Dokumanlar'],


        ];
        
        foreach ($auditCoordinatorPermissions as $permissionData) {
            $permission = Permission::updateOrCreate($permissionData);
            $role->givePermissionTo($permission);
        }


        Role::updateOrCreate([
            'name' => 'Denetçi',
            
        ]);

        $role= Role::findByName('Denetçi');

        $auditorPermissions=[
            ['name'=>'Denetçi İşlemleri'],
            ['name'=>'Bilgi Alınan Personel'],
            ['name'=>'Denetim Oluştur'],
            ['name'=>'Denetime Denetçi Ata'],
            ['name'=>'Denetime Personel Ata'],
            ['name'=>'Denetime Varlık Ata'],
            ['name'=>'Denetim Programı'],
            ['name'=>'Uygulama Süreci Değerlendir'],
            ['name'=>'Tedbir Etkinlik Durumu'],
            ['name'=>'Bulgular'],

            ['name'=>'Raporlar'],
            ['name'=>'Çalışma Formları'],

            

        ];
        
        foreach ($auditorPermissions as $permissionData) {
            $permission = Permission::updateOrCreate($permissionData);
            $role->givePermissionTo($permission);
        }

        Role::updateOrCreate([
            'name' => 'Envanter Yöneticisi',
            
        ]);

        $role= Role::findByName('Envanter Yöneticisi');

        $inventoryManagerPermissions=[
            ['name'=>'Varlık Grubu İşlemleri'],
            ['name'=>'Varlık İşlemleri'],
            ['name'=>'Uygulanabilirlik Bildirgesi'],
            ['name'=>'Boşluk Analizi'],
            ['name'=>'Telafi Edici Kontrol Formları'],
        ];

        foreach ($inventoryManagerPermissions as $permissionData) {
            $permission = Permission::updateOrCreate($permissionData);
            $role->givePermissionTo($permission);
        }

        Role::updateOrCreate([
            'name' => 'Siber Güvenlik Yöneticisi',
            
        ]);

        $role= Role::findByName('Siber Güvenlik Yöneticisi');

        $cyberSecurityManagerPermissions=[
            ['name'=>'Varlık Grubu İşlemleri'],
            ['name'=>'Varlık İşlemleri'],
            ['name'=>'Uygulanabilirlik Bildirgesi'],
            ['name'=>'Boşluk Analizi'],
            ['name'=>'Telafi Edici Kontrol Formları'],
            ['name'=>'İş Paketleri'],
            ['name'=>'Tedbir Ana Başlıkları'],
            ['name'=>'Tedbir Alt Başlıkları'],
            ['name'=>'Tedbirler'],

            ['name'=>'Raporlar'],
            ['name'=>'Çalışma Formları'],

        ];
        
        foreach ($cyberSecurityManagerPermissions as $permissionData) {
            $permission = Permission::updateOrCreate($permissionData);
            $role->givePermissionTo($permission);
        }

        Role::updateOrCreate([
            'name' => 'Anket Kullanıcısı',
            
        ]);


        
        Role::updateOrCreate([
            'name' => 'Super Admin',

        ]);

        $role= Role::findByName('Super Admin');

        
        $serviceRequestsPermissions=[
            ['name'=>'Servis İstekleri'],
            ['name'=>'Dokumanlar'],
        ];
           

        foreach ($serviceRequestsPermissions as $permissionData) {
            $permission = Permission::updateOrCreate($permissionData);
            $role->givePermissionTo($permission);
        }

        //Süper Admin'e tüm yetkileri ver
        $allPermissions=Permission::pluck('id')->toArray();
        
        foreach ($allPermissions as $permission) {
            
            $role->givePermissionTo($permission);
        }

        
        $role= Role::findByName('Admin');

        //Admin'e yetkileri ver
        //Şimdilik tüm yetkiler verildi
        $allPermissions=Permission::pluck('id')->toArray();
       
        foreach ($allPermissions as $permission) {
            
            $role->givePermissionTo($permission);
        }

    }
}
