<?php

namespace App\Http\Controllers;

use App\Checklist;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ChecklistController extends Controller
{
    /**
     * index
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {

        $pageLimit = $request->page_limit ?: 10;
        $sort = $request->sort ?: "id";
        $pageOffsite = $request->page_offset ?: 0;

        $checklist = Checklist::limit($pageLimit)
            ->orderBy($sort, "DESC")
            ->offset($pageOffsite)
            ->get();

        $countCheckList = Checklist::count();


        $meta = [
            "count" => (int) $pageLimit,
            "total" => $countCheckList
        ];

        $dataChecklist = array();

        foreach ($checklist as $data) {
            $dataChecklist[] = array(
                'type'     => 'checklist',
                'id'        => $data->id,
                'atributs' => $data,
                "links" =>  url('/checklists/' . $data->id)
            );
        }

        if ($pageOffsite  == 0) {
            $pageOffsite = $countCheckList - $pageLimit;
        } else {
            $pageOffsite = $countCheckList - $pageLimit;
        }

        $link = [
            'first' => url("checklists?page_limit=10&page_offset=0"),
            "last"  =>   url("checklists?page_limit=" . $pageLimit . "&page_offset=" . $pageOffsite)

        ];
        $data = [
            "meta" =>  $meta,
            "data" => $dataChecklist,
            "links" => $link
        ];

        return response()->json($data, 200);
    }

    /**
     * show
     *
     * @param Request $request
     * @param mixed $id
     * @return void
     */
    public function show(Request $request, $id)
    {
        $checklist = Checklist::where('id', $id)->first();

        if (!$checklist) {
            $res = [
                "status" => "404",
                "error" => "Not Found",
            ];

            return response()->json($res, 404);
        }

        $res = [
            "data" =>  [
                "type" => "checklists",
                "id"   => $checklist->id,
                "atributes" => $checklist->makeHidden('id'),
                "links" => [
                    "self" => $request->url()
                ]
            ],

        ];

        return response()->json($res, 200);
    }

    /**
     * create
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        $data = $request->input('data');

        $objectDomain = $data['attributes']['object_domain'];
        $objectId = $data['attributes']['object_id'];
        $description = $data['attributes']['description'];
        $due = $data['attributes']['due'];
        $urgency = $data['attributes']['urgency'];
        $dateDue = Carbon::parse($due);

        $create = Checklist::create([
            "object_domain" => $objectDomain,
            "object_id" => $objectId,
            "due" => $dateDue->format('Y-m-d H:i:s'),
            "urgency" => $urgency,
            "description" => $description,
            "is_completed" => 0
        ]);

        if ($create) {
            $data  = [
                "type" => "chcklist",
                "attributes" => $create,
            ];

            return response()->json($data, 201);
        }
    }

    /**
     * update
     *
     * @param Request $request
     * @param mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $checklist = Checklist::find($id);

        if ($checklist) {
            $checklist->update($request->input('data')['attributes']);
            return response()->json($checklist, 201);
        } else {
            $err = [
                "status" => "404",
                "error" => "Not Found"
            ];
            return response()->json($err, 404);
        }
    }

    /**
     * delete
     *
     * @param Request $request
     * @param mixed $id
     * @return void
     */
    public function delete(Request $request, $id)
    {
        $checklist = Checklist::where('id', $id)->first();

        if (!$checklist) {
            $res = [
                "status" => "404",
                "error" => "Not Found",
            ];

            return response()->json($res, 404);
        }
        $checklist->delete();

        return response()->json("success_delete", 204);
    }
}
