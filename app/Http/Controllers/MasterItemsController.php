<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MasterItem;
use Illuminate\Http\Request;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    // public function search(Request $request)
    // {
    //     $kode = $request->kode;
    //     $nama = $request->nama;
    //     $hargamin = $request->hargamin;
    //     $hargamax = $request->hargamax;

    //     $data_search = MasterItem::query();

    //     if (!empty($kode)) $data_search = $data_search->where('kode', $kode);
    //     if (!empty($nama)) $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');
    //     if (!empty($hargamin)) $data_search = $data_search->where('harga_beli', '>=', $hargamin)->where('harga_beli', '<=', $hargamax);

    //     $data_search = $data_search->select('kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier')->orderBy('id')->get();


    //     return json_encode([
    //         'status' => 200,
    //         'data' => $data_search
    //     ]);
    // }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;
        $hargamin = $request->hargamin;
        $hargamax = $request->hargamax;

        $data_search = MasterItem::query();

        if ($kode) {
            $data_search->where('kode', $kode);
        }

        if ($nama) {
            $data_search->where('nama', 'LIKE', '%' . $nama . '%');
        }

        if ($hargamin !== null && $hargamax !== null) {
            $data_search->whereBetween('harga_beli', [$hargamin, $hargamax]);
        } elseif ($hargamin !== null) {
            $data_search->where('harga_beli', '>=', $hargamin);
        } elseif ($hargamax !== null) {
            $data_search->where('harga_beli', '<=', $hargamax);
        }

        $data_search = $data_search->select('kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier')
            ->orderBy('id')
            ->get();

        return response()->json([
            'status' => 200,
            'data' => $data_search
        ]);
    }


    // public function formView($method, $id = 0)
    // {
    //     if ($method == 'new') {
    //         $item = [];
    //     } else {
    //         $item = MasterItem::find($id);
    //     }
    //     $data['item'] = $item;
    //     $data['method'] = $method;
    //     return view('master_items.form.index', $data);
    // }

    public function formView($method, $id = 0)
    {
        $categories = Category::all();

        if ($method == 'new') {
            $item = new MasterItem();
            $selectedCategories = [];
        } else {
            $item = MasterItem::findOrFail($id);
            $selectedCategories = $item->categories->pluck('id')->toArray();
        }

        return view('master_items.form.index', [
            'item' => $item,
            'method' => $method,
            'categories' => $categories,
            'selectedCategories' => $selectedCategories
        ]);
    }


    public function singleView($kode)
    {
        $data['data'] = MasterItem::where('kode', $kode)->first();

        // dd($data);
        return view('master_items.single.index', $data);
    }

    // public function formSubmit(Request $request, $method, $id = 0)
    // {
    //     if ($method == 'new') {
    //         $data_item = new MasterItem;
    //         $kode = MasterItem::count('id');
    //         $kode = $kode + 1;
    //         $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
    //         sleep(3);
    //     } else {
    //         $data_item = MasterItem::find($id);
    //         $kode = $data_item->kode;
    //     }

    //     $data_item->nama = $request->nama;
    //     $data_item->harga_beli = $request->harga_beli;
    //     $data_item->laba = $request->laba;
    //     $data_item->kode = $kode;
    //     $data_item->supplier = $request->supplier;
    //     $data_item->jenis = $request->jenis;
    //     $data_item->save();

    //     return redirect('master-items');
    // }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data_item = new MasterItem;
            $kode = MasterItem::count('id') + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
            sleep(3);
        } else {
            $data_item = MasterItem::find($id);
            $kode = $data_item->kode;
        }

        // $data_item->nama = $request->nama;
        // $data_item->harga_beli = $request->harga_beli;
        // $data_item->laba = $request->laba;
        // $data_item->kode = $kode;
        // $data_item->supplier = $request->supplier;
        // $data_item->jenis = $request->jenis;

        // if ($request->has('category_ids')) {
        //     $data_item->categories()->sync($request->category_ids);
        // } else {

        //     $data_item->categories()->sync([]);
        // }


        // if ($request->hasFile('foto')) {


        //     if ($method != 'new' && $data_item->foto && file_exists(storage_path('app/public/' . $data_item->foto))) {
        //         unlink(storage_path('app/public/' . $data_item->foto));
        //     }

        //     $file = $request->file('foto');
        //     $filename = time() . '_' . $file->getClientOriginalName();
        //     $file->storeAs('master_items', $filename, 'public');

        //     $data_item->foto = 'master_items/' . $filename;
        // }

        // $data_item->save();

        // return redirect('master-items');

        $data_item->nama = $request->nama;
        $data_item->harga_beli = $request->harga_beli;
        $data_item->laba = $request->laba;
        $data_item->kode = $kode;
        $data_item->supplier = $request->supplier;
        $data_item->jenis = $request->jenis;

        $category_id = $request->category_id ? [$request->category_id] : [];

        $data_item->save(); // simpan dulu supaya dapat id

        // sync kategori ke pivot table
        $data_item->categories()->sync($category_id);

        // simpan foto terakhir
        if ($request->hasFile('foto')) {
            if ($method != 'new' && $data_item->foto && file_exists(storage_path('app/public/' . $data_item->foto))) {
                unlink(storage_path('app/public/' . $data_item->foto));
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('master_items', $filename, 'public');

            $data_item->foto = 'master_items/' . $filename;
            $data_item->save();
        }
        return redirect('master-items');
    }


    public function delete($id)
    {
        MasterItem::find($id)->delete();
        return redirect('master-items');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach ($data as $item) {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100, 1000000);
            $item->laba = rand(10, 99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi', 'Bukulapuk', 'TokoBagas', 'E Commurz', 'Blublu'];
        $random = rand(0, 4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat', 'Alkes', 'Matkes', 'Umum', 'ATK'];
        $random = rand(0, 4);
        return $array[$random];
    }
}
