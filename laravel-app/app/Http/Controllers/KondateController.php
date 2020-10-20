<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Menu;
use App\Kondate;

class KondateController extends Controller
{
    public function history() {
        $kondate = Kondate::all();

        return view('kondate/history', [
            'kondate' => $kondate,
        ]);
    }

    public function history_detail($id) {
        $kondate = Kondate::where('id', $id)->get()->first();

        $menu_ids = explode(',', $kondate->menu_id);
        $menu_array = [];
        $menu_array['ingredienst'] = [];

        foreach ($menu_ids as $menu_id) {
            $menu = Menu::where('id', $menu_id)->get()->first();
            $menu_array['name'][] = $menu->name;
            $menu_array['ingredients'][] = array_chunk(explode(',', $menu->ingredients), 2);
        }

        return view('kondate/detail', [
            'kondate' => $kondate,
            'menu_array' => $menu_array,
        ]);

    }

    public function generate_kondate_list() {
        $kondate_ids = isset($_POST['kondate-id']) ? $_POST['kondate-id'] : null;
        $ingredients_list = [];

        if($kondate_ids == null) {
            return redirect('/');
        }

        foreach($kondate_ids as $kondate_id) {
            $menu = Menu::where('id', $kondate_id)->get()->first();
            $ingredients_list[$menu->id]['name'] = $menu->name;
            $ingredients_list[$menu->id]['ingredient'] = array_chunk(explode(',', $menu->ingredients), 2);
        }

        $kondate = new Kondate;

        return view('kondate/kondate_list', [
            'kondate' => $kondate,
            'ingredients_list' => $ingredients_list,
        ]);
    }

    public function save_kondate_list(Request $request) {
        $this->validate($request, [
            'id' => 'required',
        ]);

        //menu_idを配列から文字列に変更
        $menu_id = implode(',', $_POST['id']);

        $kondate = new Kondate;
        $kondate->menu_id = $menu_id;
        $kondate->save();

        return view('kondate/save_complete');
    }
}
