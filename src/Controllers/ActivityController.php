<?php

namespace Pedr0cazz\SpatieLogUi\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::all()->sortByDesc('created_at');

        $logs = $activities;

        $logs = $logs->map(function ($item, $key) {
            $item->description = self::stateToText($item->description);

            return $item;
        });

        foreach ($logs as $log) {
            if ($log->causer_type == 'App\User') {
                $log->causer_id = $log->causer->email;
            }
        }

        $logs = $logs->sortByDesc('created_at');

        $logs = $logs->map(function ($log) {
            $log->properties = json_decode($log->properties);

            return $log;
        });

        return view('spatie_log_ui::index', compact('logs'));
    }

    public static function stateToText($state)
    {
        switch ($state) {
            case 'updated':
                return 'Updated';
                break;
            case 'created':
                return 'Created';
                break;
            case 'deleted':
                return 'Deleted';
                break;
            default:
                return 'Unknown';
                break;
        }
    }

    public static function stateToColor($state)
    {
        switch ($state) {
            case 'updated':
                return 'bg-yellow-500';
                break;
            case 'created':
                return 'bg-green-500';
                break;
            case 'deleted':
                return 'bg-red-500';
                break;
            default:
                return 'bg-gray-500';
                break;
        }
    }

    public function getLogsAjax(Request $request)
    {
        $columns = $request->get('columns');
        $query = Activity::query();

        // Apply search filters for each column if there is a search value
        foreach ($columns as $column) {
            $columnData = $column['data'];
            $searchValue = $column['search']['value'];

            if (! empty($searchValue)) { // Only apply search if searchValue is not empty
                switch ($columnData) {
                    case 'description':
                        $query->where('description', 'like', '%'.$searchValue.'%');
                        break;
                    case 'subject_type':
                        $query->where('subject_type', 'like', '%'.$searchValue.'%');
                        break;
                    case 'subject_id':
                        $query->where('subject_id', 'like', '%'.$searchValue.'%');
                        break;
                    case 'causer_type':
                        $query->where('causer_type', 'like', '%'.$searchValue.'%');
                        break;
                    case 'causer_id':
                        $query->whereHas('causer', function ($q) use ($searchValue) {
                            $q->where('email', 'like', '%'.$searchValue.'%');
                        });
                        break;
                    case 'batch_uuid':
                        $query->where('batch_uuid', 'like', '%'.$searchValue.'%');
                        break;
                    case 'created_at':
                        $query->where('created_at', 'like', '%'.$searchValue.'%');
                        break;
                }
            }
        }

        // Default order by created_at DESC

        if ($request->order[0]['column'] == 0) {
            $query->orderBy('id', $request->order[0]['dir']);
        } else {
            $query->orderBy($columns[$request->order[0]['column']]['data'], $request->order[0]['dir']);
        }

        return DataTables::eloquent($query)
            ->addColumn('id', function ($record) {
                return $record->id;
            })
            ->addColumn('description', function ($record) {
                return self::stateToText($record->description);
            })
            ->addColumn('subject_type', function ($record) {
                $subjectTypeShort = $record->subject_type ? explode('\\', $record->subject_type) : [];

                return isset($subjectTypeShort[2]) ? $subjectTypeShort[2] : '';
            })
            ->addColumn('subject_id', function ($record) {
                return $record->subject_id;
            })
            ->addColumn('causer_type', function ($record) {
                $causerTypeShort = $record->causer_type ? explode('\\', $record->causer_type) : [];

                return isset($causerTypeShort[2]) ? $causerTypeShort[2] : '';
            })
            ->addColumn('causer_id', function ($record) {
                if ($record->causer_id && $record->causer_type) {
                    $causerModel = $record->causer_type::find($record->causer_id);

                    return $causerModel ? $causerModel->email : '';
                }

                return '';
            })
            ->addColumn('created_at', function ($record) {
                return $record->created_at->diffForHumans();
            })
            ->addColumn('batch_uuid', function ($record) {
                return $record->batch_uuid;
            })
            ->addColumn('actions', function ($record) {
                return "<button id='show' data-id='{$record->id}' class='text-primary'>Details</button>";
            })
            ->rawColumns(['actions']) // Ensure HTML rendering
            ->toJson();
    }

    public function getLogDetailsAjax(Request $request)
    {
        $id = $request->id;

        $activity = Activity::find($id);

        return response()->json([
            'properties' => $activity->properties,
            'event' => $activity->event,
        ]);
    }
}
