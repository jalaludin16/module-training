<?php

namespace Module\Training\Models;

use App\Traits\HasMeta;
use App\Traits\Filterable;
use App\Traits\Searchable;
use App\Traits\HasFeatures;
use Illuminate\Http\Request;
use App\Traits\HasCollectionSetup;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingHistory extends Model
{
    use Filterable;
    use HasMeta;
    use HasFeatures;
    use HasCollectionSetup;
    use Searchable;
    use SoftDeletes;

    /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection = 'platform';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'training_histories';

    /**
     * Undocumented variable
     *
     * @var array
     */
    protected $roles = ['training-history'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'meta' => 'array'
    ];

    /**
     * The default key for the order.
     *
     * @var string
     */
    protected $defaultOrder = 'name';

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return array
     */
    public static function pageHeaders(Request $request): array
    {
        return [
            ['text' => 'Name', 'value' => 'name'],
            ['text' => 'Tahun', 'value' => 'decree_year'],
            ['text' => 'Nomor', 'value' => 'decree_number'],
            ['text' => 'Jam', 'value' => 'number_of_hours'],
            ['text' => 'Updated', 'value' => 'updated_at', 'class' => 'field-datetime'],
        ];
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return array
     */
    public static function pageResourceMap(Request $request, $model): array
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'decree_number' => $model->decree_number,
            'decree_year' => $model->decree_year,
            'number_of_hours' => $model->number_of_hours,
            'updated_at' => (string) $model->updated_at,
        ];
    }

    /**
     * The model store method
     *
     * @param Request $request
     * @return void
     */
    public static function storeFromApi(Request $request)
    {
        if (! $model = static::firstWhere('decree_number', $request->sertifikat_nomor)) {
            $model = new static();
        } else {
            if ($model->filepath && Storage::disk('simceria')->exists($model->filepath)) {
                Storage::disk('simceria')->delete($model->filepath);
            }
        }

        $type = TrainingType::firstWhere('name', $request->diklat_jenis);
        $cluster = TrainingCluster::firstWhere('name', $request->diklat_rumpun);
        $register = TrainingRegister::firstWhere('name', $request->diklat_kompetensi);

        DB::connection($model->connection)->beginTransaction();

        try {
            $model->name = $request->diklat_nama;
            $model->slug = sha1(str($request->diklat_nama)->slug()->toString());
            $model->biodata_id = $request->pegawai_nip;
            $model->type_id = optional($type)->id;
            $model->register_id = optional($register)->id;
            $model->cluster_id = optional($cluster)->id;
            $model->decree_number = $request->sertifikat_nomor;
            $model->decree_date = $request->sertifikat_tanggal;
            $model->decree_year = $request->sertifikat_tahun;
            $model->start_date = $request->diklat_mulai;
            $model->end_date = $request->diklat_selesai;
            $model->number_of_hours = $request->diklat_jam;
            $model->organizer = 'BPSDM';
            $model->filepath = $request->file('sertifikat_file')->store($request->pegawai_nip, 'simceria');
            $model->save();

            DB::connection($model->connection)->commit();

            return response()->json([
                'success' => true,
                'message' => 'store data was success.'
            ], 200);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * The model update method
     *
     * @param Request $request
     * @param [type] $model
     * @return void
     */
    public static function updateRecord(Request $request, $model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            // ...
            $model->save();

            DB::connection($model->connection)->commit();

            // return new TrainingHistoryResource($model);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * The model delete method
     *
     * @param [type] $model
     * @return void
     */
    public static function deleteRecord($model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            $model->delete();

            DB::connection($model->connection)->commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * The model restore method
     *
     * @param [type] $model
     * @return void
     */
    public static function restoreRecord($model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            $model->restore();

            DB::connection($model->connection)->commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * The model destroy method
     *
     * @param [type] $model
     * @return void
     */
    public static function destroyRecord($model)
    {
        DB::connection($model->connection)->beginTransaction();

        try {
            $model->forceDelete();

            DB::connection($model->connection)->commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::connection($model->connection)->rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
