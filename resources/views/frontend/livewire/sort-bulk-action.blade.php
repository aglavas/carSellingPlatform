<div>
    @if($transaction)
        <div class="py-1" role="none">
            <a wire:click="sortBy('created-desc')" class="
                                            @if(($sortField == 'created_at') && ($sortDirection == 'desc')) bg-gray-100 @endif block px-4 py-2 text-sm font-medium text-gray-900 clickable"
               role="menuitem" tabindex="-1" id="mobile-menu-item-2">
                Newest
            </a>
            <a wire:click="sortBy('created-asc')" class="
                                            @if(($sortField == 'created_at') && ($sortDirection == 'asc')) bg-gray-100 @endif block px-4 py-2 text-sm font-medium text-gray-900 clickable"
               role="menuitem" tabindex="-1" id="mobile-menu-item-2">
                Oldest
            </a>
        </div>
    @else
        <div class="py-1" role="none">
            <a wire:click="sortBy('price-desc')" class="
                                            @if(($sortField == 'b2b_price_ex_vat') && ($sortDirection == 'desc')) bg-gray-100 @endif block px-4 py-2 text-sm font-medium text-gray-900 clickable"
               role="menuitem" tabindex="-1" id="mobile-menu-item-0">
                Price highest
            </a>
            <a wire:click="sortBy('price-asc')" class="
                                            @if(($sortField == 'b2b_price_ex_vat') && ($sortDirection == 'asc')) bg-gray-100 @endif block px-4 py-2 text-sm font-medium text-gray-900 clickable"
               role="menuitem" tabindex="-1" id="mobile-menu-item-1">
                Price lowest
            </a>
            <a wire:click="sortBy('created-desc')" class="
                                            @if(($sortField == 'created_at') && ($sortDirection == 'desc')) bg-gray-100 @endif block px-4 py-2 text-sm font-medium text-gray-900 clickable"
               role="menuitem" tabindex="-1" id="mobile-menu-item-2">
                Newest
            </a>
            <a wire:click="sortBy('brand-asc')" class="
                                            @if(($sortField == 'brand') && ($sortDirection == 'asc')) bg-gray-100 @endif block px-4 py-2 text-sm font-medium text-gray-900 clickable"
               role="menuitem" tabindex="-1" id="mobile-menu-item-1">
                By Make
            </a>
            <a wire:click="sortBy('company-asc')" class="
                                            @if(($sortField == 'company') && ($sortDirection == 'asc')) bg-gray-100 @endif block px-4 py-2 text-sm font-medium text-gray-900 clickable"
               role="menuitem" tabindex="-1" id="mobile-menu-item-1">
                By Company
            </a>
        </div>
    @endif
</div>
