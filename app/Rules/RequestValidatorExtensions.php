<?php

namespace App\Rules;

use App\Enquiry;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Livewire\TemporaryUploadedFile;
use Spatie\Permission\Models\Role;

class RequestValidatorExtensions
{
    /**
     * Is importable rule - csv, xls, xlsx
     *
     * @param $message
     * @param UploadedFile $file
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function isImportable($message, UploadedFile $file, $rule, $parameters)
    {
        $extension = strtolower($file->getClientOriginalExtension());

        return in_array($extension, ['csv', 'xls', 'xlsx']);
    }

    /**
     * Is importable message
     *
     * @return string
     */
    public function isImportableReplacer()
    {
        return "File extension not supported";
    }

    /**
     * Check if vehicle is purchasable
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function isPurchasable($message, $attribute, $rule, $parameters)
    {
        /** @var User $user */
        $user = Auth::user()->load(['cartItems']);

        $cartItemCollection = $user->cartItems;

        $identColumn = $attribute->identColumn;

        foreach ($cartItemCollection as $cartItem) {
            if (get_class($attribute) === $cartItem->vehicle_type && $attribute->$identColumn === $cartItem->vehicle_ident) {
                return false;
            }
        }

        return true;
    }

    /**
     * Is purchasable message
     *
     * @return string
     */
    public function isPurchasableReplacer()
    {
        return "Vehicle not available or already in the cart.";
    }


    /**
     * Check if vin length is valid
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function vinValid($message, $attribute, $rule, $parameters)
    {
        $vin = trim($attribute);

        $vinCharCount = strlen($vin);

        if ($vinCharCount === 17) {
            return true;
        }

        return false;
    }

    /**
     * Vin valid validation message
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return string
     */
    public function vinValidReplacer($message, $attribute, $rule, $parameters)
    {
        $message = "VIN number is not 17 characters long.";

        return $message;
    }

    /**
     *
     * Wishlist validation rule
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function forWishlist($message, $attribute, $rule, $parameters)
    {
        /** @var User $user */
        $user = Auth::user()->load(['wishlistItems']);

        $vehicleClass = get_class($attribute);

        $identColumn = $attribute->identColumn;

        $wishlistItemCollection = $user->wishlistItems;

        foreach ($wishlistItemCollection as $wishlistItem) {
            if ($wishlistItem->vehicle_type === $vehicleClass && $wishlistItem->vehicle_ident === $attribute->$identColumn) {
                return false;
            }
        }

        return true;
    }

    /**
     * Wishlist validation message
     *
     * @return string
     */
    public function forWishlistReplacer()
    {
        return "Vehicle already in wishlist.";
    }

    /**
     *
     * Vpvu valid validation rule
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function vpvuValid($message, $attribute, $rule, $parameters)
    {
        /** @var User $user */
        $user = Auth::user();

        $vehicleTypeArray = $user->vehicle_type;

        if (!$vehicleTypeArray || !count($vehicleTypeArray)) {
            return false;
        }

        if (in_array($attribute, $vehicleTypeArray)) {
            return true;
        }

        return false;
    }

    /**
     * Wishlist validation message
     *
     * @return string
     */
    public function vpvuValidReplacer()
    {
        return "User is uploading vehicles with vehicle type that is not configured in it's user profile. Or the user is missing vehicle type info in it's profile.";
    }

    /**
     * Non admin validation rule
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function nonAdmin($message, $attribute, $rule, $parameters)
    {
        $role = Role::findById($attribute);

        if (!$role || ($role->name === 'Administrator')) {
            return false;
        }

        return true;
    }

    /**
     * Non admin replacer
     *
     * @return string
     */
    public function nonAdminReplacer()
    {
        return "Role is invalid.";
    }

    /**
     * Non admin validation rule
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function xlsxExtension($message, TemporaryUploadedFile $attribute, $rule, $parameters)
    {
        $extension = $attribute->getClientOriginalExtension();

        if ($extension == 'xlsx') {
            return true;
        }

        return false;
    }

    /**
     * Non admin validation rule
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function xlsxExtensionReplacer($message, $attribute, $rule, $parameters)
    {
        return "File must be XLSX format.";
    }

    /**
     * Non admin validation rule
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function externalId($message, $attribute, $rule, $parameters)
    {
        if (strpos($attribute, '=>') != false) {
            $externalIdArray = explode('=>', $attribute);

            if (isset($externalIdArray[0]) && isset($externalIdArray[1])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Non admin validation rule
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function externalIdReplacer($message, $attribute, $rule, $parameters)
    {
        return "External id is in the wrong format.";
    }

    /**
     * Valid first reg date rule
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function validFirstRegDate($message, $attribute, $rule, $parameters)
    {
        try {
            $date = convert_to_excel_dates_to_date($attribute);
        } catch (\Exception $exception) {
            return false;
        }

        if (!$date) {
            return false;
        }

        $carbonTime = Carbon::parse($date);

        $result = $carbonTime->isValid();

        if (!$result) {
            return false;
        }

        $controlDatePast = Carbon::create(1940, 1, 1);

        $controlDateCurrent = Carbon::now();

        $result = $carbonTime->isAfter($controlDatePast);

        if (!$result) {
            return false;
        }

        $result = $carbonTime->isAfter($controlDateCurrent);

        if ($result) {
            return false;
        }

        return true;
    }

    /**
     * Valid first reg date replacer
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function validFirstRegDateReplacer($message, $attribute, $rule, $parameters)
    {
        return "First registration date is not in valid format.";
    }

    /**
     * Correct condition type
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function correctConditionType($message, $attribute, $rule, $parameters)
    {
        $user = Auth::user();

        $stockType = $user->stock_type;

        if (($stockType === 'UC') && ($attribute != 'used')) {
            return false;
        } elseif (($stockType === 'NC') && ($attribute != 'new')) {
            return false;
        }

        return true;
    }

    /**
     * Non admin validation rule
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function correctConditionTypeReplacer($message, $attribute, $rule, $parameters)
    {
        $user = Auth::user();

        $stockType = $user->stock_type;

        if ($stockType === 'UC') {
            return "User can upload used vehicles only.";
        } else {
            return "User can upload new vehicles only.";
        }
    }

    /**
     * Correct condition type
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function correctBrand($message, $attribute, $rule, Validator $validator)
    {
        $user = Auth::user();

        $stockType = $user->stock_type;

        $attribute = strtoupper(trim($attribute));

        $validatorData = $validator->getData();
        $validatorDataKey = key($validatorData);

        if (isset($validatorData['condition_type'])) {
            $conditionType = $validatorData['condition_type'];
        } else {
            $conditionType = $validatorData[$validatorDataKey]['condition_type'];
        }

        if ($stockType === 'UC' || $conditionType === 'used') {
            return true;
        }

        $user->load('brands');

        $brandCollection = $user->brands;

        if (count($brandCollection)) {
            $brandArray = $brandCollection->pluck('name')->toArray();
        } else {
            $brandArray = [];
        }

        foreach ($brandArray as &$brand) {
            $brand = strtoupper(trim($brand));
        }

        if ($stockType === 'NC') {
            if (in_array($attribute, $brandArray)) {
                return true;
            } else {
                return false;
            }
        } elseif ($stockType === 'both') {
            if ($conditionType === 'new') {
                if (in_array($attribute, $brandArray)) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Non admin validation rule
     *
     * @param $message
     * @param $attribute
     * @param $rule
     * @param $parameters
     * @return bool
     */
    public function correctBrandReplacer($message, $attribute, $rule, $parameters)
    {
        return "New vehicle brand should match selected brand in uploader profile.";
    }
}
