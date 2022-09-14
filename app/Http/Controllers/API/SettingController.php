<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Enums\ProvinceType;
use App\Enums\Countries;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProvinceList()
    {
        $data = [];
        $provinces = ProvinceType::toArray();
        if( is_array( $provinces ) && !empty( $provinces ) ) {
            foreach( $provinces as $key => $value ) {
                $data[] = ['key' => $value, 'value' => $key];
            }
        }
        $response = [
            'data'    => json_decode(json_encode($data))
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource of all countries.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCountryList()
    {
        $data = [];
        $countries = Countries::toArray();
        if( is_array( $countries ) && !empty( $countries ) ) {
            foreach( $countries as $key => $value ) {
                $data[] = ['key' => $value, 'value' => $key];
            }
        }
        $response = [
            'data'    => json_decode(json_encode($data))
        ];

        return response()->json($response, 200);
    }    
}
