<?php

namespace App\Http\Controllers\Management\Roles;

use App\Models\SidebarMenu;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $excludedRoles = ['Super Admin'];
        $roles = Role::whereNotIn('name', $excludedRoles)->get();

        return view('yonetimsel-islemler.roller.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $menus = SidebarMenu::whereNotIn('name', ['Yönetimsel İşlemler'])->get();
        $subMenus = SidebarMenu::whereNotIn('name', ['Yönetimsel İşlemler'])->whereNot('parent_id', 0)->get();
        //dd($subMenus);
        return view('yonetimsel-islemler.roller.add', compact('roles', 'menus', 'subMenus'));
    }

     //Rol ekleme
     public function storeRole(Request $request)
     {
        
        $request->validate([

           
            'name' => 'required|string|max:255',
            
        ]);
        Role::updateOrCreate($request->except('_token'));
        return  redirect()->back()->with('message', 'Rol başarıyla eklendi');

     }
   
    //Role izinleri ekleme
    public function store(Request $request)
    {
        

        //dd($request->except('_token','role_id'));

        $role = Role::findById($request->role_id);

        // Role ait tüm izinleri kaldırıp hali hazırda seçili olanları tekrar ekliyeceğiz
        $role->permissions()->detach();


        //Burada izin isimlerine göre ekleme yaptığım için biraz dolanbaçlı oldu
        foreach ($request->except('_token', 'role_id') as $permissionName => $value) {

            //ismlerdeki boşluğu sistem kaldırmak için bu kodu yazdım
            $formattedData = str_replace('_', ' ', $permissionName);

            $permissionData = ['name' => $formattedData];
            $permission = Permission::updateOrCreate($permissionData);
            $role->givePermissionTo($permission);
        }

        return  redirect()->back()->withInput()->with('message', 'Rol izinleri güncellendi');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $roller)
    {
        //dd($roller);
        return view('yonetimsel-islemler.roller.edit',compact('roller'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Role $roller, Request $request)
    {

        $request->validate([

           
            'name' => 'required|string|max:255',
            
        ]);

        //dd($request->name);

        $roller->update(['name'=>$request->name]);
        return  redirect()->route('roller.index')->with('message', 'Rol başarıyla güncellendi');
        
    }

 
    public function destroy(Role $roller)
    {
        $roller->delete();
        return  redirect()->back()->with('message', 'Rol başarıyla silindi');

    }

    public function getPermissions(Request $request, $roleId)
    {
        //return $roleId;
        //$role = Role::find($roleId);
        $role = Role::whereId($roleId)->first();


        //return $role;
        $permissions = $role->permissions->pluck('name');


        return response()->json($permissions);
    }
}
