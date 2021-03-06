@extends('template/master')
@section('title', 'Page')
@section('content')
    <div class="bg-white shadow-lg border rounded-xl p-5">
        <div class="mb-2 flex">
            <div class="w-full text-left">
               <a href="{{route('atlet.form_add')}}" class="bg-blue-500 hover:bg-blue-400 text-white text-center rounded-md shadow-md px-5 py-1"><span class="align-text-top">Tambah</span></a>
               <a href="{{route('atlet.download')}}" class="bg-yellow-500 hover:bg-yellow-400 text-white text-center rounded-md shadow-md px-5 py-1"><span class="align-text-top">Download Format</span></a>
            </div>
            <div class="w-full">
                <form action="{{route('atlet.export')}}" class="flex justify-end space-x-2">
                    <select name="search" class="block rounded-xl focus:outline-none px-1 border border-gray-300">
                        <option>Semua</option>
                        <option>Kabupaten Berau</option>
                        <option>Kabupaten Kutai Barat</option>
                        <option>Kabupaten Kutai Kartanegara</option>
                        <option>Kabupaten Kutai Timur</option>
                        <option>Kabupaten Mahakam Ulu</option>
                        <option>Kabupaten Paser</option>
                        <option>Kabupaten Penajam Paser Utara</option>
                        <option>Kota Balikpapan</option>
                        <option>Kota Bontang</option>
                        <option>Kota Samarinda</option>
                    </select>
                    <button type="submit" class="inline-block bg-purple-500 hover:bg-purple-400 text-white text-center rounded-md shadow-md px-5 py-1"><span class="align-text-top">Export</span></button>
                </form>
                <div>
                    <form action="{{route('atlet.index')}}">
                        <div class="flex rounded-md rounded-r-xl shadow-sm border shadow-xl my-2">
                            <select class="border-r-2 border-black" name="limit">
                                <option>10</option>
                                <option>20</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                            <input type="text" name="search" class="flex-1 block rounded-l-xl focus:outline-none g px-3 py-1" placeholder="Cari Atlet">
                            <button type="submit" class="inline-flex items-center rounded-r-xl border-l-0 border border-indigo-100 bg-indigo-100 text-white w-10 h-9">
                                <i class="fas fa-search text-gray-600 text-2xl m-auto"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <table class="w-full table-fixed text-center">
            <thead class="bg-gray-100">
            <tr>
                <th class="py-1">Name</th>
                <th class="py-1">Cabang Olahraga</th>
                <th class="py-1">Action</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y-2 divide-gray-200">
            @foreach($atlet as $item)
                <tr class="hover:bg-blue-100 transition-all duration-200">
                    <td class="py-1 pl-4">
                        <div class="flex items-center">
                            <div class="text-left my-auto">
                                {{$item->nama_lengkap}}
                                <div class="text-sm text-gray-500">{{$item->no_ktp}}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-1">{{\App\Models\CabangOlahraga::where('id', $item->cabang_olahraga)->first()->nama}}</td>
                    <td class="py-1">
                        <a href="{{route('atlet.export_atlet', $item->id)}}">
                            <button class="bg-green-500 text-white text-center rounded-md shadow-md px-5 py-1 relative">
                                <span class="align-text-top">View</span>
                            </button>
                        </a>
                        <a href="{{route('atlet.edit', $item->id)}}">
                            <button class="bg-yellow-500 text-white text-center rounded-md shadow-md px-5 py-1 relative">
                                <span class="align-text-top">Edit</span>
                            </button>
                        </a>
                        <a href="{{route('atlet.delete', $item->id)}}">
                            <button class="bg-red-500 text-white text-center rounded-md shadow-md px-5 py-1 relative">
                                <span class="align-text-top">Delete</span>
                            </button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$atlet->appends(request()->all())->links()}}
    </div>
@endsection
