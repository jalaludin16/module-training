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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Module\Profile\Models\ProfileCourse;

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
     * pageCombos function
     *
     * @param Request $request
     * @return array
     */
    public static function pageCombos(Request $request): array
    {
        return [
            'clusters' => TrainingCluster::forCombo(),
            'registers' => TrainingRegister::forCombo(),
            'types' => TrainingType::forCombo(),
        ];
    }

    /**
     * pageHeaders function
     *
     * @param Request $request
     * @return array
     */
    public static function pageHeaders(Request $request): array
    {
        return [
            ['text' => 'Name', 'value' => 'name'],
            ['text' => 'Tahun', 'value' => 'decree_year', 'align' => 'center', 'sortable' => false],
            ['text' => 'Nomor', 'value' => 'decree_number'],
            ['text' => 'Jam', 'value' => 'number_of_hours', 'align' => 'center', 'sortable' => false],
            ['text' => 'Validate', 'value' => 'validated', 'align' => 'center', 'sortable' => false, 'mode' => 'icon'],
            ['text' => 'Updated', 'value' => 'updated_at', 'class' => 'field-datetime'],
        ];
    }

    /**
     * pageResourceMap function
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
            'validated' => is_null($model->validated_at) ? 'check_box_outline_blank' : 'check_box',
            'updated_at' => (string) $model->updated_at,
        ];
    }

    /**
     * pageShowResourceMap function
     *
     * @param Request $request
     * @return array
     */
    public static function pageShowResourceMap(Request $request, $model): array
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'biodata_id' => $model->biodata_id,
            'cluster_id' => $model->cluster_id,
            'cluster' => [
                'text' => optional($model->cluster)->name,
                'value' => $model->cluster_id,
            ],
            'register_id' => $model->register_id,
            'register' => [
                'text' => optional($model->register)->name,
                'value' => $model->register_id,
            ],
            'type_id' => $model->type_id,
            'type' => [
                'text' => optional($model->type)->name,
                'value' => $model->type_id,
            ],
            'decree_number' => $model->decree_number,
            'decree_date' => $model->decree_date,
            'decree_year' => $model->decree_year,
            'number_of_hours' => $model->number_of_hours,
            'start_date' => $model->start_date,
            'end_date' => $model->end_date,
            'organizer' => $model->organizer,
            'filepath' => $model->filepath,
            'validated' => !is_null($model->validated_at)
        ];
    }

    /**
     * cluster function
     *
     * @return BelongsTo
     */
    public function cluster(): BelongsTo
    {
        return $this->belongsTo(TrainingCluster::class, 'cluster_id');
    }

    /**
     * register function
     *
     * @return BelongsTo
     */
    public function register(): BelongsTo
    {
        return $this->belongsTo(TrainingRegister::class, 'register_id');
    }

    /**
     * type function
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(TrainingType::class, 'type_id');
    }

    /**
     * The model store method
     *
     * @param Request $request
     * @return void
     */
    public static function storeFromApi(Request $request)
    {
        if (! $model = static::where('biodata_id', $request->pegawai_nip)
            ->where('decree_number', $request->sertifikat_nomor)
            ->first()
        ) {
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
            $model->slug = sha1(str($request->pegawai_nip . ' ' . $request->sertifikat_nomor)->slug()->toString());
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
     * validateRecord function
     *
     * @param Request $request
     * @param [type] $model
     * @return void
     */
    public static function validateRecord(Request $request, $model, $parent)
    {
        if (!$course = $parent->courses()
            ->where('biodata_id', $parent->nip)
            ->where('decree_number', $model->decree_number)
            ->first()
        ) {
            return ProfileCourse::storeFromApi($model, function () use ($model, $request) {
                $model->validated_at = now();
                $model->validated_by = $request->user()->id;
                $model->save();
            });
        } else {
            return ProfileCourse::updateFromApi($course, $model, function () use ($model, $request) {
                $model->validated_at = now();
                $model->validated_by = $request->user()->id;
                $model->save();
            });
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
