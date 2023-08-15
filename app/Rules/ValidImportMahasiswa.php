<?php

namespace App\Rules;

use App\Models\Organisasi;
use App\Models\TahunAjaran;
use Illuminate\Contracts\Validation\Rule;

class ValidImportMahasiswa implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Organisasi::where('tahun_ajaran_id', TahunAjaran::findActivedTahunAjaran()->id)->where('nama_organisasi', $value)->count() > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
