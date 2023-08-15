<?php
/**
 * Class CustomerGroupController
 *
 * PHP Version >= 8.1
 *
 * @category CustomerGroupController
 * @package  App\Http\Controllers
 * @author   Moses Egboh <mosesegboh@yahoo.com>
 * @license  https://github.com/mosesegboh/sendemails.git MIT
 * @link     https://github.com/mosesegboh/sendemails.git
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerGroup;
use Illuminate\Validation\ValidationException;

/**
 * Class CustomerGroupController
 *
 * PHP Version >= 8.1
 *
 * @category CustomerGroupController
 * @package  App\Http\Controllers
 * @author   Moses Egboh <mosesegboh@yahoo.com>
 * @license  https://github.com/mosesegboh/sendemails.git MIT
 * @link     https://github.com/mosesegboh/sendemails.git
 */
class CustomerGroupController extends Controller
{
    /**
     * Display a listing of the customer groups.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            $groups = CustomerGroup::all();
            return response()->json($groups);
        }

        $groups = CustomerGroup::all();
        return view('home', ['groups' => $groups]);
    }

    /**
     * Show the form for creating a new group.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groups/create');
    }

    /**
     * Store a newly created group in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255|unique:customer_groups,name',
            ]);

            $group = CustomerGroup::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Group created successfully!',
                'group' => $group
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->errors(),
            ], 422);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $group = CustomerGroup::find($id);

        if(!$group) { return response()->json(['message' => 'Group not found!'], 404); }

        return response()->json(['group' => $group], 200);
    }

    /**
     * Remove the specified group from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = CustomerGroup::findOrFail($id);
        $group->delete();

        return response()->json(['status' => 'success', 'message' => 'Group deleted successfully!'], 200);
    }

    /**
     * Update the details of a specific customer group.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request.
     * @param int $id The ID of the customer group to update.
     *
     * @return \Illuminate\Http\JsonResponse Returns a JSON response with a success message
     *
     * @throws \Exception Throws an exception if any error occurs during the process.
     */
    public function update(Request $request, $id)
    {
        $group = CustomerGroup::find($id);

        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        $group->update([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Group updated successfully', 'group' => $group]);
    }
}
