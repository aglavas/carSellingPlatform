@php
  $logo = \Illuminate\Support\Str::snake(strtolower($vehicle->brand));
@endphp
<tr class="bg-gray-50">
    <td class="py-6 pr-8">
        <div class="flex items-center">
            <img src="{{url('/images/logos/' . $logo . '.svg')}}" class="w-16 h-16 object-center object-cover rounded mr-6">
            <div>
                <div class="font-medium text-gray-900">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-grey-100 text-yellow-800"> {{ $vehicle->condition_type }} </span>
                    {{ $vehicle->brand }} {{ $vehicle->model }}
                </div>
                <div class="font-medium text-gray-900">{{ $vehicle->manufacturer_id }}</div>
            </div>
        </div></td>
    <td class="hidden py-6 pr-8 sm:table-cell">
        -
    </td>
    <td class="py-6 font-medium text-left whitespace-nowrap">
        {{ $vehicle->company }} <br>
        #{{ $vehicle->enquiry_id }} - {{ $vehicle->enquiry_count }} vehicles total
    </td>
    <td class="hidden py-6 pr-8 sm:table-cell">
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
            Vehicle removed
        </span>
    </td>
    <td class="py-6 font-medium text-left whitespace-nowrap">
        {{ $vehicle->transaction_updated_at }}
    </td>
</tr>
