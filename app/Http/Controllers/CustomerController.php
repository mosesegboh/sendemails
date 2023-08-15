<?php
/**
 * Class CustomerController
 *
 * PHP Version >= 8.1
 *
 * @category Controller
 * @package  App\Http\Controllers
 * @author   Moses Egboh <mosesegboh@yahoo.com>
 * @license  https://github.com/mosesegboh/sendemails.git MIT
 * @link     https://github.com/mosesegboh/sendemails.git
 */
namespace App\Http\Controllers;

use App\Models\CustomerGroup;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Validation\ValidationException;

/**
 * Class CustomerController
 *
 * PHP Version >= 8.1
 *
 * @category Controller
 * @package  App\Http\Controllers
 * @author   Moses Egboh <mosesegboh@yahoo.com>
 * @license  https://github.com/mosesegboh/sendemails.git MIT
 * @link     https://github.com/mosesegboh/sendemails.git
 */
class CustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        return view('home', ['customers' => $customers]);
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
                'first_name' => 'required|string|max:150',
                'last_name' => 'required|string|max:150',
                'email' => 'email|unique:customers,email',
                'sex' => 'in:male,female',
                'emailGroups' => 'required|exists:customer_groups,id'
            ]);

            $customer = Customer::create($data);

            $emailGroups = $data['emailGroups'];

            if (!empty($emailGroups)) {
                $customer->groups()->attach($emailGroups);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Customer added to group successfully!',
                'customer' => $customer
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->errors(),
            ], 422);
        }
    }

    /**
     * Display the specified group's customers.
     *
     * @param  int  $groupId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($groupId)
    {
        $group = CustomerGroup::find($groupId);

        if (!$group) {
            return response()->json(['message' => 'Group not found', 'status' => 'failed'], 404);
        }

        return response()->json($group->customers);
    }
}
