<?php

namespace App\Imports\Merchant;

use App\Models\Country;
use App\Models\Merchant;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class Created implements ToCollection, WithHeadingRow, WithStartRow, WithChunkReading, WithCalculatedFormulas
{
    public function collection($collection)
    {
        $country = Country::where('name', 'MALAYSIA')->first();

        foreach ($collection as $data) {

            $merchant = Merchant::where('name', $data['title'])->firstOrNew();
            $merchant->name = $data['title'] ?? 'Unknown';
            $merchant->description = $data['description'];
            $merchant->address = $data['address'];
            $merchant->postal_code = $data['postalcode'];
            $merchant->city = $data['city'] ?? 'Unknown';
            $merchant->state = $data['state'];
            $merchant->country_id = $country->id;
            $merchant->lat = $data['locationlat'];
            $merchant->lng = $data['locationlng'];
            $merchant->is_open = $data['temporarilyclosed'] || $data['permanentlyclosed'] ? 0 : 1;
            $merchant->active = 1;
            $merchant->save();

            $monday = $merchant->operationDaySettings()->where('day', 1)->firstOrNew();

            $data['monday'] = $data['monday'];
            $data['monday'] = str_replace("\xC2\xA0", ' ', $data['monday']); // Replace non-breaking space (UTF-8)

            switch (true) {
                    // Match the format like "number AM to number PM"
                case (stripos($data['monday'], 'AM to') !== false &&
                    stripos($data['monday'], 'PM') !== false &&
                    strpos($data['monday'], ',') !== false && // Ensure no comma exists
                    substr_count($data['monday'], ' to ') === 1):
                    dd(1);
                    $times = explode(' to ', $data['monday']);
                    $start = Carbon::createFromFormat('g A', trim($times[0]));
                    $end = Carbon::createFromFormat('g A', trim($times[1]));

                    $monday->day = 1;
                    $monday->start_time = $start;
                    $monday->end_time = $end;
                    $monday->active = 1;
                    $monday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $monday->save();
                    break;

                case (stripos($data['monday'], 'AM to') !== false &&
                    stripos($data['monday'], 'PM') !== false &&
                    strpos($data['monday'], ', ') === false && // Ensure comma exists
                    substr_count($data['monday'], ' to ') === 1):

                    $times = explode(' to ', $data['monday']);
                    $start = Carbon::createFromFormat('g A', trim($times[0]));
                    $end = Carbon::createFromFormat('g A', trim($times[1]));
                    $monday->day = 1;
                    $monday->start_time = $start->format('H:i:s');
                    $monday->end_time = $end->format('H:i:s');
                    $monday->active = 1;
                    $monday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $monday->save();
                    break;

                case ($data['monday'] === 'Closed'):
                    break;

                default:
                    $monday->day = 1;
                    $monday->start_time = "08:00";
                    $monday->end_time = "22:00";
                    $monday->active = 1;
                    $monday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $monday->save();
            }
        }
    }

    public function startRow(): int
    {
        return 2;
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
