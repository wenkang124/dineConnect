<?php

namespace App\Imports\Merchant;

use App\Models\Category;
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
            $merchant->address = $data['address'] ?? 'Unknown';
            $merchant->postal_code = $data['postalcode'];
            $merchant->city = $data['city'] ?? 'Unknown';
            $merchant->state = $data['state'] ?? 'Unknown';
            $merchant->country_id = $country->id;
            $merchant->lat = $data['locationlat'];
            $merchant->lng = $data['locationlng'];
            $merchant->is_open = $data['temporarilyclosed'] || $data['permanentlyclosed'] ? 0 : 1;
            $merchant->active = 1;
            $merchant->save();

            if ($data['categoryname']) {
                $category = Category::where('name', $data['categoryname'])->firstOrNew();
                $category->name = $data['categoryname'];
                $category->save();
                $merchant->categories()->sync($category->id);
            }

            $monday = $merchant->operationDaySettings()->where('day', 1)->firstOrNew();

            $data['monday'] = $data['monday'];
            $data['monday'] = str_replace("\xC2\xA0", ' ', $data['monday']); // Replace non-breaking space (UTF-8)

            switch (true) {
                    // Match the format like "number AM to number PM"
                case (stripos($data['monday'], 'AM to') !== false &&
                    stripos($data['monday'], 'PM') !== false &&
                    strpos($data['monday'], ',') !== false && // Ensure no comma exists
                    substr_count($data['monday'], ' to ') === 1):

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
                case ($data['monday'] === 'Open 24 hours'):
                    $monday->day = 1;
                    $monday->start_time = "00:00";
                    $monday->end_time = "00:00";
                    $monday->active = 1;
                    $monday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $monday->save();
                    break;

                default:
                    $monday->day = 1;
                    $monday->start_time = "08:00";
                    $monday->end_time = "22:00";
                    $monday->active = 1;
                    $monday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $monday->save();
            }

            $tuesday = $merchant->operationDaySettings()->where('day', 2)->firstOrNew();

            $data['tuesday'] = $data['tuesday'];
            $data['tuesday'] = str_replace("\xC2\xA0", ' ', $data['tuesday']); // Replace non-breaking space (UTF-8)

            switch (true) {
                    // Match the format like "number AM to number PM"
                case (stripos($data['tuesday'], 'AM to') !== false &&
                    stripos($data['tuesday'], 'PM') !== false &&
                    strpos($data['tuesday'], ',') !== false && // Ensure no comma exists
                    substr_count($data['tuesday'], ' to ') === 1):

                    $times = explode(' to ', $data['tuesday']);
                    $start = Carbon::createFromFormat('g A', trim($times[0]));
                    $end = Carbon::createFromFormat('g A', trim($times[1]));

                    $tuesday->day = 2;
                    $tuesday->start_time = $start;
                    $tuesday->end_time = $end;
                    $tuesday->active = 1;
                    $tuesday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $tuesday->save();
                    break;

                case (stripos($data['tuesday'], 'AM to') !== false &&
                    stripos($data['tuesday'], 'PM') !== false &&
                    strpos($data['tuesday'], ', ') === false && // Ensure comma exists
                    substr_count($data['tuesday'], ' to ') === 1):

                    $times = explode(' to ', $data['tuesday']);
                    $start = Carbon::createFromFormat('g A', trim($times[0]));
                    $end = Carbon::createFromFormat('g A', trim($times[1]));
                    $tuesday->day = 2;
                    $tuesday->start_time = $start->format('H:i:s');
                    $tuesday->end_time = $end->format('H:i:s');
                    $tuesday->active = 1;
                    $tuesday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $tuesday->save();
                    break;

                case ($data['tuesday'] === 'Closed'):
                    break;
                case ($data['tuesday'] === 'Open 24 hours'):
                    $tuesday->day = 2;
                    $tuesday->start_time = "00:00";
                    $tuesday->end_time = "00:00";
                    $tuesday->active = 1;
                    $tuesday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $tuesday->save();
                    break;
                default:
                    $tuesday->day = 2;
                    $tuesday->start_time = "08:00";
                    $tuesday->end_time = "22:00";
                    $tuesday->active = 1;
                    $tuesday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $tuesday->save();
            }

            $wednesday = $merchant->operationDaySettings()->where('day', 3)->firstOrNew();

            $data['wednesday'] = $data['wednesday'];
            $data['wednesday'] = str_replace("\xC2\xA0", ' ', $data['wednesday']); // Replace non-breaking space (UTF-8)

            switch (true) {
                    // Match the format like "number AM to number PM"
                case (stripos($data['wednesday'], 'AM to') !== false &&
                    stripos($data['wednesday'], 'PM') !== false &&
                    strpos($data['wednesday'], ',') !== false && // Ensure no comma exists
                    substr_count($data['wednesday'], ' to ') === 1):

                    $times = explode(' to ', $data['wednesday']);
                    $start = Carbon::createFromFormat('g A', trim($times[0]));
                    $end = Carbon::createFromFormat('g A', trim($times[1]));

                    $wednesday->day = 3;
                    $wednesday->start_time = $start;
                    $wednesday->end_time = $end;
                    $wednesday->active = 1;
                    $wednesday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $wednesday->save();
                    break;

                case (stripos($data['wednesday'], 'AM to') !== false &&
                    stripos($data['wednesday'], 'PM') !== false &&
                    strpos($data['wednesday'], ', ') === false && // Ensure comma exists
                    substr_count($data['wednesday'], ' to ') === 1):

                    $times = explode(' to ', $data['wednesday']);
                    $start = Carbon::createFromFormat('g A', trim($times[0]));
                    $end = Carbon::createFromFormat('g A', trim($times[1]));
                    $wednesday->day = 3;
                    $wednesday->start_time = $start->format('H:i:s');
                    $wednesday->end_time = $end->format('H:i:s');
                    $wednesday->active = 1;
                    $wednesday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $wednesday->save();
                    break;

                case ($data['wednesday'] === 'Closed'):
                    break;
                case ($data['wednesday'] === 'Open 24 hours'):
                    $wednesday->day = 3;
                    $wednesday->start_time = "00:00";
                    $wednesday->end_time = "00:00";
                    $wednesday->active = 1;
                    $wednesday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $wednesday->save();
                    break;
                default:
                    $wednesday->day = 3;
                    $wednesday->start_time = "08:00";
                    $wednesday->end_time = "22:00";
                    $wednesday->active = 1;
                    $wednesday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $wednesday->save();
            }

            $thursday = $merchant->operationDaySettings()->where('day', 4)->firstOrNew();

            $data['thursday'] = $data['thursday'];
            $data['thursday'] = str_replace("\xC2\xA0", ' ', $data['thursday']); // Replace non-breaking space (UTF-8)

            switch (true) {
                    // Match the format like "number AM to number PM"
                case (stripos($data['thursday'], 'AM to') !== false &&
                    stripos($data['thursday'], 'PM') !== false &&
                    strpos($data['thursday'], ',') !== false && // Ensure no comma exists
                    substr_count($data['thursday'], ' to ') === 1):

                    $times = explode(' to ', $data['thursday']);
                    $start = Carbon::createFromFormat('g A', trim($times[0]));
                    $end = Carbon::createFromFormat('g A', trim($times[1]));

                    $thursday->day = 4;
                    $thursday->start_time = $start;
                    $thursday->end_time = $end;
                    $thursday->active = 1;
                    $thursday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $thursday->save();
                    break;

                case (stripos($data['thursday'], 'AM to') !== false &&
                    stripos($data['thursday'], 'PM') !== false &&
                    strpos($data['thursday'], ', ') === false && // Ensure comma exists
                    substr_count($data['thursday'], ' to ') === 1):

                    $times = explode(' to ', $data['thursday']);
                    $start = Carbon::createFromFormat('g A', trim($times[0]));
                    $end = Carbon::createFromFormat('g A', trim($times[1]));
                    $thursday->day = 4;
                    $thursday->start_time = $start->format('H:i:s');
                    $thursday->end_time = $end->format('H:i:s');
                    $thursday->active = 1;
                    $thursday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $thursday->save();
                    break;

                case ($data['thursday'] === 'Closed'):
                    break;
                case ($data['thursday'] === 'Open 24 hours'):
                    $thursday->day = 4;
                    $thursday->start_time = "00:00";
                    $thursday->end_time = "00:00";
                    $thursday->active = 1;
                    $thursday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $thursday->save();
                    break;
                default:
                    $thursday->day = 4;
                    $thursday->start_time = "08:00";
                    $thursday->end_time = "22:00";
                    $thursday->active = 1;
                    $thursday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $thursday->save();
            }

            $friday = $merchant->operationDaySettings()->where('day', 5)->firstOrNew();

            $data['friday'] = $data['friday'];
            $data['friday'] = str_replace("\xC2\xA0", ' ', $data['friday']); // Replace non-breaking space (UTF-8)

            switch (true) {
                    // Match the format like "number AM to number PM"
                case (stripos($data['friday'], 'AM to') !== false &&
                    stripos($data['friday'], 'PM') !== false &&
                    strpos($data['friday'], ',') !== false && // Ensure no comma exists
                    substr_count($data['friday'], ' to ') === 1):

                    $times = explode(' to ', $data['friday']);
                    $start = Carbon::createFromFormat('g A', trim($times[0]));
                    $end = Carbon::createFromFormat('g A', trim($times[1]));

                    $friday->day = 5;
                    $friday->start_time = $start;
                    $friday->end_time = $end;
                    $friday->active = 1;
                    $friday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $friday->save();
                    break;

                case (stripos($data['friday'], 'AM to') !== false &&
                    stripos($data['friday'], 'PM') !== false &&
                    strpos($data['friday'], ', ') === false && // Ensure comma exists
                    substr_count($data['friday'], ' to ') === 1):

                    $times = explode(' to ', $data['friday']);
                    $start = Carbon::createFromFormat('g A', trim($times[0]));
                    $end = Carbon::createFromFormat('g A', trim($times[1]));
                    $friday->day = 5;
                    $friday->start_time = $start->format('H:i:s');
                    $friday->end_time = $end->format('H:i:s');
                    $friday->active = 1;
                    $friday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $friday->save();
                    break;

                case ($data['friday'] === 'Closed'):
                    break;
                case ($data['friday'] === 'Open 24 hours'):
                    $friday->day = 5;
                    $friday->start_time = "00:00";
                    $friday->end_time = "00:00";
                    $friday->active = 1;
                    $friday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $friday->save();
                    break;
                default:
                    $friday->day = 5;
                    $friday->start_time = "08:00";
                    $friday->end_time = "22:00";
                    $friday->active = 1;
                    $friday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $friday->save();
            }

            $saturday = $merchant->operationDaySettings()->where('day', 6)->firstOrNew();

            $data['saturday'] = $data['saturday'];
            $data['saturday'] = str_replace("\xC2\xA0", ' ', $data['saturday']); // Replace non-breaking space (UTF-8)

            switch (true) {
                    // Match the format like "number AM to number PM"
                case (stripos($data['saturday'], 'AM to') !== false &&
                    stripos($data['saturday'], 'PM') !== false &&
                    strpos($data['saturday'], ',') !== false && // Ensure no comma exists
                    substr_count($data['saturday'], ' to ') === 1):

                    $times = explode(' to ', $data['saturday']);
                    $start = Carbon::createFromFormat('g A', trim($times[0]));
                    $end = Carbon::createFromFormat('g A', trim($times[1]));

                    $saturday->day = 6;
                    $saturday->start_time = $start;
                    $saturday->end_time = $end;
                    $saturday->active = 1;
                    $saturday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $saturday->save();
                    break;

                case (stripos($data['saturday'], 'AM to') !== false &&
                    stripos($data['saturday'], 'PM') !== false &&
                    strpos($data['saturday'], ', ') === false && // Ensure comma exists
                    substr_count($data['saturday'], ' to ') === 1):

                    $times = explode(' to ', $data['saturday']);
                    $start = Carbon::createFromFormat('g A', trim($times[0]));
                    $end = Carbon::createFromFormat('g A', trim($times[1]));
                    $saturday->day = 6;
                    $saturday->start_time = $start->format('H:i:s');
                    $saturday->end_time = $end->format('H:i:s');
                    $saturday->active = 1;
                    $saturday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $saturday->save();
                    break;

                case ($data['saturday'] === 'Closed'):
                    break;
                case ($data['saturday'] === 'Open 24 hours'):
                    $saturday->day = 6;
                    $saturday->start_time = "00:00";
                    $saturday->end_time = "00:00";
                    $saturday->active = 1;
                    $saturday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $saturday->save();
                    break;
                default:
                    $saturday->day = 6;
                    $saturday->start_time = "08:00";
                    $saturday->end_time = "22:00";
                    $saturday->active = 1;
                    $saturday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $saturday->save();
            }

            $sunday = $merchant->operationDaySettings()->where('day', 0)->firstOrNew();

            $data['sunday'] = $data['sunday'];
            $data['sunday'] = str_replace("\xC2\xA0", ' ', $data['sunday']); // Replace non-breaking space (UTF-8)

            switch (true) {
                    // Match the format like "number AM to number PM"
                case (stripos($data['sunday'], 'AM to') !== false &&
                    stripos($data['sunday'], 'PM') !== false &&
                    strpos($data['sunday'], ',') !== false && // Ensure no comma exists
                    substr_count($data['sunday'], ' to ') === 1):

                    $times = explode(' to ', $data['sunday']);
                    $start = Carbon::createFromFormat('g A', trim($times[0]));
                    $end = Carbon::createFromFormat('g A', trim($times[1]));

                    $sunday->day = 0;
                    $sunday->start_time = $start;
                    $sunday->end_time = $end;
                    $sunday->active = 1;
                    $sunday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $sunday->save();
                    break;

                case (stripos($data['sunday'], 'AM to') !== false &&
                    stripos($data['sunday'], 'PM') !== false &&
                    strpos($data['sunday'], ', ') === false && // Ensure comma exists
                    substr_count($data['sunday'], ' to ') === 1):

                    $times = explode(' to ', $data['sunday']);
                    $start = Carbon::createFromFormat('g A', trim($times[0]));
                    $end = Carbon::createFromFormat('g A', trim($times[1]));
                    $sunday->day = 0;
                    $sunday->start_time = $start->format('H:i:s');
                    $sunday->end_time = $end->format('H:i:s');
                    $sunday->active = 1;
                    $sunday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $sunday->save();
                    break;

                case ($data['sunday'] === 'Closed'):
                    break;
                case ($data['sunday'] === 'Open 24 hours'):
                    $sunday->day = 0;
                    $sunday->start_time = "00:00";
                    $sunday->end_time = "00:00";
                    $sunday->active = 1;
                    $sunday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $sunday->save();
                    break;
                default:
                    $sunday->day = 0;
                    $sunday->start_time = "08:00";
                    $sunday->end_time = "22:00";
                    $sunday->active = 1;
                    $sunday->merchant_id = $merchant->id; // Ensure $merchant is defined
                    $sunday->save();
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
